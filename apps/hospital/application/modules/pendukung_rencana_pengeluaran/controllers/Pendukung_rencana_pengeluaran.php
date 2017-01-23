<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Pendukung_rencana_pengeluaran Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendukung_rencana_pengeluaran extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pendukung_rencana_pengeluaran_model');
		$config['table'] = 'trs_blud';
		$config['column_order'] = array(null,'id_blud','id_anggaran',null);
		$config['column_search'] = array(null,'id_blud','id_anggaran',null);
		$config['column_pdf'] = array('id_blud','nama_anggaran','no_rekening','no_cek','uraian','jumlah','ppn','id_kategori_pph','pph','parent_id');
		$config['order'] = array('id_blud' => 'asc');
		$this->Pendukung_rencana_pengeluaran_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Pendukung Rencana Pengeluaran';
		$data['id_table'] = 'pendukung_rencana_pengeluaran';
		$data['datatable_list'] = 'pendukung_rencana_pengeluaran/ajax_list';
		$this->template->display('pendukung_rencana_pengeluaran',$data);
    }

    public function ajax_list()
	{	
		$list = $this->Pendukung_rencana_pengeluaran_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$result = $this->Pendukung_rencana_pengeluaran_model->get_jenis_biaya($row->parent_id);
			
			$no++;
			$fields = array();
			$fields[] = $no;
                 	$fields[] = $result;
                 	$fields[] = $row->no_rekening;
                 	$fields[] = $row->uraian;
                 	$fields[] = rupiah($row->jumlah);
                 	$fields[] = rupiah($row->ppn);
                 	$fields[] = $row->nama_pph;
                 	$fields[] = rupiah($row->pph);
                 	$fields[] = rupiah($row->setoran);
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pendukung_rencana_pengeluaran_model->count_all(),
			"recordsFiltered" => $this->Pendukung_rencana_pengeluaran_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

    public function pdf_pendukung()
	{
		$get = $this->input->get(NULL,TRUE);
		
		$this->load->library("Fpdf");
		$this->load->library('currency');
		
		$tgl1 = element('tgl1',$get);
		$tgl2 = element('tgl2',$get);

		$data = array();
		$query1 = $this->db->select('trs_blud.tgl_blud,trs_blud.no_cek')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph','left')
		->where('trs_blud.tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
		->group_by('no_cek')
		->order_by('trs_blud.tgl_blud','ASC')
		->get('trs_blud')->result_array();

		$data['query1'] = $query1;
		$data['tgl_cetak'] = $tgl2;
		$this->load->view('pdf_pendukung_rencana_pengeluaran',$data);
	}
}
?>
