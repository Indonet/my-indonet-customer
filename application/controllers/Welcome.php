<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends ALL_Controller { 
    public function __construct() {
        parent::__construct();   
        if ($this->session->userdata('islogin') != true) echo redirect('auth/logout');
    }  
	public function index(){
        $this->data['content'] = 'customer/first_page';
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('customer/layout', $this->data); 
	}  
    function generated_data(){
        $cust_id = $this->session->userdata('custID');   
        $subnet_code = $this->session->userdata('subnets');   
        $url_api = 'https://api-my.indonet.id/ax/get_file_cust_ax_new';
        $post = array('cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post);
        $data_cust = json_decode($response,true); 
        if($data_cust){
            $res = array('result' => TRUE);
        }else{  
            $res = array('result' => TRUE);
        }  
        echo json_encode($res);
    }
    function check_generated_data(){
        $cust_id = $this->session->userdata('custID');  
        $subnet_code = $this->session->userdata('subnets');  
        $url_api = 'https://api-my.indonet.id/ax/check_file_cust_ax';
        $post = array('cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post);
        $res = json_decode($response,true); 
        if($res['result']){
            $res = array('result' => TRUE); 
        }else{  
            $res = array('result' => FALSE);
        }   
        echo json_encode($res);   
    }
}
