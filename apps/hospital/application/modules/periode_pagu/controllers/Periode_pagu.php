<?php

/**

	* CodeIgniter Core Model

	*

	* @package         CodeIgniter

	* @subpackage      Controller

	* @category        Periode_pagu Controller

	* @author          

	* @version         1.1

*/

defined('BASEPATH') OR exit('No direct script access allowed');



class Periode_pagu extends MY_Controller

{

    function __construct()

    {

        parent::__construct();

		$this->load->model('Periode_pagu_model');

		$config['table'] = 'periode_pagu';

		$config['column_order'] = array(null,'id','nama_periode','tanggal','status',null);

		$config['column_search'] = array('nama_periode','date_format(tanggal,"%d-%m-%Y")','status');

		$config['column_excel'] = array('id','nama_periode','tanggal','status');

		$config['column_pdf'] = array('id','nama_periode','tanggal','status');

		$config['order'] = array('id' => 'asc');

		$this->Periode_pagu_model->initialize($config);

    }



    public function index()

    {

		$data['title'] = 'Periode_pagu';

		$data['id_table'] = 'Periode_pagu';

		$data['datatable_list'] = 'periode_pagu/ajax_list';

		$data['datatable_edit'] = 'periode_pagu/ajax_edit';

		$data['datatable_delete'] = 'periode_pagu/ajax_delete';

		$data['datatable_save'] = 'periode_pagu/ajax_save';

		$data['load_form'] = $this->load_form($data);

		$this->template->display('periode_pagu',$data);

    }



    public function load_form($data)

	{

		return $this->load->view('form_periode_pagu',$data,true);

	}



    public function ajax_list()

	{	

		$list = $this->Periode_pagu_model->get_datatables();

		$data = array();

		$no = $_POST['start'];

		foreach ($list as $row) {

			$no++;

			$fields = array();

			$fields[] = $row->id;

			$fields[] = $no;

			

			$fields[] = $row->nama_periode;

			$fields[] = convert_tgl($row->tanggal,'d-m-Y',1);

			$fields[] = $row->status;

			

			$fields[] = $row->id;

			

			$data[] = $fields;

		}



		$output = array(

			"draw" => $_POST['draw'],

			"recordsTotal" => $this->Periode_pagu_model->count_all(),

			"recordsFiltered" => $this->Periode_pagu_model->count_filtered(),

			"data" => $data,

		);



		echo json_encode($output);

	}



	public function ajax_edit($id=0)

	{

		$data_object = $this->Periode_pagu_model->get_by_id($id);

		if($data_object)

		{

			$list_fields = array(

			 'id',

			 'nama_periode',

			 'tanggal',

			 'status'

			);

			

			$fields = $this->Periode_pagu_model->list_fields($list_fields);

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

			 'nama_periode' => $post['nama_periode'],

			 'tanggal' => convert_tgl($post['tanggal'],'Y-m-d'),

			 'status' => $post['status']

		);

			

		if(empty($post['id']))

		{

			$result = $this->Periode_pagu_model->insert($data);

		}

		else

		{

			$result = $this->Periode_pagu_model->update(array('id' => $post['id']), $data);

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

		$this->Periode_pagu_model->delete($id);

		echo json_encode(array("status" => TRUE));

	}

  

	public function excel()

	{

		$this->load->library("Excel");



		$query = $this->Periode_pagu_model->data_excel("Periode_pagu");

		$this->excel->export($query);

	}

	

	public function pdf()

	{

		$this->load->library("Chtml2pdf");

		$this->load->library("Header_file");

		

		$query = $this->Periode_pagu_model->data_pdf();

		$data['header'] = $this->header_file->pdf('100%');

		$data['query'] = $query;

		$content = $this->load->view('pdf_periode_pagu',$data,true);

		$this->chtml2pdf->cetak("P","A4",$content,"Periode_pagu","I"); 

	}

}

?>

