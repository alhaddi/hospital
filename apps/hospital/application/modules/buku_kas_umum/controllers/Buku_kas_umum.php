<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Buku_kas_umum Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_kas_umum extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Buku_kas_umum_model');
		$config['table'] = 'trs_blud';
		$config['column_order'] = array(null,'id','nama',null);
		$config['column_search'] = array(null,'id_blud','id_anggaran',null);
		$config['column_pdf'] = array('nama');
		$config['order'] = array('id' => 'asc');
		$this->Buku_kas_umum_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Buku Kas Umum';
		$data['id_table'] = 'buku_kas_umum';
		$data['datatable_list'] = 'buku_kas_umum/ajax_list';
		$data['load_form'] = $this->load->view('form_buku_kas',$data,true);
		$this->template->display('buku_kas_umum',$data);
    }

    public function ajax_list()
	{	
		$list = $this->Buku_kas_umum_model->get_datatables();
		$saldo = $list['saldo']['saldo'];
		$data = array();
		$no = $_POST['start'];
		foreach ($list['jurnal'] as $row) {
				$no++;
				$fields = array();
				$saldo += $row['pemasukan']-$row['pengeluaran'];
				$fields[] = $no;
				
				 $fields[] = convert_tgl($row['tanggal'],'d-m-Y',1);
				 $fields[] = $row['uraian'];
				 $fields[] = $row['no_rekening'];
				 $fields[] = ($row['pemasukan']!=0)?rupiah($row['pemasukan']):'';
				 $fields[] = ($row['pengeluaran']!=0)?rupiah($row['pengeluaran']):'';
				 $fields[] = rupiah($saldo);
				
				$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Buku_kas_umum_model->count_all(),
			"recordsFiltered" => $this->Buku_kas_umum_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function pdf_buku_kas(){
		/*
		$get = $this->input->get(NULL,TRUE);
		$tgl1 = element('tgl1',$get);
		$tgl2 = element('tgl2',$get);
		
		$this->load->library("fpdf");
		$query['saldo'] = $this->db->select('saldo,tanggal_saldo,saldo_debit,saldo_kredit')
		->where('tanggal_saldo = LAST_DAY("'.$tgl1.'" - INTERVAL 2 MONTH) + INTERVAL 1 DAY')
		->get('saldo')->row_array();
		*/
		
		
		$get = $this->input->get(NULL,TRUE);
		$tgl1 = element('tgl1',$get);
		$tgl2 = element('tgl2',$get);
		
		$this->load->library("fpdf");
		$query['saldo'] = array('saldo' => rupiah_to_number($get['saldo']),'saldo_debit' => rupiah_to_number($get['penerimaan']),'saldo_kredit' => rupiah_to_number($get['pengeluaran']));
		//var_dump($query);
		//exit();

		$query['jurnal'] = $this->db
		->select('
			no_rekening,
			uraian,
			tanggal_jurnal as tanggal,
			if(tipe_jurnal="debit",jumlah_jurnal,0) AS pemasukan,
			if(tipe_jurnal="kredit",jumlah_jurnal,0) as pengeluaran,
			urut
			')
		->join('anggaran','anggaran.id = jurnal.id_anggaran','left')
		->where('tanggal_jurnal between "'.$tgl1.'" and "'.$tgl2.'"')
		->order_by('tanggal_jurnal','ASC')
		->order_by('urut','ASC')
		->get('jurnal')->result_array();

		$query['tanggal'] = $tgl2;

		$query['jmlpengeluaranlalu'] = $query['saldo']['saldo_kredit'];
		$query['jmlpenerimaanlalu'] = $query['saldo']['saldo_debit'];
		//var_dump($query);
		//exit();

		$this->load->view("pdf_buku_kas",$query);
	}
}
?>
