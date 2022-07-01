<!DOCTYPE html>
<html lang="en"> 
	<head> 
        <link rel="canonical" href="https://indonet.co.id/" />  
		<meta charset="utf-8" />
		<title><?=$title?> | my.indonet.id</title>
		<meta name="description" content="Dashboard my indonet id" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="canonical" href="https://indonet.co.id/" />  
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />  
		<link href="<?=base_url()?>assets/themes/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/themes/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/themes/css/style.bundle.css" rel="stylesheet" type="text/css" /> 
		<link href="<?=base_url()?>assets/themes/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/themes/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/themes/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/themes/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" /> 
		<link href="<?=base_url()?>assets/themes/me/css/custom.css" rel="stylesheet" type="text/css" />  
		<link href="<?=base_url()?>assets/themes/plugins/apexcharts/dist/apexcharts.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?=base_url()?>assets/themes/me/img/icon_my.png" />
		<script src="<?=base_url()?>assets/themes/plugins/jquery/jquery.min.js"></script> 
		<script src="<?=base_url()?>assets/themes/plugins/global/plugins.bundle.js"></script>  
		<script src="<?=base_url()?>assets/themes/js/scripts.bundle.js"></script>  
		<script src="<?=base_url()?>assets/themes/js/pages/widgets.js"></script> 
		<script src="<?=base_url()?>assets/themes/plugins/sweetalert2/dist/sweetalert2.min.js"></script> 
		<script type="text/javascript">
			var base_url = "<?=base_url()?>";
		</script>
	</head> 
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">  
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed"> 
			<a href="#">
                <img alt="Logo" src="<?=base_url()?>assets/themes/me/img/logo_my_white.png" style="width: 120px"/>		
			</a> 
			<div class="d-flex align-items-center"> 
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>  
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl"> 
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg> 
					</span>
				</button> 
			</div> 
		</div> 
		<div class="d-flex flex-column flex-root"> 
			<div class="d-flex flex-row flex-column-fluid page"> 
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside"> 
					<div class="brand flex-column-auto" id="kt_brand"> 
						<a href="#" class="brand-logo">
							<img alt="Logo" src="<?=base_url()?>assets/themes/me/img/logo_my_white.png" style="width: 180px"/>
						</a> 
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl"> 
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg> 
							</span>
						</button> 
					</div> 
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper"> 
                        <?php include('menu.php');?>
					</div> 
				</div> 
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper"> 
					<?php include('header.php');?> 
					<?php include('func_other.php');?>
                    <?php $this->load->view($content, $this->data);?>  
					<?php include('footer.php');?>
				</div> 
			</div> 
		</div> 
		<div id="kt_quick_user" class="offcanvas offcanvas-right p-10"> 
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">User Profile  
			</div> 
			<div class="offcanvas-content pr-5 mr-n5"> 
				<div class="d-flex align-items-center mt-5">
					<div class="symbol symbol-100 mr-5">
						<div class="symbol-label" style="background-image:url('<?=base_url()?>assets/themes/me/img/icon_profile.jpg')"></div>
						<i class="symbol-badge bg-success"></i>
					</div>
					<div class="d-flex flex-column">
						<a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?=$data_cust[0]['NAME']?></a>
						<div class="text-muted mt-1"><?=$data_cust[0]['KNOWNAS']?></div>
						<div class="navi mt-2">
							<a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary"> 
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg> 
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary"><?=$data_cust[0]['EMAIL']?></span>
								</span>
							</a>
							<a href="<?=base_url()?>auth/logout" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
						</div>
					</div>
				</div> 
				<div class="separator separator-dashed mt-8 mb-5"></div> 
				<div class="navi navi-spacer-x-0 p-0"> 
					<a href="<?=base_url()?>account" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success"> 
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg> 
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">Account</div>
								<div class="text-muted">Account settings and more
								<span class="label label-light-danger label-inline font-weight-bold">update</span></div>
							</div>
						</div>
					</a>  
				</div> 
				<div class="separator separator-dashed my-7"></div> 
				<div> 
					<h5 class="mb-5">Recent Notifications</h5> 
					<div class="d-flex align-items-center bg-light-warning rounded p-5 gutter-b hide">
						<span class="svg-icon svg-icon-warning mr-5">
							<span class="svg-icon svg-icon-lg">
								<!--begin::Svg Icon | path:<?=base_url()?>assets/themes/media/svg/icons/Home/Library.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
										<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</span>
						<div class="d-flex flex-column flex-grow-1 mr-2">
							<a href="#" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">Another purpose persuade</a>
							<span class="text-muted font-size-sm">Due in 2 Days</span>
						</div>
						<span class="font-weight-bolder text-warning py-1 font-size-lg">+28%</span>
					</div> 
					<div class="d-flex flex-center text-center text-muted min-h-200px">
						All caught up!
						<br />
						No new notifications.
					</div> 
				</div> 
			</div> 
		</div>   
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon"> 
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg> 
			</span>
		</div>  
		<script id="sbinit" src="https://chat-my.indonet.id/js/main.js"></script>
	</body> 
</html>