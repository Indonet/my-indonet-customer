<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends ALL_Controller {    
    public function __construct() {
        parent::__construct();   
        if ($this->session->userdata('islogin') != true) echo redirect('auth/logout');
        $cust_id = $this->session->userdata('custID');
        $subnet_code = $this->session->userdata('subnets');
        $data_cust = (array)$this->get_data_ax($cust_id, $subnet_code);   
        $this->data['cust_id'] = $cust_id;   
        $this->data['subnet_code'] = $subnet_code;   
        $this->data['data_cust'] = $data_cust; 
        $this->data['date_now'] = date('d'); 
        $this->data['month_now'] = date('m');   
        $this->data['year_now'] = date('Y'); 
        $this->data['month_year_name_now'] = date('M Y');   
        $this->data['virtual_acc'] = $data_cust['VIRTUAL_ACC'];  
        $this->data['prod_list'] = $data_cust['PROD_LIST'];   
        $this->data['trans_list'] = $data_cust['TRANS_LIST'];   
        $this->data['user_id'] = $data_cust['USERID'];     
        $this->data['balance'] = $data_cust['BALANCE'];   
        $this->data['inv_list'] = $data_cust['INV_LIST'];      
        $this->data['inv_month_total'] = $data_cust['INV_MONTH_TOTAL']; 
        $this->data['inv_detail_data'] = $data_cust['INV_DETAIL_DATA'];  
        $this->data['other_data'] = $this->dashboard_model->get_where_data('other_data', array('status'=>1));  
    }  
    function get_data_ax($cust_id, $subnet_code) {  
        $url_api = 'https://api-my.indonet.id/ax/get_file_cust_data';
        $post = array('cust_id'=>$cust_id); 
        $response = $this->curl->simple_post($url_api, $post);  
        return json_decode($response,true);  
    }   
    function encryptPass($password) {
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT);
        } else {
            $salt = $this->genSalt();
            return crypt($password, $salt);
        }
    } 
    function genSalt($saltType = SALTTYPE) {
        $salt = '$1$changeme$'; //default to MD5 
        switch ($saltType) {
            case SALT_BLOWFISH:
                $salt = '$2y$07$' . generateRandomString(20) . '$';
                break;
            case SALT_MD5: default:
                $salt = '$1$' . generateRandomString(8) . '$';
                break;
        }
        return $salt;
    } 
}

class AUTH_Controller extends ALL_Controller { 
    function checkPostData() {
        if ($this->input->post()) {
            return true;
        } else {
            redirect('error');
        }
    }
    function hash_login($username, $password){ 
        $userData = $this->auth_model->get_where_data_row('user', array('username' => $username));     
        if($userData){
            $isExternal = $userData['is_external']; 
            if($isExternal == 0){
                $hash_pass = $userData['password'];
                if (password_verify($password, $hash_pass)) {
                    return $userData; 
                }
                else {
                    return false;
                } 
            }else{
                $ph = new popHelper();
                $userDetail = $ph->getUserDetail($username);
                if ($userDetail === null) {
                    return false;
                }
        
                $popPass = $userDetail[0]['password'];
                $method = mpph::getCryptMethod($popPass);
                $cryptedPass = mpph::getCryptedPassword($password, $popPass, $method, true);
                
                if ($popPass === $cryptedPass) { 
                    return $userData; 
                }
                else { 
                    return false;
                }  
                // return ($popPass === mpph::getCryptedPassword($password, $popPass, $method, true));
            }
        }else{
            return false;
        } 
    }  
    function encryptNewPass($password) {
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT);
        } else {
            $salt = $this->genSalt();
            return crypt($password, $salt);
        }
    } 
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    } 
    function set_session_user($user_data){  
        $email = explode("@", $user_data['username']);
        $subnetName = '';
        $arraySession = array(  'islogin' => TRUE, 'userID' => $user_data['username'], 'id' => $user_data['id'], 'custID' => $user_data['CUSTID'],
                                'is_subnet_admin' => $user_data['is_admin'], 'is_master' => $user_data['is_master'], 'is_external' => $user_data['is_external'],
                                'userName' => $email[0], 'userData'=> $user_data,'subnets' => $user_data['subnets'],'user_group_id' =>$user_data['user_group_id'],
                                'subnetName' => $user_data, 'subnetsExport' =>  $user_data['subnets']);  
        $this->session->set_userdata($arraySession);  
    }
    function check_ax_login($cust_id, $subnet_code) {        
        $url_api = 'https://api-my.indonet.id/ax/get_info_by_ax_id';
        $post = array('cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post);
        $res = json_decode($response,true);  
        if($res['result']){
            return true;
        }else{  
            return false;
        }       
    }  
}

class ALL_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model(array('auth_model', 'dashboard_model')); 
        $this->load->library('form_validation'); 
        date_default_timezone_set("Asia/Jakarta");   
        include_once('assets/inc/axdb.php');
        include_once('assets/inc/mpph.php');
        include_once('assets/inc/v2/ezapi.php');
        include_once('assets/inc/v2/midapi.php');
        $this->recaptcha_sitekey = '6Lf5lsQdAAAAANB-W_E6HCP5XFaxSQfvm97UU0IS';
        $this->recaptcha_secretkey = '6Lf5lsQdAAAAAKfKlYhzBzlQ7h6z1guQhnAHJQCT';
        $this->data['recaptcha_sitekey'] = $this->recaptcha_sitekey;
        $this->data['recaptcha_secretkey'] =  $this->recaptcha_secretkey;
    } 
    function create_log_user($log_data){ 
        $username = $log_data['username'];
        $cust_id = $log_data['cust_id'];
        $subnet_code = $log_data['subnet_code'];
        $file_name = './files/data_log/'.$cust_id.'-'.$subnet_code.'.log';
        $log = array('username'=>$username, 'log'=>$log_data['log'], 'date'=>date('Y-m-d H:i:s'));
        $fp = fopen($file_name, 'a+');
        fwrite($fp, json_encode($log));
        fclose($fp);  
    } 
    function buildResponse($code, $message, $data=''){ 
        switch ($code) {
            case 200:
                $status = 'OK';
                $res = true;
                break; 
            default:
                $status = 'NOK'; 
                $res = false;
                break;
        } 
        
        $generate = array('result'=>$res, 'code'=>$code, 'status'=>$status, 'message'=>$message, 'data'=>$data);    
        $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($generate, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->_display();
        exit;
    }
}