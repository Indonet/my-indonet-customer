
<!DOCTYPE html> 
<html lang="en">
	<!--begin::Head-->
	<head> 
		<meta charset="utf-8" />
		<title><?=$title?> | my.indonet.id</title>
		<meta name="description" content="Singin my indonet id" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <link rel="canonical" href="https://indonet.co.id/" /> 
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> 
		<link href="<?=base_url()?>assets/themes/css/pages/login/login-4.css" rel="stylesheet" type="text/css" /> 
		<link href="<?=base_url()?>assets/themes/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" /> 
		<link href="<?=base_url()?>assets/themes/css/style.bundle.css" rel="stylesheet" type="text/css" />  
		<link href="<?=base_url()?>assets/themes/me/css/custom.css" rel="stylesheet" type="text/css" />  
   		<script src="https://www.google.com/recaptcha/api.js"></script>
		<link rel="shortcut icon" href="<?=base_url()?>assets/themes/me/img/icon_my.png" />
	</head> 
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"> 
		<div class="d-flex flex-column flex-root"> 
			<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid"> 
				<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white"> 
					<div class="login-content d-flex flex-column pt-lg-0 pt-12"> 
						<a href="#" class="login-logo pb-xl-20 pb-15 text-center">
							<img src="<?=base_url()?>assets/themes/me/img/logo_my_2.png" class="" alt="" style="width: 300px" />
						</a> 
						<?php
							if(isset($set_new_password) && $set_new_password == true){
						?>
								<div class="login-form"> 
									<form class="form" id="set_password_form" action="#"> 
										<div class="pb-5 pb-lg-15">
											<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">New Password</h3> 
										</div> 
										<div class="form-group">
											<label class="font-size-h6 font-weight-bolder text-dark">Customer Id</label>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" readonly value="<?=$cust_id?>" autocomplete="off"/>  
										</div> 
										<div class="form-group">
											<label class="font-size-h6 font-weight-bolder text-dark">Username</label>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" readonly value="<?=$cust_email?>" autocomplete="off" id="username"/> 
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0 hide" type="text" readonly value="<?=$cust_token?>" autocomplete="off" id="cust_token"/> 
										</div> 
										<div class="form-group">
											<div class="d-flex justify-content-between mt-n5">
												<label class="font-size-h6 font-weight-bolder text-dark pt-5">New Password</label> 
											</div>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" autocomplete="off" id="new_password"/>
											<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="password" data-validator="notEmpty" class="fv-help-block msg_txt_error">Password is required</div></div>
										</div> 
										<div class="form-group">
											<div class="d-flex justify-content-between mt-n5">
												<label class="font-size-h6 font-weight-bolder text-dark pt-5">Confirm New Password</label> 
											</div>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" autocomplete="off" id="re_password"/>
											<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="password" data-validator="notEmpty" class="fv-help-block msg_txt_error" >Confirm Password is required</div></div>
										</div> 
										<div class="pb-lg-0 pb-5">
											<button type="button" onclick="set_password()" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Submit</button> 
										</div> 
									</form> 
								</div> 
						<?php
							}else{
						?>
								<div class="login-form"> 
									<form class="form" id="login_form" action="#"> 
										<div class="pb-5 pb-lg-15">
											<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
											<div class="text-muted font-weight-bold font-size-h4">New Here?
											<a href="#" onclick="create_account()" class="text-primary font-weight-bolder">Create Account</a></div>
										</div> 
										<div class="form-group">
											<label class="font-size-h6 font-weight-bolder text-dark">Username / Email</label>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" id="username"/>
											<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="username" data-validator="notEmpty" class="fv-help-block">Username is required</div></div>
										</div> 
										<div class="form-group">
											<div class="d-flex justify-content-between mt-n5">
												<label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
												<a href="#" onclick="forgot_password()" class="hide text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a>
											</div>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" id="password"/>
											<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="password" data-validator="notEmpty" class="fv-help-block">Password is required</div></div>
										</div>  
										<div class="form-group captcha_google hide">
											<div class="g-recaptcha" data-sitekey="<?=$recaptcha_sitekey?>" style="transform:scale(1);-webkit-transform:scale(1);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>         
										</div>
										<div class="pb-lg-0 pb-5">
											<input id="wrong_count" class="hide">
											<button type="button" onclick="login()" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button> 
										</div> 
									</form> 
								</div>  
								<div class="register-form hide">  
									<form class="form" id="register_form" action="#"> 
										<div class="pb-5 pb-lg-15">
											<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Create Account</h3> 
											<div class="text-muted font-weight-bold font-size-h4">Have already an account?
											<a href="#" onclick="login_account()" class="text-primary font-weight-bolder">Sign Here</a></div>
										</div> 
										<div class="hide alert alert-custom alert-light-danger div_error_reg" role="alert"><span class="alert-text error_msg_reg"></span></div>													
										<div class="form-group">
											<label class="font-size-h6 font-weight-bolder text-dark">Email</label>
											<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" placeholder="Email login" type="text" autocomplete="off" id="email_reg"/> 
										</div> 
										<hr>
										<div class=" px-10 py-5" style="background-color: #E6E7F0;">
											<p class="font-size-h6 font-weight-bolder text-dark text-center mb-10">Data Customer Indonet</p>
											<div class="form-group">
												<label class="font-size-h6 font-weight-bolder text-dark">Customer Id</label>
												<input class="form-control form-control py-7 px-6" type="text" autocomplete="off" onkeypress="return is_number_key(event)"  placeholder="00XXXXXXXX" id="cust_id_reg"/>  
											</div>  
											<div class="form-group">
												<label class="font-size-h6 font-weight-bolder text-dark">Invoice Month</label>
												<select class="form-control px-6" style="height: 50px;" id="inv_month_reg">  
													<option value="<?=date('Y-m');?>" ><?=date('F Y');?></option> 
													<option value="<?=date('Y-m', strtotime("-1 months"));?>" ><?=date('F Y', strtotime("-1 months"));?></option>
													<option value="<?=date('Y-m', strtotime("-2 months"));?>" ><?=date('F Y', strtotime("-2 months"));?></option>
												</select>
											</div>  
											<div class="form-group">
												<label class="font-size-h6 font-weight-bolder text-dark">Invoice Amount</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text ">Rp. </span>
													</div>
													<input type="text" class="form-control  py-7 px-6"  autocomplete="off" placeholder="XXXXXX" id="inv_amount_reg" onkeyup="format_money(this.value)">
												</div>   
											</div>  
											<div class="g-recaptcha" data-sitekey="<?=$recaptcha_sitekey?>" style="transform:scale(1);-webkit-transform:scale(1);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>         

										</div>  
										<div class="pb-lg-0 pb-5">
											<button type="button" onclick="submit_register()" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Submit</button> 
										</div> 
									</form> 
								</div> 
						<?php
							}
						?>
					</div> 
				</div> 
				<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right hide_mobile">
					<div class="login-conteiner bgi-no-repeat bgi-position-x-right" style="background-image: url(<?=base_url()?>assets/themes/media/svg/illustrations/login-visual-4.svg);">
						<p class="text-white  font-weight-boldest" style="position: absolute; bottom: 10px; margin-left: 20px">© 2021 - PT Indointernet Tbk</p>
						<div class="logo_btm"> 
							<img src="<?=base_url()?>assets/themes/me/img/indonet-logo-light.png" class="m-0 width-200"/>  
						</div>  
					</div>
				</div> 
			</div> 
		</div>    
		<script src="<?=base_url()?>assets/themes/plugins/jquery/jquery.min.js"></script> 
		<script id="sbinit" src="https://chat-my.indonet.id/supportboard/js/main.js"></script>
		<script src="<?=base_url()?>assets/themes/plugins/sweetalert2/dist/sweetalert2.min.js"></script> 
		<script src="<?=base_url()?>assets/themes/me/js/login.js"></script> 
		<script type="text/javascript">
			var base_url = "<?=base_url()?>";
    		var wrong_count = "<?=$this->session->userdata('wrong_count')?>";
			__init();  
		</script> 
	</body> 
</html>