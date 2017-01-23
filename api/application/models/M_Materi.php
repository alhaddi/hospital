<?php
	/* Author : Cecep Rokani */
	
	class M_Materi extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'presensikaryawan';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID, $TahunID, $limit = null, $offset = null){
			$limit_offset 	= array();
			$limit_offset[] = ($limit) ? "LIMIT ".$limit:"";
			$limit_offset[] = ($limit) ? "OFFSET ".$offset:"";
			$limit_offset 	= implode(' ',$limit_offset);
			
			$where			= array();
			
			$this->db->select('
							  IFNULL(
								rencanastudi.DetailKurikulumID,
								"-"
							  ) AS DetailKurikulumID,
							  IFNULL(rencanastudi.MKKode, "-") AS MKKode,
							  IFNULL(detailkurikulum.Nama, "-") AS NamaMatkul,
							  IFNULL(
								(SELECT 
								  Nama 
								FROM
								  dosen 
								WHERE ID = jadwal.DosenID),
								"-"
							  ) AS NamaDosen,
							  IFNULL(
								(SELECT 
								  Nama 
								FROM
								  hari 
								WHERE ID = jadwalwaktu.HariID),
								"-"
							  ) AS NamaHari,
							  IFNULL(
								(SELECT 
								  Nama 
								FROM
								  kelas 
								WHERE ID = jadwalwaktu.KelasID),
								"-"
							  ) AS NamaKelas,
							  jadwal.ID as JadwalID', FALSE);
						
			$this->db->join('jadwal', 'rencanastudi.JadwalID = jadwal.ID', 'inner');
			$this->db->join('jadwalwaktu', 'jadwalwaktu.JadwalID = jadwal.ID', 'left');
			$this->db->join('detailkurikulum', 'rencanastudi.DetailKurikulumID = detailkurikulum.ID', 'left');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
				
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			
			$this->db->where('rencanastudi.approval', '2');
			$this->db->group_by('rencanastudi.DetailKurikulumID');
			$this->db->order_by('detailkurikulum.Nama', 'ASC');
			
			$query = $this->db->get('rencanastudi');
			return $query->result_array();
		}
		
		function get_data_sesi($JadwalID, $limit = null, $offset = null){
			$limit_offset 	= array();
			$limit_offset[] = ($limit) ? "LIMIT ".$limit:"";
			$limit_offset[] = ($limit) ? "OFFSET ".$offset:"";
			$limit_offset 	= implode(' ',$limit_offset);
			
			$where			= array();
			
			$this->db->select('*', FALSE);
			
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			
			$this->db->order_by('Judul', 'ASC');
			
			$query = $this->db->get('sesi');
			return $query->result_array();
		}
		
		function get_data_materi($SesiID){
		
			$this->db->select('*');
			
			if($SesiID)
				$this->db->where('SesiID', $SesiID);
			$Query 		= $this->db->get('materi')->row();
			
			if(isset($Query))
			{
				$this->db->select('materi_file.File');
				$this->db->join('materi_file', 'materi_file.MateriID = materi.ID', 'inner');
				if($Query->ID)
					$this->db->where('materi_file.MateriID', $Query->ID);
				$Query2 	= $this->db->get('materi')->result();
				
				$materi['file'] 		= $Query2;
			}
			else
			{
				$materi['file']		= '-';
			}
			
			$materi['data'] 		= $Query;
			
			$data[]			= $materi;
			
			return $data;
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