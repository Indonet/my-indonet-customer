<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends AUTH_Controller {   
    public function index() {
        $this->data['title'] = 'Login';
        if ($this->session->userdata('islogin') && $this->session->userdata('is_subnet_admin') == 1) {            
            $this->load->helper('cookie');
            $cookie = $this->input->cookie('ci_cookie_myportal'); // we get the cookie
            $this->input->set_cookie('ci_cookie_myportal', $cookie, '86400');
            redirect('subnet');
        } else if ($this->session->userdata('islogin') && $this->session->userdata('is_subnet_admin') == 0) {
            redirect('dashboard');
        } else { 
            $memcache = new Memcached;
            $memEnable = $memcache->addServer('localhost', 11211);
            $ip = $_SERVER['REMOTE_ADDR'];
            $expiration = 1800; 
            $key = "mp_login_ip_" . $ip;
            if ($memEnable && $cdata = $memcache->get($key)) {
                $login_try = unserialize($cdata);
                $ses_login_try = $login_try;
            } else {
                $ses_login_try = $this->session->userdata('wrong_count');
            }
            if ($ses_login_try == null) {
                $ses_login_try = 0;
            } 
            $this->session->set_userdata(array('wrong_count' => $ses_login_try));
            $this->load->view('auth/login', $this->data);  
        }
    }    
    public function check_login() {
        $this->checkPostData();
        $post = $this->input->post();
        $username = $post['username'];
        $password = $post['password'];    
        $ses_login_try = $this->session->userdata('wrong_count'); 
        $recaptchaResponse = $this->input->post('captchaResponse'); 
        $captcha_validate = false;
        if ($ses_login_try > 3) {
            if($recaptchaResponse != null) {                 
                $post_api = array(
                    'secret'=>$this->recaptcha_secretkey, 'response'=>$recaptchaResponse
                );
                $url_api = "https://www.google.com/recaptcha/api/siteverify";
                $response = $this->curl->simple_post($url_api, $post_api);  
                $finalResponse = json_decode($response, true); 
                if($finalResponse['success']){ 
                    $captcha_validate = true;
                }
            }else{ 
                $ses_login_try++; 
                $this->session->set_userdata(array('wrong_count' => $ses_login_try)); 
                $this->buildResponse(400, 'Wrong Captcha!', ['wrong_count'=>$ses_login_try]);
            }
            if($ses_login_try > 10){
                $message = 'Limit Resource, please try again later';
                $this->buildResponse(400, $message);
            } 
        } else {
            $captcha_validate = true;
        }
        if($captcha_validate){
            if($username != '' && $password != ''){ 
                $user_data = $this->hash_login($username, $password);    
                $client_ip = $this->get_client_ip();  
                if($user_data){
                    $status = $user_data['status'];
                    if($status != 0){  
                        $is_admin = $user_data['is_admin'];
                        $cust_id = $user_data['CUSTID'];
                        $subnet_code = $user_data['subnets'];
                        if($is_admin == 0){  
                            $get_data_ax = $this->check_ax_login($cust_id, $subnet_code);  
                            if($get_data_ax){
                                $this->set_session_user($user_data); 
                                $log_data = array('username'=>$username, 'cust_id'=> $cust_id, 'subnet_code'=> $subnet_code, 'log'=>'login success.');
                                $this->create_log_user($log_data); 
                                $this->session->set_userdata(array('wrong_count' => 0));
                                $this->buildResponse(200, 'Login success', ['is_admin'=>$user_data['is_admin']]); 
                            }else{ 
                                $this->buildResponse(400, 'Sorry, the servers under maintenance', ['wrong_count'=>$ses_login_try]);
                            } 
                        }else{  
                            $this->session->set_userdata(array('wrong_count' => 0));
                            $this->buildResponse(200, 'Login success', ['is_admin'=>$user_data['is_admin']]);
                        }
                    }else{ 
                        $this->buildResponse(400, 'User inactive', ['wrong_count'=>$ses_login_try]);
                    }
                }else{  
                    $ses_login_try++;
                    $this->session->set_userdata(array('wrong_count' => $ses_login_try)); 
                    $this->buildResponse(400, 'Incorrect username or password', ['wrong_count'=>$ses_login_try]);
                }
            }else{ 
                $this->buildResponse(400, 'Input invalid', ['wrong_count'=>$ses_login_try]);
            } 
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    } 
    function register_new_password(){
        $this->session->sess_destroy();
        $token = $this->uri->segment(2);
        if($token != ''){
            $token_data = $this->auth_model->get_where_data_row('user_token_data', ['token'=>$token, 'status'=>0]);
            if($token_data){ 
                $this->data['cust_email'] = $token_data['email'];
                $this->data['cust_id'] = $token_data['cust_id'];
                $this->data['cust_name'] = $token_data['cust_name'];
                $this->data['cust_token'] = $token_data['token'];
                $this->data['title'] = 'New Password';
                $this->data['set_new_password'] = true;
                $this->load->view('auth/login', $this->data);  
            }else{ 
                redirect('login'); 
            }
        }else{
            redirect('login');

        }
    }
    function set_new_password(){
        $cust_token = $this->input->post('cust_token');
        $new_password = $this->input->post('new_password');
        $re_password = $this->input->post('re_password');
        
        $this->form_validation->set_rules('new_password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('re_password', 'Password Confirmation', 'trim|required|matches[new_password]');
        $this->form_validation->set_rules('cust_token', 'token', 'trim|required'); 
        if ($this->form_validation->run() == FALSE) {  
            echo json_encode(array('result'=>false, 'message'=>'Error Set Password')); 
        }else{  
            $token_data = $this->dashboard_model->get_where_data_row('user_token_data', array('token'=>$cust_token, 'status'=>0));
            if($token_data){
                $token_id = $token_data['id'];
                $token = $token_data['token'];
                $cust_name = $token_data['cust_name'];
                $cust_id = $token_data['cust_id'];
                $email = $token_data['email'];
                $type = $token_data['type']; 
                $pass_hash = $this->encryptNewPass($new_password); 
                $user_data = $this->dashboard_model->get_where_data_row('user', array('username'=>$email));
                if($user_data){
                    $this->auth_model->update_db('user_token_data', ['id'=>$token_id], ['status'=>1, 'update_at'=>date('Y-m-d H:i:s')]);
                    echo json_encode(array('result'=>false, 'message'=>'Username already exists')); 
                }else{
                    $postData = array('CUSTID'=>$cust_id, 'username'=>$email, 'password'=> $pass_hash, 'is_admin'=>0 ,'status'=>1, 'blesta_id'=>0); 
                    $save_user = $this->auth_model->add_db('user', $postData);
                    if($save_user){  
                        $this->auth_model->update_db('user_token_data', ['id'=>$token_id], ['status'=>1, 'update_at'=>date('Y-m-d H:i:s')]);
                        //set user blesta 
                        $post_api = array(
                            'type'=>'create_user', 'username'=>$email, 'email'=>$email, 'fname'=> $cust_name, 'axid'=>$cust_id
                        );   
                        $url_api = "https://api-my.indonet.id/blesta";  
                        $response = $this->curl->simple_post($url_api, $post_api);  
                        if($response){
                            $array = json_decode($response); 
                            $uid_blesta = $array->blesta_id; 
                            $this->auth_model->update_db('user', ['id'=>$save_user], ['blesta_id'=>$uid_blesta]);
                        }
                        //set user subnet 
                        $post_api = array(
                            'type'=>'get_info_by_ax_id', 'ax_id'=>$cust_id
                        ); 
                        $url_api = "https://api-my.indonet.id/ax"; 
                        $response = $this->curl->simple_post($url_api, $post_api);  
                        if($response){
                            $array = json_decode($response,1); 

                            $subnets = $array[0]['SALESDISTRICTID']; 
                            $this->auth_model->update_db('user', ['id'=>$save_user], ['subnets'=>$subnets]);                            
                        } 
                        // shell_exec("/var/www/my.indonet.id/cronjob/set_user_blesta.sh 2>&1");
                        // shell_exec("/var/www/my.indonet.id/cronjob/set_subnet_all_user.sh 2>&1"); 
                        echo json_encode(array('result'=>true, 'message'=>'Token')); 
                    }
                }
            }else{
                echo json_encode(array('result'=>false, 'message'=>'Token Invalid')); 
            } 
        } 
    }
    function register_new_user(){ 
        $post = $this->input->post();
        $captcha_validate = false; 
        $ip = $_SERVER['REMOTE_ADDR'];
        $cust_id_reg = $this->input->post('cust_id_reg');
        $inv_month_reg = $this->input->post('inv_month_reg');
        $inv_amount_reg = $this->input->post('inv_amount_reg');
        $email_reg = $this->input->post('email_reg'); 
        $recaptchaResponse = $this->input->post('captchaResponse'); 

        $this->form_validation->set_rules('cust_id_reg', 'Cust Id', 'trim|required');
        $this->form_validation->set_rules('inv_month_reg', 'Cust Id', 'trim|required');
        $this->form_validation->set_rules('inv_amount_reg', 'Cust Id', 'trim|required');
        $this->form_validation->set_rules('email_reg', 'Email', 'trim|required|valid_email'); 
        if ($recaptchaResponse != null) { 
			$post_api = array(
				'secret'=>$this->recaptcha_secretkey, 'response'=>$recaptchaResponse
			);
            $url_api = "https://www.google.com/recaptcha/api/siteverify";
            $response = $this->curl->simple_post($url_api, $post_api);  
			$finalResponse = json_decode($response, true); 
            if($finalResponse['success']){ 
                $captcha_validate = true;
            }
        } 
        if($captcha_validate){ 
            if ($this->form_validation->run() == TRUE) {  
                $exp_inv_month = explode('-', $inv_month_reg);
                $inv_year = $exp_inv_month[0];
                $inv_month = $exp_inv_month[1];
                $post_api = array(
                    'type'=>'get_info_by_ax_id', 'ax_id'=>$cust_id_reg
                ); 
                $url_api = "https://api-my.indonet.id/ax";
                $response = $this->curl->simple_post($url_api, $post_api);  
                $res_cust = json_decode($response, true);  
                if($res_cust){
                    $post_api = array(
                        'type'=>'get_total_inv', 'ax_id'=>$cust_id_reg, 'year'=>$inv_year, 'month'=>$inv_month
                    ); 
                    $url_api = "https://api-my.indonet.id/ax";
                    $response = $this->curl->simple_post($url_api, $post_api);  
                    $res_inv = json_decode($response, true); 
                    $inv_amount_reg = str_replace(".","",$inv_amount_reg); 
                    if($res_inv == $inv_amount_reg){ 
                        $check_email = $this->dashboard_model->get_where_data_row('user', array('username'=>$email_reg, 'status'=>1));
                        if(!$check_email){                            
                            $token = sha1(uniqid(rand(), true)) .''. md5(uniqid(rand(), true).''. md5($res_cust[0]['NAME'], true));
                            $postData = [
                                'token' => $token,
                                'email' => $email_reg,
                                'cust_id' => $cust_id_reg, 
                                'cust_name' => $res_cust[0]['NAME'], 
                                'type' => 'Registrasi',
                                'send_email' => 1,
                                'created_at' => date('Y-m-d H:i:s')
                            ]; 
                            $new = $this->dashboard_model->add_db('user_token_data', $postData);
                            if($new){
                                $url_token = 'https://dev-my.indonet.id/new-password/'.$token;
                                $post_api = array(
                                    'type'=>'user_register', 'cust_email'=>$email_reg, 'cust_name'=> $res_cust[0]['NAME'], 'cust_id'=>$cust_id_reg, 'url_token'=>$url_token
                                ); 
                                $url_api = "https://api-my.indonet.id/emails";
                                $response = $this->curl->simple_post($url_api, $post_api);  
                                if($response){
                                    $this->buildResponse(200, 'register new user'); 
                                }else{
                                    $this->buildResponse(400, "Error send email");
                                } 
                            }
                        }else{
                            $this->buildResponse(400, "This email address is already being used");
                        }                       
                    }else{ 
                        $this->buildResponse(400, "Invoice Amount  doesn't match");
                    }
                }else{
                    $this->buildResponse(400, 'Invalid Customer Id');
                }
            }else{                  
                $this->buildResponse(400, 'Error Registration');
            }
        }else{
            $this->buildResponse(400, 'Error Captcha');
        }
    }
}