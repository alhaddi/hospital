<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Komponen_anamesa Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Komponen_anamesa extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Komponen_anamesa_model');
		$config['table'] = 'ms_komponen_anamesa';
		$config['column_order'] = array(null,'id','nama','satuan','icon',null);
		$config['column_search'] = array('id','nama','satuan','icon');
		$config['column_excel'] = array('nama','satuan','icon');
		$config['column_pdf'] = array('nama','satuan','icon');
		$config['order'] = array('id' => 'asc');
		$this->Komponen_anamesa_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Komponen_anamesa';
		$data['id_table'] = 'komponen_anamesa';
		$data['datatable_list'] = 'komponen_anamesa/ajax_list';
		$data['datatable_edit'] = 'komponen_anamesa/ajax_edit';
		$data['datatable_delete'] = 'komponen_anamesa/ajax_delete';
		$data['datatable_save'] = 'komponen_anamesa/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('komponen_anamesa',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_komponen_anamesa',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Komponen_anamesa_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nama;
			 $fields[] = $row->satuan;
			 $fields[] = $row->icon;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Komponen_anamesa_model->count_all(),
			"recordsFiltered" => $this->Komponen_anamesa_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Komponen_anamesa_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'nama',
			 'satuan',
			 'icon',
			);
			
			$fields = $this->Komponen_anamesa_model->list_fields($list_fields);
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
			 'nama' => $post['nama'],
			 'satuan' => $post['satuan'],
			 'icon' => $post['icon']
		);
			
		if(empty($post['id']))
		{
			$result = $this->Komponen_anamesa_model->insert($data);
		}
		else
		{
			$result = $this->Komponen_anamesa_model->update(array('id' => $post['id']), $data);
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
		$this->Komponen_anamesa_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Komponen_anamesa_model->data_excel("komponen_anamesa");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Komponen_anamesa_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_komponen_anamesa',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Komponen_anamesa","I"); 
	}
}
?>
