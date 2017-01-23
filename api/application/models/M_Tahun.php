<?php
	/* Author : Cecep Rokani */
	
	class M_Tahun extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'tahun';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID){
			
			$this->db->select("
				tahun.`ID` AS IDTahun,
				tahun.`TahunID`,
				tahun.`Nama` AS NamaTahun", FALSE);
				
			$this->db->join('rencanastudi', 'rencanastudi.TahunID = tahun.ID', 'inner');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
			
			$this->db->group_by('tahun.ID');
			$this->db->order_by('Nama', 'desc');	
			$query = $this->db->get($this->table);
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
		
		#Function get Tahun Aktif
		function get_tahun()
		{
			$this->db->select('ID');
			$this->db->where('ProsesBuka', '1');
			$query = $this->db->get('tahun')->row();
			
			return $query->ID;
		}
	}
?>