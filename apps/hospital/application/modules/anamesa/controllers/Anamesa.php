<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Anamesa Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Anamesa extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Anamesa_model');
		$config['table'] = 'trs_anamesa';
		$config['column_order'] = array(
			null,
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_cara_bayar.nama',
			'ms_jenis_appointment.nama',
			'ms_poliklinik.nama',
			'trs_anamesa.add_time',
			'trs_anamesa.status',
			null
		);
		
		$config['column_search'] = array(
			'trs_anamesa.id',
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_anamesa.add_time'
		);
		$config['column_excel'] = array(
			'ms_pasien.rm as RM',
			'ms_pasien.nama_lengkap as Nama_Lengkap',
			'ms_cara_bayar.nama as Cara_Bayar',
			'ms_poliklinik.nama as Poliklinik',
			'date_format(trs_anamesa.add_time,"%d %b %Y %H:%i") as Tanggal_Daftar'
		);
		$config['column_pdf'] = array(
			'trs_anamesa.id',
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_cara_bayar.nama as cara_bayar',
			'ms_poliklinik.nama as poliklinik',
			'trs_anamesa.add_time'
		);
		$config['order'] = array('trs_anamesa.status' => 'ASC','trs_anamesa.last_update' => 'DESC');
		$this->Anamesa_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Anamesa';
		$data['id_table'] = 'anamesa';
		$data['datatable_list'] = 'anamesa/ajax_list';
		$data['datatable_edit'] = 'anamesa/ajax_edit';
		$data['datatable_delete'] = 'anamesa/ajax_delete';
		$data['datatable_save'] = 'anamesa/ajax_save';
		
		
		$data['dokter'] = $this->db->select('id,nip,nama')->where('jenis_pegawai','dokter')->get('ms_pegawai')->result_array();
	//	$data['load_form'] = $this->load_form($data);
		$this->template->display('anamesa',$data);
    }
	
	function addanamesa($id=0){
		$data['row']=array();
		if($id != 0){
		$data['row'] =$ana= $this->db->select('
			trs_anamesa.*
		')
		->where('trs_anamesa.id',$id)
		->get('trs_anamesa')->row_array();
		
		$app_before=$this->db->query("SELECT id_appointment_before FROM  trs_appointment WHERE id='".$ana['id_appointment']."'")->row_array();
		$data['dokter_pengirim']=$this->db->query("SELECT a.id,a.id_dokter,a.keterangan,b.nama,d.nama as nama_poli FROM  trs_anamesa a,ms_dokter b,trs_appointment c,ms_poliklinik d WHERE c.id=a.id_appointment AND d.id=c.id_poliklinik AND a.id_dokter=b.id AND a.id_appointment='".$app_before['id_appointment_before']."'")->row_array();
		
		}
		$data['id']=$id;
		$data['konsultasi_pengirim'] = $this->db->select('trs_billing.id_komponen as komponen')
				  ->join('trs_appointment','trs_billing.id_appointment = trs_appointment.id','inner')
				  ->join('trs_anamesa','trs_anamesa.id_appointment = trs_appointment.id','inner')
				  ->where('trs_anamesa.id',$id)
				  ->get('trs_billing')->row_array();
				  
		$data['komponen_anamesa'] = $this->db->get('ms_komponen_anamesa')->result_array();
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$w=" AND FIND_IN_SET('$otoritas',id_poliklinik)";
			
			}else{
				$w='';
			}
		$data['id_dokter']=$this->db->query('SELECT * FROM ms_pegawai WHERE jenis_pegawai="dokter" '.$w)->result();
		$this->load->view('form_anamesa',$data);
	}
	
		public function catatan_dokter_blank()
	{
		$this->load->library("Fpdf"); 
		$data=array();
        $this->load->view('catatan_dokter', $data);
	}
	
    public function load_form($data)
	{
		$data['komponen_anamesa'] = $this->db->get('ms_komponen_anamesa')->result_array();
		return $this->load->view('form_anamesa',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Anamesa_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $no;
			
			$fields[] = $row->rm;
			$fields[] = $row->nama_lengkap;
			$fields[] = $row->cara_bayar;
			$fields[] = $row->jenis_appointment;
			$fields[] = $row->poliklinik;
			$fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			$fields[] = ($row->status == 1)?'<i class="label label-success">Sudah</i>':'<i class="label label-danger">Belum</i>';
			$fields[] = '
				<button type="button" onclick="addmodal('.$row->id.')" class="btn btn-default"> <i class="flaticon-clinic-history-medical-paper-on-clipboard"></i> Anamesa</button>
			';
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Anamesa_model->count_all(),
			"recordsFiltered" => $this->Anamesa_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$data_object = $this->db->select('
			trs_anamesa.id,
			trs_anamesa.keterangan
		')
		->where('trs_anamesa.id',$post['id'])
		->get('trs_anamesa')->row_array();
		
		$data_object_detail = $this->db->select('
			trs_anamesa_detail.id_anamesa,
			trs_anamesa_detail.id_ms_anamesa,
			trs_anamesa_detail.hasil
		')
		->where('trs_anamesa_detail.id_anamesa',$post['id'])
		->get('trs_anamesa_detail')->result_array();
		
		$result['data'] = $data_object;
		$result['detail'] = $data_object_detail;
		
		echo json_encode($result);
	}

	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data['id_dokter'] = $post['id_dokter'];
		$data['keterangan'] = $post['keterangan'];
		$data['nama_perawat'] = $this->session->userdata('username');
		$data['status'] = 1;
		
		$header_anamesa = $this->db->where('id',element('id',$post))->update('trs_anamesa',$data);
		
		if($header_anamesa)
		{
			$data_detail['id_anamesa'] = element('id',$post);
			foreach($post['komponen'] as $id_komponen => $hasil)
			{
				$data_detail['id_ms_anamesa'] = $id_komponen;
				$data_detail['hasil'] = $hasil;
				
				$data_detail_batch[] = $data_detail;
			}
			$this->db->replace_batch('trs_anamesa_detail',$data_detail_batch);
		}
		
		$cek_konsultasi = $this->db->select('id')->where('id_anamesa',element('id',$post))->get('trs_konsultasi')->row_array();
		
		if(empty($cek_konsultasi['id']))
		{
			$data_konsultasi['catatan']=$data['keterangan'];
			$data_konsultasi['id_anamesa'] = element('id',$post);
			$this->db->insert('trs_konsultasi',$data_konsultasi);
		}else{
			$data_konsultasi['catatan']=$data['keterangan'];
			$data_konsultasi['id_anamesa'] = element('id',$post);
			$this->db->where("id",$cek_konsultasi['id']);
			$this->db->update('trs_konsultasi',$data_konsultasi);
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
		$this->Anamesa_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");
		
		$get = $this->input->get(NULL,TRUE);

		$query = $this->Anamesa_model->data_excel($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$get = $this->input->get(NULL,TRUE);
		
		$query = $this->Anamesa_model->data_pdf($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_anamesa',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Anamesa","I"); 
	}
}
?>
