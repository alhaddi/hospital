<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Login extends MY_Controller {
		private $folder;
		
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('login/login_model');
			$this->load->model('pasien/Pasien_model');
			$this->folder="login/";
		}
		
		public function index()
		{
			#URL#
			$data['identitas'] = $this->db->get('ms_identitas')->row();
			$data['login_url'] = site_url('login/login_process');
			$this->load->view($this->folder.'login',$data);
		}
		
		
		public function login_process()
		{
			$post = $this->input->post(NULL,TRUE);
			
			if(empty($post['username']))
			{	
				$response = array(
					'status' => false,
					'message' => 'Harap isi Username anda.'
				);
				die(json_encode($response));
			}
			
			if(empty($post['password']))
			{	
				$response = array(
					'status' => false,
					'message' => 'Harap isi Password anda.'
				);
				die(json_encode($response));
			}
			
			$param = array(
				'username' => $post['username'],
				'password' => md5($post['password'])
			);
			
			$result = $this->login_model->get_login($param);
			
			if(count($result) == 0)
			{
				$response = array(
					'status' => false,
					'message' => 'Username / Password tidak terdaftar !'
				);
				die(json_encode($response));
			}
			else
			{
				$param_user = array(
					'id' => $result['id_user']
				);
				
				$user = $this->login_model->get_user($param_user);
				$sess['username'] = $result['username'];
				$sess['id_pegawai'] = $user['id_pegawai'];
				$sess['id_user'] = $result['id_user'];
				$sess['kode_user'] = $user['kode_user'];
				$sess['nama'] = $user['nama'];
				$sess['foto'] = $user['foto'];
				$sess['id_pol'] = $user['id_poliklinik'];
				$sess['id_pen'] = $user['id_penunjang'];
				
				$this->session->set_userdata($sess);
				$redirect = (!empty($post['redirect']) && $post['redirect'] != 'undefined')?$post['redirect']:base_url();
				$response = array(
					'status' => true,
					'message' => 'Selamat datang !',
					'redirect' => $redirect
				);
				die(json_encode($response));
			}
		}
		
		public function logout()
		{
			$this->session->sess_destroy();
			$this->session->unset_userdata($_SESSION);
			redirect();
		}
		
		function login_api($user,$pass){
			
			$post = $this->input->post(NULL,TRUE);
			
			if(empty($user))
			{	
				$response = array(
					'status' => false,
					'message' => 'Harap isi Username anda.'
				);
				die(json_encode($response));
			}
			
			if(empty($pass))
			{	
				$response = array(
					'status' => false,
					'message' => 'Harap isi Password anda.'
				);
				die(json_encode($response));
			}
			
			$param = array(
				'username' => $user,
				'id_jenis_user' => 3,
				'password' => md5($pass)
			);
			
			$result = $this->login_model->get_login_api($param);
			
			if(count($result) == 0)
			{
				$response = array(
					'status' => false,
					'message' => 'Username / Password tidak terdaftar !'
				);
				die(json_encode($response));
			}
			else
			{
				$param_user = array(
					'id' => $result['id_user']
				);
				
				$user = $this->login_model->get_user($param_user);
				$pasien=$this->db->query("SELECT id FROM ms_pasien WHERE rm='".$result['username']."'")->row();
				$sess['username_api'] = $result['username'];
				$sess['id_user_api'] = $result['id_user'];
				$sess['kode_user_api'] = $user['kode_user'];
				$sess['nama_api'] = $user['nama'];
				$sess['foto_api'] = $user['foto'];
				$sess['id_pasien'] = $pasien->id;
				
				$this->session->set_userdata($sess);
				$response = array(
					'status' => true,
					'message' => 'Selamat datang '.$user['nama'].' !'
				);
				die(json_encode($response));
			}
		}
		
		function all_pasien($no_rm="")
		{
		if($this->session->userdata('username_api')){
			if(!empty($no_rm)){
			$this->db->where("rm",$no_rm);	
			}
		$list = $this->db->get('ms_pasien')->result();
		$data = array();
		$no=0;
		foreach ($list as $row) {
			$no++;
			$fields = array();
			
			$temp = array(
			 "id_pasien" => $row->id,
			 "no" => $no,
			 "no_rm" => $row->rm,
			 "nama_lengkap" => $row->nama_lengkap,
			 "tipe_identitas" => $row->tipe_identitas,
			 "no_identitas" => $row->no_identitas,
			 "jenis_kelamin" => $row->jk,
			 "usia" => $row->usia,
			 "hp" => $row->hp,
			 "alamat" => $row->alamat,
			 "add_time" => $row->add_time
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		}
		else{
				$response = array(
					'status' => false,
					'message' => 'Anda belum login'
				);
				die(json_encode($response));
			}
		}
		
		function pasien()
		{
		if($this->session->userdata('username_api')){
		$no_rm=$this->session->userdata('username_api');
		$this->db->where("rm",$no_rm);	
		$list = $this->db->get('ms_pasien')->result();
		$data = array();
		$no=0;
		foreach ($list as $row) {
			$no++;
			$fields = array();
			
			$temp = array(
			 "id_pasien" => $row->id,
			 "no" => $no,
			 "no_rm" => $row->rm,
			 "nama_lengkap" => $row->nama_lengkap,
			 "tipe_identitas" => $row->tipe_identitas,
			 "no_identitas" => $row->no_identitas,
			 "jenis_kelamin" => $row->jk,
			 "usia" => $row->usia,
			 "hp" => $row->hp,
			 "alamat" => $row->alamat,
			 "add_time" => $row->add_time
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		}
		else{
				$response = array(
					'status' => false,
					'message' => 'Anda belum login'
				);
				die(json_encode($response));
			}
		}
		
		
		function konsultasi()
		{
			if($this->session->userdata('username_api')){
		$id_pasien=$this->session->userdata("id_pasien");
		
		$this->db->from("trs_konsultasi");
		$this->db->where("ms_pasien.id",$id_pasien);
		$list = $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id_anamesa,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.tipe_identitas,
			ms_pasien.no_identitas,
			ms_cara_bayar.nama as cara_bayar,
			ms_jenis_appointment.nama as jenis_appointment,
			ms_poliklinik.nama as poliklinik,
			ms_poliklinik.id as id_poliklinik,
			trs_konsultasi.status,
			trs_konsultasi.add_time
		')
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->get()->result();
		$data = array();
		$no=0;
		foreach ($list as $r) {
			$no++;
			$fields = array();
			
			$temp = array(
				"id_konsultasi"=>$r->id,
				"id_anamesa"=>$r->id_anamesa,
				"no_rm"=>$r->rm,
				"nama_lengkap"=>$r->nama_lengkap,
				"tipe_identitas"=>$r->tipe_identitas,
				"no_identitas"=>$r->no_identitas,
				"cara_bayar"=>$r->cara_bayar,
				"jenis_appointment"=>$r->jenis_appointment,
				"nama_poliklinik"=>$r->poliklinik,
				"id_poliklinik"=>$r->id_poliklinik,
				"status"=>$r->status,
				"add_time"=>$r->add_time
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		
			}
			else
			{
					$response = array(
						'status' => false,
						'message' => 'Anda belum login'
					);
					die(json_encode($response));
			}
		}
		
		
		function anamesa($id_anamesa)
		{
			if($this->session->userdata('username_api')){
		$id_pasien=$this->session->userdata("id_pasien");
		
		$list = $this->db->select('
			ms_komponen_anamesa.nama,
			ms_komponen_anamesa.satuan,
			ms_komponen_anamesa.icon,
			trs_anamesa_detail.hasil,
			trs_anamesa_detail.id_anamesa,
			trs_anamesa_detail.id_ms_anamesa
			')
			->where('id_anamesa',$id_anamesa)
			->join('ms_komponen_anamesa','ms_komponen_anamesa.id = trs_anamesa_detail.id_ms_anamesa','inner')
			->get('trs_anamesa_detail')->result();

		
		$data = array();
		$no=0;
		foreach ($list as $r) {
			$no++;
			$fields = array();
			
			$temp = array(
				"nama"=>$r->nama,
				"satuan"=>$r->satuan,
				"hasil"=>$r->hasil
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		
			}
			else
			{
					$response = array(
						'status' => false,
						'message' => 'Anda belum login'
					);
					die(json_encode($response));
			}
		}
		
		
		function diagnosa($id)
		{
			if($this->session->userdata('username_api')){
		$id_pasien=$this->session->userdata("id_pasien");
		
		$list = $this->db->select('
			trs_diagnosa.id,
			trs_diagnosa.id as rowid,
			trs_diagnosa.code,
			trs_diagnosa.type,
			tb_data_icd.deskripsi,
			trs_diagnosa.catatan
			')
			->where('trs_diagnosa.id_konsultasi',$id)
			->join('tb_data_icd','tb_data_icd.code = trs_diagnosa.code','inner')
			->get('trs_diagnosa')->result();

		
		$data = array();
		$no=0;
		foreach ($list as $r) {
			$no++;
			$fields = array();
			
			$temp = array(
				"id_diagnosa"=>$r->id,
				"kode_diagnosa"=>$r->code,
				"deskripsi"=>$r->deskripsi,
				"catatan"=>$r->catatan,
				"type_diagnosa"=>$r->type
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		
			}
			else
			{
					$response = array(
						'status' => false,
						'message' => 'Anda belum login'
					);
					die(json_encode($response));
			}
		}
		
		function tindakan($id)
		{
			if($this->session->userdata('username_api')){
		$id_pasien=$this->session->userdata("id_pasien");
		
		$list = $this->db->select('
			trs_tindakan.id,
			trs_tindakan.id as rowid,
			trs_tindakan.jumlah_tindakan as jumlah,
			trs_tindakan.biaya,
			trs_tindakan.keterangan,
			ms_tindakan.id as id_ms_tindakan,
			ms_tindakan.nama
			')
			->where('trs_tindakan.id_konsultasi',$id)
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan','inner')
			->get('trs_tindakan')->result();

		
		$data = array();
		$no=0;
		foreach ($list as $r) {
			$no++;
			$fields = array();
			
			$temp = array(
				"id_tindakan"=>$r->id,
				"jumlah_tindakan"=>$r->jumlah,
				"biaya"=>$r->biaya,
				"keterangan"=>$r->keterangan,
				"nama_tindakan"=>$r->nama
			);
			array_push($data, $temp);
		}

		$val = json_encode($data);
		echo "{\"list_data\":" . $val . "}";
		
			}
			else
			{
					$response = array(
						'status' => false,
						'message' => 'Anda belum login'
					);
					die(json_encode($response));
			}
		}
	}
