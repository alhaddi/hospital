

<?php

defined("BASEPATH") OR exit("No direct script access allowed");



class Rekam_mediss extends MY_Model {



	var $table1;
	var $table2;
	var $column_order1;
	var $column_order2;
	var $column_search1;
	var $column_search2;
	var $column_excel1;
	var $column_excel2;
	var $column_pdf1;
	var $column_pdf2;
	var $order1;
	var $order2;

	

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	

	public function initialize($config){

		$this->table1 = $config["table1"];
		$this->table2 = $config["table2"];

		$this->column_order1 = $config["column_order1"]; //set column field database for datatable orderable
		$this->column_order2 = $config["column_order2"]; //set column field database for datatable orderable

		$this->column_search1 = $config["column_search1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_search2 = $config["column_search2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel1 = $config["column_excel1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_excel2 = $config["column_excel2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf1 = $config["column_pdf1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_pdf2 = $config["column_pdf2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->order1 = $config["order1"]; // default order 
		$this->order2 = $config["order2"]; // default order 

	}

	

	public function _get_datatables_query($p)

	{
		switch($p){
			case '1' :
				$this->db->from($this->table1); 
				$order = $this->order1;
				$column_excel = $this->column_excel1;
				$column_pdf = $this->column_pdf1;
				$column_search = $this->column_search1;
				$column_order = $this->column_order1;
				break;
			
			case '2' :
				$this->db->from($this->table2); 
				$order = $this->order2;
				$column_excel = $this->column_excel2;
				$column_pdf = $this->column_pdf2;
				$column_search = $this->column_search2;
				$column_order = $this->column_order2;
			break;
		}
		
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}

		if(isset($_POST["order"])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		} 
		else if(isset($order))
		{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($p)
	{
		$this->_get_datatables_query($p);

		$query = $this->db->get();
		
		return $query->result_array();
	}



	function count_filtered($p)

	{

		$this->_get_datatables_query($p);
		
		$query = $this->db->get();

		return $query->num_rows();

	}



	public function count_all($p)

	{
		$this->_get_datatables_query($p);

		return $this->db->count_all_results();

	}
	
	public function get_pasien($status,$cara_bayar,$tipe_bayar,$konsul,$tindakan = '',$penunjang = '')
	{
		$this->db->select('ms_pasien.id')
		->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('trs_anamesa','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('trs_konsultasi','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner');
		
		if($cara_bayar == 'BPJS'){
			$this->db->join('ms_bpjs_type','trs_appointment.id_bpjs_type = ms_bpjs_type.id');
			
			if($tipe_bayar != null){
				$this->db->where('ms_bpjs_type.nama',$tipe_bayar);
			}
		}else if($cara_bayar != null){
			$this->db->where('ms_cara_bayar.nama',$cara_bayar);
		}else{}
		
		if($status == 'baru'){
			$this->db->where('date_format(ms_pasien.add_time,"%Y-%m-%d") = date_format(trs_konsultasi.add_time,"%Y-%m-%d")');
		}else if($status == 'lama'){
			$this->db->where('date_format(ms_pasien.add_time,"%Y-%m-%d") != date_format(trs_konsultasi.add_time,"%Y-%m-%d")');
		}else{}
		
		if($konsul != null){
			$this->db->join('trs_billing','trs_billing.id_appointment = trs_appointment.id')
			->where('id_komponen','3')
			->where('id_poliklinik',$konsul);
		}
		
		if($tindakan != null){
			$this->db->join('trs_tindakan','trs_tindakan.id_konsultasi = trs_konsultasi.id')
			->join('ms_tindakan','trs_tindakan.id_ms_tindakan = ms_tindakan.id')
			->where('ms_tindakan.nama',$tindakan);
		}
		
		if($penunjang != null){
			$this->db->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
			->join('trs_penunjang','trs_penunjang.id = trs_billing.id_penunjang')
			->join('ms_penunjang','ms_penunjang.id = trs_billing.id_ms_penunjang')
			->where('ms_penunjang.nama',$penunjang);
		}
		
		return $this->db->get('ms_pasien')->num_rows();
	}
	

	public function list_fields($list_fields){

		$this->db->select(implode(",",$list_fields));

		$this->db->limit(1,0);

		

		$query = $this->db->get($this->table1);

		return $query->field_data();

	}

	

	public function data_excel($field="",$p){

		$this->db->from($this->table1); 

		$column_excel = $this->column_excel1;

		$field = (!empty($field))?$field:$column_excel;

		$query = $this->db->get();

		return $query->result_array();

	}

	

	public function data_pdf($p){

		$this->db->from($this->table1); 

		$column_pdf = $this->column_pdf4;

		$field = (!empty($field))?$field:$column_pdf;

		$query = $this->db->get();

		return $query->result_array();

	}

	

}



