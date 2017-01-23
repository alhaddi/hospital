<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Lap_fungsional Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_fungsional extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Lap_fungsional_model');
		$config['table'] = 'pagu';
		$config['column_order'] = array(null,'id_pagu','id_anggaran',null);
		$config['column_search'] = array(null,'id_pagu','id_anggaran',null);
		$config['column_pdf'] = array('id_pagu','id_anggaran');
		$config['order'] = array('id_pagu' => 'asc');
		$this->Lap_fungsional_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Lap Fungsional';
		$data['id_table'] = 'lap_fungsional';
		$data['datatable_list'] = 'lap_fungsional/ajax_list';
		
		$this->template->display('lap_fungsional',$data);
    }

    public function ajax_list()
	{	
		$list = $this->Lap_fungsional_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $no;
					$fields[] = $row->id;
                 	$fields[] = $row->no_rekening;
                 	$fields[] = $row->nama_anggaran;
                 	$fields[] = $row->pagu;
                 	$fields[] = $row->sd_bulan_lalu1;
                 	$fields[] = $row->bulan_ini1;
                 	$fields[] = $row->sd_bulan_ini1;
					$fields[] = $row->sd_bulan_lalu2;
                 	$fields[] = $row->bulan_ini2;
                 	$fields[] = $row->sd_bulan_ini2;
					$fields[] = $row->sd_bulan_lalu3;
                 	$fields[] = $row->bulan_ini3;
                 	$fields[] = $row->sd_bulan_ini3;
					$fields[] = $row->jumlah_spj;
                 	$fields[] = $row->sisa_pagu;
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Lap_fungsional_model->count_all(),
			"recordsFiltered" => $this->Lap_fungsional_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

    public function pdf_lap_fungsional()
	{
		
		$this->load->library("fpdf");

		$this->load->view('pdf_lap_fungsional');
	}
}
?>
