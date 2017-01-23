<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Menu Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Menu_model');
		$config['table'] = 'sys_menu';
		$config['column_order'] = array(null,'id','nama','link','urut','icon','parent_id','dashboard','warna_dashboard','add_time','last_update','last_user',null);
		$config['column_search'] = array('id','nama','link','urut','icon','parent_id','dashboard','warna_dashboard','add_time','last_update','last_user');
		$config['column_excel'] = array('nama','link','urut','icon','parent_id','dashboard','warna_dashboard');
		$config['column_pdf'] = array('nama','link','urut','icon','parent_id','dashboard','warna_dashboard');
		$config['order'] = array('id' => 'asc');
		$this->Menu_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Menu';
		$data['id_table'] = 'menu';
		$data['datatable_list'] = 'menu/ajax_list';
		$data['datatable_edit'] = 'menu/ajax_edit';
		$data['datatable_delete'] = 'menu/ajax_delete';
		$data['datatable_save'] = 'menu/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('menu',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_menu',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Menu_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nama;
			 $fields[] = $row->link;
			 $fields[] = $row->urut;
			 $fields[] = $row->icon;
			 $fields[] = $row->parent_id;
			 $fields[] = $row->dashboard;
			 $fields[] = $row->warna_dashboard;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			 $fields[] = convert_tgl($row->last_update,'d M Y H:i',1);
			 $fields[] = $row->last_user;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Menu_model->count_all(),
			"recordsFiltered" => $this->Menu_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Menu_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'nama',
			 'link',
			 'urut',
			 'icon',
			 'parent_id',
			 'dashboard',
			 'warna_dashboard',
			 'add_time',
			 'last_update',
			 'last_user',
			);
			
			$fields = $this->Menu_model->list_fields($list_fields);
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
			 'link' => $post['link'],
			 'urut' => $post['urut'],
			 'icon' => $post['icon'],
			 'parent_id' => $post['parent_id'],
			 'dashboard' => $post['dashboard'],
			 'warna_dashboard' => $post['warna_dashboard'],	
			'last_user'=>$this->session->userdata('username')
		);
			
		if(empty($post['id']))
		{
			$data['add_time'] = date('Y-m-d H:i:s');
			$result = $this->Menu_model->insert($data);
		}
		else
		{
			$result = $this->Menu_model->update(array('id' => $post['id']), $data);
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
		$this->Menu_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Menu_model->data_excel("menu");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Menu_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_menu',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Menu","I"); 
	}
}
?>
