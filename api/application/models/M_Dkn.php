<?php
	/* Author : Cecep Rokani */
	
	class M_Dkn extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'presensikaryawan';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($NPM, $Approval, $limit = null, $offset = null){
			$limit_offset 	= array();
			$limit_offset[] = ($limit) ? "LIMIT ".$limit:"";
			$limit_offset[] = ($limit) ? "OFFSET ".$offset:"";
			$limit_offset 	= implode(' ',$limit_offset);
			
			$where			= array();
			
			$this->db->select('
					  rencanastudi.ID,
					  rencanastudi.NPM,
					  detailkurikulum.MKKode,
					  detailkurikulum.Nama,
					  detailkurikulum.NamaInggris,
					  detailkurikulum.TotalSKS,
					  rencanastudi.NilaiHuruf,
					  bobot.Bobot AS Nilai,
					  rencanastudi.NilaiAkhir,
					  (rencanastudi.TotalSKS * bobot.Bobot) AS Jumlah,
					  bobot.Keterangan,
					  rencanastudi.approval', FALSE);
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = rencanastudi.DetailKurikulumID ', 'inner');
			$this->db->join('mahasiswa', 'rencanastudi.MhswID = mahasiswa.ID', 'inner');
			$this->db->join('bobot', 'bobot.BobotMasterID = mahasiswa.BobotMasterID and rencanastudi.NilaiHuruf = bobot.Nilai', 'left');
			
			if($NPM)
				$this->db->where('rencanastudi.NPM', $NPM);
			if($Approval)
				$this->db->where('rencanastudi.approval', $Approval);
				
			$this->db->where('rencanastudi.NilaiHuruf is not null', null);
			
			$query = $this->db->get('rencanastudi');
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