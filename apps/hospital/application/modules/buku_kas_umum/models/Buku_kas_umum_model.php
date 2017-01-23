
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Buku_kas_umum_model extends MY_Model {

	var $table;
	var $column_order;
	var $column_search;
	var $order;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function initialize($config){
		
		$this->table = $config["table"];
		$this->column_order = $config["column_order"]; //set column field database for datatable orderable
		$this->column_search = $config["column_search"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_pdf = $config["column_pdf"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->order = $config["order"]; // default order 
	}
	
	private function _get_datatables_query($p1,$p2)
	{
		$this->db->from($p2);

		if(!empty($_POST['custom_filter']))
		{
			$custom_filter = $_POST['custom_filter'];
			
			if(count($custom_filter)>0)
			{
				foreach($custom_filter as $cf){
					foreach($cf  as $index=>$value){
						if($index == 'datatable_daterange1')
						{
							$date1 = $value;
						}
						elseif($index == 'datatable_daterange2')
						{
							$date2 = $value;
						}
						else
						{
							$where_filter[$index] = $value; 
						}
					}
					
					if(!empty($date1) && !empty($date2))
					{
						if($p2 != 'saldo'){
							$this->db->where('DATE('.$p2.'.'.$p1.') >=',convert_tgl($date1,'Y-m-d'));
							$this->db->where('DATE('.$p2.'.'.$p1.') <=',convert_tgl($date2,'Y-m-d'));
						}else{
							$this->db->where('tanggal_saldo = LAST_DAY("'.convert_tgl($date1,'Y-m-d').'" - INTERVAL 2 MONTH) + INTERVAL 1 DAY');
						}
					}
				}
			}
		}
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST["search"]["value"]) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST["search"]["value"]);
				}
				else
				{
					$this->db->or_like($item, $_POST["search"]["value"]);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query('tanggal_saldo','saldo');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query['saldo'] = $this->db->select('saldo,tanggal_saldo')
		->get()->row_array();

		$field = array(
			'no_rekening' => '',
			'uraian' => 'Saldo Bulan Lalu',
			'tanggal' => $query['saldo']['tanggal_saldo'],
			'pemasukan' => '',
			'pengeluaran' => '',
			'urut' => '0',
			'nama_pph' => ''
			
		);
		$q0[] = $field;

		$this->_get_datatables_query('tanggal_jurnal','jurnal');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}

		$q1 = $this->db
		->select('
			no_rekening,
			uraian,
			tanggal_jurnal as tanggal,
			if(tipe_jurnal="debit",jumlah_jurnal,0) AS pemasukan,
			if(tipe_jurnal="kredit",jumlah_jurnal,0) as pengeluaran,
			urut
			')
		->join('anggaran','anggaran.id = jurnal.id_anggaran','left')
		->order_by('tanggal_jurnal','ASC')
		->order_by('urut','ASC')
		->get()->result_array();

		$query['jurnal'] = array_merge($q0,$q1);

		return $query;
	}

	function count_filtered()
	{
		$this->_get_datatables_query('tanggal_saldo','saldo');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$q0 = $this->db->select('saldo,tanggal_saldo')
		->get()->num_rows();

		$this->_get_datatables_query('tanggal_jurnal','jurnal');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}

		$q1 = $this->db
		->select('
			no_rekening,
			uraian,
			tanggal_jurnal as tanggal,
			if(tipe_jurnal="debit",jumlah_jurnal,0) AS pemasukan,
			if(tipe_jurnal="kredit",jumlah_jurnal,0) as pengeluaran,
			urut
			')
		->join('anggaran','anggaran.id = jurnal.id_anggaran','left')
		->order_by('tanggal_jurnal','ASC')
		->order_by('urut','ASC')
		->get()->num_rows();

		return $q0+$q1;
	}

	public function count_all()
	{
		$this->_get_datatables_query('tanggal_saldo','saldo');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$q0 = $this->db->select('saldo,tanggal_saldo')
		->count_all_results();

		$this->_get_datatables_query('tanggal_jurnal','jurnal');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}

		$q1 = $this->db
		->select('
			no_rekening,
			uraian,
			tanggal_jurnal as tanggal,
			if(tipe_jurnal="debit",jumlah_jurnal,0) AS pemasukan,
			if(tipe_jurnal="kredit",jumlah_jurnal,0) as pengeluaran,
			urut
			')
		->join('anggaran','anggaran.id = jurnal.id_anggaran','left')
		->order_by('tanggal_jurnal','ASC')
		->order_by('urut','ASC')
		->count_all_results();

		return $q0+$q1;
	}
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db->get($this->table);
		return $query->field_data();
	}
	
	public function data_pdf($field=""){
		$field = (!empty($field))?$field:$this->column_pdf;
		$this->db->select($this->column_pdf);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	public function get_pengeluaran($tgl1,$tgl2){
		$this->db
		->select('
			no_rekening,
			uraian,
			tgl_blud as tanggal,
			"0" as pemasukan,
			setoran as pengeluaran,
			"1" as urut,
			"" as nama_pph
			')
		->join('anggaran','anggaran.id = trs_blud.id_anggaran');
	}

	public function get_pengeluaran_ppn($tgl1,$tgl2){
		$this->db
		->select('
			"" as no_rekening,
			"Dibayarkan atas PPN" as uraian,
			tgl_blud as tanggal,
			"" AS pemasukan, 
			IF(ppn is not null,ppn,0) AS pengeluaran,
			"2" as urut,
			"" as nama_pph
			')
		->where('ppn != 0');
	}

	public function get_pengeluaran_pph($tgl1,$tgl2){
		$this->db
		->select('
			"" as no_rekening,
			"Dibayarkan atas" as uraian,
			tgl_blud as tanggal,
			"" AS pemasukan, 
			IF(pph is not null,pph,0) AS pengeluaran,
			"3" as urut,
			nama_pph 
			')
		->where('pph != 0')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph');

	}
	
	public function get_penerimaan($tgl1,$tgl2){
		$this->db
		->select('
			"" as no_rekening,
			uraian,
			tanggal_jurnal as tanggal,
			jumlah_jurnal AS pemasukan,
			"0" as pengeluaran,
			"4" as urut,
			"" as nama_pph
			')
		->where('tipe_jurnal','debit');
	}
	
}

