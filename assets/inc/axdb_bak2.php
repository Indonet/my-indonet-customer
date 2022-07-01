<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('inc/db.php');

define('TBL_CINFO', 'IDN_CUSTINFOPORTAL');
define('TBL_CINVOICE', 'IDN_CUSTINVOICEPORTAL');
define('TBL_CBACC', 'CUSTBANKACCOUNT');
define('TBL_CPROD', 'MK_CUSTTABLEPRODUCT');
define('TBL_CTRANS', 'CUSTTRANS');
define('TBL_CAGING', 'IDN_CUSTAGINGPORTAL');
define('TBL_CUNAME', 'IDN_USERNAMEAX');
define('TBL_CUBAL', 'IDN_CUSTBALANCE');
define('TBL_CUSTRANS', 'IDN_CustInvoiceJourPortal');
define('TBL_NPWP', 'MK_CUSTTABLEPOSTALADDRESS');

$axdb = newAXDB();
//$axdb->debug = TRUE;
$axdb->memCache = TRUE;
$axdb->memCacheHost = 'localhost';
$axdb->SetFetchMode(ADODB_FETCH_ASSOC);

function getNpwp($custID){
    global $axdb;
    $sql = "SELECT TOP 1 ACCOUNTNUM, ADDRESS, CITY FROM " . TBL_NPWP . " WHERE ACCOUNTNUM = ? AND PURPOSE = 'Faktur Pajak'";
    $rs = $axdb->execute($sql, array($custID));
    if ($rs) {
        $cinfo = $rs->GetArray();
        return $cinfo;
    } else {
        return null;
    }
}


function getInvById($custID){
    global $axdb;
    $sql = "SELECT * FROM " . TBL_CUSTRANS . " WHERE INVOICEACCOUNT = ?";
    $rs = $axdb->execute($sql, array($custID));
    if ($rs) {
        $cinfo = $rs->GetArray();
        return $cinfo;
    } else {
        return null;
    }
}

function getCustInfo($custID) {
    global $axdb;
    $sql = "SELECT * FROM " . TBL_CINFO . " WHERE ACCOUNTNUM = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        $cinfo = $rs->GetArray();
        $cinfo['VIRTUAL_ACC'] = getCustBankAcc($custID);
        $cinfo['PROD_LIST'] = getCustProd($custID);
        $cinfo['TRANS_LIST'] = getCustTrans($custID);
        $cinfo['AGING'] = getCustAging($custID);
        $cinfo['USERID'] = getCustUsernameList($custID);
        $cinfo['BALANCE'] = getCustBalance($custID);
        $cinfo['INV_LIST'] = getInvById($custID);
        $cinfo['NPWP'] = getNpwp($custID);
        return $cinfo;
    } else {
        return null;
    }
}

function getCustInfoBal($custID) {
    global $axdb;
    $sql = "SELECT ACCOUNTNUM, NAME, KNOWNAS, MK_CUSTSTATUS, EMAIL FROM " . TBL_CINFO . " WHERE ACCOUNTNUM = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        $cinfo = $rs->GetArray();
        // $cinfo['BALANCE'] = getCustBalance($custID);
        $cinfo['USERID'] = getCustUsernameList($custID);
        return $cinfo;
    } else {
        return null;
    }
}


function getCustInfoAging($custID) {
    global $axdb;
    $sql = "SELECT ACCOUNTNUM, NAME, KNOWNAS FROM " . TBL_CINFO . " WHERE ACCOUNTNUM = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        $cinfo = $rs->GetArray();
        $cinfo['AGING'] = getCustAging($custID); 
        $cinfo['USERID'] = getCustUsernameList($custID); 
        return $cinfo;
    } else {
        return null;
    }
}


function getCustUsernameList($custID) {
	global $axdb;
	$sql = "SELECT * FROM " . TBL_CUNAME . " WHERE CUSTACCOUNT = ?";
	$rs = $axdb->execute($sql, array($custID));
	
	if ($rs) {
		return $rs->GetArray();
	} else {
		return null;
	}
}

function getCustBankAcc($custID) {
    global $axdb;
    $sql = "SELECT CUSTACCOUNT, ACCOUNTID AS BANKTYPE, MK_VIRTUALACCOUNT FROM " . TBL_CBACC . " WHERE CUSTACCOUNT = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}


function getCustBalance($custID) {
    global $axdb;
    $sql = "SELECT BALANCEMST FROM " . TBL_CUBAL . " WHERE ACCOUNTNUM = ?";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getCustAging($custID) {
    global $axdb;
    $sql = "SELECT * FROM " . TBL_CAGING . " WHERE ACCOUNTNUM = ?";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getCustAgingList() {
    global $axdb;
    $sql = "SELECT * FROM " . TBL_CAGING;
    $rs = $axdb->execute($sql);

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getCustProd($custID) {
   global $axdb;
    $sql = "SELECT CUSTTABLE, TEMPLATENAME, PRODUCTHIERARCHY, PRODUCTID, NAME, UNITID, QTY, BASECALC, NETPRICE,DISCOUNT,ONETIMECHARGE, STATUS FROM " . TBL_CPROD . " WHERE CUSTTABLE = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    } 
}

function getCustTrans($custID) {
   global $axdb;
    $sql = "SELECT VOUCHER, TRANSTYPE, TXT, PAYMREFERENCE, TRANSDATE, INVOICE, AMOUNTCUR, CURRENCYCODE,ACCOUNTNUM,TRANSTYPE from " . TBL_CTRANS . " where TRANSTYPE in (0,8,15) AND ACCOUNTNUM = ? ORDER BY TRANSDATE DESC;";
    $rs = $axdb->execute($sql, array($custID));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    } 
}

function getCustInvoiceMonthly($custID, $year = null, $month = null) {
    global $axdb;
    if (!isset($year))
        $year = date("Y");
    if (!isset($month))
        $month = date("n");
    $sql = "SELECT * FROM " . TBL_CINVOICE . "
            WHERE accountnum = ?
            AND YEAR(transdate) = ?
            AND MONTH(transdate) = ?";
    $rs = $axdb->execute($sql, array($custID, $year, $month));

    if ($rs) {
        $ret = $rs->GetArray();
        $lastmo = getCustLastMonth($custID, $year, $month);

        if ($lastmo) {
            array_push($ret, $lastmo);
        }

        return $ret;
    } else {
        return null;
    }
}

function getCustInvoiceMonthRange($custID, $fromyear = null, $frommonth = null, $toyear = null, $tomonth = null) {
    global $axdb;
    if (!isset($fromyear))
        $fromyear = date("Y");
    if (!isset($frommonth))
        $frommonth = date("n");
    if (!isset($toyear))
        $toyear = $fromyear;
    if (!isset($tomonth))
        $tomonth = $frommonth;

    $from = "{$fromyear}-{$frommonth}-01";
    $to = "{$toyear}-{$tomonth}-31";

    $sql = "SELECT * FROM " . TBL_CINVOICE . "
            WHERE accountnum = ?
            AND transdate BETWEEN ? and ?
            ORDER BY transdate DESC";
    $rs = $axdb->execute($sql, array($custID, $from, $to));

    if ($rs) {
        $ret = $rs->GetArray();
        $lastmo = getCustLastMonthRange($custID, $fromyear, $frommonth, $toyear, $tomonth);

        if ($lastmo) {
            foreach ($lastmo as $lm) {
                array_push($ret, $lm);
            }
        }
        return $ret;
    } else {
        return null;
    }
}

function getCustLastMonth($custID, $year = null, $month = null) {
    global $axdb;
    if (!isset($year))
        $year = date("Y");
    if (!isset($month))
        $month = date("n");
    $thedate = "$year-$month-01";
//    $sql = "SELECT ACCOUNTNUM, SUM(ORIGAMOUNT) AS ORIGAMOUNT, SUM(AMOUNTMST) AS AMOUNTMST FROM " . TBL_CINVOICE . "
//            WHERE accountnum = ?
//            AND transdate < ?
//            GROUP BY accountnum";
    $sql = "SELECT SUM(AMOUNTMST) AS AMOUNT FROM " . TBL_CTRANS . "
            WHERE ACCOUNTNUM = ?
            AND TRANSDATE <= DATEADD(MONTH, -1, ?)
            GROUP BY ACCOUNTNUM";

    $rs = $axdb->execute($sql, array($custID, $thedate));
    if ($rs) {
        $ls = $rs->GetArray()[0]['AMOUNT'];
        $ret['ACCOUNTNUM'] = $custID;
        $ret['TXT'] = 'SALDO BULAN LALU';
        $ret['TRANSDATE'] = $thedate;
        $ret['TRANSTYPE'] = 95;
        $ret['ORIGAMOUNT'] = $ls;
        $ret['AMOUNTMST'] = $ls;
        return $ret;
    } else {
        return null;
    }
}

function getCustLastMonthSettlement($custID, $year = null, $month = null) {
    global $axdb;
    if (!isset($year))
        $year = date("Y");
    if (!isset($month))
        $month = date("n");
    $from = strtotime("{$year}-{$month}-01");
    $from = strtotime("-1 month", $from);

    $year = (int) date("Y", $from);
    $month = (int) date("n", $from);

    $sql = "SELECT * FROM " . TBL_CINVOICE . "
            WHERE accountnum = ?
            AND YEAR(transdate) = ?
            AND MONTH(transdate) = ?
            AND transtype = 15
            ORDER BY transdate DESC";

    $rs = $axdb->execute($sql, array($custID, $year, $month));
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getCustLastMonthRange($custID, $fromyear = null, $frommonth = null, $toyear = null, $tomonth = null) {
    global $axdb;
    if (!isset($fromyear))
        $fromyear = date("Y");
    if (!isset($frommonth))
        $frommonth = date("n");
    if (!isset($toyear))
        $toyear = $fromyear;
    if (!isset($tomonth))
        $tomonth = $frommonth;


    $to = "{$toyear}-{$tomonth}-31";

    $sql = "SELECT * FROM " . TBL_CINVOICE . "
            WHERE accountnum = ?
            AND transdate BETWEEN ? and ?
            ORDER BY transdate DESC";
    $rs = $axdb->execute($sql, array($custID, $from, $to));

    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function getCustTotalInvoice($custID, $year, $month) {
    if (!isset($year))
        $year = date("Y");
    if (!isset($month))
        $month = date("n");

    $invoices = getCustInvoiceMonthly($custID, $year, $month);
    $total = 0;

    foreach ($invoices as $invoice) {
        switch ($invoice['TRANSTYPE']) {
            case 8:
            case 15:
                $total += $invoice['AMOUNTMST'];
                break;
            case 95:
                $total += $invoice['AMOUNTMST'];
                break;
            default:
                break;
        }
    }

    return $total;
}

function getCustTotalPayment($custID, $year, $month) {
    if (!isset($year))
        $year = date("Y");
    if (!isset($month))
        $month = date("n");

    $invoices = getCustInvoiceMonthly($custID, $year, $month);
    $total = 0;

    foreach ($invoices as $invoice) {
        if ($invoice['transtype'] === 15) {
            $total += $invoice['amountcur'];
        }
    }

    return $total;
}

function getSubnetList() {
    global $axdb;
    $sql = "SELECT * FROM smmBusRelSalesDistrictGroup WHERE DATAAREAID = 'indo'";
    $rs = $axdb->CacheExecute(300, $sql);
    if ($rs) {
        return $rs->GetArray();
    } else {
        return null;
    }
}

function isValidSubnet($subid) {
    $sublist = getSubnetList();
    foreach ($sublist as $sub) {
        if (strtolower($sub['SALESDISTRICTID']) == strtolower($subid))
            return true;
    }
    return false;
}

function getCustListUnderSubnet($subid) {
    if (!isValidSubnet($subid)) {
        return false;
    } else {
        global $axdb;
        $sql = "SELECT * FROM " . TBL_CINFO . " WHERE SALESDISTRICTID = ? AND DATAAREAID = 'indo'";
        
//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
        $rs = $axdb->execute($sql, array($subid));

        if ($rs) {
            return $rs->GetArray();
        } else {
            return null;
        }
    }
}

function getCustListIdNameUnderSubnet($subid) {
    if (!isValidSubnet($subid)) {
        return false;
    } else {
        global $axdb;
        $sql = "SELECT ACCOUNTNUM, DISTRICTNAME FROM " . TBL_CINFO . " WHERE SALESDISTRICTID = ? AND DATAAREAID = 'indo'";
        
//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
        $rs = $axdb->execute($sql, array($subid));

        if ($rs) {
            return $rs->GetArray();
        } else {
            return null;
        }
    }
}


function getCustListIdNameUnderSubnetLimit($subid, $limit = 50, $offset = -1) {    //offset start from 0
    if (!isValidSubnet($subid)) {
        return false;
    } else {
        global $axdb;
        $sql = "SELECT ACCOUNTNUM, DISTRICTNAME FROM " . TBL_CINFO . " WHERE SALESDISTRICTID = ? AND DATAAREAID = 'indo' ORDER BY ACCOUNTNUM ASC";
        
//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
        $rs = $axdb->CacheSelectLimit(300, $sql, $limit, $offset, array($subid));      

        if ($rs) {
            return $rs->GetArray();
        } else {
            return null;
        }
    }
}


function getCustIdUnderSubnet($subid) {
    if (!isValidSubnet($subid)) {
        return false;
    } else {
        global $axdb;
        $sql = "SELECT ACCOUNTNUM FROM " . TBL_CINFO . " WHERE SALESDISTRICTID = ? AND DATAAREAID = 'indo'";
        
//        $rs = $axdb->Cacheexecute(300, $sql, array($subid));
        $rs = $axdb->execute($sql, array($subid));

        if ($rs) {
            return $rs->GetArray();
        } else {
            return null;
        }
    }
}


function getCustInfoTest($custID) {
    global $axdb;
    $sql = "SELECT * FROM " . TBL_CINFO . " WHERE ACCOUNTNUM = ? AND DATAAREAID = 'indo'";
    $rs = $axdb->execute($sql, array($custID));
    // print_r($rs);
    if ($rs) {
        $cinfo = $rs->GetArray();
        $cinfo['VIRTUAL_ACC'] = getCustBankAcc($custID);
        $cinfo['PROD_LIST'] = getCustProd($custID);
        $cinfo['TRANS_LIST'] = getCustTrans($custID);
        $cinfo['AGING'] = getCustAging($custID);
        $cinfo['USERID'] = getCustUsernameList($custID);
        $cinfo['BALANCE'] = getCustBalance($custID);
        $cinfo['INV_LIST'] = getInvById($custID);
        // $cinfo['NPWP'] = getNpwp($custID);
        return $cinfo;
    } else {
        return null;
    }
}