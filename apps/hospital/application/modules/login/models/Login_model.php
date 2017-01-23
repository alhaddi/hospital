<?php
/* Author : Amir Mufid */

class Login_model extends MY_Model
{
	#variable private (poperpti)	
	function __construct()
	{
		parent:: __construct();
	}
	
	function get_login($param){
		$this->db->select('username,id_user');
		$this->db->where($param);
		$result = $this->db->get('sys_login')->row_array();
		return $result;
	}
	function get_login_api($param){
		$this->db->select('username,id_user');
		$this->db->where($param);
		$result = $this->db->get('sys_login')->row_array();
		return $result;
	}
	
	function get_user($param){
		$this->db->where($param);
		$result = $this->db->get('ms_user')->row_array();
		return $result;
	}
}
?>