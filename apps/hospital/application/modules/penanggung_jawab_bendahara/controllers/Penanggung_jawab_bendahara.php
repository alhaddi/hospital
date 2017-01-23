<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Penanggung_jawab_bendahara Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Penanggung_jawab_bendahara extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Penanggung_jawab_bendahara_model');
		$config['table'] = 'ms_penanggung_jawab_bendahara';
		$config['column_order'] = array(null,'id','nama',null);
		$config['column_search'] = array('id','nama');
		$config['column_excel'] = array('nama');
		$config['column_pdf'] = array('nama');
		$config['order'] = array('id' => 'asc');
		$this->Penanggung_jawab_bendahara_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Penanggung jawab bendahara';
		$data['id_table'] = 'penanggung_jawab_bendahara';
		$data['datatable_list'] = 'penanggung_jawab_bendahara/ajax_list';
		$data['datatable_edit'] = 'penanggung_jawab_bendahara/ajax_edit';
		$data['datatable_delete'] = 'penanggung_jawab_bendahara/ajax_delete';
		$data['datatable_save'] = 'penanggung_jawab_bendahara/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('penanggung_jawab_bendahara',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_penanggung_jawab_bendahara',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Penanggung_jawab_bendahara_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nip;
			 $fields[] = $row->nama;
			 $fields[] = $row->tugas;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Penanggung_jawab_bendahara_model->count_all(),
			"recordsFiltered" => $this->Penanggung_jawab_bendahara_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Penanggung_jawab_bendahara_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'nip',
			 'nama',
			 'tugas'
			);
			
			$fields = $this->Penanggung_jawab_bendahara_model->list_fields($list_fields);
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
			 'nip' => $post['nip'],	
			 'nama' => $post['nama'],	
			 'tugas' => $post['tugas']	
		);
			
		if(empty($post['id']))
		{
			$result = $this->Penanggung_jawab_bendahara_model->insert($data);
		}
		else
		{
			$result = $this->Penanggung_jawab_bendahara_model->update(array('id' => $post['id']), $data);
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
		$this->Penanggung_jawab_bendahara_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Penanggung_jawab_bendahara_model->data_excel("penanggung_jawab_bendahara");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Penanggung_jawab_bendahara_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_penanggung_jawab_bendahara',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Penanggung_jawab_bendahara","I"); 
	}
}
?>
