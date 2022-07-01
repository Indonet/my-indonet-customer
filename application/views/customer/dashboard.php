<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
			<div class="d-flex align-items-center flex-wrap mr-2">  
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>   
			</div> 
			<div class="d-flex align-items-center"> 
				<div class="btn-group">
					<button type="button" class="btn btn-secondary"  onclick="view_acc_list()"><?=$this->session->userdata('custID');?></button>
					<a type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" onclick="view_acc_list()"> </a> 
				</div>
			</div>
		</div>
	</div> 
	<div class="d-flex flex-column-fluid"> 
		<div class="container-fluid"> 
			<div class="card card-custom gutter-b">
				<div class="card-body">
					<div class="d-flex">  
						<div class="flex-grow-1"> 
							<div class="d-flex align-items-center justify-content-between flex-wrap">
								<div class="mr-3"> 
									<a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
										<?=$data_cust[0]['NAME']?>
									<i class="flaticon2-correct text-success icon-md ml-2"></i></a> 
									<div class="d-flex flex-wrap my-2">
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon-users-1"></i>
										 	<?=$data_cust[0]['KNOWNAS']?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon-users"></i>
										 	<?=$data_cust[0]['ACCOUNTNUM']?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-email"></i>
											<?php 
												$email_list = str_replace(";",", ",$data_cust[0]['EMAIL']);
										 		echo $email_list;
											?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-phone"></i>
										 	<?=$data_cust[0]['PHONE']?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-location"></i>
										 	<?=$data_cust[0]['DISTRICTNAME']?>
										</span> 
									</div> 
								</div> 
							</div>  
						</div> 
					</div>
					<div class="separator separator-solid my-7"></div> 
					<div class="d-flex align-items-center flex-wrap">  
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-money-bill-wave"></i>
							</span>
							<?php 
								if(isset($balance[0]['BALANCEMST'])){
									$last_balance = (int)$balance[0]['BALANCEMST'];
								}else{
									$last_balance = 0;
								}
							?>
							<div class="d-flex flex-column text-dark-75">
								<span class="font-weight-bolder font-size-sm">Balance</span>
								<span class="font-weight-bolder font-size-h5"> 
								<span class="text-dark-50 font-weight-bold">Rp. </span><?=number_format($last_balance, 0, ',', '.');?></span>
							</div>
						</div>  
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la  la-clipboard-list"></i>
							</span>
							<div class="d-flex flex-column flex-lg-fill">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Products</span>
								<a href="<?=base_url()?>product_info" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-exchange-alt"></i>
							</span>
							<div class="d-flex flex-column">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Transactions</span>
								<a href="<?=base_url()?>transaction_info" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
					</div> 
				</div>
			</div> 
			<div class="row"> 
				<div class="col-xl-8"> 
					<div class="card card-custom  gutter-b">  
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Products</span>
								<span class="text-muted mt-3 font-weight-bold font-size-sm">All your products Indonet</span>
							</h3> 
						</div> 
						<div class="card-body pt-0 pb-3"> 
							<div class="table-responsive">
								<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
									<thead>
										<tr class="text-uppercase"> 
											<th class="text-center">No</th>
											<th class="text-center">Products</th>
											<th class="text-center" colspan="2">Total</th> 
											<th class="text-center">Status</th>  
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
					<div class="card card-custom gutter-b"> 
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Transactions</span>
								<span class="text-muted mt-3 font-weight-bold font-size-sm">All your transactions Indonet</span>
							</h3> 
						</div> 
						<div class="card-body pt-0 pb-3"> 
							<div class="table-responsive">
								<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
									<thead>
										<tr class="text-uppercase"> 
											<th class="text-center">No</th>
											<th class="text-center">Date</th> 
											<th class="text-center">Description</th>
											<th class="text-center" colspan="2">Total</th> 
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
				<div class="col-lg-4"> 
					<div class="card card-custom gutter-b"> 
						<?php 
							$month_name_now =  date('M Y');   
							$inv_date_list = array(); 
							$inv_bill_list = array();  
							foreach ($inv_month_total as $key => $value) { 
								$y = substr($key, 0,-2);
								$m = substr($key, -2); 
								$inv_date =  date_create($y.'-'.$m); 
								$inv_date = date_format($inv_date,"M Y"); 
								array_push($inv_date_list, $inv_date); 
								array_push($inv_bill_list, $value); 
							}  
							$inv_date_list = json_encode($inv_date_list); 
							$inv_bill_list = json_encode($inv_bill_list); 
						?>
						<div class="card-header h-auto border-0">
							<div class="card-title py-5">
								<h3 class="card-label">
									<span class="d-block text-dark font-weight-bolder">Recent Billing</span>
									<span class="d-block text-muted mt-2 font-size-sm">Billing statement</span>
								</h3>
							</div>
							<div class="card-toolbar">
								<ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
									<li class="nav-item ">
										<a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
											<span class="nav-text font-size-sm"><?=$month_name_now?></span>
										</a>
									</li> 
								</ul>
							</div>
						</div> 
						<div class="card-body"> 
							<p class="text-center font-weight-bolder" style="font-size: 20px;">Rp. <?=number_format($last_balance, 0, ',', '.');?></p>
							<?php 
								$payment_min = 0;
								foreach ($other_data as $key => $value) {
									if($value['code'] == 'payment_min'){
										$payment_min = json_decode($value['data']);
										$payment_min = $payment_min->data;
										break;
									}
								} 
								// $payment_min = 1; // debug mininmal payment
								if($last_balance > 0 && $last_balance >= $payment_min){ ?>
									<div class="pb-5 pay_now_div text-center">
										<p class="font-weight-normal font-size-lg pb-5">Pay Your Bill Online
										<br>With Creditcard, Bank Transfer or Scan QR (QRIS)</p>
										<a href="#" onclick="pay_now()" class="btn btn-danger btn-shadow-hover font-weight-bolder w-100">
											<span style="font-size: 14px;"> PAY NOW </span>
										</a>
									</div>
									<script>
										window.addEventListener('load', function () {
											check_payment();
										})
									</script>
							<?php } ?>
							<div class="pt-2" id="chart_billing"></div>
						</div> 
					</div>
				</div>
			</div>  
		</div> 
	</div> 
</div>		

<div id="div1"></div>
<a id="btn_modal_pay" data-toggle="modal" class="hide" href="#modalpaynow">open modal</a> 
<div id="modalpaynow" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Select Payment Method</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr>
					<div class="mb-10 mt-10">
						<a href="#" class="btn btn-light-primary font-weight-bolder mr-2 type_pay type_1 " onclick="set_payment_method(1)">
							<i class="fas fa-credit-card mr-2"></i>Credit card <span class="label label-success ml-2 hide label_pay label_pay_1">✔</span>
						</a>
						<a href="#" class="btn btn-light-primary font-weight-bolder type_pay type_2" onclick="set_payment_method(2)">
							<i class="far fa-building mr-2"></i>Bank transfer <span class="label label-success ml-2 hide label_pay label_pay_2">✔</span>
						</a> 
						<a href="#" class="btn btn-light-primary font-weight-bolder type_pay type_3 "  onclick="set_payment_method(3)">
							<i class="fas fa-qrcode"></i>QRIS <span class="label label-success ml-2 hide label_pay label_pay_3">✔</span>
						</a>
					</div> 
                </div>
                <br>
                <div class="card"> 
                    <table class="table table-hover"> 
                        <div class="hide">  
                            <input id="tagihan" value="<?=$last_balance?>">
                            <input id="biaya_layanan" value="0">
                            <input id="total_tagihan" value="0">
                            <input id="pay_method" value="0"> 
                            <input id="pay_month" value="<?=$month_now?>"> 
                            <input id="pay_year" value="<?=$year_now?>"> 
                            <input id="cust_id" value="<?=$cust_id?>">  
                        </div>
                        <tbody>                                         
                            <tr> 
                                <td class="text-left" style="width: 300px;">Payment Method</td>
                                <td class="text-right"><span class="pay_type">-</span> </td> 
                            </tr>                                       
                            <tr> 
                                <td class="text-left">Total Bill</td>
                                <td class="text-right"><span class="tagihan_view">Rp. 0,-</span> </td> 
                            </tr>                                   
                            <tr> 
                                <td class="text-left">Admin Fee</td>
                                <td class="text-right"><span class="biaya_layanan">Rp. 0,-</span> </td> 
                            </tr>                                  
                            <tr> 
                                <td class="text-left">Pay Total</td> 
                                <td class="text-right"><span class="total_tagihan">Rp. 0,-</span> </td> 
                            </tr>
                        </tbody>
                    </table> 
                </div>  
                <hr>
                <div class="text-center">
                    <button class="btn btn-success mr-2 btn_pay_now hide font-weight-bolder" onclick="confirm_pay_now()"><i class=" flaticon2-check-mark"></i>Confirm</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<a class="btn blue hide" id="acc_list_modal_btn" data-toggle="modal" href="#acc_list_modal"></a>   
<div class="modal fade" id="acc_list_modal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Account List</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="#" class="form-horizontal approve_myflow_form" id="approve_myflow_form"  enctype="multipart/form-data" method="post"> 
					<div class="form-group row"> 
						<div class="col-12 table-responsive-lg">
							<table class="table" > 
								<thead class="thead-dark">
									<tr class="">
										<th style="border: none;">No</th>
										<th style="border: none;">Customer ID</th>
										<th style="border: none;">Customer Name</th>
										<th style="border: none;">Subnet</th>
										<!-- <th style="border: none;">Status</th>  -->
										<th style="border: none;">View</th> 
									</tr>   
								</thead>  
								<tbody class="list_view_tabel">     
								</tbody>
							</table>
						</div>
					</div> 	 
				</form> 
			</div>
			<div class="modal-footer"> 
				<button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>
<script src="<?=base_url()?>assets/themes/plugins/apexcharts/dist/apexcharts.min.js"></script>			
<script>   
	var last_balance = "<?=$last_balance?>";  
	$('.tagihan_view').html('Rp. '+formatNumber(last_balance)+',-');
	function pay_now(){
		$('.type_pay').addClass('btn-light-primary');
		$('.type_pay').removeClass('btn-primary');
		$('.label_pay').addClass('hide');
		$('.btn_pay_now').addClass('hide');
		$('#biaya_layanan').val(0);
		$('.biaya_layanan').html('Rp. '+formatNumber(0)+',-');
		$('.pay_type').html('-');
		$('.total_tagihan').html('Rp. '+formatNumber(0)+',-');
		$('#total_tagihan').val(0);
		$('#btn_modal_pay').click();
	}
	function confirm_pay_now(){
		// $('.loading_modal').removeClass('hide');
		Swal.fire ({
			onBeforeOpen: () => {
				swal.fire({
					html: '<h5>Redirects Payment Gateway.<br>Please wait...</h5>',
					showConfirmButton: false,
					allowOutsideClick: false
				});
				Swal.showLoading ()
			}
		}); 
        $('.btn_pay_now').addClass('hide'); 
        var tagihan = $('#tagihan').val(); 
        var biaya_layanan = $('#biaya_layanan').val();
        var total_tagihan = $('#total_tagihan').val();
        var pay_method = $('#pay_method').val();
        var pay_month = $('#pay_month').val();
        var pay_year = $('#pay_year').val();
        var cust_id = $('#cust_id').val();
        $.ajax({
            type: "POST",
            url: base_url+"create_inv_blesta",
            data: {'cust_id':cust_id, 'month':pay_month, 'year':pay_year, 'tagihan':tagihan, 'biaya_layanan':biaya_layanan, 'total_tagihan':total_tagihan, 'pay_method':pay_method},
            cache: false,
            dataType: "html",
            success: function(res){  
                $('#div1').html(res);   
                setTimeout(function(){ 
					Swal.close ()
                    // $('.loading_modal').addClass('hide'); 
                    $('.btn_pay_now').removeClass('hide');
                }, 3000);
            }
        });
	}
	function set_payment_method(type){
		$('.type_pay').addClass('btn-light-primary');
		$('.type_pay').removeClass('btn-primary');
		$('.label_pay').addClass('hide');
		$('.btn_pay_now').addClass('hide');
		$('#biaya_layanan').val(0);
		$('.biaya_layanan').html('Rp. '+formatNumber(0)+',-');
		$('.pay_type').html('-');
		if(type == 1){
			$('.type_1').addClass('btn-primary');
			$('.type_1').removeClass('btn-light-primary'); 
			$('.label_pay_1').removeClass('hide');
			$('.pay_type').html('Credit Card'); 
			$('.btn_pay_now').removeClass('hide');  

            var biaya_layanan = parseInt(last_balance)*0.027+1980;
            biaya_layanan = Math.ceil(biaya_layanan);
            $('.biaya_layanan').html('Rp. '+formatNumber(biaya_layanan)+',-');
            $('#biaya_layanan').val(biaya_layanan);

            var total_tagihan = parseInt(last_balance)+parseInt(biaya_layanan);    
            $('.total_tagihan').html('Rp. '+formatNumber(total_tagihan)+',-');
            $('#total_tagihan').val(total_tagihan);

            $('#pay_method').val(1);  
		}else if(type == 2){
			$('.type_2').addClass('btn-primary');
			$('.type_2').removeClass('btn-light-primary'); 
			$('.label_pay_2').removeClass('hide');
			$('.pay_type').html('Bank Transfer');
			$('.btn_pay_now').removeClass('hide'); 

            var biaya_layanan = 4400;
            $('.biaya_layanan').html('Rp. '+formatNumber(biaya_layanan)+',-');
            $('#biaya_layanan').val(biaya_layanan);

            var total_tagihan = parseInt(last_balance)+parseInt(biaya_layanan);    
            $('.total_tagihan').html('Rp. '+formatNumber(total_tagihan)+',-');
            $('#total_tagihan').val(total_tagihan);

            $('#pay_method').val(2); 
		}else if(type == 3){
			$('.type_3').addClass('btn-primary');
			$('.type_3').removeClass('btn-light-primary'); 
			$('.label_pay_3').removeClass('hide');
			$('.pay_type').html('QRIS');
			$('.btn_pay_now').removeClass('hide'); 

            var biaya_layanan = parseInt(last_balance)*0.007;
            biaya_layanan = Math.ceil(biaya_layanan);
            $('.biaya_layanan').html('Rp. '+formatNumber(biaya_layanan)+',-');
            $('#biaya_layanan').val(biaya_layanan);

            var total_tagihan = parseInt(last_balance)+parseInt(biaya_layanan);    
            $('.total_tagihan').html('Rp. '+formatNumber(total_tagihan)+',-');
            $('#total_tagihan').val(total_tagihan);

            $('#pay_method').val(3); 
		}
	}

	function check_payment(){
		var URL = window.location.href; 
        var arr_url = URL.split('/');
		var arr_url_2 = arr_url[3]; 
		var arr_url_3 =  arr_url_2.split('=');
		var type_data = arr_url_3[0];
		var type_data_2 =  type_data.split('?');
		var arr_url_4 = arr_url_3[1];
		var arr_url_5 = arr_url_3[2];
        if(arr_url_4 != undefined && arr_url_5 != undefined){   
			var arr_url_6 =  arr_url_4.split('&');
			var arr_url_7 =  arr_url_5.split('&'); 
			var inv_id = arr_url_6[0];
			var mid_id = arr_url_7[0];   
            if(inv_id != 0){ 
                if(type_data_2[1] == 'order'){   
                    // $('.loading_full').removeClass('hide');
					Swal.fire ({
						onBeforeOpen: () => {
							swal.fire({
								html: '<h5>Checking Payment.<br>Please wait...</h5>',
								showConfirmButton: false,
								allowOutsideClick: false
							});
							Swal.showLoading ()
						}
					}); 
                    $.ajax({
                        type: "POST",
                        url: base_url+"check_payment_blesta",
                        data: { 
                            'inv_id':inv_id, 'mid_id':mid_id
                        },
                        cache: false,
                        dataType: "json",
                        success: function (result) {   
                            if(result.res){   
                                // $('.loading_full').addClass('hide');
                                if(result.type == 1){
                                    Swal.fire('Invoice Paid','','success').then((result) => { 
                                        window.location.href = base_url+'dashboard';
                                    });  
                                }else if(result.type == 2){
                                    Swal.fire('','Please complete your payment, for detail check your mail.','success').then((result) => { 
                                        window.location.href = base_url+'dashboard';
                                    });  
                                }
                            }else{ 
								Swal.fire('Error',result.msg,'error').then((result) => { 
									window.location.href = base_url+'dashboard';
								});  
                            }
                        }
                    });
                }  
            } 
        }else{    
            $.ajax({
                type: "POST",
                url: base_url+"check_payment_inv",
                data: {  

                },
                cache: false,
                dataType: "json",
                success: function (res) {     
                    if(res.result){
						if(res.status == 2){ 
                            $('.pay_now_div').html('Awaiting Payment, check your mail.');
                        }else if(res.status == 3){ 
                            $('.pay_now_div').html('Payment by '+res.pay_method); 
                        }
                    }
                }
            });
        }   
	} 
    function formatNumber(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2'); // changed comma to dot here
        }
        return x1 + x2;
    }
	function view_acc_list(){
		$.ajax({
            type: "POST",
            url: base_url+"get_acc_list",
            data: {},
            cache: false,
            dataType: "json",
            success: function(res){  
				if(res){
					var data_list = res.data;
					var list_view = '';
					var no = 1;
					$.each(data_list, function(index, item){ 
						var view_account = '<a href="#" onclick="change_login(\''+item.cust_id+'\')">View</a>';
						if(item.cust_id == res.cust_login){
							view_account = 'Active'; 
						}
						var active_tr = '';
						if(no % 2 == 0){
							active_tr = 'table-active';
						}
						list_view += '<tr class="'+active_tr+'">'+
										'<td style="border: none;">'+no+'</th>'+
										'<td style="border: none;">'+item.cust_id+'</td>'+
										'<td style="border: none;">'+item.cust_ax_name+'</td>'+
										'<td style="border: none;">'+item.cust_subnet_name+'</td>'+
										// '<td style="border: none;">'+item.cust_status_name+'</td>'+
										'<td style="border: none;" class="text-center">'+view_account+'</td>'+
									'</tr> '; 
						no++;
					});
					$('.list_view_tabel').html(list_view);
					$('#acc_list_modal_btn').click(); 
				} 
            }
        });
	}
	function change_login(cust_id){ 
        Swal.fire({ 
            title: "Change View Account",   
            text: 'to Cust Id : '+cust_id,
            icon: 'question',
            showCancelButton: true,  
            confirmButtonText: 'Yes',   
            cancelButtonText: "No", 
            padding: '2em'
        }).then((result) => {
			if (result.value) { 
				Swal.fire ({
                    showConfirmButton: false,
                    onBeforeOpen: () => { 
                        Swal.showLoading ()
                    }
                });
				$.ajax({
					type: "POST",
					url: base_url+"change_login",
					data: {"cust_id":cust_id},
					cache: false,
					dataType: "json",
					success: function(res){  
						if(res){ 
							window.location.href = base_url+'redirect/';
						} 
					}
				});
			}
		});
	}
	var inv_date_list = <?=$inv_date_list?>;
	var inv_bill_list = <?=$inv_bill_list?>; 
	var options = {
		chart: {
			type: 'area'
		},
		series: [{
			name: 'Billing', 
			data: [inv_bill_list[0], inv_bill_list[1], inv_bill_list[2]]
		}],
		yaxis: {
			labels: {
				formatter: function (value) {
					return "Rp. "+Number((value).toFixed(1)).toLocaleString();
				} 

			},
		},
		xaxis: {
			categories: [inv_date_list[0],inv_date_list[1],inv_date_list[2]]
		},
		dataLabels: { 
			formatter: function (val, opt) {  
				return Number((val).toFixed(1)).toLocaleString();
			}
		}
	} 
	var chart = new ApexCharts(document.querySelector("#chart_billing"), options); 
	chart.render();
</script> 