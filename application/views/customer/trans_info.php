<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Transaction Info</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Transaction List
                        <span class="d-block text-muted pt-2 font-size-sm">your transaction list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <div class="table-responsive">
                        <table class="table table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Transaction Date</th>
                                    <th class="text-center">Transaction Description</th>
                                    <th class="text-center"  colspan="2">Total</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <?php  
                                    $trans_array = trans_array($trans_list, $inv_list); 
                                    $trans_desc_old = '';
                                    $trans_date_old = '';
                                    $trans_mount_old = 0;
                                    $no = 1; 
                                    foreach ($trans_array as $key => $value) { 
                                        $trans_desc = $value['trans_desc']; 
                                        $trans_date = $value['trans_date']; 
                                        $trans_amount = $value['trans_amount'];  
                                        if($trans_desc_old == '' && $trans_date_old == ''){ 
                                            $trans_desc_old = $trans_desc; 
                                            $trans_date_old = $trans_date;
                                            $trans_mount_old = $trans_amount;
                                        }else{
                                            if($trans_desc == $trans_desc_old && $trans_date == $trans_date_old){ 
                                                $trans_desc_old = $trans_desc; 
                                                $trans_date_old = $trans_date;
                                                $trans_mount_old = $trans_mount_old+$trans_amount;
                                            }else{
                                                echo '<tr>';
                                                echo '<td>'.$no.'</td>'; 
                                                echo '<td>'.$trans_date_old.'</td>'; 
                                                echo '<td>'.$trans_desc_old.'</td>';  
                                                echo '<td>IDR </td>';  
                                                echo '<td style="text-align: right" class=" width-200">'.number_format($trans_mount_old,0,",",".").'</td>';
                                                echo '</tr>';
                                                
                                                $trans_desc_old = $trans_desc; 
                                                $trans_date_old = $trans_date;
                                                $trans_mount_old = $trans_amount;
                                                $no++;
                                            }
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>