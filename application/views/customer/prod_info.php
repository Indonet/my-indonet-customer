<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Products Info</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Products List
                        <span class="d-block text-muted pt-2 font-size-sm">your products list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <div class="table-responsive">
                        <table class="table  table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" >No</th>
                                    <th class="text-center" >Product Name</th> 
                                    <th class="text-center" colspan="2">Total</th> 
                                    <th class="text-center" >Status</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <?php   
                                    $prod_array = prod_array($prod_list); 
                                    $prod_desc_old = '';
                                    $prod_date_old = '';
                                    $prod_amount_old = 0;
                                    $no = 1;  
                                    foreach ($prod_array as $key => $value) { 
                                        $prod_desc = $value['prod_desc'];
                                        $prod_amount = $value['prod_amount'];
                                        $prod_status = $value['prod_status']; 
                                        $status = '<span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Active</span>';
                                    
                                        if($prod_desc_old == ''){ 
                                            $prod_desc_old = $prod_desc;  
                                            $prod_amount_old = $prod_amount;
                                        }else{
                                            if($prod_desc == $prod_desc_old){ 
                                                $prod_desc_old = $prod_desc;  
                                                $prod_amount_old = $prod_amount_old+$prod_amount;
                                            }else{
                                                echo '<tr>';
                                                echo '<td>'.$no.'</td>';  
                                                echo '<td>'.$prod_desc_old.'</td>';  
                                                echo '<td>IDR</td>';  
                                                echo '<td style="text-align: right" class=" width-100">'.number_format($prod_amount_old,0,",",".").'</td>';
                                                echo '<td class="text-center">'.$status.'</td>';  
                                                echo '</tr>';
                                                
                                                $prod_desc_old = $prod_desc;  
                                                $prod_amount_old = $prod_amount;
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