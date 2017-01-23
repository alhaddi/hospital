<?php
	/* Author : Amir Mufid */
	
	class M_Khs extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'presensikaryawan';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($NPM, $TahunID, $limit=null, $offset=null){

			$this->db->select("
					detailkurikulum.MKKode,
					detailkurikulum.Nama,
					detailkurikulum.NamaInggris,
					detailkurikulum.TotalSKS,
					rencanastudi.ID,
					rencanastudi.NilaiHuruf,
					rencanastudi.NilaiAkhir,
					bobot.Bobot,
					(rencanastudi.TotalSKS * bobot.Bobot) as Jumlah", FALSE);
					
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = rencanastudi.DetailKurikulumID', 'inner');	
			$this->db->join('tahun', 'tahun.ID = rencanastudi.TahunID', 'inner');	
			$this->db->join('mahasiswa', 'mahasiswa.ID = rencanastudi.MhswID', 'inner');	
			$this->db->join('bobot', 'bobot.BobotMasterID = mahasiswa.BobotMasterID AND rencanastudi.NilaiHuruf = bobot.Nilai', 'left');	
			
			if($NPM)
				$this->db->where("rencanastudi.NPM = ", $NPM);
			if($TahunID)
				$this->db->where("tahun.TahunID = ", $TahunID);
			
			$this->db->where("rencanastudi.approval = ", '2');
			$this->db->group_by('detailkurikulum.MKKode');
			
			$Query = $this->db->get('rencanastudi', $limit, $offset);
			
			return $Query->result_array();
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