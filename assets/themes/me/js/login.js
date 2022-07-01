function __init(){
    // disable_right_click();
    if ($(window).width() < 960) {
        $('.hide_mobile').addClass('hide');
    } 
    $('#login_form input').keypress(function (a) {
        if (a.which == 13) { 
            login();
        }
    }); 
    $('#set_password_form input').keypress(function (a) {
        if (a.which == 13) { 
            set_password();
        }
    });  
    if (wrong_count != "") {
        $('#wrong_count').val(wrong_count);
        if(wrong_count >= 3){
            $('.captcha_google').removeClass('hide');
        }
    }
}
function disable_right_click(){
    $('body').bind('cut copy', function (e) {
        e.preventDefault();
    });
    //Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    }); 
}
function login_account(){
    grecaptcha.reset();
    $('.login-form').removeClass('hide'); 
    $('.register-form').addClass('hide');
}
function create_account(){
    grecaptcha.reset();
    $('.register-form').removeClass('hide');
    $('.login-form').addClass('hide'); 
}
function format_money(num){
    var num =  num.replace(/\./g,'');
    var money =  num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); 
    $('#inv_amount_reg').val(money);
}
function login(){   
    var username = $('#username').val();
    var password = $('#password').val();
    var captchaResponseInput = $('#login_form').find('#g-recaptcha-response').val();    
    $('.error_empty_msg').addClass('hide');
    if(username != '' && password != ''){
        Swal.fire ({
            onBeforeOpen: () => { 
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            type: "POST",
            url: base_url+"submit-login",
            data: { 
                'username':username, 'password':password, 'captchaResponse':captchaResponseInput
            },
            cache: false,
            dataType: "json",
            success: function (res) { 
                if(res.result){
                    var is_admin = res.data.is_admin;
                    if(is_admin == 0){ 
                        Swal.fire({
                            title: 'Login Success',
                            html: '',
                            icon: 'success',
                            timer: 2000, 
                            buttons: false,
                            showConfirmButton: false
                        }).then((result) => {
                            window.location.href = base_url+'redirect/';
                        }) 
                    }else{  
                        Swal.fire({
                            title: 'Login Failed',
                            html: 'Admin? please re-login in https://admin-my.indonet.id',
                            icon: 'warning'
                        }).then((result) => {
                            window.location.href = 'https://admin-my.indonet.id/';
                        })  
                    }
                }else{
                    $('#wrong_count').val(res.data.wrong_count);
                    if(res.data.wrong_count > 3){ 
                        $('.captcha_google').removeClass('hide');
                        grecaptcha.reset();
                    }
                    Swal.fire(res.message,'','error').then((result) => { 
                        // location.reload(); 
                    });  
                }
            }
        }); 
    }else{	
        $('.error_empty_msg').removeClass('hide');
    }
}
function submit_register(){ 
    $('.div_error_reg').addClass('hide');
    var email_reg = $('#email_reg').val();
    var cust_id_reg = $('#cust_id_reg').val();
    var inv_month_reg = $('#inv_month_reg').val();
    var inv_amount_reg = $('#inv_amount_reg').val();  
    var captchaResponseInput = $('#register_form').find('#g-recaptcha-response-1').val();    
    if(email_reg != '' && cust_id_reg != '' && inv_month_reg != '' && inv_amount_reg != '' && captchaResponseInput != ''){  
        if (validateEmail(email_reg)) { 
            Swal.fire ({
                onBeforeOpen: () => {
                    swal.fire({
                        html: '<h5>Please wait...</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    Swal.showLoading ()
                }
            });  
            $.ajax({
                type: "POST",
                url: base_url+"new-register",
                data: {'email_reg': email_reg, 'cust_id_reg':cust_id_reg, 'inv_month_reg':inv_month_reg, 'inv_amount_reg':inv_amount_reg, 
                        'captchaResponse':captchaResponseInput
                    },
                cache: false,
                dataType: "json",
                success: function (res) { 
                    swal.close();
                    if(res.result){
                        grecaptcha.reset();  
                        Swal.fire('','Check Your Email To Activate Your Account','success').then((result) => { 
                            window.location.href = base_url+'login';
                        });  
                    }else{ 
                        grecaptcha.reset(); 
                        $('.error_msg_reg').html(res.message);
                        $('.div_error_reg').removeClass('hide');
                    }
                }
            });
        }else{ 
            $('.error_msg_reg').html('*Incorrect email.');
            $('.div_error_reg').removeClass('hide');
        }
    }else{ 
        $('.error_msg_reg').html('*Please input all field.');
        $('.div_error_reg').removeClass('hide');
    } 
} 
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function forgot_password(){
    Swal.fire({
        text: "to Reset your Password, please contact our Support",
        icon: "info",
        buttonsStyling: false,
        confirmButtonText: "Ok",
        customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
        }
    }).then(function() {
         
    });
}
function set_password(){   
    var cust_token = $('#cust_token').val();
    var new_password = $('#new_password').val();
    var re_password = $('#re_password').val();
    $('.error_empty_msg').addClass('hide');
    if(cust_token != '' && new_password != '' && re_password != ''){
        if(new_password == re_password){
            if(new_password.length >= 8){
                Swal.fire ({
                    onBeforeOpen: () => { 
                        Swal.showLoading ()
                    }
                }); 
                $.ajax({
                    type: "POST",
                    url: base_url+"auth/set_new_password",
                    data: { 
                        'cust_token':cust_token, 'new_password':new_password, 're_password':re_password
                    },
                    cache: false,
                    dataType: "json",
                    success: function (res) { 
                        if(res.result){ 
                            Swal.fire({
                                title: 'Set Password Success',
                                html: '',
                                icon: 'success',
                                timer: 2000, 
                                buttons: false,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.href = base_url;
                            });									
                        }else{
                            Swal.fire(res.message,'','error').then((result) => { 
                                location.reload(); 
                            });  
                        }
                    }
                }); 
            }else{
                $('.msg_txt_error').html("Password minimum 8 karakter");
                $('.error_empty_msg').removeClass('hide'); 
            }
        }else{ 
            $('.msg_txt_error').html("Password doesn't match");
            $('.error_empty_msg').removeClass('hide');
        }
    }else{	
        $('.msg_txt_error').html('field is required');
        $('.error_empty_msg').removeClass('hide');
    }
}
function is_number_key(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57))
        return false;

    return true;
}
