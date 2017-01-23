<?php
	/* Author : Cecep Rokani */
	
	class M_Krs extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'rencanastudi';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($MhswID, $TahunID, $limit=null, $offset=null){
			$limit_offset 	= array();
			$limit_offset[] = ($limit) ? "LIMIT ".$limit:"";
			$limit_offset[] = ($limit) ? "OFFSET ".$offset:"";
			$limit_offset 	= implode(' ',$limit_offset);
			
			$this->db->select("
								detailkurikulum.MKKode,
								detailkurikulum.Nama,
								detailkurikulum.TotalSKS,
								rencanastudi.NilaiHuruf NilaiHuruf,
								rencanastudi.NilaiAkhir as NilaiAkhir,
								bobot.Bobot as Bobot,
								(bobot.Bobot * rencanastudi.TotalSKS) as Jumlah,
								dosen.Nama AS NamaDosen, 
								kelas.Nama AS NamaKelas,
								rencanastudi.approval as Approval,
								(SELECT COUNT(a.ID) FROM rencanastudi a WHERE a.TahunID=rencanastudi.TahunID AND a.DetailKurikulumID=rencanastudi.DetailKurikulumID) AS JumlahPendaftar
							", false);
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
			
			//$this->db->order_by('jadwal.HariID', 'ASC');
			//$this->db->order_by('jadwal.RuangID', 'ASC');
			//$this->db->order_by('jadwal.JamMulai', 'ASC');
			$this->db->join('detailkurikulum','detailkurikulum.ID = rencanastudi.DetailKurikulumID');
			$this->db->join('jadwal', 'jadwal.ID = rencanastudi.JadwalID');
			$this->db->join('dosen', 'jadwal.DosenID = dosen.ID', 'left');
			$this->db->join('kelas', 'jadwal.KelasID = kelas.ID', 'left');
			//$this->db->join('hari', 'jadwal.HariID = hari.ID', 'left');
			$this->db->join('mahasiswa', 'mahasiswa.ID = rencanastudi.MhswID', 'inner');
			$this->db->join('bobot', 'mahasiswa.BobotMasterID = bobot.BobotMasterID AND rencanastudi.BobotMasterID AND rencanastudi.NilaiHuruf = bobot.Nilai', 'left');
			$query 	= $this->db->get('rencanastudi', $limit, $offset);
			
			return $query->result_array();
		}
		
		function get_data2($MhswID, $TahunID, $Semester, $limit=null, $offset=null){
			
			$this->db->select("
								rencanastudi.ID,
								detailkurikulum.MKKode,
								detailkurikulum.Nama AS NamaMatkul,
								dosen.ID AS DosenID,
								dosen.Nama AS NamaDosen,
								rencanastudi.TotalSKS,
								hari.Nama AS NamaHari,
								rencanastudi.approval", false);
				
			$this->db->join('detailkurikulum', 'rencanastudi.DetailKurikulumID = detailkurikulum.ID', 'inner');
			$this->db->join('jadwal', 'rencanastudi.JadwalID = jadwal.ID', 'left');
			$this->db->join('dosen', 'jadwal.DosenID = dosen.ID', 'left');
			$this->db->join('jadwalwaktu', 'jadwal.ID = jadwalwaktu.JadwalID', 'left');
			$this->db->join('hari', 'jadwalwaktu.HariID = hari.ID', 'left');
			$this->db->join('mahasiswa', 'rencanastudi.MhswID = mahasiswa.ID', 'inner');
			
			if($MhswID)
				$this->db->where('rencanastudi.MhswID', $MhswID);
			if($TahunID)
				$this->db->where('rencanastudi.TahunID', $TahunID);
			if($Semester)
				$this->db->where('detailkurikulum.Semester', $Semester);
				
			$this->db->group_by('detailkurikulum.MKKode');
				
			$query 	= $this->db->get($this->table, $limit, $offset);
			
			return $query->result_array();
		}
		
		function get_data3($KurikulumID, $ProgramID, $ProdiID, $TahunID, $Semester, $limit = null, $offset = null){
			$this->db->select("
					jadwal.ID AS JadwalID,
					detailkurikulum.MKKode,
					detailkurikulum.Nama NamaMatkul,
					(SELECT CONCAT(Title, IF(Title = '' OR Title IS NULL, '', ' '), Nama, ',', Gelar) FROM dosen WHERE ID = jadwal.DosenID) AS NamaDosen,
					detailkurikulum.TotalSKS,
					(SELECT Nama FROM hari WHERE ID = jadwalwaktu.HariID) AS NamaHari,
					kelas.Nama AS NamaKelas,
					(SELECT CONCAT(JamMulai, ' s.d ', JamSelesai) FROM kodewaktu WHERE ID = jadwalwaktu.WaktuID) AS Waktu,
					(SELECT 
					COUNT(ID) 
					FROM
					rencanastudi a 
					WHERE a.JadwalID = jadwal.ID 
					AND a.MKKode = detailkurikulum.MKKode) AS JumlahPeserta ,
					detailkurikulum.ProdiID,
					detailkurikulum.KurikulumID,
					detailkurikulum.ProgramID,
					detailkurikulum.Semester,
					detailkurikulum.ID AS DetailKurikulumID,
					jadwal.Kapasitas,
					rencanastudi.approval", false);
				
			$this->db->join('rencanastudi', 'detailkurikulum.ID = rencanastudi.DetailKurikulumID', 'left');
			$this->db->join('jadwal', 'jadwal.DetailKurikulumID = detailkurikulum.ID', 'left');
			$this->db->join('jadwalwaktu', 'jadwalwaktu.JadwalID = jadwal.ID', 'left');
			$this->db->join('kelas', 'jadwal.KelasID = kelas.ID', 'left');
			
			if($ProdiID)
				$this->db->where('detailkurikulum.ProdiID', $ProdiID);
				
			if($ProgramID)
				$this->db->where('detailkurikulum.ProgramID', $ProgramID);
				
			if($KurikulumID)
				$this->db->where('detailkurikulum.KurikulumID', $KurikulumID);
				
			if($Semester)
				$this->db->where('detailkurikulum.Semester', $Semester);
				
			//if($TahunID)
				//$this->db->where('detailkurikulum.IDTahun', $TahunID);
				
			$this->db->group_by('detailkurikulum.MKKode');
			$this->db->order_by('detailkurikulum.Semester', 'ASC');
			// $this->db->order_by('detailkurikulum.Nama', 'ASC');
			//$this->db->order_by('detailkurikulum.MKKode', 'ASC');
			//$this->db->order_by('detailkurikulum.KonsentrasiID', 'ASC');
				
			$query 	= $this->db->get('detailkurikulum', $limit, $offset);
			
			return $query->result_array();
		}
		
		function add_krs($data)
		{
			$query = $this->db->insert('rencanastudi', $data);
			
			return $query;
		}
		
		function delete_krs($where)
		{
			$this->db->where($where);
			$this->db->where('approval', '1');
			$query = $this->db->delete('rencanastudi');
			
			return $query;
		}
		
		function get_sks($MhswID, $TahunID, $KurikulumID, $ProgramID, $ProdiID){
		
			$this->db->select('Semester');
			$this->db->where('ID', $TahunID);
			$Query	= $this->db->get('tahun')->row();
			
			$this->db->select('IPS, IPK');
			$this->db->where('MhswID', $MhswID);
			$this->db->where('TahunID', $TahunID - 1);
			$Query2 = $this->db->get('hasilstudi')->row();
			
			$IPS 	= isset($Query2->IPS) ? $Query2->IPS : '';
			$IPK 	= isset($Query2->IPK) ? $Query2->IPK : '';
			
			if($IPS && $IPK)
			{
				$this->db->select('SKS');
				$this->db->where('IPK_Awal <=', $IPS);
				$this->db->where('IPK_Akhir >=', $IPK);
				
				$Query3 = $this->db->get('rangesks')->row();
			}
			
			$this->db->select('SUM(TotalSKS) AS BatasSKS');
			$this->db->where('Semester', $Query->Semester);
			$this->db->where('KurikulumID', $KurikulumID);
			$this->db->where('ProgramID', $ProgramID);
			$this->db->where('ProdiID', $ProdiID);
			$TotalSKS = $this->db->get('detailkurikulum')->row();
			
			$SKS['TotalSKS']	= $TotalSKS->BatasSKS;
			$SKS['BatasSKS']	= (isset($Query3->SKS) && $Query3->SKS < $TotalSKS->BatasSKS) ? $Query3->SKS : $TotalSKS->BatasSKS;
			
			$data[]				= $SKS;
			return $data;
		}
		
		function cek_krs($MhswID, $TahunID, $KurikulumID, $ProgramID, $ProdiID, $DetailKurikulumID)
		{
			$this->db->select('ID');
			
			$this->db->where('MhswID', $MhswID);
			$this->db->where('TahunID', $TahunID);
			$this->db->where('ProdiID', $ProdiID);
			$this->db->where('ProgramID', $ProgramID);
			$this->db->where('KurikulumID', $KurikulumID);
			$this->db->where('DetailKurikulumID', $DetailKurikulumID);
			
			$Query = $this->db->get('rencanastudi');
			
			return $Query->num_rows();
		}
		
		function check_krs($MhswID, $TahunID, $ProdiID)
		{
			$cur = date("Y-m-d");
			
			$this->db->select("KRS");
			$this->db->where("TahunID", $TahunID);
			$this->db->where("MhswID", $MhswID);
			$Query 	= $this->db->get("opsi_mahasiswa")->row();
			
			$this->db->select("tahun.ID");
			$this->db->join('tahun_detail', 'tahun.ID = tahun_detail.TahunID', 'inner');
			$this->db->where("tahun.ProsesBuka", '1');
			$this->db->where("tahun_detail.ProdiID", $ProdiID);
			$this->db->where("('". $cur ."' BETWEEN KRSMulai AND KRSSelesai)");
			$Query2 = $this->db->get("tahun")->num_rows();
			
			$data['CekKrs']	= ($Query) ? $Query->KRS : '0';
			$data['Tahun']	= $Query2 > 0 ? $Query2 : 0;
			
			$datas[]		= $data;
			
			return $datas;
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