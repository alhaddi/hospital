<?php
	/* Author : Cecep Rokani */
	
	class M_Nilai extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'rencanastudi';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($ProgramID, $ProdiID, $TahunID, $DosenID, $limit=null, $offset=null){
		
			$this->db->select("
						jadwal.ID,
						jadwal.ProdiID,
						jadwal.KurikulumID,
						jadwal.DetailKurikulumID,
						detailkurikulum.MKKode,
						detailkurikulum.Nama as NamaMatkul,
						ifnull(hari.Nama, '-') as Hari,
						ifnull(kelas.Nama, '-') as Kelas,
						ifnull(dosen.Nama, '-') as Dosen,
						ifnull(ruang.Nama, '-') as Ruang,
						ifnull(concat(kodewaktu.JamMulai, ' s.d ', kodewaktu.JamSelesai), '-') as Waktu,
						if((select count(ID) as Jum from rencanastudi where JadwalID = jadwal.ID) is null or (select count(ID) as Jum from rencanastudi where JadwalID = jadwal.ID) < 0, 0, (select count(ID) from rencanastudi where JadwalID = jadwal.ID)) as Peserta"
					, FALSE);
			
			$this->db->join('detailkurikulum', 'jadwal.DetailKurikulumID = detailkurikulum.ID', 'inner');
			$this->db->join('jadwalwaktu', ' jadwal.ID = jadwalwaktu.JadwalID', 'left');
			$this->db->join('dosen', 'jadwal.DosenID = dosen.ID', 'left');
			$this->db->join('hari', 'jadwalwaktu.HariID = hari.ID', 'left');
			$this->db->join('kodewaktu', 'jadwalwaktu.WaktuID = kodewaktu.ID', 'left');
			$this->db->join('ruang', 'jadwalwaktu.RuangID = ruang.ID', 'left');
			$this->db->join('kelas', 'jadwal.KelasID = kelas.ID', 'left');
			
			if($ProgramID)
				$this->db->where('jadwal.ProgramID', $ProgramID);
			if($ProdiID)
				$this->db->where('jadwal.ProdiID', $ProdiID);
			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			if($DosenID)
				$this->db->where('jadwal.DosenID', $DosenID);
				
			$this->db->order_by('NamaMatkul', 'asc');
			
			$query = $this->db->get('jadwal', $limit, $offset);
			return $query->result_array();
		}
		
		function get_data2($DetailKurikulumID, $TahunID, $limit=null, $offset=null)
		{
			$this->db->select("
						rencanastudi.ID,
						kelas.Nama AS Kelas,
						mahasiswa.NPM,
						mahasiswa.Nama,
						rencanastudi.MhswID,
						rencanastudi.NilaiAkhir,
						rencanastudi.NilaiHuruf", FALSE);
			
			$this->db->join('mahasiswa', 'rencanastudi.MhswID = mahasiswa.ID', 'inner');
			$this->db->join('kelas', 'mahasiswa.KelasID = kelas.ID', 'left');
			
			if($DetailKurikulumID)
				$this->db->where('rencanastudi.DetailKurikulumID', $DetailKurikulumID);
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
				
			$this->db->order_by('mahasiswa.Nama', 'ASC');
			
			$query = $this->db->get('rencanastudi', $limit, $offset);
			return $query->result_array();
		}
		
		function get_bobot($ProdiID, $TahunID, $KurikulumID, $DetailKurikulumID, $Jenis=null)
		{
			$this->db->select("
								bobotnilai.*,
								jenisbobot.Nama as NamaJenisBobot", FALSE);
								
			$this->db->join('jenisbobot', 'jenisbobot.ID = bobotnilai.JenisBobotID', 'inner');
			
			if($ProdiID)
				$this->db->where('bobotnilai.ProdiID', $ProdiID);
			if($TahunID)
				$this->db->where('bobotnilai.TahunID', $TahunID);
			if($KurikulumID)
				$this->db->where('bobotnilai.KurikulumID', $KurikulumID);
			if($DetailKurikulumID)
				$this->db->where('bobotnilai.DetailKurikulumID', $DetailKurikulumID);
			if($Jenis && $Jenis == 1)
				$this->db->where('bobotnilai.Persen > 0');
				
			$this->db->group_by('bobotnilai.JenisBobotID');
			$this->db->order_by('jenisbobot.Urut', 'ASC');
			
			$query = $this->db->get('bobotnilai');
			
			if($query->num_rows() == 0)
				$query = $this->db->get('jenisbobot');
				
			return $query->result_array();
		}
		
		function get_nilai($MhswID, $DetailKurikulumID, $TahunID)
		{
			
			if($MhswID)
				$this->db->where('MhswID', $MhswID);
			if($DetailKurikulumID)
				$this->db->where('DetailKurikulumID', $DetailKurikulumID);
			if($TahunID)
				$this->db->where('TahunID', $TahunID);
			/* if($JenisBobotID)
				$this->db->where('JenisBobotID', $JenisBobotID); */
				
			$Query = $this->db->get('bobot_mahasiswa');
			
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
		} **/
	}
?>