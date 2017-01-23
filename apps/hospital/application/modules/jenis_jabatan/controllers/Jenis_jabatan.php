<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Jenis_jabatan Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_jabatan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Jenis_jabatan_model');
		$config['table'] = 'ms_jenis_jabatan';
		$config['column_order'] = array(null,'kd','nama',null);
		$config['column_search'] = array('kd','nama');
		$config['column_excel'] = array('kd','nama');
		$config['column_pdf'] = array('kd','nama');
		$config['order'] = array('kd' => 'asc');
		$this->Jenis_jabatan_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Jenis_jabatan';
		$data['id_table'] = 'jenis_jabatan';
		$data['datatable_list'] = 'jenis_jabatan/ajax_list';
		$data['datatable_edit'] = 'jenis_jabatan/ajax_edit';
		$data['datatable_delete'] = 'jenis_jabatan/ajax_delete';
		$data['datatable_save'] = 'jenis_jabatan/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('jenis_jabatan',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_jenis_jabatan',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Jenis_jabatan_model->get_datatables();
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
			"recordsTotal" => $this->Jenis_jabatan_model->count_all(),
			"recordsFiltered" => $this->Jenis_jabatan_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Jenis_jabatan_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'kd',
			 'nama'
			);
			
			$fields = $this->Jenis_jabatan_model->list_fields($list_fields);
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
		
		$cek = $this->db->select('kd')->where('kd',$post['kd'])->get('ms_jenis_jabatan')->num_rows();
			
		if($cek == 0)
		{
			$result = $this->Jenis_jabatan_model->insert($data);
		}
		else
		{
			$result = $this->Jenis_jabatan_model->update(array('kd' => $post['kd']), $data);
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
		$this->Jenis_jabatan_model->delete($kd);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Jenis_jabatan_model->data_excel("jenis_jabatan");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Jenis_jabatan_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_jenis_jabatan',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Jenis_jabatan","I"); 
	}
}
?>
