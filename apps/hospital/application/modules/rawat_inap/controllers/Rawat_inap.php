<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Pasien Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Rawat_inap extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pasien_model');
		$this->load->model('billing/Billing_model');
		$config['table'] = 'ms_rawat_inap';
		$config['column_order'] = array(null,null,'rm','nama_lengkap','no_identitas','jk','usia','hp','alamat','add_time','last_update','last_user',null);
		$config['column_search'] = array('rm','nama_lengkap','usia','alamat','ruang_rawat','tgl_keluar','add_time','last_update','last_user');
		$config['order'] = array('last_update' => 'DESC');
		$this->Pasien_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Pasien';
		$data['id_table'] = 'ms_rawat_inap';
		$data['datatable_list'] = 'rawat_inap/ajax_list';
		$data['datatable_edit'] = 'rawat_inap/ajax_edit';
		$data['datatable_delete'] = 'rawat_inap/ajax_delete';
		
		$data['cara_bayar'] = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
		$data['cara_keluar'] = $this->db->get('ms_cara_keluar')->result_array();
		
		$data['load_form'] = $this->load->view('form_keluar',$data);
		
		$this->display('pasien',$data);
    }
	
    public function ajax_list()
	{	
		$list = $this->Pasien_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->rm;
			 $fields[] = $row->nama_lengkap;
			 $fields[] = (!empty($row->usia))?$row->usia." Tahun":'-Belum isi-';
			 $fields[] = $row->alamat;
			 $fields[] = $row->ruang_rawat;
			 $fields[] = ($row->status != '0')?convert_tgl($row->tgl_keluar,'d M Y',1):'';
			
			$tgl = convert_tgl($row->arrived_at,'Y-m-d');
			
			$pasien = '<a href="'.site_url('rawat_inap/pendaftaran/'.$row->id).'" class="btn btn-default" rel="tooltip" title="Ubah data"><i class="fa fa-pencil"></i></a>	<a href="'.site_url('rawat_inap/lihat/'.$row->id).'" class="btn btn-default" rel="tooltip" title="Lihat">Lihat</a> ';
			
			if($row->status == '0'){
				$pasien .= '<a href="#" onclick="modal_pulang('.$row->id.')" class="btn btn-default" rel="tooltip" title="Pasien Pulang"><i class="fa fa-sign-in"></i></a>';
			}
			
			$fields[] = $pasien;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pasien_model->count_all(),
			"recordsFiltered" => $this->Pasien_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}
	
		public function insert_ri($id="")
    {
		$data['title'] = 'Pendaftaran';
		$data['id_table'] = 'trs_rawat_inap';
		$data['link_save'] = 'rawat_inap/save_ri/';
		
		$this->display('form_pasien_ri',$data);
    }
	
		public function load_pasien()
    {
		$id=$this->input->post('id_pasien');
		$data['p']='2';
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$data['pekerjaan'] = $this->db->get('ms_pekerjaan')->result_array();
		$data['dokter'] = $this->db->select('id,nip,nama')->get('ms_dokter')->result_array();
		
		$data['kamar'] = $this->db->get('ms_kamar')->result_array();
		$data['ruang'] = $this->db->get('ms_ruang')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['cara_bayar'] = $a = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
		$pasien = $this->db->where('id',$id)->get('ms_pasien')->row_array();
		if(!empty($pasien))
		{
			$pasien['tanggal_lahir'] = convert_tgl(element('tanggal_lahir',$pasien),'d/m/Y');
		}
		else
		{
			$pasien = array();
		}
			$data['pasien'] = $pasien;
		
		$penanggung_jawab = $this->db->where('id_pasien',$id)->get('ms_penanggung_jawab')->result_array();
		$data['penanggung_jawab'] = $penanggung_jawab;
		
		$poliklinik_pasien = $this->db->where('id_pasien',$id)->get('trs_appointment')->result_array();
		$data['poliklinik_pasien'] = $poliklinik_pasien;
		
		$this->load->view('load_pasien',$data);
    }
	
	function save_ri(){
		
		$post = $this->input->post(NULL,TRUE);
		


		$pasien['id_agama']			= element('id_agama',$post);
		$pasien['id_pekerjaan']		= element('id_pekerjaan',$post);
		$pasien['nama_lengkap']		= element('nama_lengkap',$post);
		$pasien['tipe_identitas']	= element('tipe_identitas',$post);
		$pasien['no_identitas']		= element('no_identitas',$post);
		$pasien['jk']				= element('jk',$post);
		$pasien['tempat_lahir']		= get_field(element('tempat_lahir',$post),'wilayah','name');
		$pasien['tanggal_lahir'] 	= convert_tgl(element('tanggal_lahir',$post),'Y-m-d');
		if(element('kate_usia',$post) == 'tahun'){
			$pasien['usia_thn']				= element('usia',$post);
		}else if(element('kate_usia',$post) == 'bulan'){
			$pasien['usia_bln']				= element('usia',$post);
		}else{
			$pasien['usia_hari']			= element('usia',$post);
		}
		$pasien['status_menikah']	= element('status_menikah',$post);
		$pasien['hp']				= element('hp',$post);
		$pasien['tlp']				= element('tlp',$post);
		$pasien['email']			= element('email',$post);
		$pasien['alamat']			= element('alamat',$post);
		$pasien['rt']				= element('rt',$post);
		$pasien['rw']				= element('rw',$post);
		$pasien['id_wilayah']		= element('id_wilayah',$post);
		$pasien['kelurahan']		= element('kelurahan',$post);
		$pasien['golongan_darah']	= element('golongan_darah',$post);
		
		$pasien = array_string_to_null($pasien);
			if($this->db->where('id',$post['id'])->update('ms_pasien',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $post['id'];
			}
		
		$auto_rawat = $this->db->query("SELECT ifnull((MAX(no_rawat)+1),1) as auto_rm FROM `trs_rawat_inap`")->row_array();
		
		$rm								= element('auto_rm',$auto_rawat);
		$insert['no_rawat']				= str_pad($rm, 8, "0", STR_PAD_LEFT); 
		$insert['penanggung_jawab_nama']= element("penanggung_jawab_nama",$post);
		$insert['penanggung_jawab_tlp']	= element("penanggung_jawab_tlp",$post);
		$insert['penanggung_jawab_hp']	= element("penanggung_jawab_hp",$post);
		$insert['id_kamar']				= element("id_kamar",$post);
		$insert['id_ruang']				= element("id_ruang",$post);
		$insert['asal_pasien']			= element('asal_pasien',$post);
		$insert['no_rujukan']			= element('no_rujukan',$post);
		$insert['rujukan_dari']			= element('rujukan_dari',$post);
		$insert['id_pasien'] 			= $post['id'];
		$insert['id_cara_bayar'] 		= element('id_cara_bayar',$post);
		$insert['id_bpjs_type'] 		= element('id_bpjs_type',$post);
		$insert['no_bpjs'] 				= element('no_bpjs',$post);
		$insert['no_polis'] 			= element('no_bpjs',$post);
		$insert['nama_perusahaan'] 		= element('nama_perusahaan',$post);
		$insert = array_filter($insert);
			
			$this->db->insert('trs_rawat_inap',$insert);
		
		
					$response = array(
						'status' => true,
						'message' => 'Pasien dengan nama '.element('nama_lengkap',$post).' telah berhasil di daftarkan.',
						'redirect' => site_url('rawat_inap/insert_ri')
					);
					die(json_encode($response));
		
	}
	
	
	function history_poli($id_pasien){
		
		$body = $this->db
			->select('ms_poliklinik.nama as nama_poliklinik,ms_cara_bayar.nama as nama_cara_bayar,ms_jenis_appointment.nama as jenis_appointment,trs_appointment.add_time')
			->where('trs_appointment.id_pasien',$id_pasien)
			->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
			->join('ms_cara_bayar','ms_cara_bayar.id = trs_appointment.id_cara_bayar','inner')
			->join('ms_jenis_appointment','ms_jenis_appointment.id = trs_appointment.id_jenis_appointment','inner')
			->order_by('trs_appointment.add_time','DESC')
			->get('trs_appointment')->result_array();
		$head = array(
			'nama_poliklinik'=>'Nama Poliklinik',
			'nama_cara_bayar'=>'Cara Bayar',
			'jenis_appointment'=>'Jenis Daftar',
			'add_time'=>'Tanggal'
		);
		
		$config_table['thead'] = $head;
		$config_table['tbody'] = $body;
		$config_table['no'] = 1;
		echo '<div class="table-responsive">'.$this->bootstarp_table($config_table).'</div>';
	}
	
	public function lihat($id="")
    {
		$p = $this->input->get('p');
		
		$data['title'] = 'Pendaftaran';
		$data['id_table'] = 'ms_rawat_inap';
		$data['link_save'] = 'rawat_inap/save/';
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$data['pekerjaan'] = $this->db->get('ms_pekerjaan')->result_array();
		$data['dokter'] = $this->db->select('id,nip,nama')->get('ms_dokter')->result_array();
		
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['cara_bayar'] = $a = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
		$pasien = $this->db->where('id',$id)->get('ms_rawat_inap')->row_array();
		if(!empty($pasien))
		{
			$pasien['tanggal_lahir'] = convert_tgl(element('tanggal_lahir',$pasien),'d/m/Y');
			$pasien['tgl_masuk'] = convert_tgl(element('tgl_masuk',$pasien),'d/m/Y');
			$pasien['tgl_keluar'] = convert_tgl(element('tgl_keluar',$pasien),'d/m/Y');
		}
		else
		{
			$pasien = array();
		}
			$data['pasien'] = $pasien;
		
		$penanggung_jawab = $this->db->where('id_pasien',$id)->get('ms_penanggung_jawab')->result_array();
		$data['penanggung_jawab'] = $penanggung_jawab;
		
		$poliklinik_pasien = $this->db->where('id_pasien',$id)->get('trs_appointment')->result_array();
		$data['poliklinik_pasien'] = $poliklinik_pasien;
		
		$this->display('form_lihat',$data);
    }
	
	public function pendaftaran($id="")
    {
		$p = $this->input->get('p');
		
		$data['title'] = 'Pendaftaran';
		$data['id_table'] = 'ms_rawat_inap';
		$data['link_save'] = 'rawat_inap/save';
		$data['cara_bayar'] = $a = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$pasien = $this->db->where('id',$id)->get('ms_rawat_inap')->row_array();
		if(!empty($pasien))
		{
			$pasien['tanggal_lahir'] = convert_tgl(element('tanggal_lahir',$pasien),'d/m/Y');
			$pasien['tgl_masuk'] = convert_tgl(element('tgl_masuk',$pasien),'d/m/Y');
			$pasien['tgl_keluar'] = convert_tgl(element('tgl_keluar',$pasien),'d/m/Y');
		}
		else
		{
			$pasien = array();
		}
			$data['pasien'] = $pasien;
		
		$penanggung_jawab = $this->db->where('id_pasien',$id)->get('ms_penanggung_jawab')->result_array();
		$data['penanggung_jawab'] = $penanggung_jawab;
		
		$poliklinik_pasien = $this->db->where('id_pasien',$id)->get('trs_appointment')->result_array();
		$data['poliklinik_pasien'] = $poliklinik_pasien;
		
		$this->display('form_pasien',$data);
    }
	
	public function save(){
		$post = $this->input->post(NULL,TRUE);
		
		$pasien['rm']				= element('rm',$post); 
		$pasien['id_pekerjaan']		= element('id_pekerjaan',$post);
		$pasien['nama_lengkap']		= element('nama_lengkap',$post);
		$pasien['jk']				= element('jk',$post);
		$pasien['cara_bayar']		= element('cara_bayar',$post);
		$pasien['cara_masuk']		= element('cara_masuk',$post);
		$pasien['tempat_lahir']		= element('tempat_lahir',$post);
		$pasien['tanggal_lahir'] 	= convert_tgl(element('tanggal_lahir',$post),'Y-m-d');
		$pasien['tgl_masuk'] 		= convert_tgl(element('tgl_masuk',$post),'Y-m-d');
		$pasien['tgl_keluar'] 		= convert_tgl(element('tgl_keluar',$post),'Y-m-d');
		$pasien['usia']				= element('usia',$post);
		$pasien['alamat']			= element('alamat',$post);
		$pasien['ruang_rawat']		= element('ruang_rawat',$post);
		$pasien['cara_keluar']		= element('cara_keluar',$post);
		$pasien['keterangan']		= element('keterangan',$post);
		
		if(element('tgl_keluar',$post) == null){
			$pasien['status'] = 0;
		}
		
		$pasien = array_string_to_null($pasien);
		
		$cek = $this->db->select('id')
		->where('nama_lengkap',$pasien['nama_lengkap'])
		->where('rm',$pasien['rm'])
		->where('id !=',element('id',$post))
		->get('ms_pasien')->row_array();
		
		if(!empty($cek['id']))
		{
			$response = array(
				'status' => false,
				'message' => 'Terjadi duplicate entry pasien dengan data yang sama <br> RM : '.element('rm',$post).'<br> Nama : '.element('nama_lengkap',$post),
			);
			die(json_encode($response));
		}
		
		$this->db->trans_start();
		
		if(empty($post['id']))
		{
			if($this->db->insert('ms_rawat_inap',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $this->db->insert_id();
			}
		}
		else
		{
			if($this->db->where('id',$post['id'])->update('ms_rawat_inap',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $post['id'];
			}
		}
		
		if($success_pasien = 1)
		{
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$response = array(
					'status' => false,
					'message' => 'Terjadi kesalahan'
				);
				die(json_encode($response));
				
			}
			else
			{

				if($success_pasien > 0) {
					$response = array(
						'status' => true,
						'message' => 'Pasien baru dengan nama '.element('nama_lengkap',$post).' telah berhasil di tambahkan',
						'redirect' => site_url('rawat_inap').'?p=1'
					);
					die(json_encode($response));
				}
			}
			
		}
		
	}
	
	public function save_pasien_pulang(){
		$post = $this->input->post(NULL,TRUE);
		$pasien = $this->db->select('nama_lengkap')->where('id',$post['id'])->get('ms_rawat_inap')->row_array();
		if($this->db->where('id',$post['id'])->update('ms_rawat_inap',array('tgl_keluar' => date('Y-m-d'),'status' => 1))){
			$response = array(
				'status' => true,
				'message' => 'Pasien dengan nama '.$pasien['nama_lengkap'].' telah keluar',
				'redirect' => site_url('rawat_inap').'?p=1'
			);
			die(json_encode($response));
		}
	}
    
	public function poliklinik_pasien(){
		$post = $this->input->post(NULL,TRUE);
		$poliklinik_pasien = $this->db->where('id_pasien',$post['id'])->order_by('add_time','desc')->get('trs_appointment')->row_array();
		$poliklinik_pasien['id_pasien'] = $post['id'];
		if($poliklinik_pasien){
			$poliklinik_pasien = array_filter($poliklinik_pasien);
		}
		echo json_encode($poliklinik_pasien);
		
	}
	
	public function save_poliklinik_pasien(){
		$post = $this->input->post(NULL,TRUE);
		if($this->_save_poliklinik_pasien($post))
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	
	private function _save_poliklinik_pasien($post){
		
		$this->db->trans_start();
		$p=element('id_jenis_appointment',$post);
			$insert['id_pasien'] = element('id_pasien',$post);
			$insert['id_jenis_appointment'] = element('id_jenis_appointment',$post);
			$insert['id_poliklinik'] = element('id_poliklinik',$post);
			$insert['id_cara_bayar'] = element('id_cara_bayar',$post);
			$insert['id_bpjs_type'] = element('id_bpjs_type',$post);
			$insert['no_bpjs'] = element('no_bpjs',$post);
			$insert['no_polis'] = element('no_bpjs',$post);
			$insert['nama_perusahaan'] = element('nama_perusahaan',$post);
			$insert['id_dokter'] = element('id_dokter',$post);
			$insert['tgl_pertemuan'] = convert_tgl(element('tgl_pertemuan',$post),'Y-m-d H:i:s');
			$insert = array_filter($insert);
			
			$this->db->insert('trs_appointment',$insert);
			$id_appointment = $this->db->insert_id();
			$this->db->where('id',element('id_pasien',$post))->update('ms_pasien',array('arrived_at'=>date('Y-m-d H:i:s')));
			if( $this->db->affected_rows() > 0 )
			{
				$no_tagihan = $this->Billing_model->no_tagihan();
				
				$komponen = $this->db->select('ms_komponen_registrasi.*')
				->get_where('ms_komponen_registrasi',array('id'=>element('id_komponen',$post)))->row_array();
			if( $insert['id_poliklinik'] == 21 )
			{
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = 5;
					$insert_tagihan['nominal'] = 0;
					$this->db->insert('trs_billing_manual',$insert_tagihan);
			}else{
				
				if(element('id_jenis_appointment',$post) == 2)
				{
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = 2;
					$insert_tagihan['nominal'] = 20000;
					$this->db->insert('trs_billing',$insert_tagihan);
				}
				else{
					if(count($komponen)){
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = element('id',$komponen);
					$insert_tagihan['nominal'] = element('nominal',$komponen);
					
					$this->db->insert('trs_billing',$insert_tagihan);
					}else{
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = $p;
					$insert_tagihan['nominal'] = (element('id_cara_bayar',$post) != '5')?get_field($p,'ms_komponen_registrasi','nominal'):'0';
					
					$this->db->insert('trs_billing',$insert_tagihan);
					} 
				}
			
			}

			}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function ajax_delete()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		if(!is_array($id)){
			$id[] = $id;
		}
		$this->Pasien_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$get = $this->input->get(NULL,TRUE);
		$this->load->library("Excel");

		$query = $this->Pasien_model->data_excel($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$get = $this->input->get(NULL,TRUE);
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		switch($get['p']){
			case '1' : $this->db->where('DATE(ms_rawat_inap.add_time) >=',convert_tgl($get['tgl1'],'Y-m-d'));
					   $this->db->where('DATE(ms_rawat_inap.add_time) <=',convert_tgl($get['tgl2'],'Y-m-d')); 
					   $data['title'] = 'Data Pasien Rawat Inap'; break;
			case '2' : $this->db->where('tgl_masuk',date('Y-m-d')); 
					   $data['title'] = 'Data Pasien Masuk Rawat Inap Hari Ini'; break;
			case '3' : $this->db->where('tgl_keluar',date('Y-m-d')); 
					   $data['title'] = 'Data Pasien Keluar Rawat Inap Hari Ini'; break;
		}
		$query = $this->Pasien_model->data_pdf($get['column_order'],$get['dir_order']);
		$data['query'] = $query;
		$data['header'] = $this->header_file->pdf('100%');
		$content = $this->load->view('pdf_rawat_inap',$data,true);
		$this->chtml2pdf->cetak("L","A4",$content,"Pasien","I"); 
	}
	
	public function kartu_pasien($id)
	{
		$this->load->library("Fpdf"); 
		$this->load->library("Ciqrcode");
		$data['identitas'] = $this->db->get('ms_identitas')->row_array();
		$data['pasien'] = $pasien = $this->db
			->where('id',$id)
			->get('ms_pasien')->row_array();
		$path = FILES_PATH.'/img/QR';
		//QRcode($pasien['rm'],$path);
        $this->load->view('kartu_pasien', $data);
	}
	
	function select2_pasien()
	{
		$search = strip_tags(trim(element('q',$_GET)));
		$page = strip_tags(trim(element('page',$_GET)));
		
		$limit=30;
		$offset=($limit*$page);
		
		$this->db->select('id,rm,nama_lengkap');
		$this->db->group_start();
		$this->db->like('nama_lengkap',$search,'both');
		$this->db->or_like('rm',$search,'both');
		$this->db->group_end();
		$this->db->order_by('nama_lengkap');
		$query = $this->db->get('ms_pasien',$limit,$offset)->result();
		$found=count($query);
		if($found > 0){
			foreach ($query as $key => $value) {
				$data[] = array(
				'id' => $value->id,
				'nama' => $value->nama_lengkap,
				'text' => $value->rm.' | '.$value->nama_lengkap
				);
			}
		} else {
			$data[] = array(
				'id' => '',
				'text' => 'Pasien tidak ditemukan.'
			);
		}
		
		$this->db->select('count(id) as jml',false);
		$query = $this->db->get('ms_pasien',$limit,$offset)->row();
		
		$result['total_count'] = $query->jml;
		$result['items'] = $data;
		// return the result in json
		echo json_encode($result);
	}
}
?>
