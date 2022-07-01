<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__FILE__)."/vt_api/Veritrans.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadApi() {
    $server_key_dev = "VT-server-P3suFQLRSnEsUZv_7yG2JEUK";
    $client_key_dev = "VT-client-A0ebYnil-f0LoInY";
//Load the files required		
//        Loader::load(dirname(__FILE__) . DS . "api" . DS . "Veritrans.php");

// Set our server key

//        error_log("meta: " . print_r($meta,true));

//        print_r($meta);

//        if ($meta['dev_mode'] === 'true') {
//            print_r("dev");
            Veritrans_Config::$isProduction = false;
            Veritrans_Config::$serverKey = $server_key_dev;
            Veritrans_Config::$clientKey = $client_key_dev;
//            error_log('dev');
//        } else {
////            print_r("prod");
//            Veritrans_Config::$isProduction = true;
//            Veritrans_Config::$serverKey = $meta['server_key'];
//            Veritrans_Config::$clientKey = $meta['client_key'];
////            error_log('prod');
//        }
        $amount = 56831;
        $inv = "12_$amount";
        $clientId = 18;
        $extra_data = array('currency' => "IDR", 'cid' => $clientId, 'inv' => $inv);
        $transaction = array(
            'payment_type' => 'vtweb',
            'vtweb' => array(
                'credit_card_3d_secure' => true,
//                'payment_notification_url' => $callback_url,
                'finish_redirect_url' => 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'unfinish_redirect_url' => 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'error_redirect_url' => 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            ),
            'transaction_details' => array(
                'order_id' => 'AX-1234561-1604',
                'gross_amount' => $amount, // no decimal allowed for creditcard
                ),
            
//            'customer_details' => $customer_details,
//            'item_details' => $item_details,
            'custom_field1' => base64_encode(serialize($extra_data)),
        );
            
//$transaction = array(
//    'transaction_details' => array(
//        'order_id' => rand(),
//        'gross_amount' => 10000, // no decimal allowed for creditcard
//        )
//    );

$vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);
print "<a href='$vtweb_url'>$vtweb_url</a>";

    }
    
    loadApi();