<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Account</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="row">
                <div class="col-lg-4">  
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header h-auto py-4">
                            <div class="card-title">
                                <h3 class="card-label">User Profile
                                <span class="d-block text-muted pt-2 font-size-sm">User  profile preview</span></h3>
                            </div> 
                        </div> 
                        <div class="card-body py-4">
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Cust Id:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder"><?=$data_cust[0]['ACCOUNTNUM']?></span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Name:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder"><?=$data_cust[0]['NAME']?></span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Knownas:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder"><?=$data_cust[0]['KNOWNAS']?></span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Register Date:</label>
                                <?php 
                                    $reg_date = $data_cust[0]['MK_REGISTRATIONDATE']; 
                                ?>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder"><?=$reg_date?></span>
                                </div>
                            </div> 
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Phone:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder"><?=$data_cust[0]['PHONE']?></span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Email:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                        <?php
                                            $email_array = explode(";",$data_cust[0]['EMAIL']);
                                            foreach ($email_array as $key => $value) {
                                                echo '<a href="#">'.$value.'</a><br>';
                                            }
                                        ?> 
                                    </span>
                                </div>
                            </div> 
                        </div>  
                    </div> 
                </div>
                <div class="col-lg-8"> 
                    <div class="card card-custom gutter-b card-stretch"> 
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x" role="tablist">  
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#contact_view">
                                            <span class="svg-icon svg-icon-success mr-5"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"></path>
                                                    </g>
                                                </svg> 
                                            </span>
                                            <span class="nav-text">Contact Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#setting_view">
                                            <span class="svg-icon svg-icon-primary"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"></path>
                                                    </g>
                                                </svg> 
                                            </span>
                                            <span class="nav-text">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> 
                        <div class="card-body px-10">
                            <div class="tab-content pt-5">  
                                <div class="tab-pane active" id="contact_view" role="tabpanel">
                                    <form class="form">
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <h3 class="font-size-h6 mb-5">User Info:</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">User Name Login</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$this->session->userdata('userID')?>" />
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Customer id</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['ACCOUNTNUM']?>" />
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Name</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['NAME']?>" />
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Knownas</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['KNOWNAS']?>" />
                                            </div>
                                        </div> 
                                        <div class="separator separator-dashed my-10"></div> 
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <h3 class="font-size-h6 mb-5">Contact Info:</h3>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Phone</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['PHONE']?>" />
                                                </div>
                                                <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Email Address</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-at"></i>
                                                        </span>
                                                    </div>
                                                    <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['EMAIL']?>" />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Invoice Address</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-home"></i>
                                                        </span>
                                                    </div>
                                                    <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$data_cust[0]['INVOICEADDRESS']?></textarea>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Instalation Address</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-home"></i>
                                                        </span>
                                                    </div>
                                                    <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$data_cust[0]['INSTALATIONADDRESS']?></textarea>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Faktur Pajak Address</label>
                                            <div class="col-lg-9 col-xl-7">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-home"></i>
                                                        </span>
                                                    </div>
                                                    <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$data_cust[0]['FAKTURPAJAKADDRESS']?></textarea>
                                                </div>
                                            </div>
                                        </div>   
                                    </form>
                                </div>
                                <div class="tab-pane" id="setting_view" role="tabpanel">
                                    <form class="form"> 
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <h3 class="font-size-h6 mb-5">Change Password:</h3>
                                            </div>
                                        </div>  
                                        <?php if ($this->session->userdata('is_external') == 0){ ?> 
                                            <div class="form-group row error_msg hide">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">&nbsp;</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="alert alert-custom alert-light-danger pd-10" role="alert">
                                                        <div class="alert-icon">
                                                            <i class="text-danger flaticon-exclamation-2"></i>
                                                        </div>
                                                        <div class="alert-text alert_text_msg"> 
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Current Password</label>
                                                <div class="col-lg-9 col-xl-6"> 
                                                    <input class="form-control form-control-lg form-control-solid" type="password" id="old_pass"/> 
                                                    <div class="fv-plugins-message-container  error_empty_msg hide">
                                                        <div data-field="password" data-validator="notEmpty" class="fv-help-block">Current Password is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">New Password</label>
                                                <div class="col-lg-9 col-xl-6"> 
                                                    <input class="form-control form-control-lg form-control-solid" type="password" id="new_pass"/> 
                                                    <div class="fv-plugins-message-container  error_empty_msg hide">
                                                        <div data-field="password" data-validator="notEmpty" class="fv-help-block">New Password is required</div>
                                                    </div>
                                                    <div class="fv-plugins-message-container  error_same_msg hide">
                                                        <div data-field="password" data-validator="notEmpty" class="fv-help-block">New Password is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Confirm New Password</label>
                                                <div class="col-lg-9 col-xl-6"> 
                                                    <input class="form-control form-control-lg form-control-solid" type="password" id="conf_new_pass"/> 
                                                    <div class="fv-plugins-message-container  error_empty_msg hide">
                                                        <div data-field="password" data-validator="notEmpty" class="fv-help-block">Confirm New  is required</div>
                                                    </div>
                                                    <div class="fv-plugins-message-container  error_same_msg hide">
                                                        <div data-field="password" data-validator="notEmpty" class="fv-help-block">New Password is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="button" class="btn btn-primary mr-2 " onclick="change_password()">Submit</button> 
                                            </div>
                                        <?php }else{ ?> 
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">&nbsp;</label>
                                                <div class="col-lg-9 col-xl-6"> 
                                                    <div class="alert alert-custom alert-default" role="alert">
                                                        <div class="alert-icon">
                                                            <span class="svg-icon svg-icon-primary svg-icon-xl"> 
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"></path>
                                                                        <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                    </g>
                                                                </svg> 
                                                            </span>
                                                        </div>
                                                        <div class="alert-text">to change your password, please contact our support</div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?> 
                                    </form>
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div>
            </div> 
        </div> 
    </div> 
</div>
<script>
    function change_password(){
        var old_pass = $('#old_pass').val();
        var new_pass = $('#new_pass').val();
        var conf_new_pass = $('#conf_new_pass').val();
        $('.error_msg').addClass('hide'); 
        $('.error_empty_msg').addClass('hide');
        if(old_pass != '' && new_pass != '' && conf_new_pass != ''){
            if(new_pass == conf_new_pass){
                if(new_pass.length >= 8){
                    $.ajax({
                        type: "POST",
                        url: base_url+"check_current_pass",
                        data: { 
                            'old_pass':old_pass, 'conf_new_pass':conf_new_pass
                        },
                        cache: false,
                        dataType: "json",
                        success: function (res) { 
                            if(res.result){
                                Swal.fire({
                                    title: 'Change Password Success',
                                    html: '',
                                    icon: 'success',  
                                }).then((result) => { 
                                    location.reload(); 
                                }) 
                            }else{
                                $('.error_msg').removeClass('hide');
                                $('.alert_text_msg').html('<code>Current Password</code> does not match !');
                                $('#old_pass').focus();
                            }
                        }
                    }); 
                }else{
                    $('.error_msg').removeClass('hide');
                    $('.alert_text_msg').html('New Password must be at least<code>8 characters</code>!');
                }
            }else{ 
                $('.error_msg').removeClass('hide');
                $('.alert_text_msg').html('<code>New Password</code> and <code>Confirm New Password</code> does not match !');
            }
        }else{
            $('.error_empty_msg').removeClass('hide');
        }
    }
</script>