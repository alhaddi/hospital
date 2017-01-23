<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Kepegawaian Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepegawaian extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
		$data['link_save'] = 'kepegawaian/ajax_save';
		$data['id_table'] = 'kepegawaian';
		$this->display('form_kepegawaian',$data);
    }
	
    public function ajax_list()
	{	
		$list = $this->Kepegawaian_model->get_datatables();
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
			 $fields[] = ($row->jk == 'L')?'Laki-laki':'Perempuan';
			 $fields[] = (!empty($row->usia))?$row->usia." Tahun":'-Belum isi-';
			 $fields[] = $row->hp;
			 $fields[] = $row->alamat;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			 $fields[] = convert_tgl($row->last_update,'d M Y H:i',1);
			 $fields[] = $this->session->userdata('username');
			
			$tgl = convert_tgl($row->arrived_at,'Y-m-d');
			$poli = ($tgl != date('Y-m-d'))?'<button onclick="modal_poli('.$row->id.')" type="button" class="btn btn-default" rel="tooltip" title="Daftar ke Poliklinik"><img src="'.FILES_HOST.'img/panah.png"></button>':'';
			$t="";
				$t='<button data-action="modal" data-modal-type="alert_load" data-modal-header="Riwayat Kepegawaian" data-modal-content="'.site_url('kepegawaian/history_poli/'.$row->id).'" type="button" class="btn btn-default" rel="tooltip" title="Riwayat Kepegawaian"><i class="fa fa-history"></i></button> '.$poli;
			$fields[] = '
				<a href="'.site_url('kepegawaian/pendaftaran/'.$row->id.'?p='.$p).'" class="btn btn-default" rel="tooltip" title="Ubah data"><i class="fa fa-pencil"></i></a>
				<a href="'.site_url('kepegawaian/kartu_kepegawaian/'.$row->id).'" target="_blank" class="btn btn-default" rel="tooltip" title="Cetak Kartu"><i class="fa fa-credit-card"></i></a>		
			 '.$t;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Kepegawaian_model->count_all(),
			"recordsFiltered" => $this->Kepegawaian_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}
	
	function history_poli($id_kepegawaian){
		
		$body = $this->db
			->select('ms_poliklinik.nama as nama_poliklinik,ms_cara_bayar.nama as nama_cara_bayar,ms_jenis_appointment.nama as jenis_appointment,trs_appointment.add_time')
			->where('trs_appointment.id_kepegawaian',$id_kepegawaian)
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
		$data['id_table'] = 'kepegawaian';
		$data['link_save'] = 'kepegawaian/save/';
		$data['p']=$p;
		$data['agama'] = $this->db->order_by('id','asc')->get('ms_agama')->result_array();
		$data['pekerjaan'] = $this->db->get('ms_pekerjaan')->result_array();
		$data['dokter'] = $this->db->select('id,nip,nama')->get('ms_dokter')->result_array();
		
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['cara_bayar'] = $a = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
		$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
		$kepegawaian = $this->db->where('id',$id)->get('ms_kepegawaian')->row_array();
		if(!empty($kepegawaian))
		{
			$kepegawaian['tanggal_lahir'] = convert_tgl(element('tanggal_lahir',$kepegawaian),'d/m/Y');
		}
		else
		{
			$kepegawaian = array();
		}
			$data['kepegawaian'] = $kepegawaian;
		
		$penanggung_jawab = $this->db->where('id_kepegawaian',$id)->get('ms_penanggung_jawab')->result_array();
		$data['penanggung_jawab'] = $penanggung_jawab;
		
		$poliklinik_kepegawaian = $this->db->where('id_kepegawaian',$id)->get('trs_appointment')->result_array();
		$data['poliklinik_kepegawaian'] = $poliklinik_kepegawaian;
		
		$this->display('form_kepegawaian',$data);
    }
	
	public function save(){
		$post = $this->input->post(NULL,TRUE);
		
		$auto_rm = $this->db->query("SELECT ifnull((MAX(rm)+1),1) as auto_rm FROM `ms_kepegawaian`")->row_array();
		
		
		$rm							= (empty($post['auto_rm']))?element('rm',$post):element('auto_rm',$auto_rm);
		$kepegawaian['rm']				= str_pad($rm, 8, "0", STR_PAD_LEFT); 
		$kepegawaian['id_agama']			= element('id_agama',$post);
		$kepegawaian['id_pekerjaan']		= element('id_pekerjaan',$post);
		$kepegawaian['nama_lengkap']		= element('nama_lengkap',$post);
		$kepegawaian['tipe_identitas']	= element('tipe_identitas',$post);
		$kepegawaian['no_identitas']		= element('no_identitas',$post);
		$kepegawaian['jk']				= element('jk',$post);
		$kepegawaian['tempat_lahir']		= get_field(element('tempat_lahir',$post),'wilayah','name');
		$kepegawaian['tanggal_lahir'] 	= convert_tgl(element('tanggal_lahir',$post),'Y-m-d');
		$kepegawaian['usia']				= element('usia',$post);
		$kepegawaian['status_menikah']	= element('status_menikah',$post);
		$kepegawaian['nama_orangtua']	= element('nama_orangtua',$post);
		$kepegawaian['asal_kepegawaian']		= element('asal_kepegawaian',$post);
		$kepegawaian['no_rujukan']		= element('no_rujukan',$post);
		$kepegawaian['rujukan_dari']		= element('rujukan_dari',$post);
		$kepegawaian['hp']				= element('hp',$post);
		$kepegawaian['tlp']				= element('tlp',$post);
		$kepegawaian['email']			= element('email',$post);
		$kepegawaian['alamat']			= element('alamat',$post);
		$kepegawaian['rt']				= element('rt',$post);
		$kepegawaian['rw']				= element('rw',$post);
		$kepegawaian['id_wilayah']		= element('id_wilayah',$post);
		$kepegawaian['kelurahan']		= element('kelurahan',$post);
		$kepegawaian['nama_ayah']		= element('nama_ayah',$post);
		$kepegawaian['golongan_darah']	= element('golongan_darah',$post);
		$kepegawaian['telp_emergency']	= element('telp_emergency',$post);
		$kepegawaian['IC_Number']		= element('IC_Number',$post);
		
		$kepegawaian = array_string_to_null($kepegawaian);
		
		$cek = $this->db->select('id')
		->where('nama_lengkap',$kepegawaian['nama_lengkap'])
		->where('rm',$kepegawaian['rm'])
		->where('id !=',element('id',$post))
		->get('ms_kepegawaian')->row_array();
		
		if(!empty($cek['id']))
		{
			$response = array(
				'status' => false,
				'message' => 'Terjadi duplicate entry kepegawaian dengan data yang sama <br> RM : '.element('rm',$post).'<br> Nama : '.element('nama_lengkap',$post),
			);
			die(json_encode($response));
		}
		
		$this->db->trans_start();
		
		if(empty($post['id']))
		{
			if($this->db->insert('ms_kepegawaian',$kepegawaian))
			{
				$success_kepegawaian = 1;
				$id_kepegawaian = $this->db->insert_id();
			}
		}
		else
		{
			if($this->db->where('id',$post['id'])->update('ms_kepegawaian',$kepegawaian))
			{
				$success_kepegawaian = 1;
				$id_kepegawaian = $post['id'];
			}
		}
		
		if($success_kepegawaian = 1)
		{
			foreach($post['penanggung_jawab'] as $pj){
				if(!empty($pj['id'])){
					$ps = $this->db->where('id',$pj['id'])->get('ms_kepegawaian')->row_array();
					$pj['nama'] = $ps['nama_lengkap'];
					$pj['rm'] = $ps['rm'];
					$pj['type'] = 1;
				}
				else
				{
					$pj['type'] = 2;
					$pj['rm'] = '';
				}
				$pj['id_kepegawaian'] = $id_kepegawaian;
				
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
						$poliklinik['id_kepegawaian'] = $id_kepegawaian;
						$this->_save_poliklinik_kepegawaian($poliklinik);
					}			
				}
				if($success_kepegawaian > 0) {
					$response = array(
						'status' => true,
						'message' => 'Kepegawaian baru dengan nama '.element('nama_lengkap',$post).' telah berhasil di tambahkan',
						'redirect' => site_url('kepegawaian')
					);
					die(json_encode($response));
				}
			}
			
			
		}
		
		
		
	}
    
	public function poliklinik_kepegawaian(){
		$post = $this->input->post(NULL,TRUE);
		$poliklinik_kepegawaian = $this->db->where('id_kepegawaian',$post['id'])->order_by('add_time','desc')->get('trs_appointment')->row_array();
		$poliklinik_kepegawaian['id_kepegawaian'] = $post['id'];
		if($poliklinik_kepegawaian){
			$poliklinik_kepegawaian = array_filter($poliklinik_kepegawaian);
		}
		echo json_encode($poliklinik_kepegawaian);
		
	}
	
	public function save_poliklinik_kepegawaian(){
		$post = $this->input->post(NULL,TRUE);
		if($this->_save_poliklinik_kepegawaian($post))
		{
			echo json_encode(array("status" => TRUE));
		}
	}
	
	private function _save_poliklinik_kepegawaian($post){
		
		$this->db->trans_start();
		$p=element('id_jenis_appointment',$post);
			$insert['id_kepegawaian'] = element('id_kepegawaian',$post);
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
			$this->db->where('id',element('id_kepegawaian',$post))->update('ms_kepegawaian',array('arrived_at'=>date('Y-m-d H:i:s')));
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
		$this->Kepegawaian_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$get = $this->input->get(NULL,TRUE);
		$this->load->library("Excel");

		$query = $this->Kepegawaian_model->data_excel($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$get = $this->input->get(NULL,TRUE);
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Kepegawaian_model->data_pdf($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_kepegawaian',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Kepegawaian","I"); 
	}
	
	public function kartu_kepegawaian($id)
	{
		$this->load->library("Fpdf"); 
		$this->load->library("Ciqrcode");
		$data['identitas'] = $this->db->get('ms_identitas')->row_array();
		$data['kepegawaian'] = $kepegawaian = $this->db
			->where('id',$id)
			->get('ms_kepegawaian')->row_array();
		$path = FILES_PATH.'/img/QR';
		//QRcode($kepegawaian['rm'],$path);
        $this->load->view('kartu_kepegawaian', $data);
	}
	
	function select2_kepegawaian()
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
		$query = $this->db->get('ms_kepegawaian',$limit,$offset)->result();
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
				'text' => 'Kepegawaian tidak ditemukan.'
			);
		}
		
		$this->db->select('count(id) as jml',false);
		$query = $this->db->get('ms_kepegawaian',$limit,$offset)->row();
		
		$result['total_count'] = $query->jml;
		$result['items'] = $data;
		// return the result in json
		echo json_encode($result);
	}
}
?>
