<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Dashboard extends MY_Controller {
		function __construct()
		{
			parent::__construct();
		}
		
		public function index()
		{
			if($this->session->userdata('username') != 'bendahara'){
				$data['title'] = 'Dashboard';
			}else{
				$data['title'] = 'SI PAKU BABE';
			}
				$this->db->select('
					sys_menu.*
				');
	
				$this->db->where("sys_menu.dashboard",1);
				$this->db->where('sys_akses_menu.akses','READ');
				$this->db->where('sys_akses_menu.username',$this->session->userdata('username'));
				$this->db->join('sys_akses_menu','sys_akses_menu.id_menu = sys_menu.id','inner');
				$this->db->order_by('sys_menu.urut','asc');
				$this->db->order_by('sys_menu.parent_id','asc');
				$data['menu'] =$data_menu = $this->db->get('sys_menu')->result();;
			
			$this->template->display('dashboard',$data);
		}
		
		function select2_pasien(){
			$search = ($_GET['q'])?strip_tags(trim($_GET['q'])):'';
			
			$w=" AND (rm LIKE '%$search%' OR nama_lengkap LIKE '%$search%')";
			$pasien=$this->db->query("SELECT a.id,a.rm,a.nama_lengkap,b.id_jenis_appointment FROM ms_pasien a,trs_appointment b WHERE a.id=b.id_pasien $w")->result();
			$found=count($pasien);
			if($found > 0)
			{
					foreach($pasien as $r){
						$app=($r->id_jenis_appointment == 1)?'Rawat Jalan':'IGD';
						$p['id']=$r->id;
						$p['text']=$r->rm." - ".$r->nama_lengkap." [$app]";
						$p['nama']=$r->nama_lengkap;
						$data[]=$p;
					}
			} 			
			else 
			{
				$data[] = array(
					'id' => '',
					'text' => 'Pasien tidak ditemukan.',
					'nama' => 'Pasien tidak ditemukan.',
				);
			
			}
			
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result); 
		}
		
		
		function select2_wilayah(){
			$search = ($_GET['q'])?strip_tags(trim($_GET['q'])):'';
			$group = strip_tags(trim($_GET['group']));
			$kode = strip_tags(trim($_GET['kode']));
			//$identitas = strip_tags(trim($_GET['identitas']));;

			$will = get_wilayah($kode,$group,$search);
			 
			$found=count($will);
			if($found > 0)
			{
				foreach ($will as $key => $value) {
					
					if($value->Kode_Negara)
					{
						unset($negara);
						$negara['Kode_Negara'] = $value->Kode_Negara;
						$negara['Negara'] = $value->Negara;
						
						$loop_negara[$negara['Kode_Negara']]=$negara;
					}
	
					if($value->Kode_Propinsi)
					{
						unset($propinsi);
						$propinsi['Kode_Propinsi'] = $value->Kode_Propinsi;
						$propinsi['Propinsi'] = $value->Propinsi;
						
						$loop_prop[$negara['Kode_Negara']][$propinsi['Kode_Propinsi']] = $propinsi;
					}
					
					if($value->Kode_Kota)
					{
						unset($kota);
						$kota['Kode_Kota'] = $value->Kode_Kota;
						$kota['Kota'] = $value->Kota;
						
						$loop_kota[$propinsi['Kode_Propinsi']][$kota['Kode_Kota']] = $kota;
					}
					if($value->Kode_Kecamatan)
					{
						unset($kecamatan);
						$kecamatan['Kode_Kecamatan'] = $value->Kode_Kecamatan;
						$kecamatan['Kecamatan'] = $value->Kecamatan;
						
						$loop_kecamatan[$kota['Kode_Kota']][$kecamatan['Kode_Kecamatan']] = $kecamatan;
					}
					
				}
				
				unset($negara);
				unset($propinsi);
				unset($kota);
				unset($kecamatan);
				
				foreach($loop_negara as $neg){
					$negara['text'] = $neg['Negara'];
					
					foreach($loop_prop[$neg['Kode_Negara']] as $prop){
						$propinsi['id'] =  $prop['Kode_Propinsi'];
						$propinsi['text'] = $prop['Propinsi'];
						
						foreach($loop_kota[$prop['Kode_Propinsi']] as $kot){
							$kota['id'] = $kot['Kode_Kota'];
							$kota['text'] = $kot['Kota'];
							
							foreach($loop_kecamatan[$kot['Kode_Kota']] as $kec){
								$kecamatan['id'] = $kec['Kode_Kecamatan'];
								$kecamatan['text'] = $kec['Kecamatan'];
								
								$data_kecamatan[] = $kecamatan;
							}
							
							if($data_kecamatan){
								$kota['children'] = $data_kecamatan;
								unset($kota['id']);
							}
							
							unset($data_kecamatan);
							$data_kota[] = $kota;
						}
						if($data_kota){
							$propinsi['children'] = $data_kota;
							unset($propinsi['id']);
						}
						unset($data_kota);
						$data_propinsi[] = $propinsi;
					}
					$negara['children'] = $data_propinsi;
					unset($data_propinsi);
					 
					$data[] = $negara;
				}
			 	
			} 
			
			else 
			{
				$data[] = array(
					'id' => '',
					'text' => 'Wilayah tidak ditemukan.',
					'nama' => 'Wilayah tidak ditemukan.',
				);
			
			}
			
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result); 
		}
		
		function select2_wilayah_kota(){
			$search = ($_GET['q'])?strip_tags(trim($_GET['q'])):'';
			$group = strip_tags(trim($_GET['group']));
			$kode = strip_tags(trim($_GET['kode']));
			//$identitas = strip_tags(trim($_GET['identitas']));;

			$will = get_wilayah($kode,$group,$search);
			 
			$found=count($will);
			if($found > 0)
			{
				foreach ($will as $key => $value) {
					
					if($value->Kode_Negara)
					{
						unset($negara);
						$negara['Kode_Negara'] = $value->Kode_Negara;
						$negara['Negara'] = $value->Negara;
						
						$loop_negara[$negara['Kode_Negara']]=$negara;
					}
	
					if($value->Kode_Propinsi)
					{
						unset($propinsi);
						$propinsi['Kode_Propinsi'] = $value->Kode_Propinsi;
						$propinsi['Propinsi'] = $value->Propinsi;
						
						$loop_prop[$negara['Kode_Negara']][$propinsi['Kode_Propinsi']] = $propinsi;
					}
					
					if($value->Kode_Kota)
					{
						unset($kota);
						$kota['Kode_Kota'] = $value->Kode_Kota;
						$kota['Kota'] = $value->Kota;
						
						$loop_kota[$propinsi['Kode_Propinsi']][$kota['Kode_Kota']] = $kota;
					}
					
				}
				
				unset($negara);
				unset($propinsi);
				unset($kota);
				
				foreach($loop_negara as $neg){
					$negara['text'] = $neg['Negara'];
					
					foreach($loop_prop[$neg['Kode_Negara']] as $prop){
						$propinsi['id'] =  $prop['Kode_Propinsi'];
						$propinsi['text'] = $prop['Propinsi'];
						
						foreach($loop_kota[$prop['Kode_Propinsi']] as $kot){
							$kota['id'] = $kot['Kode_Kota'];
							$kota['text'] = $kot['Kota'];
							
							$data_kota[] = $kota;
						}
						if($data_kota){
							$propinsi['children'] = $data_kota;
							unset($propinsi['id']);
						}
						unset($data_kota);
						$data_propinsi[] = $propinsi;
					}
					$negara['children'] = $data_propinsi;
					unset($data_propinsi);
					 
					$data[] = $negara;
				}
			 	
			} 
			
			else 
			{
				$data[] = array(
					'id' => '',
					'text' => 'Wilayah tidak ditemukan.',
					'nama' => 'Wilayah tidak ditemukan.',
				);
			
			}
			
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result); 
		}
		
	}
