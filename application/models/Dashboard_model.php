<?php
class Dashboard_model extends CI_Model{	
	  function __construct(){
        parent::__construct();     
  	}
      function get_all_data($tabel_name){
          $query = $this->db->get($tabel_name); 
          $result = $query->result_array();
          return $result;
      }
    function get_where_data($tabel_name, $where, $orderBy = '', $sort='',$limit = 100000){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, $sort)->limit($limit)->get_where($tabel_name, $where);
        }
        $result = $query->result_array();
        return $result;
    }
    function get_where_data_row($tabel_name, $where, $orderBy='', $sort=''){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, $sort)->get_where($tabel_name, $where);
        }
        $result = $query->row_array();
        return $result;
    }   
    function update_db($tabel_name, $where, $postData){      
        $this->db->where($where);
        $this->db->update($tabel_name, $postData);
        $result = TRUE;
        return $result; 
    }
    function add_db($tabel_name, $postData){           
        $this->db->insert($tabel_name, $postData);  
        return $this->db->insert_id();
    }
    function truncate_tabel($tabel_name){
        $this->db->truncate($tabel_name);
    }
    function get_active_reg_data(){ 
        $this->db->select("user_token_data.*, ax_customer_list.cust_name as cust_ax_name, ax_customer_list.cust_subnet_name as cust_subnet_name");
        $this->db->from("user_token_data");
        $this->db->join("ax_customer_list", "ax_customer_list.cust_id = user_token_data.cust_id", "LEFT");   
        $this->db->where("user_token_data.status", 1); 
        $result_array = $this->db->get()->result_array(); 
        return $result_array; 
    }
    function get_user_group_by_id($user_group_id){ 
        $this->db->select("user_group_data.cust_id, ax_customer_list.cust_name as cust_ax_name, ax_customer_list.cust_subnet_name, 
                            ax_customer_list.cust_subnet_code, ax_customer_list.cust_status_name");
        $this->db->from("user_group_data");
        $this->db->join("ax_customer_list", "ax_customer_list.cust_id = user_group_data.cust_id", "LEFT");   
        $this->db->where("user_group_data.group_id", $user_group_id); 
        $this->db->where("user_group_data.status", 1); 
        $result_array = $this->db->get()->result_array(); 
        return $result_array; 
    }
}