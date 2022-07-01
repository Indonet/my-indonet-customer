<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_ax extends ALL_Controller {   
    function check_ax_login() {
        $cust_id = '0000012823';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $out = getCustInfoOnly($cust_id); 
        if($out){  
            return true;
        }else{ 
            return false;
        }   
    }  
    function get_total_inv(){ 
        $type_ax = 'get_total_inv'; 
        $ax_id = '0001348754';
        $year = '2021';  
        $month = '12';  
        $url_api = 'https://api-my.indonet.id/ax';
        $post = array('type'=>$type_ax, 'ax_id'=>$ax_id, 'year'=>$year, 'month'=>$month); 
        $response = $this->curl->simple_post($url_api, $post);     
        echo $response; 
    }
    function check_ax_connect(){
        $check_ax_login = $this->check_ax_login();
        if($check_ax_login){
            echo 'ax connected';
        }else{
            echo 'ax disconnected';
        }
    } 
    function demo_post_data_ax_cust_id() { 
        $subnet_code = 'S-001';
        $cust_id = '0021719984';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now;
        $year_array = array();
        $month_array = array();
        for ($i=2; $i >= 0; $i--) {  
            $fromyear = date("Y", strtotime("-".$i." months"));
            array_push($year_array, $fromyear);
            $frommonth = date("m", strtotime("-".$i." months"));
            array_push($month_array, $frommonth); 
        }   
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
        print_r($out); die(); 
        
        // $ax_customer_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_id != '=>''));
        // foreach ($ax_customer_list as $key_list => $value_list) {
        //     $list_id = $value_list['id'];
        //     $list_cust_id = $value_list['cust_id']; 
        //     $out = getCustUsernameList($list_cust_id);  
        //     $user_id_array = ''; 
        //     foreach ($out as $key => $value) {
        //         $user_id = $value['USERNAME'];
        //         if($user_id_array == ''){
        //             $user_id_array = $user_id;
        //         }else{ 
        //             $user_id_array = $user_id_array.', '.$user_id;
        //         }
        //     }
        //     $update = $this->dashboard_model->update_db('ax_customer_list', array('id'=>$list_id), array('cust_user_id'=>$user_id_array));
        //     echo 'updadte id => '.$list_id."\n"; 
        //     die();
        // }
        // print_r($ax_customer_list); die();
        // $out = getCustUsernameList($cust_id);
        // $user_id_array = '';
        // foreach ($out as $key => $value) {
        //     $user_id = $value['USERNAME'];
        //     if($user_id_array == ''){
        //         $user_id_array = $user_id;
        //     }else{ 
        //         $user_id_array = $user_id_array.', '.$user_id;
        //     }
        // }
        
        // $out = getCustTrans($cust_id);
        // $out = getInvById($cust_id);
        // print_r($user_id_array); 
        // print_r($out); die(); 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";

    } 
    function demo_get_data_cust(){
        $cust_id = $this->input->get('cust_id');
        $data_cust = $this->dashboard_model->get_where_data_row('user', array('CUSTID'=>$cust_id));
        if($data_cust){
            $subnet_code = $data_cust['subnets'];
            $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  // ambil filenya
            if(file_exists($file_name)){     // jika ada filenya
                $file_data = file_get_contents($file_name); // buka file dengan fungsi ini
                print_r(json_decode($file_data)); // cetak isi filenya
            }else{
                echo 'tidak ada file cust id => '.$cust_id;
            }
        }else{
            echo 'tidak ada cust id => '.$cust_id;
        } 
    }
    function get_data_ax_cust_id($cust_id, $subnet_code) {  // get data customer details ax
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');   
        $year_array = array();
        $month_array = array();
        for ($i=2; $i >= 0; $i--) {  
            $fromyear = date("Y", strtotime("-".$i." months"));
            array_push($year_array, $fromyear);
            $frommonth = date("m", strtotime("-".$i." months"));
            array_push($month_array, $frommonth); 
        }  
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  // tempat lokasi file dan nama file serta format file txt
        if(file_exists($file_name)){    // jika filenya sudah ada
            unlink($file_name); // hapus dulu filenya
            echo 'delete cust_id => '.$cust_id.'; subnet_code => '.$subnet_code.'; success'."\n";  
        }
        $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);   // data yang mau diinput kedalam file text
        if($out){  
            $fp = fopen($file_name, 'w'); // buka filenya dulu yang tadi 
            fwrite($fp, json_encode($out)); // tulis filenya
            fclose($fp); // tutup filenya
            echo 'create new cust_id => '.$cust_id.'; subnet_code => '.$subnet_code.'; success'."\n"; 
        } 
        return;
    }
    
    function set_subnet_all_user() {
        $users = $this->dashboard_model->get_where_data('user', array('status'=>1));
        $count_users = count($users);
        $no = 1;
        $start_time = date('Y-m-d H:s:i');
        echo 'waktu mulai => start '.$start_time."\n";  
        foreach ($users as $key => $value) {
            $id = $value['id'];
            $cust_id = $value['CUSTID']; 
            $is_admin = $value['is_admin']; 
            $old_subnets = $value['subnets'];  
            if($old_subnets == null || $old_subnets == '0'){ 
                if($is_admin == 0){
                    $out = getCustDisticName($cust_id);  
                    if($out){   
                        $subnet_code = $out[0]['SALESDISTRICTID'];
                        $update_user = $this->dashboard_model->update_db('user', array('id'=>$id), array('subnets'=>$subnet_code)); 
                        if($update_user){
                            echo 'no => '.$no.' dari => '.$count_users.'; id user => '.$id.'; update from => '.$old_subnets.'; to '.$subnet_code."\n";
                        }
                    }else{
                        echo 'id user => '.$id.'; cust id => '.$cust_id.'; skip'."\n";
                    }
                } 
                $no++;
            }else{ 
                echo 'id user => '.$id.'; cust id => '.$cust_id.'; skip'."\n";
            } 
        } 
        echo 'waktu selesai => '.$start_time.' to '.date('Y m d H:i:s')."\n";
    }  
    function renew_cust_list_ax(){  
        $check_ax_login = $this->check_ax_login(); 
        if($check_ax_login){  
            $this->dashboard_model->truncate_tabel('ax_customer_list'); 
            $start_time = date('Y-m-d H:s:i');
            echo 'get new cust_list => start'.$start_time."\n";
            $arraySubnets = array(  'S-001','S-002','S-003','S-004','S-005','S-006','S-007','S-008','S-009','S-010','S-011','S-012','S-013','S-014','S-015','S-016',
                                    'S-017','S-018','S-019','S-020','S-021','S-022','S-023');   
            // $array_acc = array();        
            foreach ($arraySubnets as $key => $value) {            
                $subnet_code = $value; 
                $out = getCustAccListUnderSubnet($subnet_code);
                if($out){  
                    foreach ($out as $key_out => $value_out) { 
                        $cust_id = $value_out['ACCOUNTNUM'];
                        $cust_name = $value_out['NAME'];
                        $cust_knownas = $value_out['KNOWNAS'];
                        $cust_subnet_code = $value_out['SALESDISTRICTID'];
                        $cust_subnet_name = $value_out['DISTRICTNAME'];
                        $cust_status = $value_out['MK_CUSTSTATUS'];
                        $cust_status_name = '';
                        switch ($cust_status) {
                            case 0:
                                $cust_status_name = 'Active';
                                break;
                            case 1:
                                $cust_status_name = 'Hold';
                                break;
                            case 2:
                                $cust_status_name = 'Close';
                                break; 
                        }
                        $cust_status_name = $cust_status_name;
                        $cust_type = $value_out['TYPECUST'];
                        $post_data = array( 'cust_id'=>$cust_id, 'cust_name'=>$cust_name, 'cust_knownas'=>$cust_knownas, 'cust_subnet_code'=>$cust_subnet_code, 
                                            'cust_subnet_name'=>$cust_subnet_name, 'cust_status'=>$cust_status, 'cust_status_name'=>$cust_status_name, 'cust_type'=>$cust_type); 
                        $add_cust = $this->dashboard_model->add_db('ax_customer_list', $post_data);
                        if($add_cust){
                            $custUserData = getCustUsernameList($cust_id);  
                            $user_id_array = ''; 
                            foreach ($custUserData as $keyUser => $valUser) {
                                $user_id = $valUser['USERNAME'];
                                if($user_id_array == ''){
                                    $user_id_array = $user_id;
                                }else{ 
                                    $user_id_array = $user_id_array.', '.$user_id;
                                }
                            }
                            $update = $this->dashboard_model->update_db('ax_customer_list', array('id'=>$add_cust), array('cust_user_id'=>$user_id_array));
                        }
                        echo 'add cust id '.$cust_id."\n";
                    } 
                }
                echo 'subnet => '.$value."\n";
            }   
            echo 'get new cust_list end => '.$start_time.' to '.date('Y-m-d H:s:i')."\n";
        }else{
            echo 'ax disconnected';
        }
    } 
    function set_cust_by_name(){
        $check_ax_login = $this->check_ax_login(); 
        if($check_ax_login){  
            $this->dashboard_model->truncate_tabel('ax_customer_group'); 
            $start_time = date('Y-m-d H:s:i');
            echo 'get new cust_list => start'.$start_time."\n";
            $cust_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_name !='=>''), 'cust_name', 'asc');
            $group_name = '';
            foreach ($cust_list as $key => $value) {
                $cust_name = $value['cust_name'];
                $check_exist = $this->dashboard_model->get_where_data('ax_customer_group', array('cust_name '=>$cust_name), 'cust_name', 'asc');
                if(!$check_exist){
                    $cust_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_name '=>$cust_name), 'cust_name', 'asc');
                    $array_group = array();
                    foreach ($cust_list as $key_list => $value_list) {
                        $cust_id = $value_list['cust_id'];
                        $cust_knownas = $value_list['cust_knownas'];
                        $cust_subnet_code = $value_list['cust_subnet_code'];
                        $cust_subnet_name = $value_list['cust_subnet_name'];
                        $cust_status_name = $value_list['cust_status_name'];
                        $cust_type = $value_list['cust_type'];
                        $array_data = array('cust_id'=>$cust_id, 'cust_knownas'=>$cust_knownas, 'cust_subnet_code'=>$cust_subnet_code, 'cust_subnet_name'=>$cust_subnet_name, 
                                            'cust_status_name'=>$cust_status_name, 'cust_type'=>$cust_type);
                        array_push($array_group, $array_data); 
                    }
                    $post_data = array('cust_name'=>$cust_name, 'cust_data'=>json_encode($array_group), 'cust_count'=>count($cust_list));
                    $add_group = $this->dashboard_model->add_db('ax_customer_group', $post_data);
                } 
                echo $cust_name."\n"; 
                // die();
            }
        }else{
            echo 'ax disconnected';
        }
    }
    // get data customer details by user login myportal 
    function set_cust_info_ax_by_user_login(){ 
        $check_ax_login = $this->check_ax_login(); 
        if($check_ax_login){    
            $cust_list = $this->dashboard_model->get_where_data('user', array('is_admin'=>0, 'status'=>1)); 
            $count_list = count($cust_list);
            $no = 1;
            $start_time = date('Y-m-d H:s:i');
            echo 'waktu mulai => start'.$start_time."\n"; 
            foreach ($cust_list as $key => $value) {  
                $cust_id = $value['CUSTID'];
                $subnet_code = $value['subnets'];  
                echo 'no => '.$no.' dari => '.$count_list.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; jam => '.date('Y m d H:i:s')."\n";
                $data = $this->get_data_ax_cust_id($cust_id, $subnet_code); 
                $no++; 
            } 
            echo 'waktu selesai => '.$start_time.' to '.date('Y m d H:i:s')."\n";
        }else{
            echo 'ax disconnected';
        }
    }
    function set_count_subnet(){  
        $subnet_list = getSubnetList();  
        $cust_list = $this->dashboard_model->get_all_data('ax_customer_list'); 
        if($cust_list){
            $this->dashboard_model->truncate_tabel('subnets'); 
            $array_count = array(); 
            $start_time = date('Y-m-d H:s:i');
            echo 'waktu mulai => start'.$start_time."\n"; 
            $no = 1; 
            foreach ($subnet_list as $key => $value) {
                $subnet_code = $value['SALESDISTRICTID'];
                $subnet_name = $value['DESCRIPTION']; 
                $subnet_count = array_count_values(array_column($cust_list, 'cust_subnet_code'))[$subnet_code];   
                $post_data = array('subnet_code'=>$subnet_code, 'subnet_name'=>$subnet_name, 'subnet_count'=>$subnet_count); 
                $add_subnet = $this->dashboard_model->add_db('subnets', $post_data);
                echo 'no => '.$no.'; subnet_code => '.$subnet_code.'; subnet => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $no++;
            }  
            echo 'waktu selesai => '.$start_time.' to '.date('Y m d H:i:s')."\n";
        }
    }
    function set_count_status_user(){  
        $status_list = array(array('status_code'=>0, 'status_name'=>'Active'), array('status_code'=>1, 'status_name'=>'Hold'), array('status_code'=>2, 'status_name'=>'Close'));   
        $cust_list = $this->dashboard_model->get_all_data('ax_customer_list'); 
        if($cust_list){
            $this->dashboard_model->truncate_tabel('user_status'); 
            $array_count = array(); 
            foreach ($status_list as $key => $value) {
                $status_code = $value['status_code'];
                $status_name = $value['status_name']; 
                $status_count = array_count_values(array_column($cust_list, 'cust_status'))[$status_code];  
                $post_data = array('status_code'=>$status_code, 'status_name'=>$status_name, 'status_count'=>$status_count); 
                $add_status = $this->dashboard_model->add_db('user_status', $post_data);
                echo 'status_name => '.$status_count."\n";
            }  
        }
    }
    function create_user_blesta(){ 
        $getAllUser = $this->dashboard_model->get_where_data('user', array('blesta_id'=>0, 'CUSTID !='=>0));  
        if($getAllUser){
            foreach ($getAllUser as $key => $value) {
                $id = $value['id'];
                $username = $value['username'];
                $email = $value['username'];
                $fname = $username;
                $lname = 'Indonet'; 
                $axid = trim($value['CUSTID']); 
                $blesta_id_exist = $value['blesta_id']; 
                if($blesta_id_exist == 0){ 
                    if(strlen($axid) == 10){
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo 'invalid email';
                            $email = $email.'@indo.net.id';
                        } 
                        echo $email;
                        $data = array('username'=>$username);
                        $user_blesta = getUserExist($data);  
                        if(isset($user_blesta['id'])){
                            $id_blesta = $user_blesta['id']; 
                            $postData = array('blesta_id' => $id_blesta);
                            $where = array('id'=>$id); 
                            $update = $this->dashboard_model->update_db('user', $where, $postData);  
                            echo 'user sudah ada id=> '.$id.' username => '.$username.' ax id => '.$axid.' blesta id => '.$id_blesta."\n";
                        }else{ 
                            $data_post = array('username'=>$username, 'email'=>$email, 'axid'=>$axid, 'fname'=>$fname, 'lname'=>$lname);  
                            $user_blesta = createNewUser($data_post);   
                            if($user_blesta){
                                $blesta_id = $user_blesta['id'];  
                                $update = $this->dashboard_model->update_db('user', array('id'=>$id), array('blesta_id'=>$blesta_id));
                                if($update){
                                    echo 'createNewUser Blesta success id=> '.$id.' username => '.$username.' ax id => '.$axid."\n";
                                }else{ 
                                    echo 'createNewUser Blesta failed 1, error update db local id=> '.$id.' username => '.$username.' ax id => '.$axid."\n";
                                }
                            }else{
                                // print_r($user_blesta);
                            }
                        }
                    }else{
                        echo 'createNewUser Blesta failed 3 (tidak ada no pelanggan), id => '.$id.' username => '.$username.' ax id => '.$axid."\n";
                    } 
                }else{
                    echo 'create Blesta failed, sudah ada id blesta, id => '.$id.' username => '.$username."\n"; 
                } 
            } 
        }else{
            echo 'tidak ada data';
        }
    }
    function debug_info_ax(){
        $subnet_code = $this->input->get('subnet_code');
        $cust_id = $this->input->get('cust_id');
        if(isset($subnet_code)){
            $cust_list = getCustListUnderSubnet($subnet_code);
            echo $subnet_code;
            if($cust_list){ 
                echo 'count => '.count($cust_list);
                echo '<pre>';
                print_r($cust_list);
            }
        } 
        if(isset($cust_id)){
            $cust_data = getCustInfo($cust_id); 
            echo $cust_id."<br>";
            if($cust_data){ 
                echo 'count => '.count($cust_data);
                echo '<pre>';
                print_r($cust_data);
            }
        }
        echo 'done';
    }
}