<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Tindakan Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Tindakan_model');
		$config['table'] = 'ms_tindakan';
		$config['column_order'] = array(null,null,'ms_tindakan.nama','ms_tindakan.biaya','ms_tindakan.id_kategori_tindakan','ms_tindakan.keterangan',null);
		$config['column_search'] = array('ms_tindakan.nama','ms_tindakan.biaya','ms_tindakan.id_kategori_tindakan','ms_tindakan.keterangan');
		$config['column_excel'] = array('ms_tindakan.nama','ms_tindakan.biaya','ms_tindakan.id_kategori_tindakan','ms_tindakan.keterangan');
		$config['column_pdf'] = array('ms_tindakan.nama','ms_tindakan.biaya','ms_tindakan.id_kategori_tindakan','ms_tindakan.keterangan');
		$config['order'] = array('ms_tindakan.nama' => 'asc');
		$this->Tindakan_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Tindakan';
		$data['id_table'] = 'tindakan';
		$data['datatable_list'] = 'tindakan/ajax_list';
		$data['datatable_edit'] = 'tindakan/ajax_edit';
		$data['datatable_delete'] = 'tindakan/ajax_delete';
		$data['datatable_save'] = 'tindakan/ajax_save';
		$data['load_form'] = $this->load_form($data);
		$this->template->display('tindakan',$data);
    }

    public function load_form($data)
	{
		
		$data['kategori_tindakan'] = $this->db->get('ms_kategori_tindakan')->result_array();
		$data['ms_poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		return $this->load->view('form_tindakan',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Tindakan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nama;
			 $fields[] = rupiah($row->biaya);
			 $fields[] = $row->kategori_tindakan;
			 $fields[] = $row->namapoli;
			 $fields[] = $row->keterangan;
			$fields[] = $row->id;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Tindakan_model->count_all(),
			"recordsFiltered" => $this->Tindakan_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Tindakan_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			 'id',
			 'nama',
			 'biaya',
			 'id_ms_poliklinik',
			 'id_kategori_tindakan',
			 'keterangan',
			);
			
			$fields = $this->Tindakan_model->list_fields($list_fields);
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
			 'biaya' => rupiah_to_number($post['biaya']),
			 'id_kategori_tindakan' => $post['id_kategori_tindakan'],
			 'id_ms_poliklinik' => $post['id_ms_poliklinik'],
			 'keterangan' => $post['keterangan']
		);
			
		if(empty($post['id']))
		{
			$result = $this->Tindakan_model->insert($data);
		}
		else
		{
			$result = $this->Tindakan_model->update(array('id' => $post['id']), $data);
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
		$this->Tindakan_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Tindakan_model->data_excel("tindakan");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Tindakan_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_tindakan',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Tindakan","I"); 
	}
}
?>
