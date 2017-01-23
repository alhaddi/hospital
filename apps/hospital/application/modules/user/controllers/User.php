<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        User Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('User_model');
		$config['table'] = 'ms_user';
		$config['column_order'] = array(null,'id','kode_user','nama','no_identitas','jk','tempat_lahir','tgl_lahir','alamat','telp','hp','email','foto','add_time','last_update','last_user',null);
		$config['column_search'] = array('id','kode_user','nama','no_identitas','jk','tempat_lahir','tgl_lahir','alamat','telp','hp','email','foto','add_time','last_update','last_user');
		$config['column_excel'] = array('kode_user','nama','no_identitas','jk','tempat_lahir','tgl_lahir','alamat','telp','hp','email','foto');
		$config['column_pdf'] = array('kode_user','nama','no_identitas','jk','tempat_lahir','tgl_lahir','alamat','telp','hp','email','foto');
		$config['order'] = array('id' => 'asc');
		$this->User_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'User';
		$data['id_table'] = 'user';
		$data['datatable_list'] = 'user/ajax_list';
		$data['datatable_edit'] = 'user/ajax_edit';
		$data['datatable_delete'] = 'user/ajax_delete';
		$data['datatable_save'] = 'user/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('user',$data);
    }

    public function load_form($data)
	{
		return $this->load->view('form_user',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->User_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->kode_user;
			 $fields[] = $row->nama;
			 $fields[] = $row->no_identitas;
			 $fields[] = $row->jk;
			 $fields[] = $row->tempat_lahir;
			 $fields[] = convert_tgl($row->tgl_lahir,'d M Y',1);
			 $fields[] = $row->alamat;
			 $fields[] = $row->telp;
			 $fields[] = $row->hp;
			 $fields[] = $row->email;
			 $fields[] = $row->foto;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			 $fields[] = convert_tgl($row->last_update,'d M Y H:i',1);
			 $fields[] = $row->last_user;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->User_model->count_all(),
			"recordsFiltered" => $this->User_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->User_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'kode_user',
			 'nama',
			 'no_identitas',
			 'jk',
			 'tempat_lahir',
			 'tgl_lahir',
			 'alamat',
			 'telp',
			 'hp',
			 'email',
			 'foto',
			 'add_time',
			 'last_update',
			 'last_user',
			);
			
			$fields = $this->User_model->list_fields($list_fields);
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
			 'kode_user' => $post['kode_user'],
			 'nama' => $post['nama'],
			 'no_identitas' => $post['no_identitas'],
			 'jk' => $post['jk'],
			 'tempat_lahir' => $post['tempat_lahir'],
			 'tgl_lahir' => $post['tgl_lahir'],
			 'alamat' => $post['alamat'],
			 'telp' => $post['telp'],
			 'hp' => $post['hp'],
			 'email' => $post['email'],
			 'foto' => $post['foto'],	
			'last_user'=>$this->session->userdata('username')
		);
			
		if(empty($post['id']))
		{
			$data['add_time'] = date('Y-m-d H:i:s');
			$result = $this->User_model->insert($data);
		}
		else
		{
			$result = $this->User_model->update(array('id' => $post['id']), $data);
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
		$this->User_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->User_model->data_excel("user");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->User_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_user',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"User","I"); 
	}
}
?>
