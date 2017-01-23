<?php
	/* Author : Cecep Rokani */
	
	class M_Users extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'presensimahasiswa';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($param, $kondisi=null){
			if($kondisi)
			{
				$this->db->select('
									user.ID,
									user.Nama,
									user.PassOrtu,
									user.EntityID,
									user.TabelUserID');
				$this->db->join('ortu', 'ortu.MhswID = user.EntityID', 'inner');
			}
			else
			{			
				$this->db->select('
							user.ID,
							user.Nama,
							user.Password,
							user.EntityID,
							user.TabelUserID');
							}
			if($param)
				$this->db->where($param);
			$query = $this->db->get('user');
			return $query->result_array();
		}
		
		function get_data2($param){
			$this->db->select('
							user.ID,
							user.Nama,
							user.Password,
							user.EntityID,
							user.TabelUserID');
			$this->db->join('mahasiswa', 'mahasiswa.ID = user.EntityID and mahasiswa.StatusMhswID = 1', 'inner');
			if($param)
				$this->db->where($param);
			$query = $this->db->get('user');
			return $query->result_array();
		}
		
		function get_data_mhs($MhswID){
			$this->db->select("
					ifnull(agama.Nama,'-') as NamaAgama,
					ifnull(propinsi.Nama,'-') as NamaProv,
					ifnull(kota.Nama,'-') as NamaKota,
					ifnull(program.Nama,'-') as NamaProgram,
					ifnull(programstudi.Nama,'-') as NamaProdi,
					ifnull(statusmahasiswa.Nama,'-') as NamaStatusMhsw,
					ifnull(jenissekolah.Nama,'-') as NamaJenisSekolah,
					kurikulum.Nama as NamaKurikulum,
					CONCAT(penghasilan.min, ' - ', penghasilan.max) as PenghasilanOrtu,
					(select sum(TotalSKS) from rencanastudi where MhswID = mahasiswa.ID) as SKS,
					mahasiswa.*
			", false);
					// (select max(Semester) from rencanastudi where MhswID = mahasiswa.ID) as Semester,
			$this->db->where('mahasiswa.ID', $MhswID);
			$this->db->join('agama','agama.ID = mahasiswa.AgamaID','left');
			$this->db->join('propinsi','propinsi.ID = mahasiswa.PropinsiID','left');
			$this->db->join('kota','kota.ID = mahasiswa.KotaID','left');
			$this->db->join('program','program.ID = mahasiswa.ProgramID','left');
			$this->db->join('programstudi','programstudi.ID = mahasiswa.ProdiID','left');
			$this->db->join('statusmahasiswa','statusmahasiswa.ID = mahasiswa.StatusMhswID','left');
			$this->db->join('jenissekolah','jenissekolah.ID = mahasiswa.JenisSekolahID','left');
			$this->db->join('penghasilan','penghasilan.ID = mahasiswa.PenghasilanID','left');
			$this->db->join('kurikulum','kurikulum.ID = mahasiswa.KurikulumID','left');
			
			$query = $this->db->get('mahasiswa');
			
			return $query->result_array();
		}
		
		function get_data_tahun(){
			
			$this->db->select("
				  IFNULL(tahun_detail.ID, '') AS ID,
				  IFNULL(tahun_detail.TahunID, '') AS tahunID,
				  IFNULL(programstudi.Nama, '') AS ProgramStudi,
				  IFNULL(tahun.Semester, '') AS Semester,
				  IFNULL(tahun.Nama, '') AS Nama,
				  IFNULL(tahun_detail.KRSMulai, '') AS TglKRSMulai,
				  IFNULL(tahun_detail.KRSSelesai, '') AS TglKRSSelesai,
				  IFNULL(tahun_detail.KuliahMulai, '') AS TglKuliahMulai,
				  IFNULL(tahun_detail.KuliahSelesai, '') AS TglKuliahSelesai,
				  IFNULL(tahun_detail.UTSMulai, '') AS TglUTSMulai,
				  IFNULL(tahun_detail.UTSSelesai, '') AS TglUTSSelesai,
				  IFNULL(tahun_detail.UASMulai, '') AS TglUASMulai,
				  IFNULL(tahun_detail.UASSelesai, '') AS TglUASSelesai,
				  IFNULL(tahun_detail.NilaiMulai, '') AS TglNilaiMulai,
				  IFNULL(tahun_detail.NilaiSelesai, '') AS TglNilaiSelesai,
				  IFNULL(tahun.ProsesBuka, '') AS ProsesBuka,
				  IFNULL(tahun.TahunID, '') AS TahunID2 
			",false);
			
			$this->db->join('tahun_detail', 'tahun_detail.TahunID = tahun.ID', 'inner');
			$this->db->join('programstudi', 'tahun_detail.ProdiID = programstudi.ID', 'inner');
			$this->db->where('tahun.ProsesBuka', 1);
			$this->db->group_by('tahun.ID');
			$this->db->order_by('tahun.TahunID', 'DESC');
			$query = $this->db->get('tahun');
			
			return $query->result_array();
		}
		
		function get_data_pembimbing($MhswID){
			
			$this->db->select("pembimbing.PembimbingID, dosen.NIDN, dosen.Nama, dosen.Telepon, dosen.HP", false);
			
			$this->db->join('pembimbing', 'pembimbing.ID = setpembimbing.PembimbingID', 'inner');
			$this->db->join('mahasiswa', 'mahasiswa.ID = setpembimbing.MhswID', 'inner');
			$this->db->join('dosen', 'pembimbing.PembimbingID = dosen.ID', 'inner');
			$this->db->where('setpembimbing.MhswID', $MhswID);
			
			$query = $this->db->get('setpembimbing');
			
			return $query->result_array();
		}
		
		function get_data_dosen($where)
		{
			$this->db->select('
						dosen.*, 
						agama.ID as IDAgama, 
						agama.Nama as NamaAgama,
						propinsi.Nama as NamaProv,
						kota.Nama as NamaKota,
						golongan.Nama as NamaGolongan,
						jabatan.Nama as NamaJabatan,
						concat(programstudi.ProdiID, " || ", (select Nama from jenjang where ID = programstudi.JenjangID), " || ", programstudi.Nama) as NamaProdi,
						keahlian.Nama as NamaKeahlian,
						jenjang.Nama as NamaJenjang
						', FALSE);
						
			$this->db->join('agama', 'agama.ID = dosen.AgamaID', 'left');
			$this->db->join('propinsi', 'propinsi.ID = dosen.PropinsiID', 'left');
			$this->db->join('kota', 'kota.ID = dosen.KotaID', 'left');
			$this->db->join('golongan', 'golongan.ID = dosen.GolonganID', 'left');
			$this->db->join('jabatan', 'jabatan.ID = dosen.JabatanID', 'left');
			$this->db->join('programstudi', 'programstudi.ID = dosen.ProdiID', 'left');
			$this->db->join('keahlian', 'keahlian.ID = dosen.KeahlianID', 'left');
			$this->db->join('jenjang', 'jenjang.ID = dosen.JenjangID', 'left');
			
			$this->db->where('dosen.ID', $where);
			
			$Query = $this->db->get('dosen');
			return $Query->result_array();
		}
		
		function ubah_profil_mhsw($data, $MhswID)
		{
			$this->db->where('ID', $MhswID);
			$Cek = $this->db->get('mahasiswa')->num_rows();
			
			if($Cek > 0)
			{
				$this->db->where('ID', $MhswID);
				$this->db->update('mahasiswa', $data);
			}
			
			return $this->db->affected_rows();
		}
		
		function change_password($where, $data)
		{
			$this->db->where($where);
			$this->db->update('user', $data);
			
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
		} **/
	}
