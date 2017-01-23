<?php
	/* Author : Cecep Rokani */
	
	class M_Bimbingan extends CI_Model
	{
		#variable private (poperpti)
		private $table= 'bimbingan';
		private $pk = 'ID';
		
		function __construct()
		{
			parent:: __construct();
		}
		
		function get_data($DosenID, $TahunID, $limit = null, $offset = null){
			$this->db->select('
								mahasiswa.Nama as NamaMahasiswa,
								mahasiswa.ProdiID,
								IFNULL(hasilstudi.IPS, "0.00") as IPS,
								ifnull(hasilstudi.IPK, "0.00") as IPK,
								if((select count(ID) from rencanastudi where MhswID = setpembimbing.MhswID and TahunID = "'.$TahunID.'" and approval = 2) > 0, "Y", "X") as Approval,
								setpembimbing.*', FALSE);
				
			$this->db->join('mahasiswa', 'setpembimbing.MhswID = mahasiswa.ID', 'inner');
			$this->db->join('hasilstudi', 'hasilstudi.MhswID = setpembimbing.MhswID', 'left');
			
			if($DosenID)
				$this->db->where('setpembimbing.DosenID', $DosenID);
			
			$this->db->where('mahasiswa.StatusMhswID NOT IN ("1", "2", "4", "6", "7")');
				
			$this->db->group_by('setpembimbing.MhswID');
			$this->db->order_by('mahasiswa.Nama', 'ASC');
			
			$query = $this->db->get('setpembimbing', $limit, $offset);
			return $query->result_array();
		}
		
		function bimbinganKRS($TahunID, $KurikulumID, $KelasID, $ProdiID, $ProgramID, $limit = null, $offset = null)
		{
			$this->db->select('					
						detailkurikulum.ID as IDMatkul,
						detailkurikulum.MKKode,
						jadwal.DosenID as DosenID,
						dosen.Nama as NamaDosen,
						detailkurikulum.MKIDpra,
						detailkurikulum.TotalSKS,
						hari.Nama as Hari,
						kelas.Nama as Kelas,
						ruang.Nama as Ruang,
						concat(kodewaktu.JamMulai, " - ", kodewaktu.JamSelesai) as Waktu,
						ruang.KapKul,
						if(ifnull(ruang.KapKul, 0) - (select count(ID) from rencanastudi where TahunID = 8 and JadwalID = jadwal.ID) < 0, 0, ifnull(ruang.KapKul, 0) - (select count(ID) from rencanastudi where TahunID = 8 and JadwalID = jadwal.ID)) as SisaKapasitas,
						rencanastudi.approval,
						jadwal.*', FALSE);
				
			$this->db->join('detailkurikulum', 'jadwal.DetailKurikulumID = detailkurikulum.ID', 'inner');		
			$this->db->join('rencanastudi', 'rencanastudi.DetailKurikulumID = detailkurikulum.ID and jadwal.ID = rencanastudi.JadwalID', 'left');		
			$this->db->join('kelas', 'jadwal.KelasID = kelas.ID', 'left');		
			$this->db->join('jadwalwaktu', 'jadwal.ID = jadwalwaktu.JadwalID', 'left');		
			$this->db->join('dosen', 'dosen.ID = jadwal.DosenID', 'left');		
			$this->db->join('ruang', 'ruang.ID = jadwalwaktu.RuangID', 'left');		
			$this->db->join('hari', 'jadwalwaktu.HariID = hari.ID', 'left');		
			$this->db->join('kodewaktu', 'jadwalwaktu.WaktuID = kodewaktu.ID', 'left');	

			if($TahunID)
				$this->db->where('jadwal.TahunID', $TahunID);
			if($KurikulumID)
				$this->db->where('detailkurikulum.KurikulumID', $KurikulumID);
			if($KelasID)
				$this->db->where('jadwal.KelasID', $KelasID);
			if($ProgramID)
				$this->db->where('jadwal.ProgramID', $ProgramID);
			if($ProdiID)
				{
					$this->db->where('jadwal.ProdiID', $ProdiID);
					$this->db->where('detailkurikulum.ProdiID', $ProdiID);
				}				
				
			//$this->db->where('detailkurikulum.Semester', $Semester);
			
			$this->db->group_by('jadwal.ID');
			$this->db->order_by('detailkurikulum.Nama', 'ASC');
		
			$query = $this->db->get('jadwal', $limit, $offset);
			return $query->result_array();
		}
		
		function approval($Jenis, $Approval, $ID)
		{
			$TahunID	= $this->db->query('select ID from tahun where ProsesBuka = 1')->row();
			if($Jenis && $Jenis == 1)
			{
				$this->db->where('ID', $ID);
				$this->db->update('rencanastudi', array('approval' => $Approval));
				
				return $this->db->affected_rows();
			}
			else if($Jenis && $Jenis == 2)
			{
				$this->db->where('TahunID', $TahunID->ID);
				$this->db->where("MhswID", $ID);
				$this->db->update('rencanastudi', array('approval' => $Approval));	
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