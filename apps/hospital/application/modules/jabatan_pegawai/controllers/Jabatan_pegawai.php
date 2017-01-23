<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Jabatan_pegawai Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_pegawai extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Jabatan_pegawai_model');
		$config['table'] = 'ms_jabatan';
		$config['column_order'] = array(null,'id','kode_jenis_jabatan_pegawai','nama',null);
		$config['column_search'] = array('id','kode_jenis_jabatan_pegawai','nama');
		$config['column_excel'] = array('kode_jenis_jabatan_pegawai','nama');
		$config['column_pdf'] = array('kode_jenis_jabatan_pegawai','nama');
		$config['order'] = array('id' => 'asc');
		$this->Jabatan_pegawai_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Riwayat Jabatan';
		$data['id_table'] = 'jabatan_pegawai';
		$data['datatable_list'] = 'jabatan_pegawai/ajax_list';
		$data['datatable_edit'] = 'jabatan_pegawai/ajax_edit';
		$data['datatable_delete'] = 'jabatan_pegawai/ajax_delete';
		$data['datatable_save'] = 'jabatan_pegawai/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('jabatan_pegawai',$data);
    }

    public function load_form($data)
	{
		$data['kode_jenis_jabatan'] = $this->db->get('ms_jenis_jabatan')->result_array();
		$data['unit_kerja'] = $this->db->get('ms_unit_kerja')->result_array();
		return $this->load->view('form_jabatan_pegawai',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Jabatan_pegawai_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = '';
			$fields[] = '';
			$fields[] = '<input type="checkbox" name="jabatan_terakhir" value="'.$row->id.'">';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Jabatan_pegawai_model->count_all(),
			"recordsFiltered" => $this->Jabatan_pegawai_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Jabatan_pegawai_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'kode_jenis_jabatan_pegawai',
			 'nama'
			);
			
			$fields = $this->Jabatan_pegawai_model->list_fields($list_fields);
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
			 'kode_jenis_jabatan_pegawai' => $post['kode_jenis_jabatan_pegawai'],	
			 'nama' => $post['nama'],	
		);
			
		if(empty($post['id']))
		{
			$result = $this->Jabatan_pegawai_model->insert($data);
		}
		else
		{
			$result = $this->Jabatan_pegawai_model->update(array('id' => $post['id']), $data);
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
		$this->Jabatan_pegawai_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Jabatan_pegawai_model->data_excel("jabatan_pegawai");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Jabatan_pegawai_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_jabatan_pegawai',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Jabatan_pegawai","I"); 
	}
}
?>
