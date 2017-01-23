<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Agama Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Dokter_model');
		$config['table'] = 'ms_dokter';
		$config['column_order'] = array(null,'id','nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama',null);
		$config['column_search'] = array('id','nip','no_identitas','jk','spesialis','hp','alamat','tgl_lahir','nama');
		$config['column_excel'] = array('nama');
		$config['column_pdf'] = array('nama');
		$config['order'] = array('id' => 'asc');
		$this->Dokter_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Dokter';
		$data['id_table'] = 'dokter';
		$data['datatable_list'] = 'dokter/ajax_list';
		$data['datatable_edit'] = 'dokter/ajax_edit';
		$data['datatable_delete'] = 'dokter/ajax_delete';
		$data['datatable_save'] = 'dokter/ajax_save';
		//$data['load_form'] = $this->load_form($data);
		$this->template->display('dokter',$data);
    }

    public function load_form($data)
	{
		$this->db->select('id,nama');
		$data['poli']=$this->db->get('ms_poliklinik')->result();
		return $this->load->view('form_agama',$data,true);
	}
	
	function adddokter($id=0){
		$data['row']=array();
		if($id != 0){
		$data['row'] = $this->Dokter_model->get_by_id($id);
		}
		$poli=$this->session->userdata('id_pol');
		$this->db->select('id,nama');		
		if($poli){
		$w=" id IN ($poli)";
		}else{
		$w=" id =''";	
			}
		$this->db->where($w);
		$data['poli']=$this->db->get('ms_poliklinik')->result();
		$this->load->view('form_agama',$data);
	}
	
    public function ajax_list()
	{	
		$list = $this->Dokter_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $row->id;
			$fields[] = $no;
			
			 $fields[] = $row->nip;
			 $fields[] = $row->nama;
			 $fields[] = $row->no_identitas;
			 $fields[] = ($row->jk == 'L')?'Laki-laki':'Perempuan';
			 $fields[] = $row->spesialis;
			 $fields[] = $row->hp;
			 $fields[] = $row->alamat;
			 $fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			
			$fields[] = '<button type="button" class="btn" onclick="addmodal('.$row->id.')"><i class="fa fa-pencil"></i></button>';
			$data[] = $fields;
		}



		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Dokter_model->count_all(),
			"recordsFiltered" => $this->Dokter_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit($id=0)
	{
		$data_object = $this->Dokter_model->get_by_id($id);
		if($data_object)
		{
			$list_fields = array(
			'id_poliklinik',
			'spesialis',
			'id',
			'nip',
			'nama',
			'no_identitas',
			'tempat_lahir',
			'tgl_lahir',
			'jk',
			'alamat',
			'telp',
			'hp',
			'email',
			'gol_darah',
			'kode_golongan',
			'unit_kerja',
			'status_pegawai'

			);
			
			$fields = $this->Dokter_model->list_fields($list_fields);
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
		'spesialis'=>$post['spesialis'],
		'id_poliklinik'=>implode(',',$post['id_poliklinik']),
		'nip'=>$post['nip'],
		'nama'=>$post['nama'],
		'no_identitas'=>$post['no_identitas'],
		'tempat_lahir'=>$post['tempat_lahir'],
		'tgl_lahir'=>convert_tgl($post['tgl_lahir'],'Y-m-d',1),
		'jk'=>$post['jk'],
		'alamat'=>$post['alamat'],
		'telp'=>$post['telp'],
		'hp'=>$post['hp'],
		'email'=>$post['email'],
		'gol_darah'=>$post['gol_darah'],
		'kode_golongan'=>$post['kode_golongan'],
		'unit_kerja'=>$post['unit_kerja'],
		'status_pegawai'=>$post['status_pegawai']
		);
			
		if(empty($post['id']))
		{
			$result = $this->Dokter_model->insert($data);
		}
		else
		{
			$result = $this->Dokter_model->update(array('id' => $post['id']), $data);
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
		$this->Dokter_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Dokter_model->data_excel("agama");
		$this->excel->export($query);
	}
	
	public function pdf()
	{
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$query = $this->Dokter_model->data_pdf();
		$data['header'] = $this->header_file->pdf('100%');
		$data['query'] = $query;
		$content = $this->load->view('pdf_agama',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Agama","I"); 
	}
}
?>
