<?php

/**

	* CodeIgniter Core Model

	*

	* @package         CodeIgniter

	* @subpackage      Controller

	* @category        Agama Controller

	* @author          

	* @version         1.1

*/

defined('BASEPATH') OR exit('No direct script access allowed');



class Anggaran extends MY_Controller

{

    function __construct()

    {

        parent::__construct();

		$this->load->model('Anggaran_model');

		$config['table'] = 'anggaran';

		$config['column_order'] = array(null,'id','nama_anggaran','no_rekening','parent_id',null);

		$config['column_search'] = array('id','nama_anggaran','no_rekening','parent_id');

		$config['column_excel'] = array('id','nama_anggaran','no_rekening','parent_id');

		$config['column_pdf'] = array('id','nama_anggaran','no_rekening','parent_id');

		$config['order'] = array('id' => 'desc');

		$this->Anggaran_model->initialize($config);

    }



    public function index()

    {

		$data['title'] = 'Anggaran';

		$data['id_table'] = 'anggaran';

		$data['datatable_list'] = 'anggaran/ajax_list';

		$data['datatable_edit'] = 'anggaran/ajax_edit';

		$data['datatable_delete'] = 'anggaran/ajax_delete';

		$data['datatable_save'] = 'anggaran/ajax_save';

		$data['pr'] = $this->db->select('id,nama_anggaran')->get('anggaran')->result_array();


		$data['load_form'] = $this->load_form($data);
		

		$this->template->display('anggaran',$data);

    }



    public function load_form($data)

	{

		return $this->load->view('form_anggaran',$data,true);

	}



    public function ajax_list()

	{	

		$list = $this->Anggaran_model->get_datatables();

		$data = array();

		$no = $_POST['start'];

		foreach ($list as $row) {

			$no++;

			$fields = array();

			$fields[] = $row->id;

			$fields[] = $no;

			

			 $fields[] = $row->nama_anggaran;

			 $fields[] = $row->no_rekening;

			 $fields[] = $row->parent_id;

			 

			$fields[] = $row->id;

			

			$data[] = $fields;

		}



		$output = array(

			"draw" => $_POST['draw'],

			"recordsTotal" => $this->Anggaran_model->count_all(),

			"recordsFiltered" => $this->Anggaran_model->count_filtered(),

			"data" => $data,

		);



		echo json_encode($output);

	}



	public function ajax_edit($id=0)

	{

		$data_object = $this->Anggaran_model->get_by_id($id);

		if($data_object)

		{

			$list_fields = array(
			 'id',
			 
			 'nama_anggaran',

			 'no_rekening',

			 'parent_id',

			);

			$data = (array) $data_object;
			
			
			if(!empty($data['no_rekening'])){
			
				$no_rekening = explode('.',$data['no_rekening']);
				$data['no1'] = $no_rekening[0];
				$data['no2'] = $no_rekening[1];
				$data['no3'] = $no_rekening[2];
				$data['no4'] = $no_rekening[3];
				$data['no5'] = $no_rekening[4];
				$data['no6'] = $no_rekening[5];
				$data['no7'] = $no_rekening[6];
				$data['no8'] = $no_rekening[7];
				$data['no9'] = $no_rekening[8];
			}
			
			foreach($data as $index=>$value){
				$data_new['name'] = $index;
				$data_new['value'] = $value;
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

			 'nama_anggaran' => $post['nama_anggaran'],

			 'no_rekening' => 

			 $post['no1'].'.'.$post['no2'].'.'.$post['no3'].'.'.$post['no4'].'.'.

			 $post['no5'].'.'.$post['no6'].'.'.$post['no7'].'.'.$post['no8'].'.'.
			 $post['no9'],

			 'parent_id' => $post['parent_id']

		);

			

		if(empty($post['id']))

		{

			$result = $this->Anggaran_model->insert($data);

		}

		else

		{

			$result = $this->Anggaran_model->update(array('id' => $post['id']), $data);

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

		$this->Anggaran_model->delete($id);

		echo json_encode(array("status" => TRUE));

	}

  

	public function excel()

	{

		$this->load->library("Excel");



		$query = $this->Anggaran_model->data_excel("anggaran");

		$this->excel->export($query);

	}

	

	public function pdf()

	{

		$this->load->library("Chtml2pdf");

		$this->load->library("Header_file");

		

		$query = $this->Anggaran_model->data_pdf();

		$data['header'] = $this->header_file->pdf('100%');

		$data['query'] = $query;

		$content = $this->load->view('pdf_anggaran',$data,true);

		$this->chtml2pdf->cetak("P","A4",$content,"Anggaran_Blud","I"); 

	}
	
	public function get_parent(){
		$search = ($_GET['q'])?strip_tags(trim($_GET['q'])):'';
		$query = $this->db->select('id,nama_anggaran')
		->where('nama_anggaran',$search)
		->get('anggaran')->result_array();
		$data = array();
		$found = count($query);
		if($found > 0){
			foreach($query as $r){
				$field = array();
				$field['id'] = $r['id'];
				$field['text'] = $r['nama_anggaran'];
				$field['name'] = $r['nama_anggaran'];
				$data[] = $field;
			}
		}else{
			$data = array(
					'id' => '',
					'text' => 'Parent tidak di temukan'
					);
		}
		echo json_encode($data);
	}

}

?>

