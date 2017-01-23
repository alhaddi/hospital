<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Billing Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_manual extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Billing_model');
		$config['table'] = 'trs_billing_manual';
		$config['column_order'] = array(
			null,
			'rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing.id_ms_penunjang',
			'trs_billing.nominal',
			'trs_billing.add_time',
			'trs_billing.status',
			null
		);
		
		
			
		$config['column_search'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing_manual.status',
			'trs_billing_manual.nominal',
			'trs_billing_manual.add_time'
		);
		$config['column_excel'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing_manual.status',
			'trs_billing_manual.nominal',
			'trs_billing_manual.add_time'
		);
		$config['column_pdf'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing_manual.status',
			'trs_billing_manual.nominal',
			'trs_billing_manual.add_time'
		);
		$config['order'] = array('trs_billing_manual.status' => 'ASC','ms_pasien.add_time' => 'Desc');
		$this->Billing_model->initialize($config);
    }

    public function index()
    {
		$p = $this->input->get('p');
		$data['title'] = 'Billing Konsultasi';
		$data['id_table'] = 'billing_manual';
		$data['datatable_list'] = 'billing_manual/ajax_list/'.$p;
		$data['datatable_edit'] = 'billing_manual/ajax_edit';
		$data['datatable_delete'] = 'billing_manual/ajax_delete';
		$data['datatable_save'] = 'billing_manual/ajax_save';
		$data['cara_bayar'] = $this->db->get('ms_cara_bayar')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$data['load_form'] = $this->load_form($data);
		
		$this->template->display('billing',$data);
    }
	
	
    public function load_form($data)
	{
		$data['id_table'] = 'billing_manual';
		$data['jenis_bayar'] = $this->db->get('ms_jenis_bayar')->result_array();
		return $this->load->view('form_billing',$data,true);
	}
	
	public function pembayaran(){
		$p = $this->input->get('p');
		
		$post = $this->input->post(NULL,TRUE);
			$billing = $this->db->select('
			trs_billing_manual.id,
			trs_billing_manual.id_appointment,
			ms_komponen_registrasi.nama as nama_komponen,
			trs_billing_manual.nominal as total_bayar
		')
		->where('trs_billing_manual.id',element('id',$post))
		->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing_manual.id_komponen','inner')
		->get('trs_billing_manual')->row_array();
		if(!empty($billing))
		{
			$billing = array_filter($billing);
		}
		echo json_encode($billing);
	}
	
	function billing_penunjang(){
		$post = $this->input->post(NULL,TRUE);
		$PenunjangID=element('PenunjangID',$post);
		$kelompok=$this->db->query("SELECT kelompok FROM ms_kategori_penunjang WHERE id_ms_penunjang='$PenunjangID' GROUP BY kelompok")->result();
foreach($kelompok as $row){ 
			$data=$this->db->query("SELECT id,nama,biaya FROM ms_kategori_penunjang WHERE id_ms_penunjang='$PenunjangID' AND kelompok='$row->kelompok'")->result();
	echo "<b>".$row->kelompok."</b>";
	echo "<ol>";
	foreach($data as $r){
		echo "<li><input type='checkbox' data-kategori-id='$r->id'  data-kategori-harga='$r->biaya' data-checkbox-kategori='true' name='kategori[]' value='$r->id' id='label".$r->id."'> <label for='label".$r->id."'>".$r->nama." (".rupiah($r->biaya).")</label></li>";
	}
	echo "</ol>";
}
	}
	
	public function save_pembayaran(){
		$post = $this->input->post(NULL,TRUE);
		$kat=$this->input->post("kategori");
		$update['id_jenis_bayar'] = element('id_jenis_bayar',$post);
		$update['total_bayar'] = rupiah_to_number(element('total_bayar',$post));
		$update['nominal'] = rupiah_to_number(element('total_bayar',$post));
		$update['kategori'] = implode(",",$kat);
		$update['keterangan'] = element('keterangan',$post);
		$update = array_string_to_null($update);
		
		$this->db->where('id',element('id',$post))->update('trs_billing_manual',$update);
		
		echo json_encode(array("status" => true));
	}

    public function ajax_list($id)
	{	
		$list = $this->Billing_model->get_datatables($id);
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $no;
			
			$fields[] = $row->rm;
			$fields[] = $row->nama_lengkap;
			$fields[] = $row->tipe_identitas.' '.$row->no_identitas;
			$fields[] = $row->cara_bayar;
			$fields[] = $row->poliklinik;
			$fields[] = get_field($row->id_komponen,'ms_komponen_registrasi');
			$fields[] = rupiah($row->nominal);
			$fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			$fields[] = ($row->status == 1)?'<i class="label label-success">Sudah Bayar</i>':'<i id="label_'.$row->id.'" class="label label-danger">Belum Bayar</i>';
			$fields[] = ($row->status == 1)?
				'<a href="'.site_url('billing_manual/kwitansi/'.$row->id_pasien.'/'.$row->id).'" target="_BLANK" class="btn btn-default btn-block" rel="tooltip" title="Ubah data"><i class="fa fa-print"></i> Kwitansi</a>'
				:
				'<button type="button" onclick="modal_pembayaran('.$row->id.')" type="button" class="btn btn-default btn-block" rel="tooltip" title="Cetak Kartu"><i class="fa fa-money"></i> Bayar</button>'
			;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Billing_model->count_all($id),
			"recordsFiltered" => $this->Billing_model->count_filtered($id),
			"data" => $data,
		);

		echo json_encode($output);
	}
	
	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array(
			 'id_pasien' => $post['id_pasien'],
			 'id_komponen' => $post['id_komponen'],
			 'no_tagihan' => $post['no_tagihan'],
			 'nominal' => $post['nominal'],
			 'total_bayar' => $post['total_bayar'],
			 'sisa' => $post['sisa'],	
			'last_user'=>$this->session->userdata('username')
		);
			
		if(empty($post['id']))
		{
			$data['add_time'] = date('Y-m-d H:i:s');
			$result = $this->Billing_model->insert($data);
		}
		else
		{
			$result = $this->Billing_model->update(array('id' => $post['id']), $data);
		}
		
		echo json_encode(array("status" => true));
		
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Billing_model->data_excel("billing");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Billing_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_billing',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Billing","I"); 
	}
	
	public function kwitansi($id_pasien,$id_billing) {
        $this->load->library('fpdf');
        $this->load->library('currency');
		
		$data['identitas']	= $this->db->get('ms_identitas')->row_array();
        $data['pasien'] 	= $this->db->get_where('ms_pasien',array('id'=>$id_pasien))->row_array();
        $data['payment'] 	= $payment = $this->db->get_where('trs_billing_manual',array('id'=>$id_billing))->row_array();
        //var_dump($data);
        $this->load->view('kwitansi', $data);
    }
}
?>
