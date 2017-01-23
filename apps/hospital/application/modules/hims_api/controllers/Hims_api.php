<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Hims_api extends MY_Controller {
		private $folder;
		
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('hims_api/login_model');
			
			$this->folder="hims_api/";
		}
		
		public function index()
		{
			echo "asd";
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
				$sess['id_user'] = $result['id_user'];
				$sess['kode_user'] = $user['kode_user'];
				$sess['nama'] = $user['nama'];
				$sess['foto'] = $user['foto'];
				
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
	}
