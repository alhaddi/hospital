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

class Penunjang extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pasien_model');
		$this->load->model('billing/Billing_model');
		$config['table'] = 'ms_pasien';
		$config['column_order'] = array(null,'rm','nama_lengkap','no_identitas','ms_cara_bayar.nama','jk','usia','hp','alamat','ms_pasien.add_time','ms_pasien.last_update','ms_pasien.last_user',null);
		$config['column_search'] = array('rm','nama_lengkap','no_identitas','ms_cara_bayar.nama','jk','usia','hp','alamat','ms_pasien.add_time','ms_pasien.last_update','ms_pasien.last_user');
		$config['column_excel'] = array('rm','id_agama','id_pekerjaan','nama_lengkap','tipe_identitas','no_identitas','jk','tempat_lahir','tanggal_lahir','usia','status_menikah','nama_orangtua','asal_pasien','no_rujukan','rujukan_dari','hp','tlp','email','alamat','rt','rw','id_wilayah','kelurahan','arrived_at','status');
		$config['column_pdf'] = array('rm','id_agama','id_pekerjaan','nama_lengkap','tipe_identitas','no_identitas','jk','tempat_lahir','tanggal_lahir','usia','status_menikah','nama_orangtua','asal_pasien','no_rujukan','rujukan_dari','hp','tlp','email','alamat','rt','rw','id_wilayah','kelurahan','arrived_at','status');
		$config['order'] = array('rm' => 'DESC');
		$this->Pasien_model->initialize($config);
    }

    public function index()
    {
		$data['id_jenis_appointment'] = $p = $this->input->get('p');
		$data['title'] = 'penunjang';
		$data['id_table'] = 'penunjang';
		$data['datatable_list'] = 'penunjang/ajax_list/'.$p;
		$data['datatable_edit'] = 'penunjang/ajax_edit';
		$data['datatable_delete'] = 'penunjang/ajax_delete';
		
		$data['cara_bayar'] = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['dokter'] = $this->db->get('ms_dokter')->result_array();
		$id_user=$this->session->userdata("id_user");
		$penunjang=get_field($id_user,'ms_user','id_penunjang');
		$w=" id IN ($penunjang)";
		$this->db->where($w);
		$data['ms_penunjang'] = $this->db->get('ms_penunjang')->result_array();
		
		$this->display('pasien',$data);
    }
	
    public function load_kategori(){
		@extract($_POST);
		$var=$this->db->query("SELECT id,nama,kelompok FROM ms_kategori_penunjang WHERE id_ms_penunjang='$id_ms_penunjang'")->result();
		$multiple=(get_field($id_ms_penunjang,'ms_penunjang','multiple') == 1)?'multiple':'';
		$opt="";
		$check="<br><div class='row-fluid'>";
		$kel="";
		$n=1;
		foreach($var as $r){
			$opt.= "<option value='$r->id'>$r->nama</option>";
			
			if($n == 1){ $s="<h4>$r->kelompok</h4>"; $kel=$r->kelompok;}
			
			$check.= $s.'<div class="col-md-12"><input data-checkbox-kategori="true" name="kategori[]" id="label'.$r->id.'" value="'.$r->id.'" type="checkbox"> <label for="label'.$r->id.'">'.$r->nama.'</label></div>';
			if($kel == $r->kelompok){
				$s="";
			}else{
				 $s="<hr><h4>$r->kelompok</h4>"; $kel=$r->kelompok;
			}
			$n++;
		}
		if(get_field($id_ms_penunjang,'ms_penunjang','multiple') == 1){
		echo '<label for="textfield" class="control-label">Kategori Penunjang</label>';
		echo "<div style='height:300px; overflow:auto;'>".$check."</div><br></div>";
		}else{
			$style=(count($var) > 1)?'':' style="display:none;"';
		echo '<label for="textfield" '.$style.' class="control-label">Kategori Penunjang</label>';
		echo '<select name="kategori[]" '.$style.' '.$multiple.' class="form-control" id="kategori" data-rule-required="true" >'.$opt.'</select>';
		}

	}
	
    public function save_penunjang(){
		$post = $this->input->post(NULL,TRUE);
		$penunjang['id_ms_penunjang'] = element('id_ms_penunjang',$post);
		$penunjang['id_pasien'] = element('id_pasien',$post);
		$penunjang['klinis'] = element('klinis',$post);
		$penunjang['id_dokter'] = element('id_dokter',$post);
		$penunjang['nama_dokter'] = element('nama_dokter',$post);
		$penunjang['kategori'] = implode(',',$this->input->post('kategori'));
		$penunjang['biaya'] = rupiah_to_number(element('biaya',$post));
		$penunjang['jumlah'] = 1;
		$penunjang['id_konsultasi'] = "";
		$penunjang['keterangan'] = "";
		$this->db->insert("trs_penunjang",$penunjang);
		$pen=$this->db->insert_id();
			$insert['id_pasien'] = element('id_pasien',$post);
			$insert['id_cara_bayar'] =1;
			$insert['id_jenis_appointment'] =1;
			$insert['id_poliklinik'] = element('id_poliklinik',$post);			
			$this->db->insert('trs_appointment',$insert);
			
			$id_appointment = $this->db->insert_id();

				$no_tagihan = $this->Billing_model->no_tagihan();

					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_penunjang'] =$pen;
					$insert_tagihan['id_ms_penunjang'] =get_field($pen,'trs_penunjang','id_ms_penunjang');
					$insert_tagihan['id_komponen'] = 5;
					$insert_tagihan['nominal'] = rupiah_to_number(element('biaya',$post));
					$this->db->insert('trs_billing',$insert_tagihan);
		
		echo json_encode(array("status" => TRUE));
	}
	
    public function ajax_list($p="")
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
			 $fields[] = $row->tipe_identitas.' '.$row->no_identitas;
			 $fields[] = '';//$row->cara_bayar;
			 $fields[] = ($row->jk == 'L')?'Laki-laki':'Perempuan';
			 $fields[] = (!empty($row->usia))?$row->usia." Tahun":'-Belum isi-';
			 $fields[] = $row->hp;
			 $fields[] = $row->alamat;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			 $fields[] = convert_tgl($row->last_update,'d M Y H:i',1);
			 $fields[] = $this->session->userdata('username');
			
			$tgl = convert_tgl($row->arrived_at,'Y-m-d');
			$poli = '<button onclick="modal_poli('.$row->id.')" type="button" class="btn btn-default" rel="tooltip" title="Daftar ke Penunjang"><i class="fa fa-sign-in"></i></button>';

			$fields[] = $poli;
			
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
	
	public function pendaftaran($id="")
    {
		$p = $this->input->get('p');
		
		$data['title'] = 'Pendaftaran';
		$data['id_table'] = 'pasien';
		$data['link_save'] = 'pasien/save/'.$p;
		$data['p']=$p;
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$data['pekerjaan'] = $this->db->get('ms_pekerjaan')->result_array();
		
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
		
		$this->display('form_pasien',$data);
    }
	
	public function save($p){
		$post = $this->input->post(NULL,TRUE);
		
		$auto_rm = $this->db->query("SELECT ifnull((MAX(rm)+1),1) as auto_rm FROM `ms_pasien`")->row_array();
		
		
		$rm							= (empty($post['auto_rm']))?element('rm',$post):element('auto_rm',$auto_rm);
		$pasien['rm']				= str_pad($rm, 8, "0", STR_PAD_LEFT); 
		$pasien['id_agama']			= element('id_agama',$post);
		$pasien['id_pekerjaan']		= element('id_pekerjaan',$post);
		$pasien['nama_lengkap']		= element('nama_lengkap',$post);
		$pasien['tipe_identitas']	= element('tipe_identitas',$post);
		$pasien['no_identitas']		= element('no_identitas',$post);
		$pasien['jk']				= element('jk',$post);
		$pasien['tempat_lahir']		= element('tempat_lahir',$post);
		$pasien['tanggal_lahir'] 	= convert_tgl(element('tanggal_lahir',$post),'Y-m-d');
		$pasien['usia']				= element('usia',$post);
		$pasien['status_menikah']	= element('status_menikah',$post);
		$pasien['nama_orangtua']	= element('nama_orangtua',$post);
		$pasien['asal_pasien']		= element('asal_pasien',$post);
		$pasien['no_rujukan']		= element('no_rujukan',$post);
		$pasien['rujukan_dari']		= element('rujukan_dari',$post);
		$pasien['hp']				= element('hp',$post);
		$pasien['tlp']				= element('tlp',$post);
		$pasien['email']			= element('email',$post);
		$pasien['alamat']			= element('alamat',$post);
		$pasien['rt']				= element('rt',$post);
		$pasien['rw']				= element('rw',$post);
		$pasien['id_wilayah']		= element('id_wilayah',$post);
		$pasien['kelurahan']		= element('kelurahan',$post);
		
		$pasien = array_string_to_null($pasien);
		
		$cek = $this->db->select('id')
		->where('nama_lengkap',$pasien['nama_lengkap'])
		->where('tanggal_lahir',$pasien['tanggal_lahir'])
		->where('id !=',element('id',$post))
		->get('ms_pasien')->row_array();
		
		if(!empty($cek['id']))
		{
			$response = array(
				'status' => false,
				'message' => 'Terjadi duplicate entry pasien dengan data yang sama <br> Nama : '.element('nama_lengkap',$post).'<br> Tanggal Lahir : '.element('tanggal_lahir',$post),
			);
			die(json_encode($response));
		}
		
		$this->db->trans_start();
		
		if(empty($post['id']))
		{
			if($this->db->insert('ms_pasien',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $this->db->insert_id();
			}
		}
		else
		{
			if($this->db->where('id',$post['id'])->update('ms_pasien',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $post['id'];
			}
		}
		
		if($success_pasien = 1)
		{
			foreach($post['penanggung_jawab'] as $pj){
				if(!empty($pj['id'])){
					$ps = $this->db->where('id',$pj['id'])->get('ms_pasien')->row_array();
					$pj['nama'] = $ps['nama_lengkap'];
					$pj['rm'] = $ps['rm'];
					$pj['type'] = 1;
				}
				else
				{
					$pj['type'] = 2;
					$pj['rm'] = '';
				}
				$pj['id_pasien'] = $id_pasien;
				
				if(!empty($pj['nama'])){
					$penanggung_jawab[] = $pj;
				}
			}
			
			if(!empty($penanggung_jawab)){
				$this->db->replace_batch('ms_penanggung_jawab',$penanggung_jawab);
			}
			
			
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
				if(empty($post['id'])){
					foreach($post['poliklinik'] as $index_poli=>$value_poli){
						$poliklinik[$index_poli] = $value_poli;
					}
					if(!empty($poliklinik)){
						$poliklinik['id_pasien'] = $id_pasien;
						$poliklinik['id_jenis_appointment'] = $p;
						$this->_save_poliklinik_pasien($poliklinik);
					}			
				}
				if($success_pasien > 0) {
					$response = array(
						'status' => true,
						'message' => 'Pasien baru dengan nama '.element('nama_lengkap',$post).' telah berhasil di tambahkan',
						'redirect' => site_url('pasien').'?p='.$p
					);
					die(json_encode($response));
				}
			}
			
			
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
					$insert_tagihan['nominal'] = element('biaya',$komponen);
					$this->db->insert('trs_billing',$insert_tagihan);
					}else{
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = $p;
					$insert_tagihan['nominal'] = ($insert['id_cara_bayar'] == 2)?0:get_field($p,'ms_komponen_registrasi','nominal');
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
		$this->load->library("Excel");

		$query = $this->Pasien_model->data_excel("pasien");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Pasien_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_pasien',$data,true);
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
