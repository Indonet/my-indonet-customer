<?php
class Auth_model extends CI_Model{	
	  function __construct(){
        parent::__construct();     
  	}
  	function compareUserPassword($username, $userpass){
        $query = $this->db->get_where('user', array('user_name' => $username, 'user_password' => sha1($userpass)));	
        return $query->row_array();
  	}
  	function checkCurnPass($userId, $curnPass){
        $query = $this->db->get_where('user', array('user_id' => $userId, 'user_password' => sha1($curnPass)));	
        return $query->row_array();  		
  	}
  	function changePassword($userId, $newPass){  		
        return $this->db->where('user_id',$userId)->update('USER',array('user_password' => sha1($newPass)));
  	}
    function get_where_data($tabel_name, $where, $orderBy = ''){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, 'ASC')->get_where($tabel_name, $where);
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
    function updateUser($where, $postData){      
        $this->db->where($where);
        $this->db->update('user', $postData);
        $result = TRUE;
        return $result; 
    }
    function add_db($tabel_name, $postData){           
        $this->db->insert($tabel_name, $postData);  
        return $this->db->insert_id();
    }
}