<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(__DIR__ . '/blesta/blesta_api.php');
   
global $api;
//= ezone Production Server
$user = "myportal";
$key = "c98bb30d15f613984e06e7fd760f0f69";
$url = "https://ezone.oncloud.co.id/api/";
 
// ==========================================

//= ezone development server
//$user = "myportal";
//$key = "8bd6bc514778645ef7dc272b10564384";
//$url = "https://dev-ezone.oncloud.co.id/api/";
// ==========================================

$api = new BlestaApi($url, $user, $key);

function getUserEzone($username){
    global $api;    
    $data = array(
        'username' => $username
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
            return ((array) $res2->response());
        } else {
            return false;
            //($res2->errors());
        }
    } else {
        return false;
        // print_r($res1->errors());
    }
}
function createNewUserEzone($dataUser){  
    global $api;
    $explodeEmail = explode("@",$dataUser['email']);
    $firstname = $explodeEmail[0];
    $lastname = $explodeEmail[1];
    $data = array(
        'vars' => array(
            'username' => $dataUser['custId'],
            'new_password' => $dataUser['pass'],
            'confirm_password' => $dataUser['pass'],
            'client_group_id' => 2,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'title' => null, //OPTIONAL
            'company' => null, //OPTIONAL
            'email' =>  $dataUser['email'],
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
                // 'tax_exempt' => false,
                // 'tax_id' => null,
                'default_currency' => 'IDR',
                'language' => 'en_us'
            ),
            'custom' => array(
                'ax_custid' =>  $dataUser['custId'],
            )
        )
    );
    $res3 = $api->post("clients", "create", $data);
    if (!$res3->errors()) {
        $out = (array) $res3->response();
        if (isset($out['settings']))
            unset($out['settings']);
            // print_r($out);
        return $out;    
    }else{
        // print_r($res3->errors());
        return null;
    }
}
function createNewInvoice($dataUser){  
    global $api;
    $tax = false;
    $lines = array();
    foreach ($dataUser['invNow'] as $key => $value) {
        $textDesc = '';
        if(isset($value['NAME'])){
            $textDesc = $value['NAME'];
        }
        if($textDesc == ''){
            $textDesc = $value['TXT'];
        }
        $dataInvItem = array('description' => $textDesc,
                'amount' =>  $value['AMOUNTMST'],
                'qty' => 1,
                'tax' => $tax);
        array_push($lines, $dataInvItem);
    }
    $data = array(
        'vars' => array(
        'client_id' => $dataUser['clientIdEzone'],
        'date_billed' => date("c"),
        'date_due' => date("c"),
        'currency' => "IDR",
        'lines' => 
            $lines
            // array(
            //     'description' => "Line item #2",
            //     'amount' => "3000",
            //     'qty' => 2
            // )
        ,
        'delivery' => array("email")
        )
    );
    $response = $api->post("invoices", "add", $data);
    if (!$response->errors()) {
        $out = $response->response();
        return $out; 
    } else {
        return $response->errors(); 
    }
}
function getIdbyUsername($username){   
    global $api;
    $data = array(
        'username' => $username
    );
    
    $res1 = $api->post("users", "getByUsername", $data);  
    if (!$res1->errors() && $res1->response()){
        $uid = (array) $res1->response();
        $uid = $uid['id'];

        $data = array(
            'user_id' => $uid,
            'get_settings' => false
        );
        $res2 = $api->post("clients", "getByUserId", $data);
        if (!$res2->errors()) {
            // print_r((array) $res2->response());
            return (array)$res2->response();
        } else {
            // print_r($res2->errors());
            return false;
        }
    } else {
        // print_r($res1->errors());
        return false;
    }
}
function getInvEzone($invId){
    global $api;
    $data = array(
        'invoice_id' => $invId
    );
    $response = $api->post("invoices", "get", $data);
    if(!$response->errors()){
        return (array)$response->response();
    }else{
        return false;
    }
}