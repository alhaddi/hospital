<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Golongan Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Golongan_model');
		$config['table'] = 'ms_golongan';
		$config['column_order'] = array(null,'kd','nama',null);
		$config['column_search'] = array('kd','nama');
		$config['column_excel'] = array('kd','nama');
		$config['column_pdf'] = array('kd','nama');
		$config['order'] = array('kd' => 'asc');
		$this->Golongan_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Golongan';
		$data['id_table'] = 'golongan';
		$data['datatable_list'] = 'golongan/ajax_list';
		$data['datatable_edit'] = 'golongan/ajax_edit';
		$data['datatable_delete'] = 'golongan/ajax_delete';
		$data['datatable_save'] = 'golongan/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('golongan',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_golongan',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Golongan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->kd;
			$fields[] = $no;
			
			 $fields[] = $row->kd;
			 $fields[] = $row->nama;
			$fields[] = $row->kd;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Golongan_model->count_all(),
			"recordsFiltered" => $this->Golongan_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Golongan_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'kd',
			 'nama'
			);
			
			$fields = $this->Golongan_model->list_fields($list_fields);
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
			 'kd' => $post['kd'],
			 'nama' => $post['nama'],	
		);
		
		$cek = $this->db->select('kd')->where('kd',$post['kd'])->get('ms_golongan')->num_rows();
			
		if($cek == 0)
		{
			$result = $this->Golongan_model->insert($data);
		}
		else
		{
			$result = $this->Golongan_model->update(array('kd' => $post['kd']), $data);
		}
		
		echo json_encode(array("status" => true));
		
	}
  

	public function ajax_delete()
	{
		$post = $this->input->post(NULL,TRUE);
		$kd = $post['id'];
		if(!is_array($kd)){
			$kd[] = $kd;
		}
		$this->Golongan_model->delete($kd);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Golongan_model->data_excel("golongan");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Golongan_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_golongan',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Golongan","I"); 
	}
}
?>
