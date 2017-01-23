<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Agama Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Hrm extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pegawai_model');
		$config['table'] = 'ms_pegawai';
		$config['column_order'] = array(null,'id','nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama',null);
		$config['column_search'] = array('id','nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama');
		$config['column_excel'] = array('nama');
		$config['column_pdf'] = array('nama');
		$config['order'] = array('id' => 'asc');
		$this->Pegawai_model->initialize($config);
    }

    public function show($jenis)
    {
		$data['title'] = ucfirst($jenis);
		$data['id_table'] = $jenis;
		$data['datatable_list'] = 'pegawai/ajax_list/'.$jenis;
		$data['datatable_edit'] = 'pegawai/ajax_edit/';
		$data['datatable_delete'] = 'pegawai/ajax_delete/';
		$data['datatable_save'] = 'pegawai/ajax_save/'.$jenis;
		//$data['load_form'] = $this->load_form($data);
		$this->template->display('pegawai',$data);
    }

    public function load_form($data)
	{
		$this->db->select('id,nama');
		$data['poli']=$this->db->get('ms_poliklinik')->result();
		return $this->load->view('form_agama',$data,true);
	}

	public function view($id="") {
		if($id == ""){
		$id=$this->session->userdata("id_pegawai");
		}
		$data['id_table']="hrm";
		$data['row'] = array(); 
		$data['jabatan'] = array(); 
		if(!empty($id)){
		$this->db->from("ms_pegawai");
		$this->db->where("id",$id);
		$query = $this->db->get();

	
		$data['row'] = $query->row_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_jabatan'] = $this->db->order_by('id','asc')->get('pegawai_jabatan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_kepangkatan'] = $this->db->order_by('id','asc')->get('pegawai_kepangkatan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_pendidikan'] = $this->db->order_by('id','asc')->get('pegawai_pendidikan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_keluarga'] = $this->db->order_by('id','asc')->get('pegawai_keluarga')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_diklat_pelatihan'] = $this->db->order_by('id','asc')->get('pegawai_diklat_pelatihan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_cuti'] = $this->db->order_by('id','asc')->get('pegawai_cuti')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_organisasi'] = $this->db->order_by('id','asc')->get('pegawai_keanggotaan_organisasi')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_mutasi'] = $this->db->order_by('id','asc')->get('pegawai_mutasi')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_penghargaan'] = $this->db->order_by('id','asc')->get('pegawai_penghargaan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_gaji'] = $this->db->order_by('id','asc')->get('pegawai_gaji')->result_array();
		
		$data['id_ms_jenis_user'] = $this->db->order_by('id','asc')->get('sys_jenis_user')->result_array();
		$data['kode_golongan'] = $this->db->order_by('kd','asc')->get('ms_golongan')->result_array();
		$data['id_ms_unit_kerja'] = $this->db->order_by('id','asc')->get('ms_unit_kerja')->result_array();
		$data['id_ms_jabatan'] = $this->db->order_by('id','asc')->get('ms_jabatan')->result_array();
		$data['ms_dokumen_pegawai'] = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();	
		}
		
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$this->template->display('form_view',$data);
	}
	public function profile($id="") {
		if($id == ""){
		$id=$this->session->userdata("id_pegawai");
		}
		$data['id_table']="hrm";
		$data['row'] = array(); 
		$data['jabatan'] = array(); 
		if(!empty($id)){
		$this->db->from("ms_pegawai");
		$this->db->where("id",$id);
		$query = $this->db->get();

	
		$data['row'] = $query->row_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_jabatan'] = $this->db->order_by('id','asc')->get('pegawai_jabatan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_kepangkatan'] = $this->db->order_by('id','asc')->get('pegawai_kepangkatan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_pendidikan'] = $this->db->order_by('id','asc')->get('pegawai_pendidikan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_keluarga'] = $this->db->order_by('id','asc')->get('pegawai_keluarga')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_diklat_pelatihan'] = $this->db->order_by('id','asc')->get('pegawai_diklat_pelatihan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_cuti'] = $this->db->order_by('id','asc')->get('pegawai_cuti')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_organisasi'] = $this->db->order_by('id','asc')->get('pegawai_keanggotaan_organisasi')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_mutasi'] = $this->db->order_by('id','asc')->get('pegawai_mutasi')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_penghargaan'] = $this->db->order_by('id','asc')->get('pegawai_penghargaan')->result_array();
		$this->db->where("id_ms_pegawai",$id);
		$data['pegawai_gaji'] = $this->db->order_by('id','asc')->get('pegawai_gaji')->result_array();
		
		$data['id_ms_jenis_user'] = $this->db->order_by('id','asc')->get('sys_jenis_user')->result_array();
		$data['kode_golongan'] = $this->db->order_by('kd','asc')->get('ms_golongan')->result_array();
		$data['id_ms_unit_kerja'] = $this->db->order_by('id','asc')->get('ms_unit_kerja')->result_array();
		$data['id_ms_jabatan'] = $this->db->order_by('id','asc')->get('ms_jabatan')->result_array();
		$data['ms_dokumen_pegawai'] = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();	
		}
		
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$this->template->display('form_pegawai',$data);
	}
	
	function loadjabatan(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_jabatan")->row_array();
		}
		$data['id_ms_pegawai']="";
		$data['ms_jabatan']=$this->db->get("ms_jabatan")->result_array();
		$data['id_ms_unit_kerja']=$this->db->get("ms_unit_kerja")->result_array();
		$this->load->view('form_jabatan',$data);
	} 	
	function loadkepangkatan(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_kepangkatan")->row_array();
		}
		
		$data['id_ms_golongan']=$this->db->get("ms_golongan")->result_array();
		$this->load->view('form_kepangkatan',$data);
	} 	
	function loadpendidikan(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_pendidikan")->row_array();
		}
		$data['id_ms_jenjang']=$this->db->get("ms_jenjang")->result_array();
		$this->load->view('form_pendidikan',$data);
	} 
	function loadkeluarga(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_keluarga")->row_array();
		}
		$data['id_ms_pekerjaan']=$this->db->get("ms_pekerjaan")->result_array();
		$this->load->view('form_keluarga',$data);
	}  
	function loaddiklat(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_diklat_pelatihan")->row_array();
		}
		$this->load->view('form_diklat',$data);
	}  
	function loadcuti(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_cuti")->row_array();
		}
		$this->load->view('form_cuti',$data);
	} 
	function loadmutasi(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_mutasi")->row_array();
		}
		$data['ms_jabatan']=$this->db->get("ms_jabatan")->result_array();
		$data['id_ms_unit_kerja']=$this->db->get("ms_unit_kerja")->result_array();
		$this->load->view('form_mutasi',$data);
	} 
	function loadorganisasi(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_keanggotaan_organisasi")->row_array();
		}
		$this->load->view('form_organisasi',$data);
	}  
	function loadpenghargaan(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_penghargaan")->row_array();
		}
		$this->load->view('form_penghargaan',$data);
	}   
	function loadgaji(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_gaji")->row_array();
		}
		$this->load->view('form_gaji',$data);
	}  
	function loaddokumen(){
		$post = $this->input->post(NULL,TRUE);
		$id=(!empty(element('tid',$post)))?element('tid',$post):null;
		$data['row']=array();
		if(!empty($id)){
		$this->db->where("id",$id);
		$data['row']=$this->db->get("pegawai_dokumen")->row_array();
		}
		$data['id']=element('id_ms_pegawai',$post);
		$data['ms_dokumen_pegawai'] = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();	
		$this->load->view('form_dokumen',$data);
	} 
	
	function save_pegawai(){
	
		$post = $this->input->post(NULL,TRUE);
		
		if(!empty($post['jabatan']))
			{
				$value = $post['jabatan'];

					$jabatan['id'] = $value['id'];
					$jabatan['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$jabatan['jenis_jabatan'] = $value['jenis_jabatan'];
					$jabatan['id_ms_jabatan'] = $value['id_ms_jabatan'];
					$jabatan['id_ms_unit_kerja'] = $value['id_ms_unit_kerja'];
					$jabatan['id_ms_sub_unit_kerja'] = $value['id_ms_sub_unit_kerja'];
					$jabatan['esselon'] = $value['esselon'];
					$jabatan['tmt'] = convert_tgl($value['tmt'],'Y-m-d');
					$jabatan['jabatan_terakhir'] = element('jabatan_terakhir',$value);
					$jabatan['no_sk'] = $value['no_sk'];
					$jabatan['tgl_sk'] = convert_tgl($value['tgl_sk'],'Y-m-d');
					$jabatan['penandatangan'] = $value['penandatangan'];
					$jabatan['status'] = $value['status'];
					$pegawai_jabatan[] = $jabatan;
				
				$this->db->replace_batch('pegawai_jabatan',$pegawai_jabatan);
				$jid=(!empty($jabatan['id']))?$jabatan['id']:$this->db->insert_id();
				$idmsj=($jabatan['id_ms_jabatan'])?get_field($jabatan['id_ms_jabatan'],'ms_jabatan'):'';
				$idmsu=($jabatan['id_ms_unit_kerja'])?get_field($jabatan['id_ms_unit_kerja'],'ms_unit_kerja'):'';
				$idmss=($jabatan['id_ms_sub_unit_kerja'])?get_field($jabatan['id_ms_sub_unit_kerja'],'ms_unit_kerja'):'';
				$jj=($jabatan['jabatan_terakhir'] == '1')?'Ya':'-';
				$data['isi']='<tr id="checkop'.$jid.'"><td style="width:3%;" class="text-center"><input type="checkbox" class="checkop" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$jj.'</td><td style="width:35%;" class="text-left">'.$idmsj.'  <a style="cursor:pointer;" onclick="addData(\'loadjabatan\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$idmsu.'</td><td style="width:20%;" class="text-left">'.$idmss.'</td><td style="width:10%;" class="text-left">'.$jabatan["esselon"].'</td></tr>';
				$data['tr']="checkop".$jid;
				$data['tbody']="tJabatan";
			}
			
		if(!empty($post['kepangkatan']))
			{
				$value = $post['kepangkatan'];

					$kepangkatan['id'] = $value['id'];
					$kepangkatan['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$kepangkatan['golongan'] = $value['golongan'];
					$kepangkatan['pangkat'] = $value['pangkat'];
					$kepangkatan['esselon'] = $value['esselon'];
					$kepangkatan['tmt'] = convert_tgl($value['tmt'],'Y-m-d');
					$kepangkatan['tgl_sk'] = convert_tgl($value['tgl_sk'],'Y-m-d');
					$kepangkatan['no_sk'] = $value['no_sk'];
					$kepangkatan['penandatangan'] = $value['penandatangan'];
					$pegawai_kepangkatan[] = $kepangkatan;
				
				$this->db->replace_batch('pegawai_kepangkatan',$pegawai_kepangkatan);
				$jid=(!empty($kepangkatan['id']))?$kepangkatan['id']:$this->db->insert_id();
				$g=get_field($kepangkatan['golongan'],'ms_golongan');
				$data['isi']='<tr id="checkkepangkatan'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkkepangkatan" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$g.' </td><td style="width:35%;" class="text-left">'.$kepangkatan["pangkat"].' <a style="cursor:pointer;" onclick="addData(\'loadkepangkatan\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$kepangkatan["esselon"].'</td><td style="width:20%;" class="text-left">'.$kepangkatan["tmt"].'</td><td style="width:10%;" class="text-left">'.$kepangkatan["no_sk"].'</td></tr>';
				$data['tr']="checkkepangkatan".$jid;
				$data['tbody']="tKepangkatan";
			}
					
		if(!empty($post['pendidikan']))
			{
				$value = $post['pendidikan'];

					$pendidikan['id'] = $value['id'];
					$pendidikan['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$pendidikan['jenis_pendidikan'] = $value['jenis_pendidikan'];
					$pendidikan['id_ms_jenjang'] = $value['id_ms_jenjang'];
					$pendidikan['nama_sekolah'] = $value['nama_sekolah'];
					$pendidikan['program_studi'] = $value['program_studi'];
					$pendidikan['jurusan'] = $value['jurusan'];
					$pendidikan['tahun_masuk'] = $value['tahun_masuk'];
					$pendidikan['tahun_lulus'] = $value['tahun_lulus'];
					$pendidikan['lama_pendidikan'] = $value['lama_pendidikan'];
					$pendidikan['no_ijazah'] = $value['no_ijazah'];
					$pendidikan['tgl_ijazah'] = convert_tgl($value['tgl_ijazah'],'Y-m-d');
					$pegawai_pendidikan[] = $pendidikan;
				
				$this->db->replace_batch('pegawai_pendidikan',$pegawai_pendidikan);
				$jid=(!empty($pendidikan['id']))?$pendidikan['id']:$this->db->insert_id();
				$idmsj=($pendidikan['id_ms_jenjang'])?get_field($pendidikan['id_ms_jenjang'],'ms_jenjang'):'';
				$data['isi']='<tr id="checkpendidikan'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkpendidikan" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$idmsj.'</td><td style="width:35%;" class="text-left">'.$pendidikan['nama_sekolah'].' <a style="cursor:pointer;" onclick="addData(\'loadpendidikan\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$pendidikan['program_studi'].'</td><td style="width:20%;" class="text-left">'.$pendidikan['jurusan'].'</td><td style="width:10%;" class="text-left">'.$pendidikan['tahun_lulus'].'</td>';
				$data['tr']="checkpendidikan".$jid;
				$data['tbody']="tPendidikan";
			}			
		if(!empty($post['keluarga']))
			{
				$value = $post['keluarga'];

					$keluarga['id'] = $value['id'];
					$keluarga['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$keluarga['hubungan'] = $value['hubungan'];
					$keluarga['nama_lengkap'] = $value['nama_lengkap'];
					$keluarga['tempat_lahir'] = $value['tempat_lahir'];
					$keluarga['tgl_lahir'] =  convert_tgl($value['tgl_lahir'],'Y-m-d');
					$keluarga['usia'] = $value['usia'];
					$keluarga['id_ms_pekerjaan'] = $value['id_ms_pekerjaan'];
					$keluarga['pendidikan_terakhir'] = $value['pendidikan_terakhir'];
					$keluarga['pendidikan_terakhir'] = $value['pendidikan_terakhir'];
					$pegawai_keluarga[] = $keluarga;
				
				$this->db->replace_batch('pegawai_keluarga',$pegawai_keluarga);
				$jid=(!empty($keluarga['id']))?$keluarga['id']:$this->db->insert_id();
				$idmsj=($keluarga['id_ms_pekerjaan'])?get_field($keluarga['id_ms_pekerjaan'],'ms_pekerjaan'):'';
				$data['isi']='<tr id="checkkeluarga'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkkeluarga" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$keluarga['hubungan'].' </td><td style="width:35%;" class="text-left">'.$keluarga['nama_lengkap'].' <a style="cursor:pointer;" onclick="addData(\'loadkeluarga\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$keluarga['tempat_lahir'].', '.$keluarga['tgl_lahir'].'</td><td style="width:20%;" class="text-left">'.$keluarga['usia'].'</td><td style="width:10%;" class="text-left">'.$idmsj.'</td></tr>';
				$data['tr']="checkkeluarga".$jid;
				$data['tbody']="tKeluarga";
			}			
		if(!empty($post['diklat']))
			{
				$value = $post['diklat'];

					$diklat['id'] = $value['id'];
					$diklat['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$diklat['jenis'] = $value['jenis'];
					$diklat['nama'] = $value['nama'];
					$diklat['penyelenggara'] = $value['penyelenggara'];
					$diklat['tgl_mulai'] =  convert_tgl($value['tgl_mulai'],'Y-m-d');
					$diklat['tgl_selesai'] =  convert_tgl($value['tgl_selesai'],'Y-m-d');
					$diklat['tgl_ijazah'] =  convert_tgl($value['tgl_ijazah'],'Y-m-d');
					$diklat['jml_jam'] = $value['jml_jam'];
					$diklat['predikat'] = $value['predikat'];
					$diklat['angkatan'] = $value['angkatan'];
					$diklat['no_ijazah'] = $value['no_ijazah'];
					$diklat['penandatangan'] = $value['penandatangan'];
					$diklat['tempat'] = $value['tempat'];
					$pegawai_diklat[] = $diklat;
				
				$this->db->replace_batch('pegawai_diklat_pelatihan',$pegawai_diklat);
				$jid=(!empty($diklat['id']))?$diklat['id']:$this->db->insert_id();
				$data['isi']='<tr id="checkdiklat'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkdiklat" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$diklat['jenis'].' </td><td style="width:35%;" class="text-left">'.$diklat['nama'].' <a style="cursor:pointer;" onclick="addData(\'loaddiklat\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$diklat['penyelenggara'].'</td><td style="width:20%;" class="text-left">'.$diklat['jml_jam'].'</td><td style="width:10%;" class="text-left">'.$diklat['predikat'].'</td></tr>';
				$data['tr']="checkdiklat".$jid;
				$data['tbody']="tDiklat";
			}		
		if(!empty($post['cuti']))
			{
				$value = $post['cuti'];

					$cuti['id'] = $value['id'];
					$cuti['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$cuti['keterangan'] = $value['keterangan'];
					$cuti['tgl_berlaku'] =  convert_tgl($value['tgl_berlaku'],'Y-m-d');
					$cuti['tgl_awal'] =  convert_tgl($value['tgl_awal'],'Y-m-d');
					$cuti['tgl_akhir'] =  convert_tgl($value['tgl_akhir'],'Y-m-d');
					$cuti['tgl_sk'] =  convert_tgl($value['tgl_sk'],'Y-m-d');
					$cuti['no_sk'] = $value['no_sk'];
					$cuti['penandatangan'] = $value['penandatangan'];
					$pegawai_cuti[] = $cuti;
				
				$this->db->replace_batch('pegawai_cuti',$pegawai_cuti);
				$jid=(!empty($cuti['id']))?$cuti['id']:$this->db->insert_id();
				$data['isi']='<tr id="checkcuti'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkcuti" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$cuti['no_sk'].' </td><td style="width:35%;" class="text-left">'.$cuti['keterangan'].' <a style="cursor:pointer;" onclick="addData(\'loadcuti\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$cuti['tgl_berlaku'].'</td><td style="width:20%;" class="text-left">'.$cuti['tgl_awal'].'</td><td style="width:10%;" class="text-left">'.$cuti['tgl_akhir'].'</td></tr>';
				$data['tr']="checkcuti".$jid;
				$data['tbody']="tCuti";
			}	
		if(!empty($post['organisasi']))
			{
				$value = $post['organisasi'];

					$organisasi['id'] = $value['id'];
					$organisasi['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$organisasi['nama'] = $value['nama'];
					$organisasi['jabatan'] = $value['jabatan'];
					$organisasi['no_periode'] = $value['no_periode'];
					$organisasi['tgl_awal'] =  convert_tgl($value['tgl_awal'],'Y-m-d');
					$organisasi['tgl_akhir'] =  convert_tgl($value['tgl_akhir'],'Y-m-d');
					$organisasi['tgl_sk'] =  convert_tgl($value['tgl_sk'],'Y-m-d');
					$organisasi['no_sk'] = $value['no_sk'];
					$organisasi['penandatangan'] = $value['penandatangan'];
					$pegawai_organisasi[] = $organisasi;
				
				$this->db->replace_batch('pegawai_keanggotaan_organisasi',$pegawai_organisasi);
				$jid=(!empty($organisasi['id']))?$organisasi['id']:$this->db->insert_id();
				$data['isi']='<tr id="checkorganisasi'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkorganisasi" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$organisasi['no_periode'].' </td><td style="width:35%;" class="text-left">'.$organisasi['nama'].' <a style="cursor:pointer;" onclick="addData(\'loadorganisasi\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$organisasi['jabatan'].'</td><td style="width:20%;" class="text-left">'.$organisasi['tgl_awal'].'</td><td style="width:10%;" class="text-left">'.$organisasi['no_sk'].'</td></tr>';
				$data['tr']="checkorganisasi".$jid;
				$data['tbody']="tOrganisasi";
			}
		if(!empty($post['mutasi']))
			{
				$value = $post['mutasi'];

					$mutasi['id'] = $value['id'];
					$mutasi['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$mutasi['id_ms_jabatan'] = $value['id_ms_jabatan'];
					$mutasi['pangkat'] = $value['pangkat'];
					$mutasi['tmt'] =  convert_tgl($value['tmt'],'Y-m-d');
					$mutasi['tgl_sk'] =  convert_tgl($value['tgl_sk'],'Y-m-d');
					$mutasi['no_sk'] = $value['no_sk'];
					$mutasi['penandatangan'] = $value['penandatangan'];
					$mutasi['tujuan'] = $value['tujuan'];
					$mutasi['id_ms_unit_kerja_asal'] = $value['id_ms_unit_kerja_asal'];
					$mutasi['id_ms_unit_kerja_tujuan'] = $value['id_ms_unit_kerja_tujuan'];
					$pegawai_mutasi[] = $mutasi;
				
				$this->db->replace_batch('pegawai_mutasi',$pegawai_mutasi);
				$jid=(!empty($mutasi['id']))?$mutasi['id']:$this->db->insert_id();
				$idmsj=get_field($mutasi['id_ms_jabatan'],'ms_jabatan');
				$idmsu1=get_field($mutasi['id_ms_unit_kerja_asal'],'ms_unit_kerja');
				$idmsu2=get_field($mutasi['id_ms_unit_kerja_tujuan'],'ms_unit_kerja');
				$data['isi']='<tr id="checkmutasi'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkmutasi" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$idmsj.' </td><td style="width:35%;" class="text-left">'.$mutasi['pangkat'].' <a style="cursor:pointer;" onclick="addData(\'loadmutasi\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$idmsu1.'</td><td style="width:20%;" class="text-left">'.$idmsu2.'</td><td style="width:10%;" class="text-left">'.$mutasi['no_sk'].'</td></tr>';
				$data['tr']="checkmutasi".$jid;
				$data['tbody']="tMutasi";
			}
		if(!empty($post['penghargaan']))
			{
				$value = $post['penghargaan'];

					$penghargaan['id'] = $value['id'];
					$penghargaan['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$penghargaan['keterangan'] = $value['keterangan'];
					$penghargaan['nama'] = $value['nama'];
					$penghargaan['asal_sk'] = $value['asal_sk'];
					$penghargaan['tgl_sk'] =  convert_tgl($value['tgl_sk'],'Y-m-d');
					$penghargaan['no_sk'] = $value['no_sk'];
					$penghargaan['penandatangan'] = $value['penandatangan'];
					$pegawai_penghargaan[] = $penghargaan;
				
				$this->db->replace_batch('pegawai_penghargaan',$pegawai_penghargaan);
				$jid=(!empty($penghargaan['id']))?$penghargaan['id']:$this->db->insert_id();
				$data['isi']='<tr id="checkpenghargaan'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkpenghargaan" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$penghargaan['no_sk'].' </td><td style="width:35%;" class="text-left">'.$penghargaan['nama'].' <a style="cursor:pointer;" onclick="addData(\'loadpenghargaan\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$penghargaan['asal_sk'].'</td><td style="width:20%;" class="text-left">'.$penghargaan['tgl_sk'].'</td><td style="width:10%;" class="text-left">'.$penghargaan['keterangan'].'</td></tr>';
				$data['tr']="checkpenghargaan".$jid;
				$data['tbody']="tPenghargaan";
			}
		if(!empty($post['gaji']))
			{
				$value = $post['gaji'];

					$gaji['id'] = $value['id'];
					$gaji['id_ms_pegawai'] = element("id_ms_pegawai",$post);
					$gaji['keterangan'] = $value['keterangan'];
					$gaji['gaji'] = $value['gaji'];
					$gaji['perubahan_gaji'] = $value['perubahan_gaji'];
					$gaji['tmt'] =  convert_tgl($value['tmt'],'Y-m-d');
					$gaji['no_sk'] = $value['no_sk'];
					$pegawai_gaji[] = $gaji;
				
				$this->db->replace_batch('pegawai_gaji',$pegawai_gaji);
				$jid=(!empty($gaji['id']))?$gaji['id']:$this->db->insert_id();
				$data['isi']='<tr id="checkgaji'.$jid.'"><td style="width:3%;" class="text-center "><input class="checkgaji" type="checkbox" value="'.$jid.'"></td><td style="width:12%;" class="text-left">'.$gaji['no_sk'].' </td><td style="width:35%;" class="text-left">'.$gaji['gaji'].' <a style="cursor:pointer;" onclick="addData(\'loadgaji\','.$jid.')"><i  class="fa fa-pencil"></i></a></td><td style="width:20%;" class="text-left">'.$gaji['tmt'].'</td><td style="width:20%;" class="text-left">'.$gaji['perubahan_gaji'].'</td><td style="width:10%;" class="text-left">'.$gaji['keterangan'].'</td></tr>';
				$data['tr']="checkgaji".$jid;
				$data['tbody']="tGaji";
			}
		if(!empty($post['dokumen']))
			{
				$value = $post['dokumen'];

		
		$loop = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();			
		foreach($loop as $r){
		$data="";	
		
		$x=element('before'.$r['id'],$post);
		$config['upload_path'] = FILES_PATH.'/img/dokumen/';
		$config['allowed_types'] = 'jpeg|jpg|png|pdf';
		$config['overwrite'] = TRUE;
		$config['max_size']	= '1000';
		$config['file_name'] = url_title(element('id_ms_pegawai',$post))."_".$r['id'];
		
		create_dir($config['upload_path']);
		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload($r['id'])) {
			$upload = $this->upload->data();
			$foto = $upload['file_name'];
			$NamaFoto = element('id_ms_pegawai',$post)."_".$foto;
			$data['link']=$foto;
			if($x != 0){
				unlink(FILES_PATH.'/img/dokumen/'.$x);
			}
			$l=1;
		}else{
			$NamaFoto = "";
			// echo $this->upload->display_errors();
			$l=0;
		}
		
		if($l == 1){
			if($x != 0){
			$this->db->where("id_ms_dokumen_pegawai",$r['id']);
			$this->db->where("id_ms_pegawai",element('id_ms_pegawai',$post));
			$this->db->update("pegawai_dokumen",$data);
			}else{
			$data['id_ms_dokumen_pegawai']=$r['id'];
			$data['id_ms_pegawai']=element('id_ms_pegawai',$post);
			$this->db->insert("pegawai_dokumen",$data);
			}
		}
		} 

			}
			echo json_encode($data);
	}
	
	public function save()
	{
		$post = $this->input->post(NULL,TRUE);
		if(empty(element('jenis_pegawai',$post))){
			$jenis_pegawai="pegawai";
		}else{
			$jenis_pegawai=element('jenis_pegawai',$post);
		}
		if(!empty($this->input->post('id_poliklinik'))){
			$polik=implode(',',$this->input->post('id_poliklinik'));
		}else{
			$polik=null;
		}
		$data = array(
			'id'	=> element('id',$post),
			'jenis_pegawai'	=> $jenis_pegawai,
			'kd'	=> element('kd',$post),
			'nip'	=> element('nip',$post),
			'no_registrasi_pegawai'	=> element('no_registrasi_pegawai',$post),
			'nama'	=> element('nama',$post),
			'no_identitas'	=> element('no_identitas',$post),
			'tempat_lahir'	=> element('tempat_lahir',$post),
			'tgl_lahir'	=> convert_tgl(element('tgl_lahir',$post),'Y-m-d',1),
			'jk'	=> element('jk',$post),
			'usia'	=> element('usia',$post),
			'alamat'	=> element('alamat',$post),
			'telp'	=> element('telp',$post),
			'hp'	=> element('hp',$post),
			'email'	=> element('email',$post),
			'gol_darah'	=> element('gol_darah',$post),
			'desa'	=> element('desa',$post),
			'status_sipil'	=> element('status_sipil',$post),
			'id_ms_agama'	=> element('id_agama',$post),
			'id_ms_wilayah'	=> element('id_wilayah',$post),
			'gelar_depan'	=> element('gelar_depan',$post),
			'gelar_belakang'	=> element('gelar_belakang',$post),
			'masa_kerja_thn'	=> element('masa_kerja_thn',$post),
			'masa_kerja_bln'	=> element('masa_kerja_bln',$post),
			'status_pegawai'	=> element('status_pegawai',$post),
			'id_poliklinik'	=> $polik
		);
		
							
		$config['upload_path'] = FILES_PATH.'/img/foto/';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['overwrite'] = TRUE;
		$config['file_name'] = url_title(element('nama',$post));
		
		create_dir($config['upload_path']);
		
		$this->load->library('upload', $config);

		if($this->upload->do_upload('foto')) {
			$upload = $this->upload->data();
			$data['foto'] = $upload['file_name'];
			$f=1;
		}else{
			$data['foto'] = get_field(element('id',$post),'ms_pegawai','foto');
		} 

		
		$status = false;
		if($this->db->replace("ms_pegawai", $data)){
			$status = true;
		}
		die(json_encode(array("status" => $status)));
		
	}

	function hapus(){
		
		$post = $this->input->post(NULL,TRUE);
		$x=explode(',',$post['ID']);
		$this->db->where_in('id',$x);
		$this->db->delete($post['t']);
	}

	
			public function ajax_delete_keluarga(){
			$post = $this->input->post(NULL,TRUE);
			$keluarga = $post['keluarga'];
			$id = $keluarga['rowid'];
			$this->db->where_in("id",$id);
			$this->db->delete('pegawai_keluarga');
			
			echo json_encode(array("status" => TRUE));
			
			
		}	 		
			public function ajax_delete_pendidikan(){
			$post = $this->input->post(NULL,TRUE);
			$pendidikan = $post['pendidikan'];
			$id = $pendidikan['rowid'];
			$this->db->where_in("id",$id);
			$this->db->delete('pegawai_pendidikan');
			
			echo json_encode(array("status" => TRUE));
			
			
		}
	function adddokter($id=0){
		$data['row']=array();
		if($id != 0){
		$data['row'] = $this->Pegawai_model->get_by_id($id);
		}
		$poli=$this->session->userdata('id_pol');
		$this->db->select('id,nama');		
		if($poli){
		$w=" id IN ($poli)";
		}else{
		$w=" id =''";	
			}
		$this->db->where($w);
		$data['id_ms_unit_kerja'] = $this->db->order_by('id','asc')->get('ms_unit_kerja')->result_array();
		$data['id_ms_jabatan'] = $this->db->order_by('id','asc')->get('ms_jabatan')->result_array();
		$data['poli']=$this->db->get('ms_poliklinik')->result();
		$this->load->view('form_agama',$data);
	}
	
	function adduser($id=0){
		$data['row'] = $this->Pegawai_model->get_user_id($id);	
		$data['poli']=$this->db->get('ms_poliklinik')->result();
		$data['penunjang']=$this->db->get('ms_penunjang')->result();
		$data['menu']=$this->db->get('sys_menu')->result();
		$data['id_pegawai']=$id;
		$this->load->view('form_user',$data);
	}
	
    public function ajax_list($jenis)
	{	
		$list = $this->Pegawai_model->get_datatables($jenis);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nip;
			 $fields[] = $row->nama;
			 $fields[] = $row->no_identitas;
			 $fields[] = ($row->jk == 'L')?'Laki-laki':'Perempuan';
			 $fields[] = $row->spesialis;
			 $fields[] = $row->hp;
			 $fields[] = $row->alamat;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			
			$fields[] = '<a style="cursor:pointer;" onclick="addmodal('.$row->id.')"><i class="fa fa-pencil"></i> Edit</a> <a style="cursor:pointer;" onclick="addmodaluser('.$row->id.')"><i class="fa fa-user"></i> Setting User</a>';
			$data[] = $fields;
		}



		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pegawai_model->count_all(),
			"recordsFiltered" => $this->Pegawai_model->count_filtered($jenis),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Pegawai_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			'id_poliklinik',
			'spesialis',
			'id',
			'nip',
			'nama',
			'no_identitas',
			'tempat_lahir',
			'tgl_lahir',
			'jk',
			'alamat',
			'telp',
			'hp',
			'email',
			'gol_darah',
			'kode_golongan',
			'unit_kerja',
			'status_pegawai'

			);
			
			$fields = $this->Pegawai_model->list_fields($list_fields);
			$data = (array) $data_object;
			foreach($fields as $meta){
				$data_new['name'] = $meta->name;
				$data_new['value'] = $data[$meta->name];
				$data_array[] = $data_new;
			}
			
			
			$result['status'] = 0;
			$result['data_array'] = $data_array;
			$result['data_object'] = $data_object;
			$response['response'] = $result;
		}
		else
		{
			$result['status'] = 99;
			$response['response'] = $result;
		}
		echo json_encode($response);
	}

	public function ajax_save($jenis)
	{
		$post = $this->input->post(NULL,TRUE);
		if(element('id_poliklinik',$post)){
			$pol=implode(',',element('id_poliklinik',$post));
		}else{
			$pol="";
		}
		$data = array(
		'jenis_pegawai'=>$jenis,
		'kedudukan_hukum'=>element('kedudukan_hukum',$post),
		'spesialis'=>element('spesialis',$post),
		'jenis_jabatan'=>element('jenis_jabatan',$post),
		'id_ms_jabatan'=>element('id_ms_jabatan',$post),
		'id_poliklinik'=>$pol,
		'nip'=>element('nip',$post),
		'nama'=>element('nama',$post),
		'no_identitas'=>element('no_identitas',$post),
		'tempat_lahir'=>element('tempat_lahir',$post),
		'tgl_lahir'=>convert_tgl(element('tgl_lahir',$post),'Y-m-d',1),
		'jk'=>element('jk',$post),
		'alamat'=>element('alamat',$post),
		'telp'=>element('telp',$post),
		'hp'=>element('hp',$post),
		'email'=>element('email',$post),
		'gol_darah'=>element('gol_darah',$post),
		'kode_golongan'=>element('kode_golongan',$post),
		'id_ms_unit_kerja'=>element('id_ms_unit_kerja',$post),
		'status_pegawai'=>element('status_pegawai',$post)
		);
			
		if(empty($post['id']))
		{
			$result = $this->Pegawai_model->insert($data);
			$i=$this->db->insert_id();
			$send['id_pegawai']=$i;
			$send['username']=element('username',$post);
			$send['menu'][]=43;
			$send['password']=element('password',$post);
			$this->ajax_save_user($jenis,$send);
		}
		else
		{
			$result = $this->Pegawai_model->update(array('id' => $post['id']), $data);
		}
		
		echo json_encode(array("status" => true));
		
	}

	function save_dokumen(){
	
		$post = $this->input->post(NULL,TRUE);
		
		$loop = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();			
		foreach($loop as $r){
		$data="";	
		
		$x=element('before'.$r['id'],$post);
		$config['upload_path'] = FILES_PATH.'/img/dokumen/';
		$config['allowed_types'] = 'jpeg|jpg|png|pdf';
		$config['overwrite'] = TRUE;
		$config['file_name'] = url_title(element('id_ms_pegawai',$post))."_".$r['id'];
		
		create_dir($config['upload_path']);
		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload($r['id'])) {
			$upload = $this->upload->data();
			$foto = $upload['file_name'];
			$NamaFoto = $foto;
			$data['link']=$foto;
			if($x != 0){
				unlink(FILES_PATH.'/img/dokumen/'.$x);
			}
			$l=1;
		}else{
			$NamaFoto = "";
			echo $this->upload->display_errors();
			print_r($_FILES);
			$l=0;
		}
		
		if($l == 1){
			if($x != 0){
			$this->db->where("id_ms_dokumen_pegawai",$r['id']);
			$this->db->where("id_ms_pegawai",element('id_ms_pegawai',$post));
			$this->db->update("pegawai_dokumen",$data);
			}else{
			$data['id_ms_dokumen_pegawai']=$r['id'];
			$data['id_ms_pegawai']=element('id_ms_pegawai',$post);
			$this->db->insert("pegawai_dokumen",$data);
			}
		}
		} 

	}
		

	public function ajax_save_user($jenis,$post="")
	{
		if($post == ""){
		$post = $this->input->post(NULL,TRUE);
		}
		$this->db->where('id',$post['id_pegawai']);
		$pegawai=$this->db->get('ms_pegawai')->row_array();
		$user['nama']=element('nama',$pegawai);	
		$user['no_identitas']=element('no_identitas',$pegawai);	
		$user['jk']=element('jk',$pegawai);	
		$user['tempat_lahir']=element('tempat_lahir',$pegawai);	
		$user['tgl_lahir']=element('tgl_lahir',$pegawai);	
		$user['alamat']=element('alamat',$pegawai);	
		$user['telp']=element('telp',$pegawai);	
		$user['hp']=element('hp',$pegawai);	
		$user['email']=element('email',$pegawai);	
		$user['id_pegawai']=element('id',$pegawai);
		if(!empty($post['id_poliklinik'])){
		$user['id_poliklinik']=implode(',',$post['id_poliklinik']);	
		}
		
		if(!empty($post['id_penunjang'])){
		$user['id_penunjang']=implode(',',$post['id_penunjang']);	
		}

		if(empty($post['id_user']))
		{
			$result = $this->db->insert('ms_user',$user);
			$id_user=$this->db->insert_id();
			if($id_user){
			$login['username']=$post['username'];
			$login['password']=md5($post['password']);
			$login['id_user']=$id_user;
			$login['id_jenis_user']=3;
			$this->db->insert('sys_login',$login);

			$this->db->where('username',$post['username']);
			if($this->db->delete('sys_akses_menu')){
				foreach($post['menu'] as $row){
				$akses['username']=$post['username'];
				$akses['id_menu']=$row;
				$akses['akses']='READ';
				$this->db->insert('sys_akses_menu',$akses);
				}
			}
			}
		}
		else
		{
			$this->db->where('id',$post['id_user']);
			$result = $this->db->update('ms_user',$user);
			$login['username']=element('username',$post);
			$login['password']=md5(element('username',$post));
			$login['id_jenis_user']=3;
			$this->db->where('id_user',$post['id_user']);
			$this->db->update('sys_login',$login);

			$this->db->where('username',element('username',$post));
			if($this->db->delete('sys_akses_menu')){
				foreach(element('menu',$post) as $row){
				$akses['username']=element('username',$post);
				$akses['id_menu']=$row;
				$akses['akses']='READ';
				$this->db->insert('sys_akses_menu',$akses);
				}
			}
		}
		
		echo json_encode(array("status" => true));
		
	}
  	

	public function ajax_delete()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		if(!is_array($id)){
			$id[] = $id;
		}
		$this->Pegawai_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Pegawai_model->data_excel("agama");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Pegawai_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_agama',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Agama","I"); 
	}

		
}
?>
