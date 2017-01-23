<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Kategori_pph Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_pph extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Kategori_pph_model');
		$config['table'] = 'ms_kategori_pph';
		$config['column_order'] = array(null,'id','nama_pph',null);
		$config['column_search'] = array('id','nama_pph');
		$config['column_excel'] = array('nama_pph');
		$config['column_pdf'] = array('nama_pph');
		$config['order'] = array('id' => 'asc');
		$this->Kategori_pph_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Kategori_pph';
		$data['id_table'] = 'kategori_pph';
		$data['datatable_list'] = 'kategori_pph/ajax_list';
		$data['datatable_edit'] = 'kategori_pph/ajax_edit';
		$data['datatable_delete'] = 'kategori_pph/ajax_delete';
		$data['datatable_save'] = 'kategori_pph/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('kategori_pph',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_kategori_pph',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Kategori_pph_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nama_pph;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Kategori_pph_model->count_all(),
			"recordsFiltered" => $this->Kategori_pph_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Kategori_pph_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'nama_pph'
			);
			
			$fields = $this->Kategori_pph_model->list_fields($list_fields);
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
			 'nama_pph' => $post['nama_pph'],	
		);
			
		if(empty($post['id']))
		{
			$result = $this->Kategori_pph_model->insert($data);
		}
		else
		{
			$result = $this->Kategori_pph_model->update(array('id' => $post['id']), $data);
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
		$this->Kategori_pph_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Kategori_pph_model->data_excel("kategori_pph");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Kategori_pph_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_kategori_pph',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Kategori_pph","I"); 
	}
}
?>
