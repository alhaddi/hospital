<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	// This can be removed if you use __autoload() in config.php OR use Modular Extensions
	require APPPATH . '/libraries/REST_Controller.php';
	
	/**
		* Ini adalah contoh dari beberapa metode interaksi dasar aplikasi Student EDU
		* disarankan menggunakan stored procedure / model dalam pembuatan query yang nantinya 
		* akan di olah menjadi array sesuai kebutuhan
		*
		* @package         CodeIgniter
		* @subpackage      Rest Server
		* @category        Controller
		* @author          Amir Mufid, Cecep Rokani
		* @license         PT. Edu Sinergi Informatika, MIT Licence
		* @documentation   https://github.com/chriskacerguis/codeigniter-restserver
	*/
	class Api extends REST_Controller {
		
		function __construct()
		{
			parent::__construct();
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET, POST, DELETE"); //GET, POST, OPTIONS, PUT, DELETE
			
			$this->methods['user_get']['limit'] = 10000; // requests per hour per user/key
			$this->methods['user_post']['limit'] = 10000; // requests per hour per user/key
			$this->methods['user_delete']['limit'] = 10000; // requests per hour per user/key
			$this->load->model('M_Tahun', 'm_tahun');
		}
		
		//---------------- get KHS ---------------------------------------------------------------
		public function khs_get()
		{
			$this->load->model('M_Khs', 'm_khs');
			
			$mhswid 		= $this->get('mhswid');
			$tahunid 		= $this->get('tahunid');
			$limit 			= $this->get('limit');
			$offset 		= $this->get('offset');
			
			if ( empty($mhswid) || empty($tahunid) )
			{
				$response = array(
					'status' => FALSE,
					'message' => 'MhswID dan Kode Tahun tidak boleh kosong !'
				);
				$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			
	//		$data['ips'] = view_ips($IDMhsw,$TahunID);
//			$data['count']=count($data['query']);

			//$KHS 			= $this->m_khs->get_data($npm, $tahunid, $limit, $offset);
			$KHS			= view_khs($mhswid, $tahunid);	
			$total_row		= count($KHS);
			$IPK			= view_ipk($mhswid, $tahunid);
			$total_sks		= 0;
			$tot_jum		= 0;
			
			if($total_row > 1)
			{
				foreach($KHS as $row)
				{
					$data['ID']					= $row->MKKode;
					$data['TahunID']			= $row->TahunID;
					$data['BobotMasterID']		= $row->BobotMasterID;
					$data['DetailKurikulumID']	= $row->DetailKurikulumID;
					$data['MKKode']				= $row->MKKode;
					$data['NamaMatakuliah']		= $row->NamaMatakuliah;
					$data['TotalSKS']			= $row->TotalSKS;
					$data['JadwalID']			= $row->JadwalID;
					$data['JadwalUDTemp']		= $row->JadwalIDtmp;
					$data['KurikulumID']		= $row->KurikulumID;
					$data['MhswID']				= $row->MhswID;
					$data['Bobot']				= $row->Bobot;
					$data['NilaiBobot']			= $row->NilaiBobot;
					$data['NilaiAkhir']			= $row->NilaiAkhir;
					$data['NilaiHuruf']			= $row->NilaiHuruf;
										
					$total_sks					+= (int) $row->TotalSKS;
					$tot_jum					+= (float) $row->NilaiBobot;
					
					$result[] 					= array_null_to_string($data);
				}
				
				$data2['JumSKS']				= $total_sks;
				$data2['JumBobot']				= number_format($tot_jum, 2, '.', ',');
				$data2['IPS']					= number_format($tot_jum/$total_sks, 2, '.', ',');
				$data2['IPK']					= $IPK->IPK;
				$result2[] 						= array_null_to_string($data2);
				
				$response['responseData']['results'] = $result2;
				$response['responseData']['results'][1] = $result;
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data tidak di temukan !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
	
		//---------------- get DKN ---------------------------------------------------------------
		public function dkn_get()
		{
			$this->load->model('M_Dkn', 'm_dkn');
			
			$mhswid			= $this->get('mhswid');
			$limit 			= $this->get('limit');
			$offset 		= $this->get('offset');
			
			if ( empty($mhswid) )
			{
				$response = array(
					'status' => FALSE,
					'message' => 'MhswID tidak boleh kosong !'
				);
				$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			
			// $DKN 			= $this->m_dkn->get_data($npm, '2', $limit, $offset);
			$DKN 			= view_transkrip_sementara($mhswid);
			$total_row 		= count($DKN);
			$total_sks		= 0;
			$tot_jum		= 0;
			
			if($total_row < 1)
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data DKN tidak ditemukan'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($DKN as $row)
				{
					$data['ID']					= $row->MKKode;
					$data['TahunID']			= $row->TahunID;
					$data['BobotMasterID']		= $row->BobotMasterID;
					$data['DetailKurikulumID']	= $row->DetailKurikulumID;
					$data['MKKode']				= $row->MKKode;
					$data['NamaMatakuliah']		= $row->NamaMatakuliah;
					$data['TotalSKS']			= $row->TotalSKS;
					$data['JadwalID']			= $row->JadwalID;
					$data['JadwalUDTemp']		= $row->JadwalIDtmp;
					$data['KurikulumID']		= $row->KurikulumID;
					$data['MhswID']				= $row->MhswID;
					$data['Bobot']				= $row->Bobot;
					$data['NilaiBobot']			= $row->NilaiBobot;
					$data['NilaiAkhir']			= $row->NilaiAkhir;
					$data['NilaiHuruf']			= $row->NilaiHuruf;
										
					$total_sks					+= (int) $row->TotalSKS;
					$tot_jum					+= (float) $row->NilaiBobot;
					
					$result[] 					= array_null_to_string($data);
				}
				
				$data2['JumSKS']				= $total_sks;
				$data2['JumBobot']				= number_format($tot_jum, 2, '.', ',');
				$data2['IPK']					= number_format($tot_jum / $total_sks,2,'.',',');
				$result2[] 						= array_null_to_string($data2);
				
				$response['responseData']['results'] = $result2;
				$response['responseData']['results'][1] = $result;
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		}
	
		//---------------- get KRS ---------------------------------------------------------------
		public function krs_get()
		{
			$this->load->model('M_Krs', 'm_krs');
			
			$mhswid			= $this->get('mhswid');
			$tahunid 		= $this->get('tahunid');
			$limit 			= $this->get('limit');
			$offset 		= $this->get('offset');
			$SKS 			= 0;
			
			if (empty($mhswid))
			{
				$response = array(
					'status' => FALSE,
					'message' => 'MhswID tidak boleh kosong !'
				);
				$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			
			$KRS				 			= $this->m_krs->get_data($mhswid, $tahunid, $limit, $offset);
			$total_row 						= $this->db->affected_rows();
			
			if($total_row < 1)
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data tidak di temukan !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($KRS as $row)
				{
					$data2['MKKode']			= $row['MKKode'];
					$data2['Nama']				= $row['Nama'];
					$data2['TotalSKS']			= $row['TotalSKS'];
					$data2['NilaiHuruf']		= $row['NilaiHuruf'];
					$data2['NilaiAkhir']		= $row['NilaiAkhir'];
					$data2['Bobot']				= $row['Bobot'];
					$data2['Jumlah']			= $row['Jumlah'];
					$data2['NamaDosen']			= $row['NamaDosen'];
					$data2['NamaKelas']			= $row['NamaKelas'];
					$SKS						+= $row['TotalSKS'];
					$Total['JumSKS']				= $SKS;
					$data2['Approval']			= $row['Approval'];
					$data2['JumlahPendaftar']	= $row['JumlahPendaftar'];
					
					$result[] 					= array_null_to_string($data2);
				}
				
				$result2[]				= $Total;
				
				$response['responseData']['results'] 	= $result2;
				$response['responseData']['results'][1] = $result;
		
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		}
		
		//---------------- get Tahun ---------------------------------------------------------------
		public function filtertahun_get()
		{			
			$mhswid 			= $this->get('mhswid');
			
			if (empty($mhswid))
			{
				$response = array(
					'status' => FALSE,
					'message' => 'MhswID tidak boleh kosong !'
				);
				$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			
			$Tahun					 			= $this->m_tahun->get_data($mhswid);
			$total_row 							= $this->db->affected_rows();
			
			if($total_row < 1)
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data tidak di temukan !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($Tahun as $row)
				{
					$result[] = array_null_to_string($row);
				}
				
				$response['responseData']['results'] = $result;
		
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		}
		
		//---------------- get Data Filter ---------------------------------------------------------------
		public function filter_get()
		{			
			$table		= $this->get('Table');
			$where		= $this->get('where');
			$field		= $this->get('field');
			
			if($where)
				$this->db->where($field, $where);
			
			$tabel								= $this->db->get($table)->result_array();
			$total_row 							= $this->db->affected_rows();
			
			if($total_row < 1)
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data tidak di temukan !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($tabel as $row)
				{
					$result[]						= array_null_to_string($row);
				}
				
				$response['responseData']['results'] = $result;
		
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		}
		
		//---------------- get Data Mahasiswa ---------------------------------------------------------------
		public function datamhsw_get()
		{			
			$this->load->model('M_Users', 'model');
			$MhswID								= $this->get('MhswID');
			
			$Data								= $this->model->get_data_mhs($MhswID);
			$total_row 							= $this->db->affected_rows();
		
			$tahun								= $this->db->query("SELECT ID, Nama FROM tahun WHERE ProsesBuka = '1'")->row();
			$Ipk								= view_ipk($MhswID, $tahun->ID);
			$Semester		 					= get_semester($MhswID, $tahun->ID);
			
			if($total_row < 1)
			{
				$data 	= array(
					'status' => FALSE,
					'message' => 'Data tidak di temukan !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($Data as $row)
				{
					$Foto						= $row['Foto'];
					$Kelamin					= $row['Kelamin'];
					$data[]						= array_null_to_string($row);
				}					
				if(count($Ipk) > 0)
				{				
					$data2['jumlahSKS'] 		= ($Ipk->JmlSKS) ? $Ipk->JmlSKS : '-';
					$data2['jmlBobot']			= ($Ipk->JmlBobot) ? $Ipk->JmlBobot : '-';
					$data2['IPK']				= ($Ipk->IPK) ? $Ipk->IPK : '-';
					$data2['Semester']			= ($Semester->Semester) ? $Semester->Semester : '-';
					$data2['TahunAkademik']		= ($tahun->Nama) ? $tahun->Nama : '-';
					$data2['UrlFoto'] 			= (get_photo($Foto, $Kelamin, 'mahasiswa')) ? get_photo($Foto, $Kelamin, 'mahasiswa') : '-';
				}
				
				//$data['NilaiHuruf']		= ($Ipk->NilaiHuruf) ? $IPK->NilaiHuruf : '';
				
				$response['responseData']['results'] = $data;
				$response['responseData']['results'][1] = $data2;
		
				$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		}
		
		function login_post()
		{
			$this->load->model('M_Users', 'm_user');
			$this->load->model('M_Ortu', 'm_ortu');
			
			$param = array(
				'user.Nama' => $this->post('username'),
				'user.Password' => md5($this->post('password')),
				'user.TabelUserID' => '4'
			);
			
			$User 			= $this->m_user->get_data2($param);
			$total_row 		= $this->db->affected_rows();
			
			if($total_row != 1 )
			{
				$data = array(
					'status' => 0,
					'message' => 'Maaf Username atau Password Salah ! :)'
				);
				
				$response['responseData']['results'][0] = $data;
				
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				foreach($User as $row)
					$MhswID				= $row['EntityID'];
				
				$Mahasiswa				= $this->m_user->get_data_mhs($MhswID);
				$total_row2		 		= $this->db->affected_rows();
				
				$Tahun 					= $this->m_user->get_data_tahun();
				$total_row3 			= $this->db->affected_rows();
				
				$Pembimbing				= $this->m_user->get_data_pembimbing($MhswID);
				$total_row4		 		= $this->db->affected_rows();
				
				$Ortu					= $this->m_ortu->get_id_ortu($MhswID);
				
				$data['status']			= 1;
				
				
				if($total_row2 > 0)
				{
					foreach($Mahasiswa as $rew)
					{
						$result[] 			= array_null_to_string($rew);
						$Foto				= $rew['Foto'];
						$Kelamin			= $rew['Kelamin'];
					}
				}
				
				if($total_row3 > 0)
				{
					foreach($Tahun as $raw)
					{
						$result2[] 	= array_null_to_string($raw);
					}
				}
				
				if($total_row4 > 0)
				{					
					foreach($Pembimbing as $riw)
					{
						$dataPembimbing['NIK'] 		= ($riw['NIDN']) ? $riw['NIDN'] : '-';
						$dataPembimbing['Nama'] 	= ($riw['Nama']) ? $riw['Nama'] : '-';
						$dataPembimbing['Telepon'] 	= ($riw['Telepon']) ? $riw['Telepon'] : '-';
						
						$result3[] 					= $dataPembimbing;
					}
				}
				else
				{
						$dataPembimbing['NIK'] 		= '-';
						$dataPembimbing['Nama'] 	= '-';
						$dataPembimbing['Telepon'] 	= '-';
						
						$result3[] 					= $dataPembimbing;
				}
				
				$dataOrtu['IDIbu']					= ($Ortu->Ibu) ? $Ortu->Ibu : '-';
				$dataOrtu['IDAyah']					= ($Ortu->Ayah) ? $Ortu->Ayah : '-';
				$result4[]							= $dataOrtu;				
				
				$kondisi['data'] 					= 'Kosong';
				$data['UrlFoto'] 					= (get_photo($Foto, $Kelamin, 'mahasiswa')) ? get_photo($Foto, $Kelamin, 'mahasiswa') : '-';
				
				$response['responseData']['results'][0] = ($total_row > 0) ? $data : '';
				$response['responseData']['results'][1] = ($total_row2 > 0) ? $result : $result[] = $kondisi;
				$response['responseData']['results'][2] = ($total_row3 > 0) ? $result2 : $result2[] = $kondisi;
				$response['responseData']['results'][3] = $result3;
				$response['responseData']['results'][4] = $result4;
		
				$this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
			}
		}
		
		function changepassword_post()
		{
			$this->load->model('M_Users', 'm_user');
			
			$Jenis		= $this->post('jenis');
			
			if($Jenis == 1)
			{				
				$where = array(
					'Nama' => $this->post('username'),
					'Password' => md5($this->post('password')),
					'TabelUserID' => '4'
				);
				
				$data = array(
					'Password' => md5($this->post('passwordbaru'))
				);
			}
			else
			{							
				$where = array(
					'Nama' => $this->post('username'),
					'PassOrtu' => md5($this->post('password')),
					'TabelUserID' => '4'
				);
										
				$data = array(
					'PassOrtu' => md5($this->post('passwordbaru'))
				);
				
			}
			
			$total_row 			= $this->m_user->change_password($where, $data);
			
			if($total_row != 1 )
			{
				$notif = array(
					'status' => 0,
					'message' => 'Maaf data gagal diubah !'
				);
				
				$response['responseData']['results'][0] = $notif;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
			else
			{
				$notif = array(
					'status' => 1,
					'message' => 'Data berhasil di ubah !'
				);
				
				$response['responseData']['results'][0] = $notif;
				$this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
			}
		}
	}
