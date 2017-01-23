<?php
	/* Author : Cecep Rokani */
	
	class M_Presensi extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'rencanastudi';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID, $TahunID, $limit=null, $offset=null){
		
			$this->db->select(' 
					rencanastudi.ID AS ID,
					jadwalwaktu.ID as JadwalID,
					presensimahasiswa.RuangID,
					presensimahasiswa.Tgl,
					presensimahasiswa.HariID,
					presensimahasiswa.WaktuID,
					presensimahasiswa.MhswID,
					detailkurikulum.MKKode,
					detailkurikulum.Nama AS NamaMatkul,
					rencanastudi.NPM,
					CONCAT((SELECT Nama FROM hari WHERE ID = jadwalwaktu.HariID), " - ", (SELECT CONCAT(JamMulai, " s.d ", JamSelesai) FROM kodewaktu WHERE ID = jadwalwaktu.WaktuID)) AS Waktu'
					, FALSE);
			
			$this->db->join('detailkurikulum', ' rencanastudi.DetailKurikulumID = detailkurikulum.ID', 'inner');
			$this->db->join('jadwalwaktu', ' jadwalwaktu.JadwalID = rencanastudi.JadwalID', 'left');
			$this->db->join('presensimahasiswa', 'presensimahasiswa.MhswID = rencanastudi.MhswID AND presensimahasiswa.JadwalID = jadwalwaktu.ID', 'left');
			$this->db->join('jenispresensi', 'jenispresensi.ID = presensimahasiswa.JenisPresensiID', 'left');
			$this->db->join('hari', 'hari.ID = jadwalwaktu.HariID', 'left');
			$this->db->join('kodewaktu', 'kodewaktu.ID = jadwalwaktu.WaktuID', 'left');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
			$this->db->where('rencanastudi.approval', 2);
			//$this->db->group_by('rencanastudi.DetailKurikulumID');
			$this->db->group_by('detailkurikulum.MKKode');
			$this->db->order_by('NamaMatkul', 'asc');
			
			$query = $this->db->get($this->table, $limit, $offset);
			return $query->result_array();
		}
		
		function get_kehadiran($MhswID, $JadwalID)
		{
			$this->db->select('presensimahasiswa.JadwalID, jenispresensi.Kode as KodeJenisAbsen , presensimahasiswa.Pertemuan');
			$this->db->join('jenispresensi', 'presensimahasiswa.JenisPresensiID = jenispresensi.ID', 'inner');
			
			if($MhswID)
				$this->db->where('presensimahasiswa.MhswID', $MhswID);
			if($JadwalID)
				$this->db->where('presensimahasiswa.JadwalID', $JadwalID);
				
			$Query = $this->db->get('presensimahasiswa');
			
			return $Query->result_array();
		}
		
		function get_kehadiran2($DosenID, $JadwalID)
		{
			$this->db->select('presensidosen.Tgl, presensidosen.JadwalID, jenispresensi.Kode as KodeJenisAbsen , presensidosen.Pertemuan');
			$this->db->join('jenispresensi', 'presensidosen.JenisPresensiID = jenispresensi.ID', 'inner');
			
			if($DosenID)
				$this->db->where('presensidosen.DosenID', $DosenID);
			if($JadwalID)
				$this->db->where('presensidosen.JadwalID', $JadwalID);
				
			$Query = $this->db->get('presensidosen');
			
			return $Query->result_array();
		}
		
		function get_data2($DosenID, $TahunID, $ProdiID, $limit = null, $offset = null)
		{
			$this->db->select(' 
								jadwal.ID AS ID,
								jadwal.ID as JadwalID,
								presensidosen.RuangID,
								presensidosen.Tgl,
								jadwalwaktu.HariID,
								jadwalwaktu.WaktuID,
								presensidosen.DosenID,
								detailkurikulum.ID as IDMatkul,
								detailkurikulum.MKKode,
								detailkurikulum.Nama AS NamaMatkul,
								CONCAT(( SELECT Nama FROM hari WHERE ID = jadwalwaktu.HariID ), " - ", ( SELECT CONCAT( JamMulai, " s.d ", JamSelesai ) FROM kodewaktu WHERE ID = jadwalwaktu.WaktuID )) AS Waktu
								', FALSE);
			
			$this->db->join('detailkurikulum', ' jadwal.DetailKurikulumID = detailkurikulum.ID', 'inner');
			$this->db->join('jadwalwaktu', ' jadwalwaktu.JadwalID = jadwal.ID', 'left');
			$this->db->join('presensidosen', 'presensidosen.DosenID = jadwal.DosenID AND presensidosen.JadwalID = jadwalwaktu.ID', 'left');
			$this->db->join('jenispresensi', 'jenispresensi.ID = presensidosen.JenisPresensiID', 'left');
			
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			//if($ProgramID)
			//	$this->db->where('jadwal.ProgramID', $ProgramID);
			if($ProdiID)
				$this->db->where('jadwal.ProdiID', $ProdiID);
			if($DosenID)
				$this->db->where('(jadwal.DosenID = "'.$DosenID.'" OR FIND_IN_SET("'.$DosenID.'", jadwal.DosenAnggota))');
			
			$this->db->group_by('jadwal.DetailKurikulumID');
			$this->db->order_by('NamaMatkul', 'asc');
			$this->db->order_by('presensidosen.Pertemuan', 'asc');
			
			$query = $this->db->get('jadwal', $limit, $offset);
			return $query->result_array();
		}
		
		function get_daftar_mahasiswa($ProgramID, $TahunID, $DosenID, $limit=null, $offset=null)
		{
			$this->db->select("
							jadwal.ID,
							jadwal.DetailKurikulumID,
							IFNULL(detailkurikulum.MKKode, '-') as MKKode,
							IFNULL(detailkurikulum.Nama, '-') AS NamaMatkul,
							IFNULL(hari.Nama, '-') AS Hari,
							IFNULL(kelas.Nama, '-') AS Kelas,
							IFNULL(jadwal.DosenID, '-') as DosenID,
							IFNULL(dosen.Nama, '-') AS Dosen,
							IFNULL(ruang.Nama, '-') AS Ruang,
							IFNULL(jadwalwaktu.JadwalID, '-') AS JadwalID,
							IFNULL(CONCAT(
								kodewaktu.JamMulai,
								' s.d ',
								kodewaktu.JamSelesai
							), '-') AS Waktu,
							IFNULL((
								SELECT
									count(ID)
								FROM
									rencanastudi
								WHERE
									JadwalID = jadwal.ID
							), 0) AS Peserta", FALSE);
							
			$this->db->join('jadwalwaktu', 'jadwalwaktu.JadwalID = jadwal.ID', 'inner');
			$this->db->join('detailkurikulum', 'detailkurikulum.ID = jadwal.DetailKurikulumID', 'inner');
			$this->db->join('dosen', 'dosen.ID = jadwal.DosenID', 'left');
			$this->db->join('hari', 'hari.ID = jadwalwaktu.HariID', 'left');
			$this->db->join('kodewaktu', 'kodewaktu.ID = jadwalwaktu.WaktuID', 'left');
			$this->db->join('ruang', 'ruang.ID = jadwalwaktu.RuangID', 'left');
			$this->db->join('kelas', 'kelas.ID = jadwal.KelasID', 'left');
			
			if($ProgramID)
				$this->db->where('jadwal.ProgramID', $ProgramID);
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			if($DosenID)
				{
					$this->db->where('jadwal.DosenID = "'.$DosenID.'" OR FIND_IN_SET("'.$DosenID.'", jadwal.DosenAnggota)');
				}
			
			$query = $this->db->get('jadwal', $limit, $offset);
			return $query->result_array();
		}
		
		function input_presensi($jenis, $where=null, $data)
		{
			if($jenis && $jenis == 1)
				$this->db->insert('presensimahasiswa', $data);
			else
			{
				$this->db->where($where);
				$this->db->update('presensimahasiswa',$data);
			}
		}
		
		function get_data_mahasiswa($JadwalID, $Pertemuan, $TahunID)
		{
			if($Pertemuan)
				$this->db->where('JadwalID',$JadwalID);
			if($JadwalID)
				$this->db->where('Pertemuan',$Pertemuan);
				
			$Cek = $this->db->get('presensimahasiswa')->num_rows();
			
			if($Cek == 0)
			{
				$this->db->select('
								rencanastudi.ID,
								mahasiswa.NPM,
								mahasiswa.Nama', FALSE);
				
				$this->db->join('mahasiswa', 'mahasiswa.ID = rencanastudi.MhswID', 'inner');
				if($JadwalID)
					$this->db->where('rencanastudi.JadwalID', $JadwalID);
				$this->db->order_by('mahasiswa.Nama', 'ASC');
				
				$Query = $this->db->get('rencanastudi');
			}
			else
			{
				$this->db->select('', FALSE);
				if($JadwalID)
					$this->db->where('JadwalID', $JadwalID);
				if($TahunID)
					$this->db->where('TahunID', $TahunID);
					
				$Query = $this->db->get('rencanastudi');
			}
			
			return $Query->result_array();
		}
		
		function get_presensi_mahasiswa($MhswID, $JadwalID, $Pertemuan)
		{
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			if($JadwalID)
				$this->db->where('JadwalID', $JadwalID);
			if($Pertemuan)
				$this->db->where('Pertemuan', $Pertemuan);
				
			$Query = $this->db->get('presensimahasiswa');
			
			return $Query->result();
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
		} **/
	}
?>