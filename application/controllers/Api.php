<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Api extends ALL_Controller { 
    public function get_data_ax() { 
        $argv = $_SERVER['argv']; 
        $subnet_code = $argv[3]; 
        $cust_id = $argv[4]; 
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
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt'; 
        if(!file_exists($file_name)){   
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array); 
            if($out){
                $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
            }else{
                // redirect('auth/logout');
            } 
        }  
        // $file_data = file_get_contents($file_name);
        // return json_decode($file_data); 
    }  
    public function set_cust_list_ax() { 
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';  
        if(!file_exists($file_name)){   
            $arraySubnets = array(  'S-001','S-002','S-003','S-004','S-005','S-006','S-007','S-008','S-009','S-010','S-011','S-012','S-013','S-014','S-015','S-016',
                                    'S-017','S-018','S-019','S-020','S-021','S-022');  
            // $arraySubnets = array(  'S-022');      
            $array_acc = array();        
            foreach ($arraySubnets as $key => $value) {            
                $subnet_code = $value; 
                $out = getCustAccListUnderSubnet($subnet_code);  
                $array_acc = array_merge($array_acc, $out);
                echo 'subnet => '.$value."\n";
            } 
            if($array_acc){
                $fp = fopen('./files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($array_acc));
                fclose($fp);
            } 
        }else{
            echo 'file already exists';
        }
    }   
    function set_cust_info_ax(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);
        // $subnet_code_view = 'S-001'; // 14756 // Jakarta 
        // $subnet_code_view = 'S-002'; // 420 // Bandung - done
        // $subnet_code_view = 'S-003'; // 537 // Bogor - done
        // $subnet_code_view = 'S-004'; // 20 // Purwakarta - done
        // $subnet_code_view = 'S-005'; // 15 // Tegal - done
        // $subnet_code_view = 'S-006'; // 17 // Pekalongan - done
        // $subnet_code_view = 'S-007'; // 382 // Solo - done
        // $subnet_code_view = 'S-008'; // 740 // Surabaya - done
        // $subnet_code_view = 'S-009'; // 33 // Kediri - done
        $subnet_code_view = 'S-010'; // 189 // Malang
        // $subnet_code_view = 'S-011'; // 39 // Mataram
        // $subnet_code_view = 'S-012'; // 146 // Medan
        // $subnet_code_view = 'S-013'; // 674 // Denpasar
        // $subnet_code_view = 'S-014'; // 63 // Banjarmasin
        // $subnet_code_view = 'S-015'; // 2 // Bontang
        // $subnet_code_view = 'S-016'; // 146 // Balikpapan
        // $subnet_code_view = 'S-017'; // 2148 // Jakarta Kuncit
        // $subnet_code_view = 'S-018'; // 84 // Jakarta Noble Hs
        // $subnet_code_view = 'S-019'; // 3 // Jakarta Ra Residence
        // $subnet_code_view = 'S-020'; // 1523 data // KBPa (Kota Baru Parahyangan)
        // $subnet_code_view = 'S-021'; // 306 // Jakarta Soho Pancoran (SoPan)
        // $subnet_code_view = 'S-022'; // 630 // Neo Soho Podomoro City
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    
    function get_data_ax_cust_id($cust_id, $subnet_code) {
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
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt';  
        if(!file_exists($file_name)){   
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
            if($out){
                $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
            }
        }else{
            echo 'file exists => '.$cust_id."\n";
        } 
        return;
    }  

    public function test_exec() {
        echo "Proc_text::Index is called at ".$this->rightnow()."<br>";
        $cust_id = '0054984211';
        $command = "php ".FCPATH."index.php api get_data_ax ".$cust_id." > /dev/null &"; 
        shell_exec($command);  
        echo "Proc_text::Index is done at ".$this->rightnow()."<br>";  
    }  
    public function rightnow() {
        $time = microtime(true);
        $micro_time = sprintf("%06d", ($time - floor($time)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.'.$micro_time, $time));
        return $date->format("H:i:s.u");
    }
    public function asdf(){   
        $asd = array('data'=>10000);
        echo json_encode($asd);
    } 
    function get_data_ax_manual() {
        $cust_id = $this->input->get('cust_id');
        $subnet_code = $this->input->get('subnet_code');
        if($cust_id && $subnet_code){
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
            $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  
            if(file_exists($file_name)){   
                unlink($file_name);
            } 
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
            if($out){
                $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt', 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
                echo 'selesai';
            } 
            return;
        }else{
            echo 'error';
        }
    }  
    function get_data_ax_manual_by_subnet() { 
        $subnet_code = 'S-007';
        $cust_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_subnet_code'=>$subnet_code, 'cust_status <>'=>2)); 
        $count_list = count($cust_list);
        $no = 1;
        if($cust_list){
            foreach ($cust_list as $key => $value) {
                $cust_id = $value['cust_id'];
                if($cust_id){
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
                    $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  
                    if(file_exists($file_name)){   
                        unlink($file_name);
                    } 
                    $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
                    if($out){
                        $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt', 'w');
                        fwrite($fp, json_encode($out));
                        fclose($fp); 
                        echo $no.' dari '.$count_list.' selesai cust id => '.$cust_id."\n";
                    }  
                }else{
                    echo 'error';
                }
                $no++;
            }
        }else{
            echo 'no data subnet';
        }
    }  
    
    function get_data_active_reg() {  
        $cust_list = $this->dashboard_model->get_active_reg_data(); 
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
        $abj = ["", "A", "B", "C", "D", "E", "F"];
        $desc = ["", "No", "Customer ID", "Customer Name", "Email", "Subnet", "Active Date"];
        $no = 1;
        $row = 3;
        for ($i=1; $i <= 6; $i++) {  
            $sheet->setCellValue($abj[$i]."1", $i);
            $sheet->setCellValue($abj[$i]."2", $desc[$i]);
        }  
        foreach ($cust_list as $key => $value) {
            $id = $value['id'];
            $email = $value['email'];
            $cust_id = $value['cust_id'];
            $cust_name = $value['cust_name'];
            $update_at = $value['update_at'];
            $cust_ax_name = $value['cust_ax_name'];
            $cust_subnet_name = $value['cust_subnet_name'];
            if($cust_name == $cust_ax_name){
                $arry_cust = array('email'=>$email, 'cust_id'=>$cust_id, 'cust_name'=>$cust_name, 'update_at'=>$update_at, 'email'=>$email, 'cust_subnet_name'=>$cust_subnet_name);
                $sheet->setCellValue($abj[1].$row, $no);
                $sheet->setCellValue($abj[2].$row, $cust_id);
                $sheet->setCellValue($abj[3].$row, $cust_name);
                $sheet->setCellValue($abj[4].$row, $email);
                $sheet->setCellValue($abj[5].$row, $cust_subnet_name);
                $sheet->setCellValue($abj[6].$row, $update_at);  
                $row++;
                $no++; 
            } 
        } 
        foreach(range('A','F') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
		$writer = new Xlsx($spreadsheet);
		
		$filename = 'Active Register My Indonet('.date('Y-m-d').')';
        $path_file = 'files/'.$filename.'.xlsx';
        $path_attch_file = base_url().'files/'.$filename.'.xlsx';
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		// header('Cache-Control: max-age=0'); 
        $writer->save($path_file); 
    }
    function demo_billing_ali(){
        // $cust_id = $this->session->userdata('custID');
        $periode = '202205';
        $cust_id = '0054991565';
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
        $post_api = ['periode'=>$periode, 'customer_id'=>$cust_id];   
        $url_api = "https://api.indonet.id/billing/history";  
        $response = $this->curl->simple_post($url_api, $post_api); 
        if($response){
            $res = json_decode($response, true);
            print_r($res);
        }
        echo $access_token;
    }
}