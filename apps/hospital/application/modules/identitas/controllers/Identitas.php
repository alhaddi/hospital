<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Identitas Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Identitas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('datatables_model');
		$config['table'] = 'ms_identitas';
		$config['column_order'] = array(null,'id','nama','alamat','tlp','fax','email','website','logo',null);
		$config['column_search'] = array('id','nama','alamat','tlp','fax','email','website','logo');
		$config['order'] = array('nama' => 'asc');
		$this->datatables_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Ubah Identitias';
		$data['id_table'] = 'ms_identitias';
		$data['form_save'] = 'identitas/save';
		$data['row'] = $this->db->get('ms_identitas')->row_array();
		$this->template->display('form_identitas',$data);
    }

	public function save()
	{
		$post = $this->input->post(NULL,TRUE);
		
		$config['upload_path'] = FILES_PATH.'/img/';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['overwrite'] = TRUE;
		$config['file_name'] = 'logo';
		
		create_dir($config['upload_path']);
		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload('logo'))
		{
			$upload = $this->upload->data();
			$logo = $upload['file_name'];
			$data['logo'] = $logo;
		} 
		
		$data = array(
			 'nama' => $post['nama'],
			 'alamat' => $post['alamat'],
			 'tlp' => $post['tlp'],
			 'fax' => $post['fax'],
			 'email' => $post['email'],
			 'website' => $post['website']
		);
			
		if(empty($post['id']))
		{
			$result = $this->datatables_model->insert($data);
			$response['message'] = 'Data identitas baru berhasil di tambahkan !';
		}
		else
		{
			$result = $this->datatables_model->update(array('id' => $post['id']), $data);
			$response['message'] = 'Data identitas berhasil di ubah !';
		}
		$response['status'] = true;
		echo json_encode($response);
		
	}
}