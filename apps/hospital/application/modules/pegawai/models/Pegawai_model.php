
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Pegawai_model extends MY_Model {

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
	
	private function _get_datatables_query($jenis)
	{
		
		$this->db->from($this->table);

		$i = 0;
		
		$poli=$this->session->userdata('id_pol');
		if($poli){
		$w=" (id_poliklinik IN ($poli) OR id_poliklinik IS NULL OR id_poliklinik ='')";
		}else{
		$w=" (id_poliklinik ='' OR id_poliklinik IS NULL OR id_poliklinik ='')";	
			}
		$w.=" AND jenis_pegawai='$jenis'";
		$this->db->where($w);
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

	function get_datatables($jenis)
	{
		$this->_get_datatables_query($jenis);
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($jenis)
	{
		$this->_get_datatables_query($jenis);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_user_id($id)
	{
		$this->db->select("ms_user.id,ms_user.id as id_user,
ms_user.id_poliklinik,
ms_user.id_penunjang,
ms_user.id_pegawai,
sys_login.username");
		$this->db->where("id_pegawai",$id);
		$this->db->join("sys_login","sys_login.id_user = ms_user.id");
		$query = $this->db->get('ms_user');

		return $query->row_array();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where("id",$id);
		$query = $this->db->get();

		return $query->row_array();
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

	public function delete($id)
	{
		$this->db->where_in("id", $id);
		$this->db->delete($this->table);
	}
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db->get($this->table);
		return $query->field_data();
	}
	
	public function data_excel($field=""){
		$field = (!empty($field))?$field:$this->column_excel;
		$this->db->select($this->column_excel);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
	public function data_pdf($field=""){
		$field = (!empty($field))?$field:$this->column_pdf;
		$this->db->select($this->column_pdf);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
}

