<?php
	/* Author : Cecep Rokani */
	
	class M_Pengumuman extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'pengumuman';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($limit = null, $offset = null){
			$limit_offset 	= array();
			$limit_offset[] = ($limit) ? "LIMIT ".$limit:"";
			$limit_offset[] = ($limit) ? "OFFSET ".$offset:"";
			$limit_offset 	= implode(' ',$limit_offset);
			
			$where			= array();
			
			$this->db->select('*', FALSE);
			
			$this->db->where('TabelUserID', '4');
			// $this->db->where('NOW() < TanggalExpire');
			
			$query = $this->db->get('pengumuman');
			return $query->result_array();
		}
		
		/* 
		#Function for count all total row data
		function count_all($keyword='')
		{	
			if($keyword)
			$this->db->like('Nama',$keyword,'both');
			
			return $this->db->count_all_results($this->table);
		}
		
		#Function for get data with id
		function get_id($id)
		{
			$this->db->where($this->pk,$id);
			return $this->db->get($this->table)->row();
		}
		
		#Function for add data
		function add($data)
		{
			return $this->db->insert($this->table,$data);
		}
		
		#Function for edit data
		function edit($id,$data)
		{
			$this->db->where($this->pk,$id);
			return $this->db->update($this->table,$data);
		}
		
		#Function for delete/remove data
		function delete($id)
		{
			$this->db->where($this->pk,$id);
			return $this->db->delete($this->table);
		} */
	}
?>