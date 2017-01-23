<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Pagu Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pagu_model');
		$config['table'] = 'pagu';
		$config['column_order'] = array(null,'id','id_anggaran','pagu','id_periode',null);
		$config['column_search'] = array('nama_anggaran','pagu','nama_periode');
		$config['column_excel'] = array('nama_anggaran','pagu','nama_periode');
		$config['column_pdf'] = array('nama_anggaran','pagu','nama_periode');
		$config['order'] = array('id_pagu' => 'asc');
		$this->Pagu_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Pagu';
		$data['id_table'] = 'pagu';
		$data['datatable_list'] = 'pagu/ajax_list';
		$data['datatable_edit'] = 'pagu/ajax_edit';
		$data['datatable_delete'] = 'pagu/ajax_delete';
		$data['datatable_save'] = 'pagu/ajax_save';

		$data['periode'] = $this->db->select('id,nama_periode,tanggal')
		->where('status','aktif')
		->get('periode_pagu')->result_array();
		$data['anggaran'] = $this->db->select('id,nama_anggaran,no_rekening')
		->where('status_anggaran','0')
		->get('anggaran')->result_array();
		
		$data['load_form'] = $this->load_form($data);
		$this->template->display('pagu',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_pagu',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Pagu_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id_pagu;
			$fields[] = $no;
			
			 $fields[] = $row->nama_anggaran;
			 $fields[] = rupiah($row->pagu);
			 $fields[] = $row->nama_periode;
			 
			$fields[] = $row->id_pagu;
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pagu_model->count_all(),
			"recordsFiltered" => $this->Pagu_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}
	
	public function ajax_edit($id=0)
	{
		$data_object = $this->Pagu_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id_pagu',
			 'id_anggaran',
			 'pagu',
			 'id_periode',
			);
			
			$fields = $this->Pagu_model->list_fields($list_fields);
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

	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array(
			 'id_anggaran' => $post['id_anggaran'],
			 'pagu' => ($post['pagu']!='')?rupiah_to_number($post['pagu']):'0',
			 'id_periode' => $post['id_periode']
		);
			
		if(empty($post['id_pagu']))
		{
			$result = $this->Pagu_model->insert($data);
		}
		else
		{
			$result = $this->Pagu_model->update(array('id_pagu' => $post['id_pagu']), $data);
		}
		
		echo json_encode(array("status" => true,"ID" => $post['id_pagu'],"ID Anggaran" => $post['id_anggaran']));
		
	}
  

	public function ajax_delete()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		if(!is_array($id)){
			$id[] = $id;
		}
		$this->Pagu_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Pagu_model->data_excel("pagu");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Pagu_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_pagu',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Pagu","I"); 
	}	
}
?>
