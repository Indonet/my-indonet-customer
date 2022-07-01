<?php
    function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
        return $array;
    }
    function prod_array($prod_list){ 
        $prod_list_sort = aasort($prod_list,"BUNDLINGDESCRIPTION");  
        $prod_desc_old = '';
        $prod__mount_old = 0;
        $prod_array = array();
        foreach ($prod_list_sort as $key => $value) {  
            if($value['STATUS'] == 'Active'){ 
                $status = '';
                $prod_desc = $value['INVOICEDESCRIPTION'];
                $prod_bundling_desc = $value['BUNDLINGDESCRIPTION'];
                $prod_amount = $value['AMOUNT']; 
                $prod_status = $value['STATUS'];
                if($prod_bundling_desc != ''){   
                    $prod_desc = $prod_bundling_desc;  
                    if($prod_desc == $prod_desc_old){ 
                        $array_list = array('prod_desc'=>$prod_desc, 'prod_amount'=>$prod_amount, 'prod_status'=>$prod_status);
                        array_push($prod_array, $array_list);
                    }else{
                        $array_list = array('prod_desc'=>$prod_desc, 'prod_amount'=>$prod_amount, 'prod_status'=>$prod_status);
                        array_push($prod_array, $array_list);
                    }
                    $prod_desc_old = $prod_desc; 
                    $prod__mount_old = $prod_amount; 
                }else{
                    $array_list = array('prod_desc'=>$prod_desc, 'prod_amount'=>$prod_amount, 'prod_status'=>$prod_status);
                    array_push($prod_array, $array_list);
                }
            
            }
        } 
        $array_list = array('prod_desc'=>'', 'prod_amount'=>'', 'prod_status'=>'');
        array_push($prod_array, $array_list);
        return $prod_array;
    }
    function trans_array($trans_list, $inv_list){ 
        $trans_list_sort = aasort($trans_list,"TRANSDATE");  
        $no = 1; 
        $trans_array = array();
        foreach ($trans_list_sort as $key => $value) {  
            foreach ($inv_list as $keyInv => $valueInv) {   
                if($value['TRANSTYPE'] == '8'){
                    $valTransType = 'Customer';
                    if($value['INVOICE'] == $valueInv['INVOICEID']){
                        $descTrans = $valueInv['NAME'];
                    }
                }else if($value['TRANSTYPE'] == '15'){
                    $descTrans = $value['TXT'];
                    $valTransType = 'Payment';
                }else if($value['TRANSTYPE'] == '0'){
                    $descTrans = 'Saldo Awal';
                    $valTransType = '';
                }else{
                    $valTransType = '';
                } 
            } 
            $trans_date =  date_create($value['TRANSDATE']);
            $trans_date = (date_format($trans_date,"d M Y"));  
            $array_list = array('trans_date'=>$trans_date, 'trans_desc'=>$descTrans, 'trans_amount'=>$value['AMOUNTCUR']);
            array_push($trans_array, $array_list);
            $no++;
        } 
        $array_list = array('trans_date'=>'', 'trans_desc'=>'', 'trans_amount'=>'');
        array_push($trans_array, $array_list);
        return $trans_array;
    }
?>