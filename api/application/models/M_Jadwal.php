<?php
	/* Author : Cecep Rokani */
	
	class M_Jadwal extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'rencanastudi';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID, $TahunID, $HariID, $limit = null, $offset = null){
			
			$where			= array();
			
			$this->db->select("
					jadwal.ID AS JadwalID,
					jadwalwaktu.ID AS JadwalWaktuID,
					detailkurikulum.MKKode AS MKKode,
					detailkurikulum.Nama AS Nama,
					detailkurikulum.TotalSKS AS SKS,
					IF(
					dosen.ID,
					CONCAT(
					IFNULL(dosen.Title, ''),
					' ',
					IFNULL(dosen.Nama, ''),
					' ',
					IFNULL(dosen.Gelar, '')
					),
					''
					) AS NamaDosen,
					jadwal.DosenAnggota,
					IF(jadwal.DosenAnggota IS NULL, 'T', 'Y') AS TeamTeaching,
					dosen.NIDN,
					hari.Nama AS NamaHari,
					ruang.Nama AS NamaRuang,
					kelas.Nama AS NamaKelas,
					CONCAT(
					kodewaktu.JamMulai,
					' s.d ',
					kodewaktu.JamSelesai
					) AS Waktu ", FALSE);
				
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = rencanastudi.DetailKurikulumID', 'inner');
			$this->db->join('jadwal', 'jadwal.ID = rencanastudi.JadwalID', 'inner');
			$this->db->join('mahasiswa', 'mahasiswa.ID = rencanastudi.MhswID', 'inner');
			$this->db->join('dosen', 'jadwal.DosenID = dosen.ID', 'inner');
			$this->db->join('jadwalwaktu', 'jadwalwaktu.JadwalID = jadwal.ID', 'left');
			$this->db->join('kelas', 'kelas.ID = jadwalwaktu.KelasID', 'left');
			$this->db->join('hari', 'hari.ID = jadwalwaktu.HariID', 'left');
			$this->db->join('ruang', 'ruang.ID = jadwalwaktu.RuangID', 'left');
			$this->db->join('kodewaktu', 'kodewaktu.ID = jadwalwaktu.WaktuID', 'left');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
				
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
				
			if($HariID)
				$this->db->where('hari.ID', $HariID);
				
			$this->db->order_by('detailkurikulum.Nama', 'ASC');
			
			$query = $this->db->get($this->table, $limit, $offset);
			return $query->result_array();
		}
		
		function get_data2($MhswID, $TahunID, $Jenis, $limit = null, $offset = null){
			
			$where			= array();
			
			$this->db->select("		
				  jadwalujian.ID,
				  jadwalujian.JenisUjian,
				  (SELECT 
					MKKode 
				  FROM
					detailkurikulum 
				  WHERE ID = jadwalujian.DetailKurikulumID) AS MKKode,
				  (SELECT 
					Nama 
				  FROM
					detailkurikulum 
				  WHERE ID = jadwalujian.DetailKurikulumID) AS NamaMatkul,
				  jadwalujian.Tanggal,
				  jadwalujian.Pengawas,
				  (SELECT 
					Nama 
				  FROM
					ruang 
				  WHERE ID = jadwalujian.RuangID) AS Ruang,
				  CONCAT(jadwalujian.JamMulai, IF(jadwalujian.JamMulai IS NULL, '', ' - '), jadwalujian.JamSelesai) AS Waktu ", FALSE);
				
			$this->db->join('peserta_ujian', 
				'peserta_ujian.MhswID = rencanastudi.MhswID 
				AND peserta_ujian.DetailKurikulumID = rencanastudi.DetailKurikulumID 
				AND peserta_ujian.TahunID = rencanastudi.TahunID ', 'inner');
			$this->db->join('jadwalujian', 'peserta_ujian.JadwalUjianID = jadwalujian.ID', 'inner');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
				
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
				
			if($Jenis)
				$this->db->where('jadwalujian.JenisUjian', $Jenis);
				
			$this->db->order_by('NamaMatkul', 'ASC');
			$this->db->order_by('Tanggal', 'ASC');
			
			$query = $this->db->get($this->table, $limit, $offset);
			return $query->result_array();
		}
		
		function get_data3($TahunID, $DosenID, $ProdiID, $HariID, $limit=null, $offset=null)
		{
			$this->db->select("	
					jadwal.ID as JadwalID,
					detailkurikulum.ID AS IDMatkul,
					jadwalwaktu.ID as JadwalWaktuID,
					IFNULL(detailkurikulum.MKKode, '-') as MKKode,
					IFNULL(detailkurikulum.Nama, '-') AS NamaMatkul,
					IFNULL(hari.Nama, '-') AS Hari,
					IFNULL(kelas.Nama, '-') AS Kelas,
					IFNULL(jadwal.DosenAnggota, '-') as DosenAnggota,
					IF(jadwal.DosenAnggota IS NULL, 'T', 'Y') AS TeamTeaching,
					IFNULL(ruang.Nama, '-') AS Ruang,
					dosen.NIP AS NIDN,
					IF(
					dosen.ID,
					CONCAT(
					IFNULL(dosen.Title, ''),
					' ',
					IFNULL(dosen.Nama, ''),
					' ',
					IFNULL(dosen.Gelar, '')
					),
					''
					) AS NamaDosen,
					IFNULL(CONCAT(
						kodewaktu.JamMulai,
						' s.d ',
						kodewaktu.JamSelesai
					), '-') AS Waktu,
					IFNULL((
						SELECT
							COUNT(ID)
						FROM
							rencanastudi
						WHERE
							JadwalID = jadwal.ID
					), 0) AS Peserta", FALSE);
					
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = jadwal.DetailKurikulumID', 'inner');		
			$this->db->join('jadwalwaktu', 'jadwalwaktu.JadwalID = jadwal.ID', 'left');		
			$this->db->join('hari', 'jadwalwaktu.HariID = hari.ID', 'left');		
			$this->db->join('ruang', 'jadwalwaktu.RuangID = ruang.ID', 'left');		
			$this->db->join('kelas', 'jadwal.KelasID = kelas.ID', 'left');		
			$this->db->join('dosen', 'jadwal.DosenID = dosen.ID', 'left');		
			$this->db->join('kodewaktu', 'jadwalwaktu.WaktuID = kodewaktu.ID', 'left');		
			
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			if($DosenID)
				$this->db->where('jadwal.DosenID', $DosenID);
			if($ProdiID)
				$this->db->where('jadwal.ProdiID', $ProdiID);
			if($HariID)
				$this->db->where('hari.ID', $HariID);
				
			$this->db->where('jadwal.Aktif', 'Ya');
					
			$query = $this->db->get('jadwal', $limit, $offset);
			return $query->result_array();
		}
		
		function get_data4($ProdiID, $ProgramID, $TahunID, $JenisUjian, $DosenID, $limit=null, $offset=null)
		{
			$this->db->select('
				jadwalujian.ID,
				jadwalujian.Kode,
				detailkurikulum.ID as IDMatkul,
				detailkurikulum.MKKode,
				detailkurikulum.Nama as NamaMatkul,
				jadwalujian.Tanggal,
				ruang.Nama as Ruang,
				CONCAT(jadwalujian.JamMulai, " s.d ", jadwalujian.JamSelesai) as Waktu,
				jadwalujian.Pengawas,
				jadwalujian.JenisUjian', FALSE);
				
			$this->db->join('detailkurikulum', 'jadwalujian.DetailKurikulumID = detailkurikulum.ID', 'inner');
			$this->db->join('ruang', 'jadwalujian.RuangID = ruang.ID', 'left');
			
			if($ProdiID)
				$this->db->where('detailkurikulum.ProdiID', $ProdiID);
			if($ProgramID)
				$this->db->where('detailkurikulum.ProgramID', $ProgramID);
			if($TahunID)
				$this->db->where('jadwalujian.TahunID', $TahunID);
			if($JenisUjian)
				$this->db->where('jadwalujian.JenisUjian', $JenisUjian);
			
			$this->db->where('FIND_IN_SET("'.$DosenID.'_dosen", Pengawas)');
			
			$query = $this->db->get('jadwalujian', $limit, $offset);
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