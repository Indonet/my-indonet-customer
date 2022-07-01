<?php


    // get data customer details by subnet
    
    function set_cust_info_ax_jakarta(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-001'; // 14756 // Jakarta 
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_bandung(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-002'; // 420 // Bandung - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_bogor(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-003'; // 537 // Bogor - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_purwakarta(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-004'; // 20 // Purwakarta - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_tegal(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-005'; // 15 // Tegal - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_pekalongan(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-006'; // 17 // Pekalongan - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_solo(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-007'; // 382 // Solo - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_surabaya(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-008'; // 740 // Surabaya - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_kediri(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-009'; // 33 // Kediri - done
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_malang(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-010'; // 189 // Malang
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_mataram(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-011'; // 39 // Mataram
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_medan(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-012'; // 146 // Medan
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_denpasar(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-013'; // 674 // Denpasar
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_banjarmasin(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-014'; // 63 // Banjarmasin
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_botang(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-015'; // 2 // Bontang
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_balikpapan(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-016'; // 146 // Balikpapan
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_kuncit(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-017'; // 2148 // Jakarta Kuncit
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_noble(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-018'; // 84 // Jakarta Noble Hs
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_ra(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-019'; // 3 // Jakarta Ra Residence
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_kbpa(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-020'; // 1523 data // KBPa (Kota Baru Parahyangan)
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_sopan(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-021'; // 306 // Jakarta Soho Pancoran (SoPan)
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    function set_cust_info_ax_neo(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);  
        $subnet_code_view = 'S-022'; // 630 // Neo Soho Podomoro City
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name.'; jam => '.date('Y m d H:i:s')."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code_view);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
?>