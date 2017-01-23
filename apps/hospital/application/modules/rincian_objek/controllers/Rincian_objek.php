<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Rincian_objek Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Rincian_objek extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Rincian_objek_model');
		$config['table'] = 'trs_blud';
		$config['column_order'] = array(null,'id_blud','id_anggaran',null);		
		$config['column_search'] = array(null,'id_blud','id_anggaran',null);		
		$config['column_pdf'] = array(null,'id_blud','id_anggaran',null);		
		$config['order'] = array('id_blud' => 'asc');
		$this->Rincian_objek_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Rincian Objek';
		$data['id_table'] = 'rincian_objek';
		$data['datatable_list'] = 'rincian_objek/ajax_list';

		$data['id_anggaran'] = $this->db->select('id, nama_anggaran')
		->where('status_anggaran','0')
		->get('anggaran')->result_array();
		$data['load_form'] = $this->load->view('form_rincian_objek',$data,true);
		$this->template->display('rincian_objek',$data);
    }

    public function ajax_list()
	{	
		$list = $this->Rincian_objek_model->get_datatables();
		$saldo = $list['saldo']['saldo'];
		$fields = array();
		$data = array();
		$no = $_POST['start'];
			
		foreach ($list['objek'] as $row) {
			$no++;
			$saldo += $row->ls-$row->gu-$row->tup;
			$fields[] = $no;
			
			 $fields[] = convert_tgl($row->tgl_blud,'d-m-Y',1);
	         $fields[] = $no;
			 $fields[] = $row->uraian;
			 $fields[] = rupiah($row->ls);
			 $fields[] = rupiah($row->gu);
			 $fields[] = rupiah($row->tup);
			 $fields[] = rupiah($saldo);
			
			$data[] = $fields;
			
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Rincian_objek_model->count_all(),
			"recordsFiltered" => $this->Rincian_objek_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function pdf_buku_rincian_objek(){
		
		$this->load->library("fpdf");

		$get = $this->input->get(NULL,TRUE);
		$tgl1 = element('tgl1',$get);
		$tgl2 = element('tgl2',$get);
		$id_anggaran = element('id_anggaran',$get);
		$saldo = element('saldo',$get);
		$ls = element('ls',$get);
		$gu = element('gu',$get);
		$tup = element('tup',$get);
		
		$query2['saldo'] = rupiah_to_number($saldo);
		$query2['ls'] = rupiah_to_number($ls);
		$query2['gu'] = rupiah_to_number($gu);
		$query2['tup'] = rupiah_to_number($tup);
		
		
		/*
		$q0 = $this->db->select('LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY as tgl_saldo')
		->get()->row_array();
		
		$q1 = $this->db->select('id_pagu')
		->join('pagu','pagu.id_anggaran = anggaran.id')
		->join('periode_pagu','pagu.id_periode = periode_pagu.id')
		->where('periode_pagu.status','Aktif')
		->where('anggaran.id',$id_anggaran)
		->get('anggaran')->row_array();
		
		$q2 = $this->db->select('saldo')
		->where('tanggal_saldo = LAST_DAY(NOW() - INTERVAL 3 MONTH) + INTERVAL 1 DAY')
		->get('saldo_objek')->row_array();
		
		$q3 = $this->db->select('sum(if(kategori_belanja="LS",jumlah,0)) as LS, sum(if(kategori_belanja="GU",jumlah,0)) as GU, sum(if(kategori_belanja="TUP",jumlah,0)) as TUP')
		->where('id_anggaran',$id_anggaran)
		->where('tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
		->get('trs_blud')->row_array();
		
		$query['id_pagu'] = $q1['id_pagu'];
		$query['tanggal_saldo'] = $q0['tgl_saldo'];
		$query['saldo_ls'] = $q3['LS'];
		$query['saldo_gu'] = $q3['GU'];
		$query['saldo_tup'] = $q3['TUP'];
		$query['saldo'] = $q2['saldo']-$q3['LS']-$q3['GU']-$q3['TUP'];
		
		$success = $this->Rincian_objek_model->insert_saldo_objek($query);
		*/
		
		//----
		
		/*
		$q4 = $this->db->select('saldo_objek.id_pagu,saldo,tanggal_saldo,saldo_ls,saldo_gu,saldo_tup,pagu')
		->join('pagu','pagu.id_pagu = saldo_objek.id_pagu')
		->join('periode_pagu','pagu.id_periode = periode_pagu.id')
		->where('periode_pagu.status','Aktif')
		->where('pagu.id_anggaran',$id_anggaran)
		->where('tanggal_saldo = LAST_DAY("'.convert_tgl($tgl1,'Y-m-d',1).'" - INTERVAL 2 MONTH) + INTERVAL 1 DAY')
		->get('saldo_objek')->row_array();
		
		if(convert_tgl($q4['tanggal_saldo'],'Y',1)==date('Y')){
			$query2['saldo'] = $q4['saldo'];
			$query2['jmlLs'] = $q4['saldo_ls'];
			$query2['jmlGu'] = $q4['saldo_gu'];
			$query2['jmlTup'] = $q4['saldo_tup'];
		}else{
			$query2['saldo'] = $q4['pagu'];
			$query2['jmlLs'] = '';
			$query2['jmlGu'] = '';
			$query2['jmlTup'] = '';
		}
		*/
		
		$q1 = $this->db->select('trs_blud.id_anggaran,nama_anggaran,no_rekening,pagu,tgl_blud,last_day(tgl_blud) as last')
		->where('anggaran.id',$id_anggaran)
		->where('tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
		->join('anggaran','anggaran.id = trs_blud.id_anggaran')
		->join('pagu','anggaran.id = pagu.id_anggaran')
		->get('trs_blud');
		
		if($q1->num_rows() != 0){
			$query2['query1'] = $q1->result_array();
			$query2['cek'] = 0;
		}else{
			$q2 = $this->db->select('id_anggaran,nama_anggaran,no_rekening,pagu')
			->join('pagu','anggaran.id = pagu.id_anggaran')
			->where('anggaran.id',$id_anggaran)
			->get('anggaran')->result_array();
			foreach($q2 as $r){
				$fields['id_anggaran'] = $r['id_anggaran'];
				$fields['nama_anggaran'] = $r['nama_anggaran'];
				$fields['no_rekening'] = $r['no_rekening'];
				$fields['pagu'] = $r['pagu'];
				$fields['tgl_blud'] = $tgl2;
				$fields['last'] = $tgl2;
				$data[] = $fields;
			}
			$query2['query1'] = $data;
			$query2['cek'] = 1;
		}
		
		$query2['tgl_cetak'] = $tgl2;
		
		$this->load->view("pdf_buku_rincian_objek",$query2);
	}
}
?>
