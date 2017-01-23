<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Penerimaan Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Penerimaan_model');
		$config['table'] = 'jurnal';
		$config['column_order'] = array(null,'id','tanggal_jurnal','uraian','jumlah_jurnal',null);
		$config['column_search'] = array('date_format(tanggal_jurnal,"%d-%m-%Y")','uraian','jumlah_jurnal');
		$config['column_excel'] = array('id','tgl_blud','uraian','jumlah');
		$config['column_pdf'] = array('jurnal.id','anggaran.nama_anggaran','anggaran.no_rekening','jurnal.tgl_blud','jurnal.uraian','trs_blud.jumlah');
		$config['order'] = array('id' => 'asc');
		$this->Penerimaan_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Data Pendukung Penerimaan';
		$data['id_table'] = 'penerimaan';
		$data['datatable_list'] = 'penerimaan/ajax_list';
		$data['datatable_edit'] = 'penerimaan/ajax_edit';
		$data['datatable_delete'] = 'penerimaan/ajax_delete';
		$data['datatable_save'] = 'penerimaan/ajax_save';

		$data['load_form'] = $this->load_form($data);
		$this->template->display('penerimaan',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_penerimaan',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Penerimaan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = ($row->status == 'Aktif')?'<input type="checkbox" data-datatable-bulk_delete="true" name="id[]" value="'.$row->id.'">':'';
			$fields[] = $no;
			
			 $fields[] = convert_tgl($row->tanggal_jurnal,'d-m-Y',1);
			 $fields[] = $row->uraian;
			 $fields[] = rupiah($row->jumlah_jurnal);
				
			$fields[] = ($row->status == 'Aktif')?'<button onclick="modal_penerimaan('.$row->id.')" type="button" class="btn btn-default" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>':'';
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Penerimaan_model->count_all(),
			"recordsFiltered" => $this->Penerimaan_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		$data_object = $this->Penerimaan_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'tanggal_jurnal',
			 'uraian',
			 'jumlah_jurnal'
			);
			
			$fields = $this->Penerimaan_model->list_fields($list_fields);
			$data = (array) $data_object;
			
			foreach($fields as $meta){
				if($meta->name == 'tanggal_jurnal'){
					$tgl = explode(" ",$data[$meta->name]);
					$data_new['value'] = $tgl[1];
					$data_new['name'] = 'time_jurnal';
					$data_array[] = $data_new;
					
					$data_new['value'] = convert_tgl($tgl[0],'d/m/Y',1);
					$data_new['name'] = $meta->name;
					$data_array[] = $data_new;
				}else{
					$data_new['name'] = $meta->name;
					$data_new['value'] = $data[$meta->name];
					$data_array[] = $data_new;
				}
			}
			
			$result['status'] = 0;
			$result['data_array'] = $data_array;
			$result['data_object'] = $data_object;
			$response = $data_array;
		}
		else
		{
			$result['status'] = 99;
			$response['response'] = $result;
		}
		echo json_encode($response);
	}

	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
			
		if(empty($post['id']))
		{
			$data = array(
			 'jumlah_jurnal' => rupiah_to_number($post['jumlah_jurnal']),
			 'tipe_jurnal' => 'debit',
			 'tanggal_jurnal' => convert_tgl($post['tanggal_jurnal'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
			 'uraian' => $post['uraian'],
			 'urut' => '4'
		);
			$result = $this->Penerimaan_model->insert($data);
		}
		else
		{
			$data = array(
			 'jumlah_jurnal' => rupiah_to_number($post['jumlah_jurnal']),
			 'tipe_jurnal' => 'debit',
			 'tanggal_jurnal' => convert_tgl($post['tanggal_jurnal'].' '.$post['time_jurnal'],'Y-m-d H:i:s',1),
			 'uraian' => $post['uraian'],
			 'urut' => '4'
			);
			$result = $this->Penerimaan_model->update(array('id' => $post['id']), $data);
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
		$this->Penerimaan_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Penerimaan_model->data_excel("penerimaan");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Penerimaan_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_penerimaan',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Penerimaan","I"); 
	}
}
?>
