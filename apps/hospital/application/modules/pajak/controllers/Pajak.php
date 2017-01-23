<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Pajak Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Pajak extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pajak_model');
		$config['table'] = 'trs_blud';
		$config['column_order'] = array(null,'id_blud','id_anggaran',null);		
		$config['column_search'] = array(null,'id_blud','id_anggaran',null);		
		$config['column_pdf'] = array(null,'id_blud','id_anggaran',null);		
		$config['order'] = array('id_blud' => 'asc');
		$this->Pajak_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Pajak';
		$data['id_table'] = 'pajak';
		$data['datatable_list'] = 'pajak/ajax_list';

		$data['id_kategori_pph'] = $this->db->select('id, nama_pph')
		->get('ms_kategori_pph')->result_array();
		$data['load_form'] = $this->load->view('form_pajak',$data,true);
		$this->template->display('pajak',$data);
    }

    public function ajax_list()
	{	
		$list = $this->Pajak_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			
			for($i=1;$i<3;$i++){
				$fields = array();
				if($i%2!=0){
				$no++;
				$fields[] = $no;
				
				 $fields[] = convert_tgl($row->tgl_blud);
				 $fields[] = 'Terima '.$row->nama_pajak.' atas '.$row->uraian;
				 $fields[] = $row->nominal;
				 $fields[] = '';
				 $fields[] = '';
				 $data[] = $fields;	
				}else if($i%2==0){
				$no++;
				$fields[] = $no;
				
				 $fields[] = convert_tgl($row->tgl_blud);
				 $fields[] = 'Disetorkan '.$row->nama_pajak." atas ".$row->uraian;
				 $fields[] = '';
				 $fields[] = $row->nominal;
				 $fields[] = '';
				 $data[] = $fields;	
				}
				else{}
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pajak_model->count_all(),
			"recordsFiltered" => $this->Pajak_model->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function pdf_pajak(){
		
		$this->load->library("fpdf");

		$get = $this->input->get(NULL,TRUE);
		$tgl1 = element('tgl1',$get);
		$tgl2 = element('tgl2',$get);
		$id_kategori_pph = element('id_kategori_pph',$get);
		$setoran = rupiah_to_number(element('setoran',$get));

		if($id_kategori_pph != 0){
			$q1 = $this->db->select('tgl_blud,id_kategori_pph,nama_pph')
			->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph')
			->where('id_kategori_pph',$id_kategori_pph)
			->where('tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
			->group_by('date_format(tgl_blud,"%Y-%m")')
			->get('trs_blud');
			
			if($q1->num_rows() != 0){
				$query['query1'] = $q1->result_array();
				$query['cek'] = 0;
			}else{
				$q2 = $this->db->select('nama_pph')->where('id',$id_kategori_pph)->get('ms_kategori_pph')->row_array();
				$query['query1'] = array(array('tgl_blud' => $tgl1,'id_kategori_pph' => $id_kategori_pph,'nama_pph' => $q2['nama_pph']));
				$query['cek'] = 1;
			}
		}else{
			$q1 = $this->db->select('tgl_blud,"0" as id_kategori_pph,"PPN" as nama_pph')
			->where('tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
			->group_by('date_format(tgl_blud,"%Y-%m")')
			->get('trs_blud');
			
			if($q1->num_rows() != 0){
				$query['query1'] = $q1->result_array();
				$query['cek'] = 0;
			}else{
				$query['query1'] = array(array('tgl_blud' => $tgl1,'id_kategori_pph' => '0','nama_pph' => 'PPH'));
				$query['cek'] = 1;
			}
		}
		$query['tgl_cetak'] = $tgl2;
		$query['setoran'] = $setoran;
		
		$this->load->view("pdf_pajak",$query);
	}
}
?>
