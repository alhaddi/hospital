
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Pajak_model extends MY_Model {

	var $table;
	var $column_order;
	var $column_search;
	var $order;
	var $where_filter = array();
	
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
							$this->where_filter[$index] = $value; 
						}
					}
					
					if(!empty($date1) && !empty($date2))
					{
						$this->db->where('DATE('.$this->table.'.tgl_blud) >=',convert_tgl($date1,'Y-m-d'));
						$this->db->where('DATE('.$this->table.'.tgl_blud) <=',convert_tgl($date2,'Y-m-d'));

					}
				}
					$this->where_filter = array_filter($this->where_filter);
					if(!empty($this->where_filter))
					{
						$this->where_filter = array_filter($this->where_filter);
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
							$this->db->where($this->where_filter);
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
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		
			$query['p1'] = $this->db
			->select('
				tgl_blud,
				"PPN" as nama_pajak,
				uraian,
				ppn as nominal
			')
			->where('ppn != 0')
			->get()->result();
			$query['p2'] = $this->where_filter;
		return $query;
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db
		->select('
			tgl_blud,
			"PPN" as nama_pajak,
			uraian,
			ppn as nominal
		')
		->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$query = $this->db
		->select('
			tgl_blud,
			"PPN" as nama_pajak,
			uraian,
			ppn as nominal
		')
		->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db->get($this->table);
		return $query->field_data();
	}

	public function data_objek2($id_anggaran,$tgl_blud){
		return $this->db
		->select('
			tgl_blud,uraian,if(kategori_belanja="LS",jumlah,0) as ls,
			if(kategori_belanja="GU",jumlah,0) as gu,
			if(kategori_belanja="TUP",jumlah,0) as tup
		')
		->where('tgl_blud BETWEEN LAST_DAY("'.$tgl_blud.'" - INTERVAL 2 MONTH) + INTERVAL 1 DAY and LAST_DAY("'.$tgl_blud.'")')
		->where('id_anggaran',$id_anggaran)
		->get('trs_blud')->result_array();
	}

	
}

