<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$memcache = new Memcached;
$memcache->addServer('localhost', 11211) or die("can't connect");

$expiration = 30;

$key = "cinv_" . 125124 . '_201605';

$tmpdata = Array(
    'nama' => 'surip',
    'jabatan' => 'kampret'
);

$sdata = serialize($tmpdata);

if ($cdata = $memcache->get($key)) {
    print "got data: ";
    $udata = unserialize($cdata);
    print_r($udata);
    
} else {
    print "no data, setting";
    $memcache->set($key, $sdata, $expiration);
}