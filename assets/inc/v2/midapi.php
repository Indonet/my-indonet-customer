<?php
require_once(__DIR__. '/apis/midtrans_snap_api.php');

global $devmode;
$devmode = false;
if($devmode) {  
    $mid = 'G455044411';
    $skey = 'SB-Mid-server-NM3ACu7o5S74Qf5A2G_ks-Xu';
    $ckey = 'SB-Mid-client-IF8mOuxYhuUNbK64'; 
}else{ 
    $mid = 'M061464';
    $skey = 'VT-server-mFSkzMVuuxKf1QCvknARVXCb';
    $ckey = 'VT-client-r91vxohFBz_OmHM3'; 
} 

global $snapApi;  
$snapApi = new MidtransSnapApi($mid, $skey, $ckey, $devmode);  

function createTransactionMid($dataUser){ 
    global $snapApi; 
    global $devmode; 
       

    $clientId = $dataUser['id_blesta'];
    $inv_desc = $dataUser['inv_desc'];
    $inv_payment_id = $dataUser['inv_payment_id'];
 
    if($devmode) {    
        $ckey = 'SB-Mid-client-IF8mOuxYhuUNbK64'; 
        $notificationURL = "https://dev-blesta.indonet.co.id/callback/gw/1/midtrans_snap/" . $clientId;
        $return_url = "https://my.indonet.id/dashboard?order=".$inv_payment_id;
    }else{  
        $ckey = 'VT-client-r91vxohFBz_OmHM3'; 
        $notificationURL = "https://blesta.indonet.co.id/callback/gw/1/midtrans_snap/" . $clientId;
        $return_url = "https://my.indonet.id/dashboard?order=".$inv_payment_id;
    } 


    $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //$orderId = $clientId . "-" . time();
    $orderId = $inv_desc;

    //$notificationURL = Configure::get("Blesta.gw_callback_url") . Configure::get("Blesta.company_id") . "/{$_matches[1]}/" . $clientId; 

    //switch ($meta['notification_mode']) {
         //case $this::NOTIF_OVERRIDE:
             //$snapApi->overrideNotifUrl = $notificationURL;
             //break;
         //case $this::NOTIF_APPEND:
             //$snapApi->appendNotifUrl = $notificationURL;
             //break;
         //default:
    //}
    //$snapApi->overrideNotifUrl = $notificationURL;
    $transaction_details = array(
        'order_id' => $orderId 
    );
    $currency = 'IDR';
    $customer_details = array(
        'first_name' => $dataUser['fname'],
        'last_name' => $dataUser['lname'],
        'email' => $dataUser['email'],
    );
    $invoice_amounts = array(array('id'=>$dataUser['inv_blesta_id'], 'amount'=>$dataUser['inv_total'])); 
    $item_details = [];
    $amount_left = 0;
    $inv = [];
    foreach ($invoice_amounts as $ia) {
        @$id = $ia['id'];
        @$amt = $ia['amount'];
        $amount_left -= $amt;
        $item_details[] = array(
            'id' => "inv_$id",
            'price' => $amt,
            'quantity' => 1,
            'name' => "Invoice #$id"
        );
        $inv[$id] = $amt;
    }
    
    $extra_data = array('cur' => $currency, 'cid' => $clientId, 'inv' => $inv);
    $transaction = [
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
        'custom_field1' => json_encode($extra_data,JSON_NUMERIC_CHECK),
        'callbacks' => [
            'finish' => $return_url,
            'unfinish' => $current_url,
            'error' => $return_url,
        ],
    ];
    $transaction['enabled_payments'] = $dataUser['enabled_payments']; 
    $snap = $snapApi->createTransaction($transaction);  
    if ($snap) {
        $snapToken = $snap->token;
        // $snapURL = $devmode ? "https://app.sandbox.midtrans.com/snap/snap.js" : "https://app.midtrans.com/snap/snap.js"; 
        $snapURL = $devmode ? "https://app.sandbox.midtrans.com/snap/snap.js" : "https://app.midtrans.com/snap/snap.js";
        $res = array('snapToken'=>$snapToken, 'snapURL'=>$snapURL, 'ckey'=>$ckey);
        return $res; 
    } else {
        return null;
    } 
}
function getStatusMid($order_id){
    global $snapApi; 
    $res = $snapApi->getTransactionStatus($order_id); 
    if($res){
        return $res; 

    } else {
        return null;
    } 
}