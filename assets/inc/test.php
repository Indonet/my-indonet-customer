<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('axdb.php');
include_once('mpdb.php');
include_once('mpph.php');
include_once('ezapi.php');

//$axdb->debug = TRUE;

//$arrayEzone = array('custId' => '12345', 'pass' => 'asd123', 'email' => 'asd@asd.com');
//$createUserEzone = createNewUserEzone($arrayEzone);

$custID = '0054986600';

//$userID= 'saj-crb';

//$subID = 'S-001,S-002,S-003,S-004,S-005,S-006,S-007,S-008,S-009,S-010,S-011,S-012,S-013,S-014,S-015,S-016,S-017,S-018,S-019,S-020,S-021,S-22';
// $subID = 'S-002';
//$out = count(getCustListUnderMultiSubnet($subID));


//$out = getCustInfoBal($custID); //get info customer balance by cust id

//$out = getCustInfoForCutomerPrint($custID); //get print invoice by cust id

//$out = getCustByUserId($userID); // get customer info by user id

//$out = getCustListIdNameUnderMultiSubnetLimit($subID, 100, 0); // get limit customer list by subnet id

$out = getCustInvoiceMonthly($custID, 2019, 12); //get invoice monthly by cust id and year month

// $out = getCustLastMonth($custID);

// $out = getCustTotalInvoice($custID, 2020, 01); // get total invoice by cust id

//$out = getCustInvoiceMonthRange('8888888888', 2013, 1, 2015, 12); //get total invoice by cust id and month range

//$out = getSubnetList(); //get all subnet

//$out = getCustInfoAging($custID); //get cust info aging by cust id

// $outCount = getCustListUnderMultiSubnet($subID); //get all customer indonet

//$out = getCustAging($custID); //get cust aging by cust id

//$out = getCustUsernameList();

//$out = getNpwp($custID);

//$out = getCustInfoTest($custID); //get info by cust id
//$custID = '0000004929';
//$out = getCustAging($custID);
//$out = getCustInfo($custID); //get info by cust id

//$out = checkDuplicate($custID); //check duplicate by cust id

//$out = getCustListIdNameUnderSubnetLimit($subID,5); //get customer limit list by subnet id 

//$out = getProdMediaList();
//$out = getProdHierarchyList();

print_r(count($outCount)); //print out data
die();
//foreach($out as $o){
//    $code = 'indonet';
//    $name = $o['INVOICEDESCRIPTION'];
//    $family = $o['MEDIAID'];
//    $active = ($o['ACTIVE']===1)?'production':'obselete';
//    
//    print("\"$name\",\"$code\",\"$family\",\"$active\"\n");
//}

//$out = getProdAllCustList();

//print_r($out);
//print("Service->Name*,Customer contract->Name\n");
/*
foreach($out as $o) {
	$code = "AX-".$o['CUSTTABLE'];
	$name = $o['INVOICEDESCRIPTION'];

	print("\"$name\",\"$code\"\n");
}
//*/

//$out = getCustListUnderMultiSubnet($subID); //get all customer indonet
//print_r($out);
//print("Name*,Status,Organization->Code,Start date,Provider->Code,Parent->Code\n");
/*
foreach($out as $o) {
	$code = "AX-".$o['ACCOUNTNUM'];
	$name = $o['NAME'];
	$type = $o['TYPECUST'];
        $parrent = (isset($o['INVOICEACCOUNT']) && $o['INVOICEACCOUNT']!=" ") ? "AX-".$o['INVOICEACCOUNT'] : '';

	print("\"$code\",\"production\",\"$code\",\"2000-01-01\",\"indonet\",\"$parrent\"\n");
}
//*/

//$out = getCustListUnderMultiSubnet($subID); //get all customer indonet
print("Name*,Code,Status,Delivery model->Name,Parent->Code\n");
///*
foreach($out as $o) {
	$code = "AX-".$o['ACCOUNTNUM'];
	$name = $o['NAME'];
	$type = $o['TYPECUST'];
        $parrent = (isset($o['INVOICEACCOUNT']) && $o['INVOICEACCOUNT']!=" ") ? "AX-".$o['INVOICEACCOUNT'] : '';

	print("\"$name\",\"$code\",\"Active\",\"$type\",\"$parrent\"\n");
}
//*/
//-------------------------------------------------------------------------------------------------------//

//$cinfo = [];
//
//foreach ($cList as $key => $value) {
//    $cusID = preg_replace('/\s+/', '', $value['ACCOUNTNUM']);
//    $arrayCusInfo['cusInfo'] = getCustInfoBal($cusID);
//    array_push($cinfo, $arrayCusInfo['cusInfo']);
//}
//
//
//$salted = '{SSHA512}QkyziROwoy14LLn/ZM2cBKmrcCo++u9nYP59CADbnB0wDU8gY5l5mTFyzsqKSxRp9ty16w5VB390KH/TQMSbuT/FHb4=';
//
////$out = mpph::getCryptedPassword($pass, $salted, 'ssha512', true);
////
////$ph = new popHelper();
////$out = $ph->getUserDetail('jason@indo.net.id');
////
////$user = $out[0];
//if (!isset($cinfo)) {
//    print "ERR";
//}
//
//array_walk_recursive($cinfo, function(&$item, $key) {
//    if (!mb_detect_encoding($item, 'utf-8', true)) {
//        print("k: $key | i: $item \n");
//        $item = utf8_encode($item);
//    }
//});
//
//
//echo json_encode($cinfo);
//
//switch (json_last_error()) {
//    case JSON_ERROR_NONE:
//        echo ' - No errors';
//        break;
//    case JSON_ERROR_DEPTH:
//        echo ' - Maximum stack depth exceeded';
//        break;
//    case JSON_ERROR_STATE_MISMATCH:
//        echo ' - Underflow or the modes mismatch';
//        break;
//    case JSON_ERROR_CTRL_CHAR:
//        echo ' - Unexpected control character found';
//        break;
//    case JSON_ERROR_SYNTAX:
//        echo ' - Syntax error, malformed JSON';
//        break;
//    case JSON_ERROR_UTF8:
//        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
//        break;
//    default:
//        echo ' - Unknown error';
//        break;
//}
//print_r($cinfo);


//$testpass = mpph::getCryptedPassword($pass, $salted, 'ssha512', true);
//
//print_r($testpass);
//
//print_r(mpph::getCryptMethod($testpass));


//print_r(getCustTotalInvoice('0001252535', 2014, 12));

//$subid = 'S-002';
//
////print "Valid SUBNET: $subid :: " . (isValidSubnet($subid)?'YES':'NO');
////print '<br />';
////
//$custList = getCustListUnderSubnet($subid);
//
//print_r($custList);

//print ("\n<br /> ----- <br />\n");

// $subid = 'S-003';

// $custList = getCustListUnderSubnet($subid);


//for ($i = 0; $i <=sizeof($custList); $i++) {
    //if (!json_encode($custList[$i], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)) {
        //print("ERROR AT: $i | " . json_last_error_msg() . "<br />\n");
        
//        var_dump($custList[$i]);
        
        //array_walk_recursive($custList[$i], function(&$val) {
            //$val = utf8_decode($val);
        //});
        
        //print (json_encode($custList[$i]));
        
        //print ("<br />");
    //}
//}

// print_r($custList);

//print_r($custList[438]);

//$ar = Array($custList[438], $custList[439]);

//foreach($custList as $cl) {
//    print (json_encode($cl));
//}

//print(json_encode($ar));

//print(json_encode($custList[438]));

//$billDate = strtotime('2014-12-01');

//$test = registerNew(REG_BY_BILL, 'syarip@kampret.com', '0001252535', '22000', $billDate);
//$test = registerNew(REG_BY_UID, 'syarip2@kampret.com', '0001242635', 'hanegoro');
//$user = "jason@indo.net.id";
//$pass = "d0d0L2015#";
//$test = registerNew(REG_BY_MIGRATE, $user, $pass);
//
//print_r($test);
//
//
////$test = 4;
////print("registerNew: $test<br />\n");
////
//if ($test) {
////    $password = 'dodolgarut';
//    $data = getToken($test);
//    $token = $data['token'];
////
//    $success = processRegister($test, $token);
////    
//    print ("activating... : " . var_dump($success));
//}


//print(genSalt());
//
//print ("<br />\n");
//
//print (encryptPass('dodol'));

//print(genSalt());

//setUserPassword(1, '123456');
//
//$compPass = compareUserPassword('subnet@myportal.com', '12345s6', LOGIN_BY_USER);
//print("pass: " . ($compPass?'ok':'not ok'));

