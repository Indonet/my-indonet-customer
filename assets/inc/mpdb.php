<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(__DIR__ . '/db.php');
include_once(__DIR__ . '/axdb.php');
include_once(__DIR__ . '/mpph.php');

global $mpdb;

$mpdb = newMPDB();
//$mpdb->debug = TRUE;
$mpdb->memCache = TRUE;
$mpdb->memCacheHost = '127.0.0.1';
$axdb->memCachePort = 11211; /// this is default memCache port
$mpdb->SetFetchMode(ADODB_FETCH_ASSOC);

        const LOGIN_BY_ID = 1;
        const LOGIN_BY_CUSTID = 2;
        const LOGIN_BY_USER = 3;

        const SALT_MD5 = 1;
        const SALT_BLOWFISH = 2;

        const ERR_USERNAME_USED = -1;
        const ERR_USERNAME_REGISTERING = -2;
        const ERR_CUSTID_USED = -3;
        const ERR_CUSTID_NOTEXIST = -4;
        const ERR_BILLDATERANGE = -5;
        const ERR_WRONGBILLAMOUNT = -6;
        const ERR_USERNAME_NOTVALIDEMAIL = -7;
        const ERR_USERID_NOTEXIST = -8;
        const ERR_WRONG_PASSWORD = -9;


        const TOKEN_USED = 0;
        const TOKEN_NEWUSER = 1;
        const TOKEN_RESETPASS = 2;
//PROCESS REGISTER
        const ERR_REGISTER_NOSUCHTOKENID = -1;
        const ERR_REGISTER_NOTFORREG = -2;
        const ERR_REGISTER_INVALIDTOKEN = -3;
        const ERR_REGISTER_TOKENCORRUPT = -4;
        const ERR_REGISTER_TOKENEXPIRED = -5;


        const REG_BY_BILL = 1;  //register by billing info
        const REG_BY_UID = 2;   //register by userid
        const REG_BY_MIGRATE = 3;   //register by using old email account (indonet)

define("SALTTYPE", SALT_BLOWFISH);

function newDB() {
    $mpdb = newMPDB();
    $mpdb->debug = TRUE;
    $mpdb->memCache = TRUE;
    $mpdb->memCacheHost = 'localhost';
    $mpdb->SetFetchMode(ADODB_FETCH_ASSOC);
    return $mpdb;
}

function genSalt($saltType = SALTTYPE) {
    $salt = '$1$changeme$'; //default to MD5

    switch ($saltType) {
        case SALT_BLOWFISH:
            $salt = '$2y$07$' . generateRandomString(20) . '$';
            break;
        case SALT_MD5: default:
            $salt = '$1$' . generateRandomString(8) . '$';
            break;
    }
    return $salt;
}

function getUserByID($id = null) {
    global $mpdb;
    if (!isset($id)) {
        return false;
    }
    $sql = "SELECT * FROM user WHERE id = ?";
    $rs = $mpdb->execute($sql, array($id));

    if ($rs) {
        return $rs->FetchRow();
    } else {
        return null;
    }
}

function getUserByCUSTID($id = null) {
    global $mpdb;
    if (!isset($id)) {
        return false;
    }
    $sql = "SELECT * FROM user WHERE CUSTID = ?";
    $rs = $mpdb->execute($sql, array($id));

    if ($rs) {
        return $rs->FetchRow();
    } else {
        return null;
    }
}

function getUserByLogin($id = null) {
    global $mpdb;
    if (!isset($id)) {
        return false;
    }
    $id = strtolower($id);
    $sql = "SELECT * FROM user WHERE LOWER(username) = ?";
    $rs = $mpdb->execute($sql, array($id));

    if ($rs) {
        return $rs->FetchRow();
    } else {
        return null;
    }
}

function getUser($id, $loginType = LOGIN_BY_ID) {
    global $mpdb;
    $usr = null;
    switch ($loginType) {
        case LOGIN_BY_USER:
            $usr = getUserByLogin($id);
            break;
        case LOGIN_BY_CUSTID:
            $usr = getUserByCUSTID($id);
            break;
        case LOGIN_BY_ID: default:
            $usr = getUserByID($id);
            break;
    }
    return $usr;
}

function isUserExist($id, $loginType = LOGIN_BY_ID) {
    if (getUser($id, $loginType)) {
        return true;
    }
    return false;
}

function getUserPassword($id, $loginType = LOGIN_BY_ID) {
    global $mpdb;
    $usr = getUser($id, $loginType);
    if ($usr) {
        return @$usr['password'];
    }
}

function compareUserPassword($id, $password, $loginType = LOGIN_BY_ID) {
    global $mpdb;

    $isExternal = false;
    $usr = getUser($id, $loginType);
    if ($usr) {
        $isExternal = $usr['is_external'];
    }

    if (!$isExternal) {
        $cryptPass = getUserPassword($id, $loginType);
//    print_r($cryptPass);
//    return false;
        if (!$cryptPass) {
            return null;
        }
        if (function_exists('password_verify')) {
            return password_verify($password, $cryptPass);
        } else {
            return ($cryptPass === crypt($password, $cryptPass));
        }
    } else {
        $ph = new popHelper();
        $userDetail = $ph->getUserDetail($id);

        if ($userDetail === null) {
            return null;
        }

        $popPass = $userDetail[0]['password'];
        $method = mpph::getCryptMethod($popPass);

        return ($popPass === mpph::getCryptedPassword($password, $popPass, $method, true));
    }
}

function encryptPass($password) {
    if (function_exists('password_hash')) {
        return password_hash($password, PASSWORD_DEFAULT);
    } else {
        $salt = genSalt();
        return crypt($password, $salt);
    }
}

function setUserPassword($id, $password, $loginType = LOGIN_BY_ID) {
    global $mpdb;
    $usr = getUser($id, $loginType);
    if ($usr) {
        @$id = $usr['id'];
        if ($id !== null) {
            $cryptPass = encryptPass($password);
            $sql = "UPDATE user SET password = ? WHERE id = ?";

            $rs = $mpdb->execute($sql, array($cryptPass, $id));

            if ($rs === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    } else {
        return null;
    }
}

function isUserRegistering($username) {
    global $mpdb;
    $username = strtolower($username);
    $date = date("Y-m-d H:i:s");

    $sql = "SELECT * FROM user_token WHERE type = ? AND LOWER(username) = ? AND ? BETWEEN created AND expiry";
    $rs = $mpdb->execute($sql, array(TOKEN_NEWUSER, $username, $date));
    return $rs->RecordCount();
}

function isUseridOwnedByCust($userid, $custid) {
    $useridList = getCustUsernameList($custid);
    if ($useridList) {
        foreach ($useridList as $uid) {
            if (strtolower($uid['USERNAME']) === strtolower($userid)) {
                return true;
            }
        }
    }
    return false;
}

function registerNew($regby = REG_BY_BILL, $username, $custidOrPass, $billOrUid = null, $billDate = null) {
    global $mpdb;
    // CHECK USERNAME
    if (isUserExist($username, LOGIN_BY_USER)) {
        return ERR_USERNAME_USED;
    }
    if (isUserRegistering($username)) {
        return ERR_USERNAME_REGISTERING;
    }
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        return ERR_USERNAME_NOTVALIDEMAIL;
    }
    // CHECK CUSTID
    if (isUserExist($custidOrPass, LOGIN_BY_CUSTID)) {
        return ERR_CUSTID_USED;
    }
    if (sizeof(getCustInfo($custidOrPass)) === 0) {
        return ERR_CUSTID_NOTEXIST;
    }
    $now = time();
    $externalUser = null;

    switch ($regby) {
        case REG_BY_UID:
            // CHECK IF USERID OWNED BY THIS CUSTID
            if (!isUseridOwnedByCust($billOrUid, $custidOrPass)) {
                return ERR_USERID_NOTEXIST;
            }
            break;
        case REG_BY_MIGRATE:
            // COMPARE PASSWORD FROM THE POP DATABASE
            $ph = new popHelper();
            $userDetail = $ph->getUserDetail($username);
            if ($userDetail === null) {
                return ERR_USERID_NOTEXIST;
            }
            if ($userDetail == null) {
                return ERR_USERID_NOTEXIST;
            }
            // SET CUSTID FROM THE POPDB
            $axid = $userDetail[0]['ax_custid'];

            // CHECK CUSTID
            if (isUserExist($axid, LOGIN_BY_CUSTID)) {
                return ERR_CUSTID_USED;
            }

            $popPass = $userDetail[0]['password'];
            $method = mpph::getCryptMethod($popPass);

            $pcrypted = mpph::getCryptedPassword($custidOrPass, $popPass, $method, true);

            $phash = mpph::removeCryptMethod($pcrypted);
            $pophash = mpph::removeCryptMethod($popPass);


//            error_log("M: $method | P: $popPass | C: $pcrypted | H: $phash | PH: $pophash");

            if ($phash !== $pophash) {
                return ERR_WRONG_PASSWORD;
            }

            // SET CUSTID FROM THE POPDB
            $custidOrPass = $userDetail[0]['ax_custid'];
            $externalUser = 1;

            break;
        case REG_BY_BILL:
        default:
            // CHECK BILLDATE
            if ($billDate === null) {
                $year = date('Y');
                $month = date('n');
            } else {
                $year = date('Y', $billDate);
                $month = date('n', $billDate);
            }
            $billDateTime = strtotime("{$year}-{$month}-01");
            $endRange = strtotime('-6 month', $now);

            if (($billDateTime > $now) || ($billDateTime < $endRange)) {
                return ERR_BILLDATERANGE;
            }
            // CHECK BILL AMOUNT
            $theBillAmount = getCustTotalInvoice($custidOrPass, $year, $month);
            if ($theBillAmount != $billOrUid) {
                return ERR_WRONGBILLAMOUNT;
            }
    }
    // ALL PASSED
    $token = generateRandomString(16); //RANDOM TOKEN STRING
    $createdDate = date("Y-m-d H:i:s", $now);
    $expiryTime = strtotime("+1 day", $now);
    $expiryDate = date("Y-m-d H:i:s", $expiryTime);
    $sql = "INSERT INTO user_token (type, token, created, expiry, username, CUSTID, debug, external) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array(TOKEN_NEWUSER, $token, $createdDate, $expiryDate, $username, $custidOrPass, 'create new user from IP: ' . $_SERVER['REMOTE_ADDR'], $externalUser));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false;
    }
}

function getToken($id) {
    global $mpdb;
    $sql = "SELECT * FROM user_token WHERE id = ?";
    $rs = $mpdb->execute($sql, array($id));

    if ($rs) {
        return $rs->FetchRow();
    } else {
        return null;
    }
}

function tokenIsExpired($id) {
    $now = time();
    if ($data = getToken($id)) {
        @$expiry = $data['expiry'];
        if ($expiry) {
            return (strtotime($expiry) < $now);
        } else { // no expiry date (null)
            return false;
        }
    }
    return null;
}

function getTokenType($id) {
    if ($data = getToken($id)) {
//        print_r($data);
        return $data['type'];
    }
    return false;
}

function compareToken($id, $token) {
    if ($data = getToken($id)) {
        if ($data['token'] === $token) {
            return true;
        }
    }
    return false;
}

// Function to set the token 
function invalidateToken($id) {
    global $mpdb;
    if ($data = getToken($id)) {
        $sql = "UPDATE user_token SET type = ? WHERE id = ?";
        $rs = $mpdb->execute($sql, array(TOKEN_USED, $id));

        if ($rs) {
            return true;
        }
    }
    return false;
}

function processRegister($tokenID, $token, $password = null) {
    if (!($data = getToken($tokenID))) {
        return ERR_REGISTER_NOSUCHTOKENID;
    }
    if ((int) getTokenType($tokenID) !== 1) {
        return ERR_REGISTER_NOTFORREG;
    }
    if (tokenIsExpired($tokenID)) {
        return ERR_REGISTER_TOKENEXPIRED;
    }
    if (!compareToken($tokenID, $token)) {
        return ERR_REGISTER_INVALIDTOKEN;
    }
    //TODO :: Add password strength test
    //
    //ALL PASS
    @$custid = $data['CUSTID'];
    @$username = $data['username'];
    $external = $data['external'];

    if (($custid == null) || ($username == null)) {
        return ERR_REGISTER_TOKENCORRUPT;
    }

    global $mpdb;
    if ($external) {
        $sql = "INSERT INTO user (CUSTID, username, is_external) VALUES(?, ?, ?)";
        $rs = $mpdb->execute($sql, array($custid, $username, $external));
    } else {
        $cryptPass = encryptPass($password);

        $sql = "INSERT INTO user (CUSTID, username, password) VALUES(?, ?, ?)";
        $rs = $mpdb->execute($sql, array($custid, $username, $cryptPass));
    }

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        
        invalidateToken($tokenID);        
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}

function processRegisterNewUser($email, $custID, $passUser) {
    //ALL PASS
    @$custid = $custID;
    @$username = $email;
    $cryptPass = encryptPass($passUser);
    if (($custid == null) || ($username == null)) {
        return ERR_REGISTER_TOKENCORRUPT;
    }

    global $mpdb;
    $sql = "INSERT INTO user (CUSTID, username, password, is_master) VALUES(?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($custid, $username, $cryptPass, '0'));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}

function getUserUnderCustomer2($custid) {
    @$custid = $custid;
    global $mpdb;
    $sql = "SELECT username, status, is_master FROM user WHERE CUSTID = ?";
    $rs = $mpdb->execute($sql, array($custid));
    if ($rs) {
        $listUser = $rs->GetArray();
        return $listUser;
    } else {
        return null;
    }
}

function changePass($id, $newPass) {
    global $mpdb;
    $cryptPass = encryptPass($newPass);
    $sql = "UPDATE user SET password = ? WHERE id = ?";
    $rs = $mpdb->execute($sql, array($cryptPass, $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}

function updateEzoneID($id, $ezoneID) {
    global $mpdb;
    if (isUserExist($id)) {
        $sql = "UPDATE user SET ezone_id = ? WHERE id = ?";
        $rs = $mpdb->execute($sql, array($ezoneID, $id));

        if ($rs === false) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
function getInvByCustnumMonthYear($custid, $searchYearMonth){
    global $mpdb;
    $sql = "SELECT * FROM invoice WHERE CUSTID = ? AND invoice_date_ax = ?";
    $rs = $mpdb->execute($sql, array($custid, $searchYearMonth));
    if ($rs) {
        $listInv = $rs->FetchRow();
        return $listInv;
    } else {
        return null;
    }
}
function addInvoice($custid, $createInvToEzone, $invDate){
    global $mpdb;
    $sql = "INSERT INTO invoice (CUSTID, invoice_number_blesta, invoice_date_ax) VALUES(?, ?, ?)";
    $rs = $mpdb->execute($sql, array($custid, $createInvToEzone, $invDate));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkUserMonitoring($custid){
    global $mpdb;
    $sql = "SELECT * FROM monitoring WHERE CUSTID = ? ";
    $rs = $mpdb->execute($sql, array($custid));
    if ($rs) {
        $row = $rs->FetchRow();
        return $row;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkUserMonitoringAll(){
    global $mpdb;
    $sql = "SELECT * FROM monitoring ";
    $rs = $mpdb->execute($sql);
    if ($rs) {
        return $rs->GetArray();
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function addUserMonitoring($custid, $iix, $int){
    global $mpdb;
    $sql = "INSERT INTO monitoring (CUSTID , IIX_CODE, INT_CODE) VALUES(?, ?, ? )";
    $rs = $mpdb->execute($sql, array($custid, $iix, $int));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)s
    }
}
function updateUserMonitoring($custid, $iix, $int){
    global $mpdb;            
    $sql = "UPDATE monitoring SET IIX_CODE = ?, INT_CODE = ? WHERE CUSTID = ?";
    $rs = $mpdb->execute($sql, array($iix, $int, $custid));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}

function checkUserAvailabilityAll(){
    global $mpdb;
    $sql = "SELECT * FROM availability ";
    $rs = $mpdb->execute($sql);
    if ($rs) {
        return $rs->GetArray();
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}

function addReport($custid, $report_name, $report_date, $report_file, $report_code_name){
    global $mpdb;
    $sql = "INSERT INTO report (CUSTID , REPORT_NAME, REPORT_DATE, REPORT_FILE, REPORT_CODE) VALUES(?, ?, ?, ?, ?)";        
            
    $rs = $mpdb->execute($sql, array($custid, $report_name, $report_date, $report_file, $report_code_name));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)s
    }
}
function getReportAll(){
    global $mpdb;
    $sql = "SELECT * FROM report ORDER BY ID desc LIMIT 100 ";
    $rs = $mpdb->execute($sql);
    if ($rs) {
        return $rs->GetArray();
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkReportExist($custid, $month, $year){
    global $mpdb;
    $sql = "SELECT * FROM report WHERE CUSTID = ? AND REPORT_DATE = ?";
    $searchYearMonth = $year.'-'.$month.'-1';
    $rs = $mpdb->execute($sql, array($custid, $searchYearMonth));
    if ($rs) {
        return $rs->GetArray();
    } else {
//        return error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function getReportByCustId($custId){
    global $mpdb;
    $sql = "SELECT * FROM report WHERE CUSTID = ? ORDER BY REPORT_DATE ASC";
    $rs = $mpdb->execute($sql, array($custId));
    if ($rs) {
        return $rs->GetArray();
    } else {
//        return error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function deleteReport($id){
    global $mpdb;   
    $sql = "DELETE FROM report WHERE ID = ? ";
    $rs = $mpdb->execute($sql, array($id));
    if ($rs) {
        // return $rs->GetArray();
        return true;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function getAllUser() {
    global $mpdb;  
    $sql = "SELECT * FROM user ";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
} 
function updateBlestaId($id, $blesta_id) {
    global $mpdb;
    $sql = "UPDATE user SET blesta_id = ? WHERE id = ?";
    $rs = $mpdb->execute($sql, array($blesta_id, $id));
    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function getAllSubnets() {
    global $mpdb;  
    $sql = "SELECT * FROM subnets ";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function createusernotoken($custid, $username, $password){
    //ALL PASS
    @$custid = $custid;
    @$username = $username;
    @$password = $password;
    $external = false;

    if (($custid == null) || ($username == null)) {
        return ERR_REGISTER_TOKENCORRUPT;
    }

    global $mpdb; 
    $cryptPass = encryptPass($password);

    $sql = "INSERT INTO user (CUSTID, username, password) VALUES(?, ?, ?)";
    $rs = $mpdb->execute($sql, array($custid, $username, $cryptPass));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function getInvPayment($data){
    global $mpdb;   
    $sql = "SELECT * FROM inv_payment WHERE cust_id = ? AND periode = ? AND billing = ? AND payment_method = ? AND payment_admin_fee = ? AND payment_total = ? AND status = ?";
    $rs = $mpdb->execute($sql, array($data['cust_id'],$data['periode'],$data['billing'],$data['payment_method'],$data['payment_admin_fee'],$data['payment_total'],
                                     $data['status']));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function chekInvPayment($data){
    global $mpdb;   
    $sql = "SELECT * FROM inv_payment WHERE cust_id = ? AND periode = ? AND billing = ? AND status != 5";
    $rs = $mpdb->execute($sql, array($data['cust_id'],$data['periode'],$data['billing']));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }

}
function getInvPaymentById($data){
    global $mpdb;   
    $sql = "SELECT * FROM inv_payment WHERE id = ?";
    $rs = $mpdb->execute($sql, array($data['inv_id']));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function updateInvPaymentById($data){ 
    global $mpdb;
    $sql = "UPDATE inv_payment SET payment_date = ? , payment_status = ? , inv_midtrans_id = ? , status = ?  WHERE id = ?";
    $rs = $mpdb->execute($sql, array($data['payment_date'],$data['payment_status'],$data['inv_midtrans_id'],$data['status'],$data['id'])); 
    if ($rs) {
        return true;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function setInvPayment($data){ 
    global $mpdb;    
    $sql = "INSERT INTO inv_payment (cust_id, periode, billing, payment_method, payment_name, payment_admin_fee, payment_total, inv_blesta_id) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array(   $data['cust_id'], $data['periode'], $data['billing'], $data['payment_method'], $data['payment_name'], $data['payment_admin_fee'],
                                $data['payment_total'], $data['inv_id_blesta'])); 
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
    //    return error_log($mpdb->ErrorMsg());
    //    return print_r($rs);
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function getDateTemp($date){
    global $mpdb;  
    $sql = "SELECT * FROM temp_data_date WHERE date_data = ?";
    $rs = $mpdb->execute($sql, array($date));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function insertDataTemp($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO temp_data_details (cust_id, cust_name, comp_name, subnet_code, subnet_name, user_id, status, domain) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['cust_id'], $arrayInsert['cust_name'], $arrayInsert['comp_name'], $arrayInsert['subnet_code'], $arrayInsert['subnet_name'], $arrayInsert['user_id'], $arrayInsert['status'], $arrayInsert['domain']));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function insertDataTempBackup($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO backup_temp_data_details (cust_id, cust_name, comp_name, subnet_code, subnet_name, user_id, status, domain) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['cust_id'], $arrayInsert['cust_name'], $arrayInsert['comp_name'], $arrayInsert['subnet_code'], $arrayInsert['subnet_name'], $arrayInsert['user_id'], $arrayInsert['status'], $arrayInsert['domain']));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}

function getDataListLocalBySubnet($sublist){
    global $mpdb;      
    $subs = [];
    $subnets = explode(',', $sublist);
    foreach ($subnets as $subnet) {
        $subs[] = $subnet;
    }

    $count = count($subs);
    $in_params = trim(str_repeat('?, ', $count), ', ');
    // global $axdb;
    $sql = "SELECT * FROM temp_data_details WHERE subnet_code IN ({$in_params}) ORDER BY cust_id ASC";

//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
    $rs = $mpdb->execute($sql, $subs);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getDataListLocalBySubnet_backup($sublist){
    global $mpdb;      
    $subs = [];
    $subnets = explode(',', $sublist);
    foreach ($subnets as $subnet) {
        $subs[] = $subnet;
    }

    $count = count($subs);
    $in_params = trim(str_repeat('?, ', $count), ', ');
    // global $axdb;
    $sql = "SELECT * FROM backup_temp_data_details WHERE subnet_code IN ({$in_params}) ORDER BY cust_id ASC";

//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
    $rs = $mpdb->execute($sql, $subs);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getDataListLocalByCustId($custId){
    global $mpdb;      
    $sql = "SELECT * FROM temp_data_details WHERE cust_id = ?";

//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
    $rs = $mpdb->execute($sql, array($custId));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getDataListLocalBackupByCustId($custId){
    global $mpdb;      
    $sql = "SELECT * FROM backup_temp_data_details WHERE cust_id = ?";

//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
    $rs = $mpdb->execute($sql, array($custId));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function truncateDataTemp(){
    global $mpdb;  
    $sql = "TRUNCATE TABLE temp_data_details";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        return true;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function deleteDataTempSingle($subnetCOde){
    global $mpdb;   
    $sql = "DELETE FROM temp_data_details WHERE subnet_code = ? ";
    $rs = $mpdb->execute($sql, array($subnetCOde));
    if ($rs) {
        //return $sql;
        return true;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function truncateDataTempBackup(){
    global $mpdb;  
    $sql = "TRUNCATE TABLE backup_temp_data_details";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        return true;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}

function setDateTemp($dateNow){
    global $mpdb;
    $sql = "UPDATE temp_data_date SET date_data = ? WHERE id = 1";
    $rs = $mpdb->execute($sql, array($dateNow));

    if ($rs) {
        return true;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function insertDataTicket($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ticket_prtg_details (ticket_no, ticket_name, device, sensor, sensor_name, date_time, uptime, downtime, link, message, status_detail, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ticket_no'], $arrayInsert['ticket_name'], $arrayInsert['device'], $arrayInsert['sensor'], $arrayInsert['sensor_name'], $arrayInsert['date_time'], $arrayInsert['uptime'], $arrayInsert['downtime'], $arrayInsert['link'], $arrayInsert['message'], $arrayInsert['status_detail'], $arrayInsert['status']));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function selectMaxIdTicketPRTG(){    
    global $mpdb;  
    $sql = "SELECT MAX(id) FROM ticket_prtg_details";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        $row = $rs->FetchRow();
        return $row;
    } else {
        return 0;
    }
}
function insertDataDomain($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO domain (cust_id, domain_name, subnet_name, status) VALUES(?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['cust_id'], $arrayInsert['domain_name'], $arrayInsert['subnet_name'], $arrayInsert['status']));

    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
//        error_log($mpdb->ErrorMsg());
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function updateDataDomain($id, $arrayUpdate) {
    global $mpdb;
    $sql = "UPDATE domain SET startdate = ? , enddate = ?, ns_data = ?, authcode = ? WHERE id = ?";
    $rs = $mpdb->execute($sql, array($arrayUpdate['startdate'], $arrayUpdate['enddate'], $arrayUpdate['ns_data'], $arrayUpdate['authcode'], $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function updateDataDomainCom1($id, $arrayUpdate) {
    global $mpdb;
    $sql = "UPDATE domain SET startdate = ? , enddate = ?, ns_data = ? WHERE id = ?";
    $rs = $mpdb->execute($sql, array($arrayUpdate['startdate'], $arrayUpdate['enddate'], $arrayUpdate['ns_data'], $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function updateDataDomainCom2($id, $arrayUpdate) {
    global $mpdb;
    $sql = "UPDATE domain SET authcode = ?  WHERE id = ?";
    $rs = $mpdb->execute($sql, array($arrayUpdate['authcode'], $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function updateDataSSL($id, $arrayUpdate) {
    global $mpdb;
    $sql = "UPDATE domain SET end_date_ssl = ?  WHERE id = ?";
    $rs = $mpdb->execute($sql, array($arrayUpdate['end_date_ssl'], $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function updateDataCustDomain($id, $arrayUpdate) {
    global $mpdb;
    $sql = "UPDATE domain SET cust_name = ? , comp_name = ?, subnet_code = ?, user_id = ? WHERE id = ?";
    $rs = $mpdb->execute($sql, array($arrayUpdate['cust_name'], $arrayUpdate['comp_name'], $arrayUpdate['subnet_code'], $arrayUpdate['user_id'], $id));

    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function getAllDomain(){
    global $mpdb;      
    $sql = "SELECT * FROM domain";
    $rs = $mpdb->execute($sql);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getDataInfoCust($custId){
    global $mpdb;      
    $sql = "SELECT * FROM ax_customer_info WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custId));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function insertInfoCustAccount($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ax_customer_info (ACCOUNTNUM) VALUES(?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM']));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function updateInfoCustAccount($custID, $key, $val) {
    global $mpdb;
    $sql = "UPDATE ax_customer_info SET $key = ? WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($val, $custID));
    if ($rs === false) {
        return false;
    } else {
        return true;
    }
}
function insertInfoProduct($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ax_customer_product (ACCOUNTNUM, INVOICEDESCRIPTION, CURRENCYCODE, AMOUNT, STATUS) VALUES(?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['INVOICEDESCRIPTION'], $arrayInsert['CURRENCYCODE'], 
                                     $arrayInsert['AMOUNT'], $arrayInsert['STATUS']));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkInfoProd($arrayInsert){
    global $mpdb;
    $sql = "SELECT * FROM ax_customer_product WHERE ACCOUNTNUM = ? AND INVOICEDESCRIPTION = ? AND CURRENCYCODE = ? AND AMOUNT = ? AND STATUS = ?";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['INVOICEDESCRIPTION'], $arrayInsert['CURRENCYCODE'], 
                                     $arrayInsert['AMOUNT'], $arrayInsert['STATUS']));
    if ($rs) {        
        return $rs->GetArray();
    } else {
        return null; //UNKNOWN ERROR (SQL ERROR)
    }
}
function deleteDataProductByAcc($custID){
    global $mpdb;   
    $sql = "DELETE FROM ax_customer_product WHERE ACCOUNTNUM = ? ";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        //return $sql;
        return true;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function insertTrans($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ax_customer_transaction (ACCOUNTNUM, VOUCHER, TRANSTYPE, TXT, PAYMREFERENCE, TRANSDATE, INVOICE, AMOUNTCUR, CURRENCYCODE) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['VOUCHER'], $arrayInsert['TRANSTYPE'], 
                                     $arrayInsert['TXT'], $arrayInsert['PAYMREFERENCE'], $arrayInsert['TRANSDATE'], $arrayInsert['INVOICE']
                                     , $arrayInsert['AMOUNTCUR'], $arrayInsert['CURRENCYCODE']));
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkInfoTrans($arrayInsert){
    global $mpdb;
    $sql = "SELECT * FROM ax_customer_transaction WHERE ACCOUNTNUM = ? AND VOUCHER = ? AND TRANSTYPE = ? AND TXT = ? AND TRANSDATE = ? AND AMOUNTCUR = ?";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['VOUCHER'], $arrayInsert['TRANSTYPE'], 
                                     $arrayInsert['TXT'], $arrayInsert['TRANSDATE'], $arrayInsert['AMOUNTCUR']));
    if ($rs) {        
        return $rs->GetArray();
    } else {
        return null; //UNKNOWN ERROR (SQL ERROR)
    }
}
function deleteDataTransByAcc($custID){
    global $mpdb;   
    $sql = "DELETE FROM ax_customer_transaction WHERE ACCOUNTNUM = ? ";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        //return $sql;
        return true;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function insertInv($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ax_customer_invoice (ACCOUNTNUM, INVOICEDATE, INVOICEID, LEDGERVOUCHER, INVOICEAMOUNT, NAME, TAXGROUP, CURRENCYCODE) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['INVOICEDATE'], $arrayInsert['INVOICEID'], 
                                     $arrayInsert['LEDGERVOUCHER'], $arrayInsert['INVOICEAMOUNT'], $arrayInsert['NAME'], $arrayInsert['TAXGROUP'], $arrayInsert['CURRENCYCODE']));                                     
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkInfoInv($arrayInsert){
    global $mpdb;
    $sql = "SELECT * FROM ax_customer_invoice WHERE ACCOUNTNUM = ? AND INVOICEDATE = ? AND LEDGERVOUCHER = ? AND INVOICEAMOUNT = ? AND NAME = ? AND TAXGROUP = ?";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['INVOICEDATE'], $arrayInsert['LEDGERVOUCHER'], 
                                     $arrayInsert['INVOICEAMOUNT'], $arrayInsert['NAME'], $arrayInsert['TAXGROUP']));
    if ($rs) {        
        return $rs->GetArray();
    } else {
        return null; //UNKNOWN ERROR (SQL ERROR)
    }
}
function deleteDataInvByAcc($custID){
    global $mpdb;   
    $sql = "DELETE FROM ax_customer_invoice WHERE ACCOUNTNUM = ? ";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return true;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function insertUsername($arrayInsert){
    global $mpdb;  
    $sql = "INSERT INTO ax_customer_username (ACCOUNTNUM, USERNAME, QUOTA, USERNAMESTATUS, DOMAIN) VALUES(?, ?, ?, ?, ?)";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['USERNAME'], $arrayInsert['QUOTA'], 
                                     $arrayInsert['USERNAMESTATUS'], $arrayInsert['DOMAIN']));                                     
    if ($rs) {
        $rowNum = $mpdb->Insert_ID();
        return $rowNum;
    } else {
        return false; //UNKNOWN ERROR (SQL ERROR)
    }
}
function checkUsername($arrayInsert){
    global $mpdb;
    $sql = "SELECT * FROM ax_customer_username WHERE ACCOUNTNUM = ? AND USERNAME = ? AND QUOTA = ? AND USERNAMESTATUS = ? AND DOMAIN = ?";
    $rs = $mpdb->execute($sql, array($arrayInsert['ACCOUNTNUM'], $arrayInsert['USERNAME'], $arrayInsert['QUOTA'], 
                                     $arrayInsert['USERNAMESTATUS'], $arrayInsert['DOMAIN']));
    if ($rs) {        
        return $rs->GetArray();
    } else {
        return null; //UNKNOWN ERROR (SQL ERROR)
    }
}
function getCustInfoProd($custID){
    global $mpdb;      
    $sql = "SELECT * FROM ax_customer_product WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustInfoTrans($custID){
    global $mpdb;      
    $sql = "SELECT * FROM ax_customer_transaction WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustInfoBankAcc($custID){
    global $mpdb;      
    $sql = "SELECT BANKTYPE, MK_VIRTUALACCOUNT FROM ax_customer_info WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustUsername($custID){
    global $mpdb;      
    $sql = "SELECT * FROM ax_customer_username WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustInfoBalance($custID){
    global $mpdb;      
    $sql = "SELECT BALANCEMST FROM ax_customer_info WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustInv($custID){
    global $mpdb;      
    $sql = "SELECT * FROM ax_customer_invoice WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}
function getCustInfoLocal($custID) {
    global $mpdb;
    $sql = "SELECT * FROM ax_customer_info WHERE ACCOUNTNUM = ?";
    $rs = $mpdb->execute($sql, array($custID));
    if ($rs) {
        $cinfo = $rs->GetArray();
        $cinfo['VIRTUAL_ACC'] = getCustInfoBankAcc($custID);
        $cinfo['PROD_LIST'] = getCustInfoProd($custID);
        $cinfo['TRANS_LIST'] = getCustInfoTrans($custID);
        $cinfo['AGING'] = '';
        $cinfo['USERID'] = getCustUsername($custID);
        $cinfo['BALANCE'] = getCustInfoBalance($custID);
        $cinfo['INV_LIST'] = getCustInv($custID);
        $cinfo['DOMAIN'] = array();
        return $cinfo;
    } else {
        return null;
    }
} 
function getAllUserEmptyEzoneId(){
    global $mpdb;      
    $sql = "SELECT * FROM user WHERE ezone_id = 0";
    $rs = $mpdb->execute($sql);
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}