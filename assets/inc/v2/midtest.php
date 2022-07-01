<?php
    include('apis/midtrans_snap_api.php'); 
    $enabled_payments = array(
        "credit_card",
        // "gopay",
        "permata_va",
        "bca_va",
        "bni_va",
        "bri_va",
        // "echannel",
        "other_va",
        // "danamon_online",
        // "mandiri_clickpay",
        // "cimb_clicks",
        // "bca_klikbca",
        // "bca_klikpay",
        // "bri_epay",
        // "xl_tunai",
        // "indosat_dompetku",
        // "kioson",
        // "Indomaret",
        // "alfamart",
        // "akulaku"
    );


    function getApi(){
        $mid = 'G455044411';
        $skey = 'SB-Mid-server-NM3ACu7o5S74Qf5A2G_ks-Xu';
        $ckey = 'SB-Mid-client-IF8mOuxYhuUNbK64';
        $devmode = true;
        return new MidtransSnapApi(
            $mid,
            $skey,
            $ckey,
            $devmode
        ); 
    }
    mid();
    function mid(){ 
        $mid = 'G455044411';
        $skey = 'SB-Mid-server-NM3ACu7o5S74Qf5A2G_ks-Xu';
        $ckey = 'SB-Mid-client-IF8mOuxYhuUNbK64';
        $devmode = true;
        
        $snapApi = getApi();

        $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $return_url = 'https://hsx.indonet.id/';
        $clientId = 6;
        $orderId = $clientId . "-" . time();

        // $notificationURL = Configure::get("Blesta.gw_callback_url") . Configure::get("Blesta.company_id") . "/{$_matches[1]}/" . $clientId;
        $notificationURL = "https://dev-blesta.indonet.co.id/callback/gw/1/midtrans_snap/" . $clientId;

        // switch ($meta['notification_mode']) {
        //     case $this::NOTIF_OVERRIDE:
        //         $snapApi->overrideNotifUrl = $notificationURL;
        //         break;
        //     case $this::NOTIF_APPEND:
        //         $snapApi->appendNotifUrl = $notificationURL;
        //         break;
        //     default:
        // }
        $snapApi->overrideNotifUrl = $notificationURL;
        // $snapApi->appendNotifUrl = $notificationURL;
        $amount = 100000;
        $transaction_details = array(
            'order_id' => $orderId
            // 'gross_amount' => round($amount, 0) // no decimal allowed
        );

        $currency = 'IDR';

        $customer_details = array(
            'first_name' => 'Syarip',
            'last_name' => 'H',
            'email' => 'syarip.hidayatullah@indonet.co.id',
        );
        $invoice_amounts = array(array('id'=>22, 'amount'=>5000)); 
        $item_details = [];
        $amount_left = round($amount, 0);
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
        // $enabled_payments = ['credit_card'];
        $enabled_payments = [ 
        "permata_va",
        "bca_va",
        "bni_va",
        "bri_va", 
        "echannel",
        "other_va",
        // "danamon_online",
        // "mandiri_clickpay",
        // "cimb_clicks",
        // "bca_klikbca",
        // "bca_klikpay",
        // "bri_epay"
        ];
       
        $transaction['enabled_payments'] = $enabled_payments;
        // print_r($snapApi); die();
        $snap = $snapApi->createTransaction($transaction);
        $snapToken = $snap->token;
        // if (!$meta['snapmode']) {
            // header("Location: {$snap->redirect_url}");
            // print_r($snap->redirect_url);
            // print "\n";
        // }
        
        $snapURL = $devmode ? "https://app.sandbox.midtrans.com/snap/snap.js" : "https://app.midtrans.com/snap/snap.js";
        print "<script src='{$snapURL}' data-client-key='{$ckey}'></script>";
        print "\n";
        print "<script language=\"javascript\">
                    snap.pay('$snapToken', {
                    onSuccess: function(result){console.log('success');console.log(result);window.location.replace(result.finish_redirect_url);},
                    onPending: function(result){console.log('pending');console.log(result);window.location.replace(result.finish_redirect_url);},
                    onError: function(result){console.log('error');console.log(result);window.location.replace(result.finish_redirect_url);},
                    onClose: function(){console.log('customer closed the popup without finishing the payment');}
                })
                
                </script>";
    }
?>