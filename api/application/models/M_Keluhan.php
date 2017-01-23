<?php
	/* Author : Cecep Rokani */
	
	class M_Keluhan extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'bug';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID = '') {
			
			$this->db->select("mahasiswa.NPM, mahasiswa.Nama, bug.Text", FALSE);
				
			$this->db->join('mahasiswa', 'bug.MhswID = mahasiswa.ID', 'inner');
			
			if($MhswID)
				$this->db->where('bug.MhswID', $MhswID);
				
			$this->db->order_by('bug.Tanggal', 'desc');	
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		
		function simpanData($MhswID, $Text) {
			$data['MhswID']		= $MhswID;
			$data['Text']		= $Text;
			$this->db->set('Tanggal', 'curdate()', false);
			return $this->db->insert($this->table, $data);
		}
	}
?>