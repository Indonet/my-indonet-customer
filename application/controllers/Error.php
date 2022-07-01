<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {    
	public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
    }
    public function index(){
        redirect('error/html/error_404');
    }
    function not_found(){
        $this->load->view('page/error_not_found');
    }
}