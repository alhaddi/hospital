<?php
	/* Author : Cecep Rokani */
	
	class M_Edom extends CI_Model
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
						IFNULL(detailkurikulum.MKKode, "-") AS MKKode,
						IFNULL(detailkurikulum.Nama, "-") AS Nama,
						IFNULL((SELECT Nama FROM dosen WHERE ID = jadwal.DosenID), "-") AS Dosen,
						IFNULL((SELECT Nama FROM kelas WHERE ID = jadwal.KelasID), "-") AS Kelas,
						IFNULL(rencanastudi.JadwalID, "-") AS JadwalID,
						IFNULL((SELECT CONCAT(JamMulai, " s.d ", JamSelesai) FROM kodewaktu WHERE ID = jadwal.KodeWaktu), "-") AS Waktu,
						IFNULL(jadwal.TahunID, "-") AS TahunID,
						IFNULL(jadwal.DosenAnggota, "-") AS DosenAnggota,
						IFNULL(jadwal.DosenID, "-") AS DosenID,'
						, FALSE);
						
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = rencanastudi.DetailKurikulumID ', 'inner');
			$this->db->join('jadwal', 'rencanastudi.JadwalID = jadwal.ID', 'inner');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
				
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			
			$this->db->where('jadwal.DosenID IS NOT NULL');
			//$this->db->where('rencanastudi.Semester != 1');
			$this->db->group_by('detailkurikulum.ID');
			
			$query = $this->db->get('rencanastudi');
			return $query->result_array();
		}
		
		function get_jum_edom($MhswID, $TahunID, $JadwalID){
			
			$this->db->select('*', FALSE);
			
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
				
			if($TahunID)
				$this->db->where('TahunID', $TahunID);
				
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			
			$this->db->where('Rate != 0');
			$query = $this->db->get('r_kuisioner_mahasiswa');
			return $query->num_rows();
		}
		
		function get_detail_edom(){
			$query = $this->db->get('m_kuisioner');
			
			return $query->result_array();
		}
		
		function get_rate_edom($MhswID, $DosenID, $JadwalID, $KuisionerID, $TahunID){
		
			$this->db->select('IFNULL(Rate, 0) AS Rate');
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			if($DosenID)
				$this->db->where('DosenID', $DosenID);
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			if($KuisionerID)
				$this->db->where('Kuisioner_id', $KuisionerID);
			if($TahunID)
				$this->db->where('TahunID', $TahunID);
				
			$query = $this->db->get('r_kuisioner_mahasiswa')->row();
			
			return (count($query) > 0) ? $query->Rate : 0;
		}
		
		function cek_edom($MhswID, $DosenID, $JadwalID, $KuisionerID, $TahunID)
		{
			$this->db->select('ID');
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			if($DosenID)
				$this->db->where('DosenID', $DosenID);
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			if($KuisionerID)
				$this->db->where('Kuisioner_id', $KuisionerID);
			if($TahunID)
				$this->db->where('TahunID', $TahunID);
				
			$Cek = $this->db->get('r_kuisioner_mahasiswa')->num_rows();
			
			return $Cek;
		}
		
		function update_detail_edom($MhswID, $DosenID, $JadwalID, $KuisionerID, $TahunID, $Data)
		{
			$this->db->where('Kuisioner_id', $KuisionerID);
			$this->db->where('MhswID', $MhswID);
			$this->db->where('DosenID', $DosenID);
			$this->db->where('TahunID', $TahunID);
			$this->db->where('JadwalID', $JadwalID);
			
			$Query = $this->db->update('r_kuisioner_mahasiswa', $Data);
			
			return $Query;
		}
		
		function add_detail_edom($Data)
		{
			$Query = $this->db->insert('r_kuisioner_mahasiswa', $Data);
			
			return $Query;
		}
		
		function delete_edom($MhswID, $DosenID, $JadwalID, $KuisionerID, $TahunID)
		{
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			if($DosenID)
				$this->db->where('DosenID', $DosenID);
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			if($KuisionerID)
				$this->db->where('Kuisioner_id', $KuisionerID);
			if($TahunID)
				$this->db->where('TahunID', $TahunID);
				
			$Query = $this->db->delete('r_kuisioner_mahasiswa');
			
			return $this->db->affected_rows();
		}
		
		function cekEdom($KodeTahun, $MhswID)
		{
			$Tahun				= get_field($KodeTahun, 'tahun', 'TahunID');
			$TahunID			= get_tahun_id($Tahun, 1, '-');
			$IDTahun			= get_where(array('TahunID' => $TahunID), 'tahun', 'ID');
			$this->db->select('ID');
			$this->db->where('MhswID', $MhswID);
			$this->db->where('TahunID', $IDTahun);
			$Total				= $this->db->get('r_kuisioner_mahasiswa')->num_rows();
			return $Total;
		}
	}
?>