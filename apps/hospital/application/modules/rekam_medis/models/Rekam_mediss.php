

<?php

defined("BASEPATH") OR exit("No direct script access allowed");



class Rekam_mediss extends MY_Model {



	var $table1;
	var $table2;
	var $table3;
	var $column_order1;
	var $column_order2;
	var $column_order3;
	var $column_search1;
	var $column_search2;
	var $column_search3;
	var $column_excel1;
	var $column_excel2;
	var $column_excel3;
	var $column_pdf1;
	var $column_pdf2;
	var $column_pdf3;
	var $order1;
	var $order2;
	var $order3;

	

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	

	public function initialize($config){

		$this->table1 = $config["table1"];
		$this->table2 = $config["table2"];
		$this->table3 = $config["table3"];

		$this->column_order1 = $config["column_order1"]; //set column field database for datatable orderable
		$this->column_order2 = $config["column_order2"]; //set column field database for datatable orderable
		$this->column_order3 = $config["column_order3"]; //set column field database for datatable orderable

		$this->column_search1 = $config["column_search1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_search2 = $config["column_search2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_search3 = $config["column_search3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel1 = $config["column_excel1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_excel2 = $config["column_excel2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_excel3 = $config["column_excel3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf1 = $config["column_pdf1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_pdf2 = $config["column_pdf2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_pdf3 = $config["column_pdf3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->order1 = $config["order1"]; // default order 
		$this->order2 = $config["order2"]; // default order 
		$this->order3 = $config["order3"]; // default order 

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
			
			case '3' :
				$this->db->from($this->table3); 
				$order = $this->order3;
				$column_excel = $this->column_excel3;
				$column_pdf = $this->column_pdf3;
				$column_search = $this->column_search3;
				$column_order = $this->column_order3;
			break;
		}
		
		if($_POST["length"] != -1)
		{
			if($p != '3'){
				$this->db->limit($_POST["length"], $_POST["start"]);
			}
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

		if($p != '3'){
			$query = $this->db->get();
		}else{
			$data_filter = array(
				'3' => 'trs_konsultasi'
			);
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
								if($index == 'id_poliklinik'){
									$where_filter['trs_appointment.'.$index] = $value;
								}else if($index == 'type'){
									$where_filter['trs_diagnosa.'.$index] = $value;
								}else{
									$where_filter[$index] = $value;
								}
							}
						}
						
						if(!empty($date1) && !empty($date2))
						{
							$this->db->where('DATE('.$data_filter[$p].'.add_time) >=',convert_tgl($date1,'Y-m-d'));
							$this->db->where('DATE('.$data_filter[$p].'.add_time) <=',convert_tgl($date2,'Y-m-d'));
						}
						
						if($p != '1'){
							$where_filter = array_filter($where_filter);
							if(!empty($where_filter))
							{
								if(array_key_exists ('kategori',$where_filter)){
									$this->db->limit($where_filter['kategori'],0);
									unset($where_filter['kategori']);
									
									if(!empty($where_filter)){
										$where_filter = array_filter($where_filter);
										$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
											$this->db->where($where_filter);
										$this->db->group_end(); //close bracket
									}
								}else{
									$where_filter = array_filter($where_filter);
									$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
										$this->db->where($where_filter);
									$this->db->group_end(); //close bracket
								}
							}else{
								if($p == '2'){
									$where_filter = array('trs_appointment.id_poliklinik' => '');
									$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
										$this->db->where($where_filter);
									$this->db->group_end(); //close bracket
								}
							}
						}
					}
				}
			}
			$query = $this->db->select('trs_diagnosa.code,trs_konsultasi.add_time,ms_icd.deskripsi_ing as deskripsi')
			->join('trs_diagnosa','trs_diagnosa.code = ms_icd.code','inner')
			->join('trs_konsultasi','trs_diagnosa.id_konsultasi = trs_konsultasi.id','inner')
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
			->group_by('trs_diagnosa.code')
			->get();
		}
		
		return $query->result_array();
	}



	function count_filtered($p)

	{

		$this->_get_datatables_query($p);

		if($p != '3'){
			$query = $this->db->get();
			return $query->num_rows();
		}else{
			$data_filter = array(
				'3' => 'trs_konsultasi'
			);
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
								if($index == 'id_poliklinik'){
									$where_filter['trs_appointment.'.$index] = $value;
								}else if($index == 'type'){
									$where_filter['trs_diagnosa.'.$index] = $value;
								}else{
									$where_filter[$index] = $value;
								}
							}
						}
						
						if(!empty($date1) && !empty($date2))
						{
							$this->db->where('DATE('.$data_filter[$p].'.add_time) >=',convert_tgl($date1,'Y-m-d'));
							$this->db->where('DATE('.$data_filter[$p].'.add_time) <=',convert_tgl($date2,'Y-m-d'));
						}
						
						if($p != '1'){
							$where_filter = array_filter($where_filter);
							if(!empty($where_filter))
							{
								if(array_key_exists ('kategori',$where_filter)){
									$this->db->limit($where_filter['kategori'],0);
									unset($where_filter['kategori']);
									
									if(!empty($where_filter)){
										$where_filter = array_filter($where_filter);
										$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
											$this->db->where($where_filter);
										$this->db->group_end(); //close bracket
									}
								}else{
									$where_filter = array_filter($where_filter);
									$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
										$this->db->where($where_filter);
									$this->db->group_end(); //close bracket
								}
							}else{
								if($p == '2'){
									$where_filter = array('trs_appointment.id_poliklinik' => '');
									$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
										$this->db->where($where_filter);
									$this->db->group_end(); //close bracket
								}
							}
						}
					}
				}
			}
			$query = $this->db->select('trs_diagnosa.code,trs_konsultasi.add_time,ms_icd.deskripsi_ing as deskripsi')
			->join('trs_diagnosa','trs_diagnosa.code = ms_icd.code','inner')
			->join('trs_konsultasi','trs_diagnosa.id_konsultasi = trs_konsultasi.id','inner')
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
			->group_by('trs_diagnosa.code')
			->get();
			
			return $query->num_rows();
		}
	}



	public function count_all($p)

	{
		if($p == '1'){
			$this->db->from($this->table1); 
			return $this->db->count_all_results();
		}else if($p == '2'){
			$this->db->from($this->table2); 
			return $this->db->count_all_results();
		}else{
			$this->db->from($this->table3); 
			return $this->db->count_all_results();
		}
		if($p != '3'){
			$query = $this->db->get();
			return $query->num_rows();
		}else{
			$query = $this->db->select('trs_diagnosa.code,trs_konsultasi.add_time,ms_icd.deskripsi_ing as deskripsi')
				->join('trs_diagnosa','trs_diagnosa.code = ms_icd.code','inner')
				->join('trs_konsultasi','trs_diagnosa.id_konsultasi = trs_konsultasi.id','inner')
				->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
				->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
				->group_by('trs_diagnosa.code')
				->get();
			return $query->num_rows();
		}
		
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
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan')
			->where('ms_tindakan.nama',$tindakan);
		}
		
		if($penunjang != null){
			$this->db->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
			->join('trs_penunjang','trs_penunjang.id = trs_billing.id_penunjang')
			->join('ms_penunjang','ms_penunjang.id = trs_billing.id_ms_penunjang');
			if($penunjang != 'lain2'){
				$this->db->where('ms_penunjang.nama',$penunjang);
			}else{
				$this->db->where('ms_penunjang.nama != "Penunjang EKG"')
				->where('ms_penunjang.nama != "Penunjang USG Kebidanan"')
				->where('ms_penunjang.nama != "Penunjang Audiologi"')
				->where('ms_penunjang.nama != "Penunjang Spirometri"');
			}
		}
		
		return $this->db->get('ms_pasien')->num_rows();
	}
	
	public function get_konsul($cara_bayar,$tipe_bayar,$konsul){
		$this->db->select('ms_pasien.id')
		->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner');
		
		if($cara_bayar == 'BPJS'){
			$this->db->join('ms_bpjs_type','trs_appointment.id_bpjs_type = ms_bpjs_type.id');
			
			if($tipe_bayar != null){
				$this->db->where('ms_bpjs_type.nama',$tipe_bayar);
			}
		}else if($cara_bayar != null){
			$this->db->where('ms_cara_bayar.nama',$cara_bayar);
		}else{}
		
		if($konsul != null){
			$this->db->join('trs_billing','trs_billing.id_appointment = trs_appointment.id')
			->where('id_komponen','3')
			->where('id_poliklinik',$konsul);
		}
		
		return $this->db->get('ms_pasien')->num_rows();
	}
	
	public function get_tindakan($cara_bayar,$tipe_bayar,$kategori){
		$this->db->select('SUM(trs_tindakan.jumlah_tindakan) as jml')
		->join('trs_konsultasi','trs_tindakan.id_konsultasi = trs_konsultasi.id','INNER')
		->join('ms_tindakan','trs_tindakan.id_ms_tindakan = ms_tindakan.id','INNER')
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','INNER')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','INNER')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_kategori_tindakan','ms_tindakan.id_kategori_tindakan = ms_kategori_tindakan.id');
		
		if($cara_bayar == 'BPJS'){
			$this->db->join('ms_bpjs_type','trs_appointment.id_bpjs_type = ms_bpjs_type.id');
			
			if($tipe_bayar != null){
				$this->db->where('ms_bpjs_type.nama',$tipe_bayar);
			}
		}else if($cara_bayar != null){
			$this->db->where('ms_cara_bayar.nama',$cara_bayar);
		}else{}
		
		if($kategori != null){
			$this->db->where('ms_kategori_tindakan.nama',$kategori);
		}
		
		$query = $this->db->get('trs_tindakan')->row_array();
		
		return $query['jml'];
	}
	
	public function get_nominal($cara_bayar,$tipe_bayar,$komponen){
		$this->db->select('sum(trs_billing.nominal) as nominal')
		->join('trs_anamesa','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('trs_konsultasi','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')		
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->join('trs_billing','trs_appointment.id = trs_billing.id_appointment','inner');
		
		if($cara_bayar == 'BPJS'){
			$this->db->join('ms_bpjs_type','trs_appointment.id_bpjs_type = ms_bpjs_type.id');
			
			if($tipe_bayar != null){
				$this->db->where('ms_bpjs_type.nama',$tipe_bayar);
			}
		}else if($cara_bayar != null){
			$this->db->where('ms_cara_bayar.nama',$cara_bayar);
		}else{}
		
		if($komponen != null){
			$this->db->where('trs_billing.id_komponen',$komponen);
		}
		
		$query = $this->db->get('trs_appointment')->row_array();
		
		return $query['nominal'];
	}
	
	public function get_nominal_konsul($cara_bayar,$tipe_bayar,$komponen){
		$this->db->select('sum(trs_billing.nominal) as nominal')		
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->join('trs_billing','trs_appointment.id = trs_billing.id_appointment','inner');
		
		if($cara_bayar == 'BPJS'){
			$this->db->join('ms_bpjs_type','trs_appointment.id_bpjs_type = ms_bpjs_type.id');
			
			if($tipe_bayar != null){
				$this->db->where('ms_bpjs_type.nama',$tipe_bayar);
			}
		}else if($cara_bayar != null){
			$this->db->where('ms_cara_bayar.nama',$cara_bayar);
		}else{}
		
		if($komponen != null){
			$this->db->where('trs_billing.id_komponen',$komponen);
		}
		
		$query = $this->db->get('trs_appointment')->row_array();
		
		return $query['nominal'];
	}
	
	public function get_diagnosa($jk,$diagnosa){
		$this->db->select('ms_pasien.id')
		->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('trs_anamesa','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('trs_konsultasi','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_diagnosa','trs_diagnosa.id_konsultasi = trs_konsultasi.id','inner')
		->where('ms_pasien.jk',$jk)
		->where('trs_diagnosa.code',$diagnosa);
		
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



