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

class Pegawai extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pegawai_model');
		$config['table'] = 'ms_pegawai';
		$config['column_order'] = array(null,'id','nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama',null);
		$config['column_search'] = array('nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama');
		$config['column_excel'] = array('nip','nama','no_registrasi_pegawai','no_identitas','jk','status_pegawai','hp','alamat','add_time');
		$config['column_pdf'] = array('nip','nama','no_registrasi_pegawai','no_identitas','jk','status_pegawai','hp','alamat','add_time');
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
	
	public function loadForm($id = null ) {
		$data['row'] = array() ; 
		if($id == null){
			$id=$this->session->userdata('id_pegawai');
			$this->db->where('id',$id);
			$data['row'] = $this->db->get('ms_pegawai')->row_array();
		}
		$data['id'] = $id;
		$data['id_table'] = "pegawai";
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$data['id_ms_jenis_user'] = $this->db->order_by('id','asc')->get('sys_jenis_user')->result_array();
		$data['kode_golongan'] = $this->db->order_by('kd','asc')->get('ms_golongan')->result_array();
		$data['id_ms_unit_kerja'] = $this->db->order_by('id','asc')->get('ms_unit_kerja')->result_array();
		$data['id_ms_jabatan'] = $this->db->order_by('id','asc')->get('ms_jabatan')->result_array();
		$data['ms_dokumen_pegawai'] = $this->db->order_by('id','asc')->get('ms_dokumen_pegawai')->result_array();
		$data['pendidikan'] = $this->db->select('
			pegawai_pendidikan.*')
			->where('ms_pegawai.id',$id)
			->join('ms_pegawai','ms_pegawai.id = pegawai_pendidikan.id_pegawai','inner')
			->get('pegawai_pendidikan')->result_array();
		$data['keluarga'] = $this->db->select('
			pegawai_keluarga.*')
			->where('ms_pegawai.id',$id)
			->join('ms_pegawai','ms_pegawai.id = pegawai_keluarga.id_pegawai','inner')
			->get('pegawai_keluarga')->result_array();
		$this->template->display('form_pegawai',$data);
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
		$data['id_ms_golongan'] = $this->db->order_by('kd','asc')->get('ms_golongan')->result_array();
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
			
			$fields[] = '<a class="btn btn-default" style="cursor:pointer;" onclick="addmodaluser('.$row->id.')"><i class="fa fa-user"></i></a> <a class="btn btn-default" href="'.site_url("hrm/profile/".$row->id).'" style="cursor:pointer;"><i class="fa fa-pencil"></i></a> <a target="_blank" class="btn btn-default" href="'.site_url("hrm/view/".$row->id).'" style="cursor:pointer;"><i class="fa fa-eye"></i></a>';
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
		'id_ms_golongan'=>element('id_ms_golongan',$post),
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
		'no_registrasi_pegawai'=>element('no_registrasi_pegawai',$post),
		'status_pegawai'=>element('status_pegawai',$post)
		);
			
		if(empty($post['id']))
		{
			$result = $this->Pegawai_model->insert($data);
			$i=$this->db->insert_id();
			$send['id_pegawai']=$i;
			$send['username']=element('username',$post);
			$send['menu'][]="43";
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

	function save_pegawai(){
	
		$post = $this->input->post(NULL,TRUE);
					
		$config['upload_path'] = FILES_PATH.'/img/foto/';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['overwrite'] = TRUE;
		$config['file_name'] = url_title(element('nama',$post));
		
		create_dir($config['upload_path']);
		
		$this->load->library('upload', $config);

		if($this->upload->do_upload('ff')) {
			$upload = $this->upload->data();
			$NamaFoto = $upload['file_name'];
			$f=1;
		}else{
			$NamaFoto = "";
			echo $this->upload->display_errors();
			print_r($_FILES);
			$f=0;
		} 

			
			
			
			

		$data = array(
		'nip'=>element('nip',$post),
		'no_registrasi_pegawai'=>element('no_registrasi_pegawai',$post),
		'no_identitas'=>element('no_identitas',$post),
		'nama'=>element('nama',$post),
		'gelar_depan'=>element('gelar_depan',$post),
		'gelar_belakang'=>element('gelar_belakang',$post),
		'tempat_lahir'=>element('tempat_lahir',$post),
		'tgl_lahir'=>convert_tgl(element('tanggal_lahir',$post),'Y-m-d',1),
		'usia'=>element('usia',$post),
		'status_sipil'=>element('status_sipil',$post),
		'jk'=>element('jk',$post),
		'gol_darah'=>element('gol_darah',$post),
		'id_ms_agama'=>element('id_ms_agama',$post),
		'telp'=>element('telp',$post),
		'hp'=>element('hp',$post),
		'alamat'=>element('alamat',$post),
		'email'=>element('email',$post),
		'status_pegawai'=>element('status_pegawai',$post),
		'kedudukan_hukum'=>element('kedudukan_hukum',$post),
		'pangkat_terakhir'=>element('pangkat_terakhir',$post),
		'masa_kerja_bln'=>element('masa_kerja_bln',$post),
		'masa_kerja_thn'=>element('masa_kerja_thn',$post),
		'kode_golongan'=>element('kode_golongan',$post),
		'tgl_mulai_golongan'=>convert_tgl(element('tgl_mulai_golongan',$post),'Y-m-d',1),
		'id_ms_jabatan'=>element('id_ms_jabatan',$post),
		'id_ms_unit_kerja'=>element('id_ms_unit_kerja',$post),
		'id_sub_ms_unit_kerja'=>element('id_sub_ms_unit_kerja',$post),
		'penempatan_unit_kerja'=>element('penempatan_unit_kerja',$post),
		'eselon_jabatan'=>element('eselon_jabatan',$post),
		'tgl_mulai_tugas_jabatan'=>convert_tgl(element('tgl_mulai_tugas_jabatan',$post),'Y-m-d',1),
		'tgl_sk_jabatan'=>convert_tgl(element('tgl_sk_jabatan',$post),'Y-m-d',1),
		'no_sk_jabatan'=>element('no_sk_jabatan',$post),
		'penandatangan_sk'=>element('penandatangan_sk',$post)
		);
		
		if(empty($post['id']))
		{
			$result = $this->Pegawai_model->insert($data);
			$id=$this->db->insert_id();
			if($f == 1){
			$this->db->query("UPDATE ms_pegawai SET foto='$NamaFoto' WHERE id='$id'");
			}
		}
		else
		{
			$result = $this->Pegawai_model->update(array('id' => $post['id']), $data);
			$id=$post['id'];
			if($f == 1){
			$this->db->query("UPDATE ms_pegawai SET foto='$NamaFoto' WHERE id='$id'");
			}
		}
		
		if(!empty($post['pendidikan']))
			{
				$value = $post['pendidikan'];
				foreach($value['id'] as $index=>$val)
				{
					$pendidikan['id'] = $value['id'][$index];
					$pendidikan['jenis_sekolah'] = $value['jenis_sekolah'][$index];
					$pendidikan['nama_sekolah'] = $value['nama_sekolah'][$index];
					$pendidikan['id_pegawai'] = $id;
					$pendidikan['jurusan'] = $value['jurusan'][$index];
					$pendidikan['tahun_lulus'] = $value['tahun_lulus'][$index];
					$pendidikan_batch[] = $pendidikan;
				}
				
				$this->db->replace_batch('pegawai_pendidikan',$pendidikan_batch);		
			}
					
		if(!empty($post['keluarga']))
			{
				$value = $post['keluarga'];
				foreach($value['id'] as $index=>$val)
				{
					$keluarga['id'] = $value['id'][$index];
					$keluarga['nama'] = $value['nama'][$index];
					$keluarga['jk'] = $value['jk'][$index];
					$keluarga['id_pegawai'] = $id;
					$keluarga['jenis_keluarga'] = $value['jenis_keluarga'][$index];
					$keluarga_batch[] = $keluarga;
				}
				
				$this->db->replace_batch('pegawai_keluarga',$keluarga_batch);		
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
			$menu=explode(',',$post['menu']);
			foreach($menu as $row){
					
				$this->db->where("username",$post['username']);
				$this->db->delete("sys_akses_menu");
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
			if(element('password',$post) != ""){
			$this->db->where('id',$post['id_user']);
			$result = $this->db->update('ms_user',$user);
			$login['username']=element('username',$post);
			$login['password']=md5(element('password',$post));
			$login['id_jenis_user']=3;
			$this->db->where('id_user',$post['id_user']);
			$this->db->update('sys_login',$login);
			}
			$this->db->where('username',element('username',$post));
			if($this->db->delete('sys_akses_menu')){
				foreach($post['menu'] as $row){
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

		$query = $this->Pegawai_model->data_excel("ms_pegawai");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Pegawai_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_pegawai',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Pegawai","I"); 
	}

		
}
?>
