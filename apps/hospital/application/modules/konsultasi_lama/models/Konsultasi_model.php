

<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Konsultasi_model extends MY_Model {

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
		$this->column_excel = $config["column_excel"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->column_pdf = $config["column_pdf"]; //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->order = $config["order"]; // default order 
	}
	
	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
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
						$this->db->where('DATE('.$this->table.'.add_time) >=',convert_tgl($date1,'Y-m-d'));
						$this->db->where('DATE('.$this->table.'.add_time) <=',convert_tgl($date2,'Y-m-d'));
					}
				}
				//$where_filter = array_filter($where_filter);
				if(!empty($where_filter))
				{
					$where_filter = array_filter($where_filter);
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->where($where_filter);
					$this->db->group_end(); //close bracket
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
		
		if(isset($_POST["order"])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
			
			if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		
		$query = $this->db->select('
			trs_konsultasi.id,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.tipe_identitas,
			ms_pasien.no_identitas,
			ms_cara_bayar.nama as cara_bayar,
			ms_jenis_appointment.nama as jenis_appointment,
			ms_poliklinik.nama as poliklinik,
			ms_poliklinik.id as id_poliklinik,
			ms_pegawai.nama as dokter,
			trs_konsultasi.status,
			trs_konsultasi.add_time
		')
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND ms_pegawai.jenis_pegawai="dokter"','left')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
		$query = $this->db->select('
			trs_konsultasi.id,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.tipe_identitas,
			ms_pasien.no_identitas,
			ms_cara_bayar.nama as cara_bayar,
			ms_jenis_appointment.nama as jenis_appointment,
			ms_poliklinik.nama as poliklinik,
			ms_poliklinik.id as id_poliklinik,
			trs_konsultasi.status,
			trs_konsultasi.add_time
		')
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
		$this->db->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where("id",$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function replace($data)
	{
		$this->db->replace_batch($this->table, $data);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where("id", $id);
		$this->db->delete($this->table);
	}

	public function delete_tindakan($id)
	{
		$this->db->where_in("id", $id);
		$this->db->delete("trs_tindakan");
	}
	public function delete_penunjang($id)
	{
		$this->db->where_in("id", $id);
		$this->db->delete("trs_penunjang");
	}
	
	public function delete_diagnosa($id)
	{
		$this->db->where_in("id", $id);
		$this->db->delete("trs_diagnosa");
	}
	
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db->get($this->table);
		return $query->field_data();
	}
	
	public function data_excel($tgl1,$tgl2,$_column_order,$_dir_order){
		$field = (!empty($field))?$field:$this->column_excel;
		$this->db->select($this->column_excel);
		
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
		if(!empty($_column_order) || !empty($_dir_order)){
			$this->db->order_by($this->column_order[$_column_order],$_dir_order);
		}else{
			$this->db->order_by('trs_konsultasi.status','asc');
			$this->db->order_by('trs_konsultasi.last_update','desc');
		}
			
		$query = $this->db
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND jenis_pegawai="dokter"','left')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->where('trs_konsultasi.last_update between "'.$tgl1.'" and "'.$tgl2.'"')
		->where('trs_konsultasi.status','1')
		->get($this->table);
		return $query->result_array();
	}
	
	public function data_pdf($tgl1,$tgl2,$_column_order,$_dir_order){
		$field = (!empty($field))?$field:$this->column_pdf;
		$this->db->select($this->column_pdf);
		
		$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
		if(!empty($_column_order) || !empty($this->column_order[$_column_order])){
			$this->db->order_by($this->column_order[$_column_order],$_dir_order);
		}else{
			$this->db->order_by('trs_konsultasi.status','asc');
			$this->db->order_by('trs_konsultasi.last_update','desc');
		}
			
		$query = $this->db
		->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
		->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
		->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
		->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
		->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND ms_pegawai.jenis_pegawai="dokter"','left')
		->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
		->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
		->where('trs_konsultasi.last_update between "'.$tgl1.'" and "'.$tgl2.'"')
		->where('trs_konsultasi.status','1')
		->get($this->table);
		return $query->result_array();
	}
	
}

