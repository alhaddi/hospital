<?php
	/* Author : Cecep Rokani */
	
	class M_Billing extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'tagihan_mahasiswa';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID, $limit = null, $offset = null){
			
			$where			= array();
			
			$this->db->select('
					tagihan_mahasiswa.ID,
					jenisbiaya.Nama AS JenisBiaya,
					tagihan_mahasiswa.Tanggal,
					tagihan_mahasiswa.Jumlah AS Debet,
					tagihan_mahasiswa.TotalCicilan AS Kredit,
					(tagihan_mahasiswa.Jumlah - tagihan_mahasiswa.TotalCicilan) AS Saldo,
					IFNULL(tagihan_verifikasi.Verifikasi, "X") AS Veritifikasi', FALSE);
				
			$this->db->join('jenisbiaya', 'tagihan_mahasiswa.JenisBiayaID = jenisbiaya.ID', 'inner');
			$this->db->join('tagihan_verifikasi', 'tagihan_mahasiswa.ID = tagihan_verifikasi.TagihanMahasiswaID', 'left');
			$this->db->join('mahasiswa', 'tagihan_mahasiswa.UserID = mahasiswa.ID', 'inner');
			$this->db->join('cicilan_tagihan_mahasiswa', 'tagihan_mahasiswa.ID = cicilan_tagihan_mahasiswa.TagihanMahasiswaID', 'left');
			
			if($MhswID)
				$this->db->where('tagihan_mahasiswa.UserID', $MhswID);
			//if($TahunID)
			//	$this->db->where('tagihan_mahasiswa.TahunID', $TahunID);
				
			$this->db->group_by('jenisbiaya.ID');
			$this->db->order_by('jenisbiaya.Nama', 'ASC');
			
			$query = $this->db->get($this->table, $limit, $offset);
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