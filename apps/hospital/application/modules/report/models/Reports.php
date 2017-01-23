

<?php

defined("BASEPATH") OR exit("No direct script access allowed");



class Reports extends MY_Model {



	var $table1;

	var $table2;

	var $column_order1;

	var $column_order2;

	var $column_search1;


	var $column_search4;
	var $column_search6;

	var $column_excel5;
	var $column_excel6;
	

	var $column_pdf4;
	var $column_pdf6;

	var $column_order3;
	var $column_order5;
	var $column_order4;
	var $column_order6;

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
		
		$this->table3 = $config["table3"];

		$this->column_order1 = $config["column_order1"]; //set column field database for datatable orderable

		$this->column_order2 = $config["column_order2"]; //set column field database for datatable orderable

		$this->column_order3 = $config["column_order3"]; //set column field database for datatable orderable

		$this->column_order4 = $config["column_order4"]; //set column field database for datatable orderable
		
		$this->column_order5 = $config["column_order5"]; //set column field database for datatable orderable
		
		$this->column_order6 = $config["column_order6"]; //set column field database for datatable orderable
		
		$this->column_order7 = $config["column_order5"]; //set column field database for datatable orderable
		
		$this->column_order8 = $config["column_order6"]; //set column field database for datatable orderable

		$this->column_search1 = $config["column_search1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_search2 = $config["column_search2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_search3 = $config["column_search3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_search4 = $config["column_search4"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_search5 = $config["column_search5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_search6 = $config["column_search6"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_search7 = $config["column_search5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_search8 = $config["column_search6"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel1 = $config["column_excel1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel2 = $config["column_excel2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel3 = $config["column_excel3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_excel4 = $config["column_excel4"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_excel5 = $config["column_excel4"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_excel6 = $config["column_excel5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_excel7 = $config["column_excel4"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_excel8 = $config["column_excel5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf1 = $config["column_pdf1"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf2 = $config["column_pdf2"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf3 = $config["column_pdf3"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->column_pdf4 = $config["column_pdf4"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_pdf5 = $config["column_pdf5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_pdf6 = $config["column_pdf6"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_pdf7 = $config["column_pdf5"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		
		$this->column_pdf8 = $config["column_pdf6"]; //set column field database for datatable searchable just firstname , lastname , address are searchable

		$this->order1 = $config["order1"]; // default order 

		$this->order2 = $config["order2"]; // default order 
		
		$this->order3 = $config["order3"]; // default order 

	}

	

	private function _get_datatables_query($p)

	{

		switch($p)

		{

			case '1' : 

				$order = $this->order1;

				$column_excel = $this->column_excel1;

				$column_pdf = $this->column_pdf1;

				$column_search = $this->column_search1;

				$column_order = $this->column_order1;

				break;

			case '2' : 

				$this->db->from($this->table1); 

				$order = $this->order1;

				$column_excel = $this->column_excel2;

				$column_pdf = $this->column_pdf2;

				$column_search = $this->column_search2;

				$column_order = $this->column_order2;

				break;				

			case '3' : 
				
				$column_excel = $this->column_excel3;

				$column_pdf = $this->column_pdf3;

				$column_search = $this->column_search3;

				$column_order = $this->column_order3;
				
				$this->db->from($this->table2); 
				break;

			case '4' : 
				$column_excel = $this->column_excel4;

				$column_pdf = $this->column_pdf4;

				$column_search = $this->column_search4;

				$column_order = $this->column_order4;
				
				$this->db->from($this->table2); 

				break;

			case '5' : 

				$this->db->from($this->table2); 

				$order = $this->order2;

				$column_excel = $this->column_excel5;

				$column_pdf = $this->column_pdf5;

				$column_search = $this->column_search5;

				$column_order = $this->column_order5;

				break;
			case '6' : 

				$this->db->from($this->table3); 

				$order = $this->order3;

				$column_excel = $this->column_excel6;

				$column_pdf = $this->column_pdf6;

				$column_search = $this->column_search6;

				$column_order = $this->column_order6;

				break;
				
			case '7' : 
				
				$column_excel = $this->column_excel7;

				$column_pdf = $this->column_pdf7;

				$column_search = $this->column_search7;

				$column_order = $this->column_order7;
				
				$this->db->from($this->table2); 
				break;

			case '8' : 
				$column_excel = $this->column_excel8;

				$column_pdf = $this->column_pdf8;

				$column_search = $this->column_search8;

				$column_order = $this->column_order8;
				
				$this->db->from($this->table2); 

				break;

		}
		
		$date_filter = array(
			1=>'ms_pasien',
			2=>'trs_appointment',
			3=>'trs_billing',
			4=>'trs_billing',
			5=>'trs_billing',
			6=>'trs_billing',
			7=>'trs_billing',
			8=>'trs_billing'
		);
		
		$where_filter = array();

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
							if($value == 'tindakan'){
								$where_filter['id_komponen'] = '4'; 
							}else if($value == 'rajal'){
								$where_filter['id_komponen'] = '1';
							}else if($value == 'igd'){
								$where_filter['id_komponen'] = '2';
							}else{
								$where_filter[$index] = $value; 
							}
						}
					}
					
					if(!empty($date1) && !empty($date2))
					{
						$this->db->where('DATE('.$date_filter[$p].'.last_update) >=',convert_tgl($date1,'Y-m-d'));
						$this->db->where('DATE('.$date_filter[$p].'.last_update) <=',convert_tgl($date2,'Y-m-d'));
					}
				}
				$where_filter = array_filter($where_filter);
				if(!empty($where_filter))
				{
					$where_filter = array_filter($where_filter);
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->where($where_filter);
					$this->db->group_end(); //close bracket
				}
				
				if($p == 1){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order1[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}elseif($p == 2){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order2[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}elseif($p == 3){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order3[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}elseif($p == 4){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order4[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}elseif($p == 5){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order5[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}elseif($p == 6){
					if(isset($_POST["order"])) // here order processing
					{
						$this->db->order_by($this->column_order6[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
					} 
				}
				
				// if(isset($_POST["order"])) // here order processing
				// {
					// $this->db->order_by($this->column_order[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
				// } 
				// else if(isset($this->order))
				// {
					// $this->db->order_by("trs_anamesa.status", "ASC");
					// $this->db->order_by("trs_anamesa.last_update","DESC");			
				// }
			}
		}

	}



	function get_datatables($p)

	{

		$this->_get_datatables_query($p);
		
		if($_POST["length"] != -1)

		{

			$this->db->limit($_POST["length"], $_POST["start"]);

		}

		switch($p){

			case '1' : 
				
				$this->db->from($this->table1); 
				
				$query = $this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_cara_bayar.nama as cara_bayar,
				ms_pasien.jk,
				ms_pasien.usia_thn,
				ms_pasien.usia_bln,
				ms_pasien.usia_hari,
				ms_pasien.hp,
				ms_pasien.alamat,
				ms_poliklinik.nama as poliklinik,
				ms_pasien.add_time as tgl_bergabung')
				->group_by('ms_pasien.id')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id')
				->get();
				break;
			
			case '2' : 
			$query = $this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_pegawai.nama as dokter,
				ms_cara_bayar.nama as cara_bayar,
				ms_komponen_registrasi.nama as nama_pembayaran,
				trs_billing.id_komponen,
				trs_billing.id_penunjang,
				trs_billing.nominal,
				trs_billing.last_update as tgl_datang,
				trs_billing.keterangan')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('trs_anamesa','trs_anamesa.id_appointment = trs_appointment.id')
				->join('ms_pegawai','trs_anamesa.id_dokter = ms_pegawai.id AND ms_pegawai.jenis_pegawai="dokter"','left')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
				->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing.id_komponen')
				->where('trs_billing.status','1')
				->where('trs_billing.nominal != 0')
				->get();
				break;
			case '3' : 
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.status = 1 AND trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (1)','left')
				->get();
				break;
			case '4' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
				->get();
				break;
			case '5' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (4)','left')
				->where('trs_appointment.id_poliklinik NOT IN (20,28)')
				->get();
				break;
			case '6' :
				$query = $this->db->select('
					ms_penunjang.nama as penunjang,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_penunjang.id')
				->join('trs_billing','trs_billing.id_ms_penunjang = ms_penunjang.id AND trs_billing.id_komponen IN (5)','left')
				->join('trs_appointment','trs_billing.id_appointment = trs_appointment.id')
				->get();
				break;
			case '7' : 
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.status = 1 AND trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (2)','left')
				->get();
				break;
			case '8' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
				->where('trs_appointment.id_poliklinik IN (20,28)')
				->get();
				break;

		}

		

		return $query->result();

	}



	function count_filtered($p)

	{

		$this->_get_datatables_query($p);

		$date_filter = array(
			1=>'ms_pasien',
			2=>'trs_appointment',
			3=>'trs_billing',
			4=>'trs_billing',
			5=>'trs_billing',
			6=>'trs_billing',
			7=>'trs_billing',
			8=>'trs_billing'
		);
		
		
		if(!empty($_POST['custom_filter']) && !empty($date_filter[$p]))
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
							if(!empty($value)){
								$where_filter[$index] = $value;
							}
						}
					}
					
					if(!empty($date1) && !empty($date2))
					{
						$this->db->where('DATE('.$date_filter[$p].'.add_time) >=',convert_tgl($date1,'Y-m-d'));
						$this->db->where('DATE('.$date_filter[$p].'.add_time) <=',convert_tgl($date2,'Y-m-d'));
					}
				}
				if(!empty($where_filter))
				{
					$where_filter = array_filter($where_filter);
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->where($where_filter);
					$this->db->group_end(); //close bracket
				}
			}
		}
		
		
		switch($p){

			case '1' : 
				
				$this->db->from($this->table1); 
				
				$query = $this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_cara_bayar.nama as cara_bayar,
				ms_pasien.jk,
				ms_pasien.usia_thn,
				ms_pasien.usia_bln,
				ms_pasien.usia_hari,
				ms_pasien.hp,
				ms_pasien.alamat,
				ms_poliklinik.nama as poliklinik,
				ms_pasien.add_time as tgl_bergabung')
				->group_by('ms_pasien.id')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id')
				->get();
				break;
			
			case '2' : 
			$query = $this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_cara_bayar.nama as cara_bayar,
				ms_komponen_registrasi.nama as nama_pembayaran,
				trs_billing.total_bayar,
				trs_billing.last_update as tgl_datang,
				trs_billing.keterangan')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
				->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing.id_komponen')
				->where('trs_billing.status','1')
				->get();
				break;
			case '3' : 
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.status = 1 AND trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (1,2)','left')
				->where('trs_billing.status','1')
				->get();
				break;
			case '4' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
				->get();
				break;
			case '5' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (4)','left')
				->get();
				break;
			case '6' :
				$query = $this->db->select('
					ms_penunjang.nama as penunjang,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_penunjang.id')
				->join('trs_billing','trs_billing.id_ms_penunjang = ms_penunjang.id AND trs_billing.id_komponen IN (5)','left')
				->join('trs_appointment','trs_billing.id_appointment = trs_appointment.id')
				->get();
				break;
			case '7' : 
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.status = 1 AND trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (1,2)','left')
				->where('trs_billing.status','1')
				->where('id_poliklinik','20')
				->where('id_poliklinik','28')
				->get();
				break;
			case '8' :
				$query = $this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
				->where('id_poliklinik','20')
				->where('id_poliklinik','28')
				->get();
				break;
			

		}

		return $query->num_rows();

	}



	public function count_all($p)

	{

		switch($p)

		{

			case '1' : 
			case '2' : $this->db->from($this->table1); break;
			case '3' : 
			case '4' : 
			case '5' : $this->db->from($this->table2); break;
			case '6' : $this->db->from($this->table3); break;
			case '5' : $this->db->from($this->table2); break;
			case '7' : 
			case '8' : $this->db->from($this->table2); break;
			

		}

		return $this->db->count_all_results();

	}

	

		

	public function list_fields($list_fields){

		$this->db->select(implode(",",$list_fields));

		$this->db->limit(1,0);

		

		$query = $this->db->get($this->table1);

		return $query->field_data();

	}

	

	public function data_excel($p,$tgl_awal,$tgl_akhir,$poliklinik = '',$cara_bayar = ''){

		switch($p)

		{

			case '1' : 

				$this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_cara_bayar.nama as cara_bayar,
				ms_pasien.jk,
				ms_pasien.usia,
				ms_pasien.hp,
				ms_pasien.alamat,
				ms_poliklinik.nama as poliklinik,
				ms_pasien.add_time as tgl_bergabung')
				->from('ms_pasien')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id')
				//->where('trs_appointment.id_poliklinik',$poliklinik)
				//->where('trs_appointment.id_cara_bayar',$cara_bayar)
				->where("date(ms_pasien.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
				$column_excel = $this->column_excel1;
				break;

			case '2' : 

				$query = $this->db->select('
				ms_pasien.rm,
				ms_pasien.no_identitas,
				ms_pasien.nama_lengkap,
				ms_cara_bayar.nama as cara_bayar,
				ms_komponen_registrasi.nama as nama_pembayaran,
				trs_billing.total_bayar,
				trs_billing.last_update as tgl_datang,
				trs_billing.keterangan')
				->from('ms_pasien')
				->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
				->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
				->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
				->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing.id_komponen')
				->where("date(ms_pasien.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");

				$column_excel = $this->column_excel3;

				break;				

			case '3' : 
				$this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->from('ms_poliklinik')
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (1,2)','left')
				->where("date(trs_billing.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
				
				$column_excel = $this->column_excel4;
				break;
			
			case '4' : 
				$this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->from('ms_poliklinik')
				->group_by('ms_poliklinik.id')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
				->where("date(trs_billing.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
				
				$column_excel = $this->column_excel4;
				break;

			case '5' :
				$this->db->select('
					ms_poliklinik.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_poliklinik.id')
				->from('ms_poliklinik')
				->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
				->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (4)','left')
				->where("date(trs_billing.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
				
				break;
			case '6' :
				$this->db->select('
					ms_penunjang.nama as poliklinik,
					IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
					IFNULL(SUM(trs_billing.nominal),0) as total
				',false)
				->group_by('ms_penunjang.id')
				->from('ms_penunjang')
				->join('trs_billing','trs_billing.id_ms_penunjang = ms_penunjang.id AND trs_billing.id_komponen IN (5)','left')
				->join('trs_appointment','trs_billing.id_appointment = trs_appointment.id')
				->where("date(trs_billing.last_update) BETWEEN '$tgl_awal' AND '$tgl_akhir'");
				break;
		}

		$query = $this->db->get();

		return $query->result_array();

	}

	

}



