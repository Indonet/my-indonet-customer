<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once(__DIR__ . '/blesta/blesta_api.php');
//= ezone Production Server

//$user = "myportal";
//$key = "c98bb30d15f613984e06e7fd760f0f69";
//$url = "https://ezone.oncloud.co.id/api/";
 
// ==========================================

//= ezone development server
//$user = "myportal";
//$key = "8bd6bc514778645ef7dc272b10564384";
//$url = "https://dev-ezone.oncloud.co.id/api/";
//// ==========================================
//
//$api = new BlestaApi($url, $user, $key);

//$data = array(
//    'username' => 'syarip'
//);
//
//$res1 = $api->post("users", "getByUsername", $data);
//
//print_r($res1);die();
//if (!$res1->errors()) {
//    $uid = (array) $res1->response();
//    $uid = $uid['id'];
//
//    $data = array(
//        'user_id' => $uid,
//        'get_settings' => false
//    );
//    
//    $res2 = $api->post("clients", "getByUserId", $data);
//    if (!$res2->errors()) {
//        print_r((array) $res2->response());
//    } else {
//        print_r($res2->errors());
//    }
//} else {
//    print_r($res1->errors());
//}

//====================
/*

$axid = '1512561262';

$data = array(
    'username' => $axid
);

$res1 = $api->post("users", "getByUsername", $data);

if (!$res1->errors()) {
    $uid = (array) $res1->response();
    $uid = $uid['id'];

    $data = array(
        'user_id' => $uid,
        'get_settings' => false
    );

    $res2 = $api->post("clients", "getByUserId", $data);
    if (!$res2->errors()) {
        $cid = (array) $res2->response();
        $cid = $cid['id'];
        $data = array(
            'client_id' => $cid,
        );
        $res3 = $api->post("clients", "delete", $data);
        if (!$res3->errors()) {
            print "<br />\nuser deleted";
        } else {
            print_r($res3->errors());
        }
    } else {
        
    }
} else {
    // NOT EXISTS, do nothing
}
/*/
//Create client
/*
$axid = '1512561262';
$data = array(
    'vars' => array(
        'username' => $axid,
        'new_password' => 'indo2016',
        'confirm_password' => 'indo2016',
        'client_group_id' => 2,
        'first_name' => 'Dodol',
        'last_name' => 'Kampret',
        'title' => null, //OPTIONAL
        'company' => null, //OPTIONAL
        'email' => 'dodol@oncloud.co.id',
        'address1' => null, //OPTIONAL
        'address2' => null, //OPTIONAL
        'city' => null, //OPTIONAL
        'state' => null, //OPTIONAL
        'zip' => null, //OPTIONAL
        'country' => 'IDN', //OPTIONAL
        'numbers' => null, //OPTIONAL (array of phone numbers/fax)
        'send_registration_email' => false,
        'settings' => array(
            'username_type' => 'username',
//            'tax_exempt' => false,
//            'tax_id' => null,
            'default_currency' => 'IDR',
            'language' => 'en_us'
        ),
        'custom' => array(
            'ax_custid' => $axid
        )
    )
);

print "\n<br />\ncreate user:";

$res3 = $api->post("clients", "create", $data);
if (!$res3->errors()) {
    $out = (array) $res3->response();
    if (isset($out['settings']))
        unset($out['settings']);
    print_r($out);
} else {
    print_r($res3->errors());
}
*/
//=========================================================
//
//$data = array(
//    'vars' => array(
//        'client_id' => 1,
//        'date_billed' => date("c"),
//        'date_due' => date("c"),
//        'currency' => "IDR",
//        'lines' => array(
//            array(
//                'description' => "coba 1",
//                'amount' => "5000",
//                'qty' => 1,
//                'tax' => true
//            ),
////            array(
////                'description' => "Line item #2",
////                'amount' => "3000",
////                'qty' => 2
////            )
//        ),
//        'delivery' => array("email")
//    )
//);
//$response = $api->post("invoices", "add", $data);
//  
//print_r($response->response());
//print_r($response->errors());

//=================
//$data = array(
//        'invoice_id' => 7
//    );
//$response = $api->post("invoices", "get", $data);
//print_r((array)$response->response());
//print_r($response->errors());
//
//$data = array(
//        'invoice_id' => 8
//    );
//$response = $api->post("invoices", "get", $data);
//print_r((array)$response->response());
//print_r($response->errors());
//$response = $api->post("invoices", "add", $data);
  
//print_r($response->response());
require 'ezapi.php';
$response = getIdbyUsername('0049180854');
print_r($response);