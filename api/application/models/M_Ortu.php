<?php
	/* Author : Cecep Rokani */
	
	class M_Ortu extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'ortu';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($ID, $Jenis){
		
			$this->db->select('
								ortu.*, 
								pekerjaan.Nama as Pekerjaan,
								pendidikan.Nama as Pendidikan, 
								raja_propinsi.id as IDPropinsi, 
								raja_propinsi.nama as Provinsi,
								concat(tipe, " ", raja_kota.nama) as Kota,
								concat("Kec. ", raja_kecamatan.nama) as Kecamatan');
			
			$this->db->join('pekerjaan', 'ortu.PekerjaanID = pekerjaan.ID', 'left');
			$this->db->join('pendidikan', 'ortu.PendidikanID = pendidikan.ID', 'left');
			$this->db->join('raja_kecamatan', 'ortu.KecamatanID = raja_kecamatan.id', 'left');
			$this->db->join('raja_kota', 'raja_kota.id = raja_kecamatan.idkota', 'left');
			$this->db->join('raja_propinsi', 'raja_propinsi.id = raja_kota.idprop', 'left');
			
			if($ID)
				$this->db->where('ortu.MhswID', $ID);
			if($Jenis)
				$this->db->where('ortu.Keterangan', $Jenis);
				
			$Query = $this->db->get('ortu');
			
			return $Query->result_array();
		}
		
		function get_id_ortu($MhswID)
		{
			$this->db->select("
				GROUP_CONCAT(
					CASE
					WHEN Keterangan = 'Ayah' THEN
						ID
					ELSE
						0
					END
				) AS Ayah,
				GROUP_CONCAT(
					CASE
					WHEN Keterangan = 'Ibu' THEN
						ID
					ELSE
						0
					END
				) AS Ibu");
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			$query = $this->db->get('ortu');
			
			if($query->num_rows() > 0)
				$data 	= $query->result();
			else
				$data[] = array('Ayah' => '-', 'Ibu' => '-');
			return $data;
		}
		
		function ubah_profil($data, $OrtuID)
		{
			$this->db->where('ID', $OrtuID);
			$Cek = $this->db->get('ortu')->num_rows();
			
			if($Cek > 0)
			{
				$this->db->where('ID', $OrtuID);
				$this->db->update('ortu', $data);
			}
			
			return $this->db->affected_rows();
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