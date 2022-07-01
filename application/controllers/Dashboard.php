<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller { 
    public function index() { 
        $this->data['content'] = 'customer/dashboard';
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('customer/layout', $this->data); 
    } 
    public function account() { 
        $this->data['content'] = 'customer/account';
        $this->data['title'] = 'Account';
        $this->data['menu_active'] = 'account';
        $this->load->view('customer/layout', $this->data); 
    }
    public function product_info() { 
        $this->data['content'] = 'customer/prod_info';
        $this->data['title'] = 'Products Info';
        $this->data['menu_active'] = 'prod_info';
        $this->load->view('customer/layout', $this->data); 
    }
    public function transaction_info() { 
        $this->data['content'] = 'customer/trans_info';
        $this->data['title'] = 'Transactions Info';
        $this->data['menu_active'] = 'trans_info';
        $this->load->view('customer/layout', $this->data); 
    }
    public function billing_statement() { 
        $this->data['content'] = 'customer/billing';
        $this->data['title'] = 'Billing Statement';
        $this->data['menu_active'] = 'billing';
        $this->load->view('customer/layout', $this->data); 
    }
    public function report() { 
        $cust_id = $this->session->userdata('custID');
        $this->data['report_data'] = $this->dashboard_model->get_where_data('report', array('CUSTID'=>$cust_id), 'ID', 'DESC', 24);  
        $this->data['content'] = 'customer/report';
        $this->data['title'] = 'Report';
        $this->data['menu_active'] = 'report';
        $this->load->view('customer/layout', $this->data); 
    }
    public function payment_info() { 
        $this->data['content'] = 'customer/pay_info';
        $this->data['title'] = 'Payment Info';
        $this->data['menu_active'] = 'pay_info';
        $this->load->view('customer/layout', $this->data); 
    }
    function get_acc_list(){ 
        $cust_id = $this->session->userdata('id');
        $cust_id_login = $this->session->userdata('custID');
        $user_data =  $this->dashboard_model->get_where_data_row('user', ['id'=>$cust_id], 'id', 'DESC');  
        if($user_data){
            $user_group_id = $user_data['user_group_id'];
            if($user_group_id != 0){ 
                $array_data =  $this->dashboard_model->get_user_group_by_id($user_group_id); 
            }else{
                $cust_ax_data =  $this->dashboard_model->get_where_data_row('ax_customer_list', ['cust_id'=>$cust_id_login], 'id', 'DESC');    
                $array_data = array(array('cust_id'=>$cust_id_login, 'cust_ax_name'=>$cust_ax_data['cust_name'], 'cust_subnet_name'=>$cust_ax_data['cust_subnet_name'], 
                                    'cust_subnet_code'=>$cust_ax_data['cust_subnet_code'], 'cust_status_name'=>$cust_ax_data['cust_status_name']));
            }
        }
        $res = array('result' => TRUE, 'data' => $array_data, 'cust_login'=>$cust_id_login);  
        echo json_encode($res); 
    }
    function change_login(){
        $cust_id = $this->session->userdata('id');
        $cust_id_select = $this->input->post('cust_id'); 
        $user_data =  $this->dashboard_model->get_where_data_row('user', ['id'=>$cust_id], 'id', 'DESC');  
        if($user_data){
            $user_group_id = $user_data['user_group_id'];
            if($user_group_id != 0){ 
                $array_data =  $this->dashboard_model->get_user_group_by_id($user_group_id);
                $cust_valid = false;
                foreach ($array_data as $key => $value) {
                    $cust_id_val = $value['cust_id'];
                    if($cust_id_val == $cust_id_select){
                        $cust_valid = true;
                    }
                }
                if($cust_valid){ 
                    $new_cust_data = $this->dashboard_model->get_where_data_row('ax_customer_list', ['cust_id'=>$cust_id_select], 'id', 'DESC');
                    $arraySession = array(  'islogin' => TRUE, 'userID' => $user_data['username'], 'id' => $user_data['id'], 'custID' => $cust_id_select,
                            'is_subnet_admin' => $user_data['is_admin'], 'is_master' => $user_data['is_master'], 'is_external' => $user_data['is_external'],
                            'userData'=> $user_data,'subnets' => $new_cust_data['cust_subnet_code'],'user_group_id' =>$user_data['user_group_id'],
                            'subnetName' => $new_cust_data['cust_subnet_name'], 'subnetsExport' => $new_cust_data['cust_subnet_code']);  
                    $this->session->set_userdata($arraySession);  
                } 
            }else{
                
            }
        }
        $res = array('result' => TRUE);  
        echo json_encode($res); 
    }
    public function get_inv_view() { 
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        if($year == ''){  
            $year = date('Y');  
        }
        if($month == ''){    
            $month = date('m');  
        }
        $ym = $year.''.$month; 
        $this->data['data_cust'] =  $this->data['data_cust'][0];  
        $this->data['year_bill'] = $year;
        $this->data['month_bill'] = $month;
        $this->data['virtual_acc_bca'] =  $this->data['virtual_acc'];
        $this->data['inv_detail_bill'] = $this->data['inv_detail_data'][$ym];  
        $this->data['inv_month_bill'] = $this->data['inv_month_total'][$ym];  
        $this->data['year_bill'] = $year;
        $this->data['month_bill'] = $month;
        $this->load->view('customer/invoice_view_new', $this->data); 
    }
    function check_current_pass(){
        $old_pass = $this->input->post('old_pass');  
        $conf_new_pass = $this->input->post('conf_new_pass');   
        $username = $this->session->userdata('userID');
        $userData = $this->dashboard_model->get_where_data_row('user', array('username' => $username));
        if($userData){
            $user_id = $userData['id'];
            $hash_pass = $userData['password'];
            if (password_verify($old_pass, $hash_pass)) {
                $hash_new_pass = $this->encryptPass($conf_new_pass); 
                $change_pass = $this->dashboard_model->update_db('user', array('id'=>$user_id), array('password'=>$hash_new_pass));
                if($change_pass){
                    $res = array('result' => TRUE);
                }else{
                    $res = array('result' => FALSE);
                }
            }
            else {
                $res = array('result' => FALSE);
            } 
        }
        echo json_encode($res); 
    }    
    function check_payment_inv(){
        $cust_id = $this->data['cust_id'];
        $date_now = $this->data['date_now'];
        $month_now = $this->data['month_now'];
        $year_now = $this->data['year_now'];
        $balance = (int)$this->data['balance'][0]['BALANCEMST'];  
        $periode = $year_now.'-'.$month_now.'-01';
        $where = array( 'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$balance); 
        $check_inv = $this->dashboard_model->get_where_data_row('inv_payment', $where, 'id', 'DESC');   
        if($check_inv){
            $inv_id = $check_inv['id'];
            if($check_inv['status'] == 1){ //process
                $res = array('result'=>true, 'status'=>1, 'msg'=>'Status Process'); 
            }else if($check_inv['status'] == 2){ //waiting for payment 
                $order_id_mid = $check_inv['inv_midtrans_id']; 
                if($order_id_mid){
                    $order_status = getStatusMid($order_id_mid);    
                    if($order_status){
                        $transaction_status = $order_status->transaction_status;  
                        $status_code = $order_status->status_code;  
                        $payment_status = 0;
                        $payment_status_info = '';
                        if($transaction_status == 'expire'){
                            $payment_status = 2; //failed/expire  
                            $postdata = array('status'=>1, 'payment_status'=>1, 'payment_date'=>'', 'inv_midtrans_id'=>'');
                            $update = $this->dashboard_model->update_db('inv_payment', array('id'=>$inv_id), $postdata);  
                            $res = array('result'=>true, 'status'=>1, 'msg'=>'Payment Expired', 'pay_method'=>$check_inv['payment_name']); 
                        }else if($transaction_status == 'settlement' || $transaction_status == 'capture'){  
                            $transaction_time = $order_status->transaction_time;  
                            $postdata = array('status'=>3, 'payment_status'=>2, 'payment_date'=>$transaction_time, 'inv_midtrans_id'=>$order_id_mid);
                            $update = $this->dashboard_model->update_db('inv_payment', array('id'=>$inv_id), $postdata);   
                            $res = array('result'=>true, 'status'=>3, 'msg'=>'Paid','pay_method'=>$check_inv['payment_name'], 'pay_date'=>$check_inv['payment_date']); 
                        }else if($transaction_status == 'pending'){ 
                            $payment_status = 1; //pending  
                            $res = array('result'=>true, 'status'=>2, 'msg'=>'Waiting for payment', 'pay_method'=>$check_inv['payment_name']); 
                        }
                    }else{
                        $res = array('result'=>false);
                    } 
                }else{
                    $res = array('result'=>false);
                }
            }else if($check_inv['status'] == 3){ //paid
                $res = array('result'=>true, 'status'=>3, 'msg'=>'Paid','pay_method'=>$check_inv['payment_name'], 'pay_date'=>$check_inv['payment_date']); 
            }
        }else{
            $res = array('result'=>false);
        }
        echo json_encode($res); 
    }
    function create_inv_blesta(){
        $post = $this->input->post();
        $t = rand(1000,9999);
        $cust_id = $post['cust_id'];
        $month =  $post['month'];
        $year =  $post['year'];
        $tagihan =  $post['tagihan'];
        $biaya_layanan =  $post['biaya_layanan'];
        $total_tagihan =  $post['total_tagihan'];
        $pay_method =  $post['pay_method']; 
        $periode = $year.'-'.$month.'-01'; 

        $enabled_payments = '';
        $payment_name = '';
        if($pay_method == 1){
            $enabled_payments = ['credit_card'];
            $payment_name = 'Credit Card';
        }else if($pay_method == 2){
            $enabled_payments = ["permata_va", "bca_va", "bni_va", "bri_va", "echannel", "other_va"];
            $payment_name = 'Bank Transfer';
        }else if($pay_method == 3){
            $enabled_payments = ["gopay", "shopeepay"];
            $payment_name = 'QRIS';
        }  
        $where = array( 'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$tagihan, 'payment_method'=>$pay_method, 'payment_admin_fee'=>$biaya_layanan, 
                        'payment_total'=>$total_tagihan, 'status'=>1);
        $data_inv_exs = $this->dashboard_model->get_where_data_row('inv_payment', $where);  
        if($data_inv_exs){
            // echo 'data inv exs';
            $data_user = $this->dashboard_model->get_where_data_row('user', array('id'=>$this->session->userdata('id')));
            $blesta_id = $data_user['blesta_id']; 
            $inv_id = $data_inv_exs['inv_blesta_id']; 
            $inv_payment_id = $data_inv_exs['id'];
            $email = $data_user['username'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                $email = $email.'@indo.net.id';
            } 
            $inv_desc = 'AX-'.$cust_id.'-'.$month.substr($year,-2).'-'.$t;
            $data_mid = array(  'inv_desc'=>$inv_desc, 'id_blesta'=>$blesta_id, 'email'=>$email, 'fname'=>$data_user['username'], 'lname'=>'indonet', 
                                'inv_blesta_id'=>$inv_id, 'inv_total'=>(int)$total_tagihan, 'enabled_payments'=>$enabled_payments, 'inv_payment_id'=>$inv_payment_id);
            // print_r($data_mid); die(); 
            $midApi = createTransactionMid($data_mid);  
            $data['midApi'] = $midApi;
            $this->load->view('customer/midtrans_snap', $data);
        }else{
            //create new inv;
            // echo 'create new inv exs';
            $data_user = $this->dashboard_model->get_where_data_row('user', array('id'=>$this->session->userdata('id')));
            $blesta_id = $data_user['blesta_id']; 
            $inv_desc = 'AX-'.$cust_id.'-'.$month.substr($year,-2).'-'.$t;
            $invList = array(array('desc'=>$inv_desc, 'amount'=>$tagihan), array('desc'=>'Admin Fee', 'amount'=>$biaya_layanan));
            $input_inv_blesta = array('id_blesta'=>$blesta_id, 'inv_list'=>$invList);   
            $createInv = createNewInv($input_inv_blesta);  
            if($createInv){
                $inv_id = $createInv;  
                $post_inv = array(  'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$tagihan, 'payment_method'=>$pay_method, 'payment_name'=>$payment_name, 
                                    'payment_admin_fee'=>$biaya_layanan, 'payment_total'=>$total_tagihan, 'inv_blesta_id'=>$inv_id);
                $post = $this->dashboard_model->add_db('inv_payment', $post_inv); 
                if($post){   
                    $email = $data_user['username'];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                        $email = $email.'@indo.net.id';
                    } 
                    $data_mid = array(  'inv_desc'=>$inv_desc, 'id_blesta'=>$blesta_id, 'email'=>$email, 'fname'=>$data_user['username'], 'lname'=>'indonet', 
                                        'inv_blesta_id'=>$inv_id, 'inv_total'=>(int)$total_tagihan, 'enabled_payments'=>$enabled_payments, 'inv_payment_id'=>$post);
                    $midApi = createTransactionMid($data_mid);  
                    $data['midApi'] = $midApi;
                    $this->load->view('customer/midtrans_snap', $data);
                }
            }else{
                echo json_encode(array('res'=>false, 'msg'=>'Error create invoice'));
            } 
        }
    }
    function check_payment_blesta(){ 
        $post = $this->input->post();
        $inv_id = $post['inv_id'];
        $mid_id = $post['mid_id']; 
         
        $data_inv = $this->dashboard_model->get_where_data_row('inv_payment', array('id'=>$inv_id)); 
        if($data_inv){ 
            if($mid_id != ''){   
                $inv_blesta_id = $data_inv['inv_blesta_id'];    
                if($inv_blesta_id != 0){
                    $inv_blesta_post = array('inv_id'=>$inv_blesta_id);
                    $inv_blesta_data = checkInv($inv_blesta_post);  
                    if($inv_blesta_data){
                        $inv_blesta_status = $inv_blesta_data['status'];
                        $inv_date_billed = $inv_blesta_data['date_billed'];
                        if($inv_blesta_status == 'active'){ 
                            $postdata = array('status'=>3, 'payment_status'=>1, 'payment_date'=>$inv_date_billed, 'inv_midtrans_id'=>$mid_id);
                            $update = $this->dashboard_model->update_db('inv_payment', array('id'=>$inv_id), $postdata);
                            $res = array('res'=>true, 'type'=>1, 'msg'=>'Paid'); 
                        }else{ 
                            // jika menunggu pembayaran 
                            $postdata = array('status'=>2, 'payment_status'=>1, 'payment_date'=>$inv_date_billed, 'inv_midtrans_id'=>$mid_id);
                            $update = $this->dashboard_model->update_db('inv_payment', array('id'=>$inv_id), $postdata); 
                            $res = array('res'=>true, 'type'=>2, 'msg'=>'Waiting For Payment'); 
                            
                        }  
                    }else{ 
                        $res = array('res'=>false, 'msg'=>'Payment Failed'); 
                    }                
                }else{ 
                    $res = array('res'=>false, 'msg'=>'Payment Failed'); 
                } 
            }else{
                $res = array('res'=>false, 'msg'=>'No Data mid'); 
            }
        }else{
            $res = array('res'=>false, 'msg'=>'No Data Invoice'); 
        }
        echo json_encode($res); 
    }
    function view_pdf_report(){
        $nameFile = $this->input->get('pdfname');
        header('Content-type: application/pdf');
        // readfile('files/report/'.$nameFile);    
        readfile('/var/www/dev-myportal.indo.net.id/files/report/'.$nameFile);      
    }
    function billing_usage_alicloud(){
        $cust_id = $this->session->userdata('custID');
        $this->data['report_data'] = $this->dashboard_model->get_where_data('report', array('CUSTID'=>$cust_id), 'ID', 'DESC', 24);  
        $this->data['content'] = 'customer/usage_alicloud';
        $this->data['title'] = 'Billing Usage Alibaba Cloud';
        $this->data['menu_active'] = 'usage_alicloud';
        $this->load->view('customer/layout', $this->data); 
    }
    function get_data_billing_usage_alicloud(){
        $post = $this->input->post();
        if($post){
            $periode = $post['periode'];
            $periode_num = date("Ym", strtotime($periode));  
            $cust_id = $post['cust_id'];  

            $cust_id = $this->session->userdata('custID');
            $access_token = $this->session->userdata('access_token_bill_alicloud');  
            if($access_token == ''){ 
                $post_api = ['grant_type'=>'password', 'login'=>true];   
                $url_api = "https://api.indonet.id/access/token";  
                $response = $this->curl->simple_post($url_api, $post_api); 
                if($response){
                    $res = json_decode($response, true);
                    $access_token = $res['access_token'];
                    $this->session->set_userdata('access_token_bill_alicloud', $access_token);
                }
            } 
            $post_api = ['periode'=>$periode_num, 'customer_id'=>$cust_id];   
            $url_api = "https://api.indonet.id/billing/history";  
            $response = $this->curl->simple_post($url_api, $post_api); 
            if($response){
                $res = json_decode($response, true);
                $res_data = ['result'=>true, 'data'=>$res];
            }else{ 
                $res_data = ['result'=>false,'data'=>'', 'message'=>'Data not found'];
            }
            echo json_encode($res_data);
        }
    }
}