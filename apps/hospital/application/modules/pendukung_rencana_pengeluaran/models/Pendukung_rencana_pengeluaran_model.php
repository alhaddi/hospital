
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Pendukung_rencana_pengeluaran_model extends MY_Model {

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
						$this->db->where('DATE('.$this->table.'.tgl_blud) >=',convert_tgl($date1,'Y-m-d'));
						$this->db->where('DATE('.$this->table.'.tgl_blud) <=',convert_tgl($date2,'Y-m-d'));
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
		$this->_get_datatables_query();
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$this->db->select('id_blud, nama_anggaran, no_rekening, no_cek, tgl_blud, uraian, jumlah, ppn, nama_pph, pph, setoran, parent_id')
		->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left');
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$this->db->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left');
		return $this->db->count_all_results();
	}
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db->get($this->table);
		return $query->field_data();
	}
	
	public function data_pdf1($tgl1,$tgl2){
		$query = $this->db->select('trs_blud.tgl_blud,trs_blud.no_cek,ms_kategori_pph.nama_pph')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph')
		->where('trs_blud.tgl_blud between "'.$tgl1.'" and "'.$tgl2.'"')
		->group_by('no_cek')
		->group_by('nama_pph')
		->order_by('trs_blud.tgl_blud','ASC')
		->get($this->table);
		return $query->result_array();
	}
	
	public function data_pdf2($field="",$tgl_blud,$no_cek){
		$field = (!empty($field))?$field:$this->column_pdf;
		$this->db->select($field);
		$query = $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph','left')
		->where('trs_blud.no_cek',$no_cek)
		->where('date_format(trs_blud.tgl_blud,"%Y-%m-%d")',convert_tgl($tgl_blud,'Y-m-d',1))
		->get($this->table);
		return $query->result_array();
	}

	public function get_jenis_biaya($parent_id){
		$result = $this->db->select('nama_anggaran as jenis_biaya')
		->where('id',$parent_id)
		->get('anggaran')->row_array();

		return $result['jenis_biaya'];
	}
	
}

