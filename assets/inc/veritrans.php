<?php
require_once dirname(__FILE__)."/vt_api/Veritrans.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getUrlVt($data) {
    
    //key Development
    /*
    $server_key_dev = "VT-server-P3suFQLRSnEsUZv_7yG2JEUK";
    $client_key_dev = "VT-client-A0ebYnil-f0LoInY";
    
    Veritrans_Config::$isProduction = false;
    Veritrans_Config::$serverKey = $server_key_dev;
    Veritrans_Config::$clientKey = $client_key_dev;
    */
    
    //key production
    $server_key_prd = "VT-server-mFSkzMVuuxKf1QCvknARVXCb";
    $client_key_prd = "VT-client-r91vxohFBz_OmHM3";
    
    Veritrans_Config::$isProduction = true;
    Veritrans_Config::$serverKey = $server_key_prd;
    Veritrans_Config::$clientKey = $client_key_prd;
    
    
    $arrayData = $data;
    
    $amount = $arrayData['amountTotal'];
    $idInv = $arrayData['idInvEzon'];
    $inv = $idInv."_".$amount;
    $clientId = $arrayData['client_id'];
    $orderId = "AX-".$arrayData['custNum']."-".$arrayData['monthyear']; //for Prod
//    $orderId = "AX-".$arrayData['custNum']."-".$arrayData['monthyear']."-".time(); //for dev
    $extra_data = array('currency' => "IDR", 'cid' => $clientId, 'inv' => $inv);
//    $paywith = array(
//        'credit_card',
//        'mandiri_clickpay',
//        'cimb_clicks',
//        'bank_transfer',
//        'bri_epay',
//        'telkomsel_cash',
//        'xl_tunai',
//        'echannel',
//        'bbm_money',
//        'cstore',
//        'indosat_dompetku',
//        'mandiri_ecash',
//        'bca_klikpay',
//        'bca_klikbca',
//    );
    $paywith = array(
        $arrayData['payment_method']
    );
    $urlBack = "https://myportal.indo.net.id/customer/billingstatment";
    
    $customer_details = array(
        'first_name' => 'user',
        'last_name' => 'demo',
        'email' => 'user@demo.com',
    );

    $item_details = [];
    $item_details[] = array(
                        'id' => "1",
                        'price' => $amount,
                        'quantity' => 1,
                        'name' => "Invoice #SO".$arrayData['monthyear']."-".$arrayData['custNum'],
                    );

    $transaction = array(
        'payment_type' => 'vtweb',
        'vtweb' => array(
            'credit_card_3d_secure' => true,
//                'payment_notification_url' => $callback_url,
            'finish_redirect_url' => $urlBack,
            'unfinish_redirect_url' => $urlBack,
            'error_redirect_url' => $urlBack,
            'enabled_payments' => $paywith,
        ),
        'transaction_details' => array(
            'order_id' => $orderId,
            'gross_amount' => round($amount, 0), // no decimal allowed for creditcard
        ),
//        'customer_details' => $customer_details,
        'item_details' => $item_details,
        'custom_field1' => base64_encode(serialize($extra_data)),
    );
    $vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);
        
    return $vtweb_url;
}