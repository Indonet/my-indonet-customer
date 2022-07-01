<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(__DIR__ . '/db.php');

class mpph {    //MYPORTAL PASSWORD HELPER


    /**
     * 64 characters that are valid for APRMD5 passwords.
     */

    const APRMD5_VALID = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * Characters used when generating a password.
     */
    const VOWELS = 'aeiouy';
    const CONSONANTS = 'bcdfghjklmnpqrstvwxz';
    const NUMBERS = '0123456789';

    
    static public function getCryptMethod($password) {
        if (preg_match('/{(.*)}(.*)/i', $password, $method)) {
            $res = strtolower($method[1]);
            if ($res === 'crypt') {
                $submethod = $method[2];
                switch (substr($submethod, 0, 3)) {
                    case '$1$':
                        $res = 'crypt-md5';
                        break;
                    case '$2$':
                        $res = 'crypt-blowfish';
                        break;
                    case '$5$':
                        $res = 'crypt-sha256';
                        break;
                    case '$6$':
                        $res = 'crypt-sha512';
                        break;
                    default:
                        $res = 'crypt';
                        break;
                }
                return $res;
            } else {
                return $res;
            }
        } else {
            return false;   //DUNNO
        }
    }
    
    static public function removeCryptMethod($password) {
        if (preg_match('/{(.*)}(.*)/i', $password, $crypted)) {
            return strtolower($crypted[2]);
        }else{
            return false;   //DUNNO
        }
    }
    
    /**
     * Formats a password using the current encryption.
     *
     * @param string $plaintext      The plaintext password to encrypt.
     * @param string $salt           The salt to use to encrypt the password.
     *                               If not present, a new salt will be
     *                               generated.
     * @param string $encryption     The kind of pasword encryption to use.
     *                               Defaults to md5-hex.
     * @param boolean $show_encrypt  Some password systems prepend the kind of
     *                               encryption to the crypted password ({SHA},
     *                               etc). Defaults to false.
     *
     * @return string  The encrypted password.
     */
    static public function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false) {
        /* Get the salt to use. */
        $salt = self::getSalt($encryption, $salt, $plaintext);
        
//        error_log("salt: $salt | plain: $plaintext");

        /* Encrypt the password. */
        switch ($encryption) {
            case 'plain':
                return $plaintext;

            case 'sha':
            case 'sha1':
                $encrypted = base64_encode(pack('H*', hash('sha1', $plaintext)));
                return $show_encrypt ? '{SHA}' . $encrypted : $encrypted;

            case 'crypt':
            case 'crypt-des':
            case 'crypt-md5':
            case 'crypt-sha256':
            case 'crypt-sha512':
            case 'crypt-blowfish':
                return ($show_encrypt ? '{CRYPT}' : '') . crypt($plaintext, $salt);

            case 'md5-base64':
                $encrypted = base64_encode(pack('H*', hash('md5', $plaintext)));
                return $show_encrypt ? '{MD5}' . $encrypted : $encrypted;

            case 'ssha':
                $encrypted = base64_encode(pack('H*', hash('sha1', $plaintext . $salt)) . $salt);
                return $show_encrypt ? '{SSHA}' . $encrypted : $encrypted;

            case 'sha256':
            case 'ssha256':
                $encrypted = base64_encode(pack('H*', hash('sha256', $plaintext . $salt)) . $salt);
                return $show_encrypt ? '{SSHA256}' . $encrypted : $encrypted;

            case 'sha512':
            case 'ssha512':
                $encrypted = base64_encode(pack('H*', hash('sha512', $plaintext . $salt)) . $salt);
                return $show_encrypt ? '{SSHA512}' . $encrypted : $encrypted;

            case 'smd5':
                $encrypted = base64_encode(pack('H*', hash('md5', $plaintext . $salt)) . $salt);
                return $show_encrypt ? '{SMD5}' . $encrypted : $encrypted;

            case 'aprmd5':
                $length = strlen($plaintext);
                $context = $plaintext . '$apr1$' . $salt;
                $binary = pack('H*', hash('md5', $plaintext . $salt . $plaintext));

                for ($i = $length; $i > 0; $i -= 16) {
                    $context .= substr($binary, 0, ($i > 16 ? 16 : $i));
                }
                for ($i = $length; $i > 0; $i >>= 1) {
                    $context .= ($i & 1) ? chr(0) : $plaintext[0];
                }

                $binary = pack('H*', hash('md5', $context));

                for ($i = 0; $i < 1000; ++$i) {
                    $new = ($i & 1) ? $plaintext : substr($binary, 0, 16);
                    if ($i % 3) {
                        $new .= $salt;
                    }
                    if ($i % 7) {
                        $new .= $plaintext;
                    }
                    $new .= ($i & 1) ? substr($binary, 0, 16) : $plaintext;
                    $binary = pack('H*', hash('md5', $new));
                }

                $p = array();
                for ($i = 0; $i < 5; $i++) {
                    $k = $i + 6;
                    $j = $i + 12;
                    if ($j == 16) {
                        $j = 5;
                    }
                    $p[] = self::_toAPRMD5((ord($binary[$i]) << 16) |
                                    (ord($binary[$k]) << 8) |
                                    (ord($binary[$j])), 5);
                }

                return '$apr1$' . $salt . '$' . implode('', $p) . self::_toAPRMD5(ord($binary[11]), 3);

            case 'md5-hex':
            default:
                return ($show_encrypt) ? '{MD5}' . hash('md5', $plaintext) : hash('md5', $plaintext);
        }
    }

    /**
     * Returns a salt for the appropriate kind of password encryption.
     * Optionally takes a seed and a plaintext password, to extract the seed
     * of an existing password, or for encryption types that use the plaintext
     * in the generation of the salt.
     *
     * @param string $encryption  The kind of pasword encryption to use.
     *                            Defaults to md5-hex.
     * @param string $seed        The seed to get the salt from (probably a
     *                            previously generated password). Defaults to
     *                            generating a new seed.
     * @param string $plaintext   The plaintext password that we're generating
     *                            a salt for. Defaults to none.
     *
     * @return string  The generated or extracted salt.
     */
    static public function getSalt($encryption = 'md5-hex', $seed = '', $plaintext = '') {
        switch ($encryption) {
            case 'crypt':
            case 'crypt-des':
                return $seed ? substr(preg_replace('|^{crypt}|i', '', $seed), 0, 2) : substr(base64_encode(hash('md5', mt_rand(), true)), 0, 2);

            case 'crypt-md5':
                return $seed ? substr(preg_replace('|^{crypt}|i', '', $seed), 0, 12) : '$1$' . base64_encode(hash('md5', sprintf('%08X%08X', mt_rand(), mt_rand()), true)) . '$';

            case 'crypt-blowfish':
                return $seed ? substr(preg_replace('|^{crypt}|i', '', $seed), 0, 16) : '$2$' . base64_encode(hash('md5', sprintf('%08X%08X%08X', mt_rand(), mt_rand(), mt_rand()), true)) . '$';

            case 'crypt-sha256':
                return $seed ? substr(preg_replace('|^{crypt}|i', '', $seed), 0, strrpos($seed, '$')) : '$5$' . base64_encode(hash('md5', sprintf('%08X%08X%08X', mt_rand(), mt_rand(), mt_rand()), true)) . '$';

            case 'crypt-sha512':
                return $seed ? substr(preg_replace('|^{crypt}|i', '', $seed), 0, strrpos($seed, '$')) : '$6$' . base64_encode(hash('md5', sprintf('%08X%08X%08X', mt_rand(), mt_rand(), mt_rand()), true)) . '$';

            case 'ssha':
                return $seed ? substr(base64_decode(preg_replace('|^{SSHA}|i', '', $seed)), 20) : substr(pack('H*', hash('sha1', substr(pack('h*', hash('md5', mt_rand())), 0, 8) . $plaintext)), 0, 4);

            case 'sha256':
            case 'ssha256':
                return $seed ? substr(base64_decode(preg_replace('|^{SSHA256}|i', '', $seed)), 32) : substr(pack('H*', hash('sha256', substr(pack('h*', hash('md5', mt_rand())), 0, 8) . $plaintext)), 0, 4);

            case 'sha512':
            case 'ssha512':
                return $seed ? substr(base64_decode(preg_replace('|^{SSHA512}|i', '', $seed)), 64) : substr(pack('H*', hash('sha512', substr(pack('h*', hash('md5', mt_rand())), 0, 8) . $plaintext)), 0, 4);

            case 'smd5':
                return $seed ? substr(base64_decode(preg_replace('|^{SMD5}|i', '', $seed)), 16) : substr(pack('H*', hash('md5', substr(pack('h*', hash('md5', mt_rand())), 0, 8) . $plaintext)), 0, 4);

            case 'aprmd5':
                if ($seed) {
                    return substr(preg_replace('/^\$apr1\$(.{8}).*/', '\\1', $seed), 0, 8);
                } else {
                    $salt = '';
                    $valid = self::APRMD5_VALID;
                    for ($i = 0; $i < 8; ++$i) {
                        $salt .= $valid[mt_rand(0, 63)];
                    }
                    return $salt;
                }

            default:
                return '';
        }
    }

    /**
     * Converts to allowed 64 characters for APRMD5 passwords.
     *
     * @param string $value   The value to convert
     * @param integer $count  The number of iterations
     *
     * @return string  $value converted to the 64 MD5 characters.
     */
    static protected function _toAPRMD5($value, $count) {
        $aprmd5 = '';
        $count = abs($count);
        $valid = self::APRMD5_VALID;

        while (--$count) {
            $aprmd5 .= $valid[$value & 0x3f];
            $value >>= 6;
        }

        return $aprmd5;
    }

}

class popHelper {

    var $popdb;

    function getUserDetail($username) {
        $sql = "SELECT username,password,active,ax_custid FROM mailbox WHERE username = ?";
        $popdb = $this->popdb;
        $rs = $popdb->execute($sql, Array($username));
        if ($rs) {
            return $rs->getRows();
        } else {
            return null;
        }
    }

    public function __construct() {
        $this->popdb = newPOPDB();
//        $this->popdb->debug = TRUE;
        $this->popdb->memCache = TRUE;
        $this->popdb->memCacheHost = 'localhost';
        $this->popdb->SetFetchMode(ADODB_FETCH_ASSOC);
    }

}
