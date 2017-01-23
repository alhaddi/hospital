
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Rincian_objek_model extends MY_Model {

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
							$this->db->where('tanggal_saldo BETWEEN LAST_DAY("'.convert_tgl($date1,'Y-m-d').'" - INTERVAL 3 MONTH) + INTERVAL 1 DAY and LAST_DAY("'.convert_tgl($date2,'Y-m-d').'" - INTERVAL 1 MONTH)');
						}
					}
				}
				if($p2 != 'saldo'){
					$where_filter = array_filter($where_filter);
					if(!empty($where_filter))
					{
						$where_filter = array_filter($where_filter);
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
							$this->db->where($where_filter);
						$this->db->group_end(); //close bracket
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
		$query['saldo'] = $this->db->select('saldo')
		->get()->row_array();

		$this->_get_datatables_query('tgl_blud','trs_blud');
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query['objek'] = $this->db
		->select('
			tgl_blud,uraian,if(kategori_belanja="LS",jumlah,0) as ls,
			if(kategori_belanja="GU",jumlah,0) as gu,
			if(kategori_belanja="TUP",jumlah,0) as tup
		')
		->get()->result();
		return $query;
	}

	function count_filtered()
	{
		$this->_get_datatables_query('tgl_blud','trs_blud');
		$query = $this->db
		->select('
			tgl_blud,uraian,if(kategori_belanja="LS",jumlah,0) as ls,
			if(kategori_belanja="GU",jumlah,0) as gu,
			if(kategori_belanja="TUP",jumlah,0) as tup
		')
		->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db
		->select('
			tgl_blud,uraian,if(kategori_belanja="LS",jumlah,0) as ls,
			if(kategori_belanja="GU",jumlah,0) as gu,
			if(kategori_belanja="TUP",jumlah,0) as tup
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
		$query = $this->db
		->select('
			tgl_blud,uraian,if(kategori_belanja="LS",jumlah,0) as ls,
			if(kategori_belanja="GU",jumlah,0) as gu,
			if(kategori_belanja="TUP",jumlah,0) as tup
		')
		->where('tgl_blud BETWEEN LAST_DAY("'.$tgl_blud.'" - INTERVAL 2 MONTH) + INTERVAL 1 DAY and LAST_DAY("'.$tgl_blud.'")')
		->where('id_anggaran',$id_anggaran)
		->get('trs_blud');
		
		if($query->num_rows() != 0){
			return $query->result_array();
		}else{
			return array(array('tgl_blud'=>$tgl_blud,'uraian'=>'NIHIL','ls'=>0,'gu'=>0,'tup'=>0));
		}
	}
	
	public function insert_saldo_objek($data)
	{
		return $this->db->insert('saldo_objek', $data);
		
	}

	
}

