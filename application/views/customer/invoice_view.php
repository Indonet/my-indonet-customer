<style>
    @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  } 
}
</style>
<div id="section-to-print">
    <div class="row justify-content-center py-8 px-8 px-md-0">
        <div class="col-md-11">
            <div class="d-flex justify-content-between pb-10 flex-column flex-md-row">
                <address>
                    <img src="<?=base_url()?>assets/themes/me/img/indonet-logo.png" class="logo-billing">
                    <br>
                    <br>
                    <strong>PT IndoInternet Tbk</strong><br>
                    <p class="text-muted">Rumah Indonet
                        <br> Jl. Rempoa Raya No. 11 
                        <br> Ciputat, Tangerang Selatan, Banten 15412
                        <br> Telp: (021) 73882525  Fax: (021) 73882626
                        <br> N.P.W.P. : 01.673.865.0-058.000  
                        <br> PKP.: 01.673.865.0-058.000
                    </p>
                </address> 
                <div class="d-flex flex-column align-items-md-end px-0">  
                    <address>  
                        <h3 class="font-bold"><?=$data_cust[0]['NAME']?></h3>
                        <h4 class="font-bold"><?=$data_cust[0]['KNOWNAS']?></h4>
                        <p class=" pt-4">
                            <?php    
                                $dateObj   = DateTime::createFromFormat('!m', $month_bill);
                                $month_name_now = $dateObj->format('F');   
                            ?>
                            <table>
                                <tr>
                                    <td class="width-120">Billing No </td>
                                    <td> : SO-<?php echo $month_now.''.substr($year_bill,2); ?>-<?=$data_cust[0]['ACCOUNTNUM']?></td>
                                </tr>
                                <tr><td class="width-100">Customer No </td><td> : <?=$data_cust[0]['ACCOUNTNUM']?> </td></tr> 
                                <tr><td class="width-100">&nbsp;</td><td> &nbsp; </td></tr> 
                                <tr>
                                    <td class="width-100 font-weight-bold font-14">Billing</td>
                                    <td class=" font-weight-bold font-14"> :  Rp. <?=number_format($inv_month_bill, 0, ',', '.');?> </td>
                                </tr> 
                                <tr><td class="width-100">Invoice Month </td><td> : <?php echo $month_name_now.' '.$year_bill; ?> </td></tr> 
                                <tr><td class="width-100">Due Date  </td><td> : 20 <?php echo $month_name_now.' '. $year_bill; ?></td></tr>  
                            </table>                   
                        </p>
                    </address>
                </div>
            </div>
            <div class="border-bottom w-100"></div> 
        </div>
    </div> 
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0"> 
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="pl-0 font-weight-bold text-muted text-uppercase">Date</th>
                            <th class="text-center font-weight-bold text-muted text-uppercase">Description</th> 
                            <th class="text-center pr-0 font-weight-bold text-muted text-uppercase width-100" colspan="2">Total</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="font-weight-boldest"> 
                            <?php 
                                foreach ((array)$inv_detail_bill as $key => $value) {
                                    if($value['TRANSTYPE'] == '95'){                             
                                        echo '<td>&nbsp;</td>';
                                        echo '<td>Saldo bulan lalu</td>'; 
                                        echo '<td style="text-align: right">IDR</td>';
                                        echo '<td style="text-align: right" class=" width-100">'.number_format($value['AMOUNTMST'],2,",",".").'</td>';
                                    }
                                }
                            ?>
                        </tr>
                        <tr> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php  
                            foreach ((array)$inv_detail_bill as $key => $value) {   
                                if($value['TRANSTYPE'] == '15' && $value['NOTPRINT'] != 1){  
                                    echo "<tr class='font-weight-boldest'>";  
                                    echo '<td>'.date("d - M - Y",strtotime($value['PAYMENTDATE'])).'</td>';                               
                                    echo '<td>'.$value['TXT'].'</td>'; 
                                    echo '<td style="text-align: right">IDR</td>';
                                    echo '<td style="text-align: right"  class=" width-100">'.number_format($value['AMOUNTMST'],2,",",".").'</td>';
                                    echo "</tr>";  
                                }
                            }
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td> 
                        </tr>
                        <?php 
                            foreach ((array)$inv_detail_bill as $key => $value) {   
                                if($value['TRANSTYPE'] != '95' && $value['TRANSTYPE'] != '15' && $value['NOTPRINT'] != 1){  
                                    echo "<tr class='font-weight-boldest'>";  
                                    echo '<td>'.date("d - M - Y",strtotime($value['INVOICEDATE'])).'</td>';                          
                                    echo '<td>'.$value['NAME'].'</td>';                             
                                    echo '<td style="text-align: right">IDR</td>';
                                    echo '<td style="text-align: right"  class=" width-100">'.number_format($value['AMOUNTMST'],2,",",".").'</td>';
                                    echo "</tr>";  
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr> 
                            <!-- <th class="font-weight-bold text-muted text-uppercase">DUE DATE</th> -->
                            <th class="font-weight-bold text-right text-muted text-uppercase">TOTAL AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder"> 
                            <!-- <td>Jan 07, 2018</td> -->
                            <td class="text-danger text-right font-size-h3 font-weight-boldest">Rp. <?=number_format($inv_month_bill,2,",",".");?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
    <div class="col-md-11">
        <div class="d-flex flex-column align-items-md-end px-0 text-right">  
            <button type="button" class="btn btn-light-primary font-weight-bold float-right" onclick="window.print();">Download Invoice</button>
        </div>
    </div>
</div> 