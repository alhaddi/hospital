
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Pengeluaran_model extends MY_Model {

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
		if($_POST["length"] != -1)
		{
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query = $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left')
		->get();
		
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left')
		->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran','left')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph','left')
		->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where("id_blud",$id);
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

	public function insert_jurnal($data)
	{
		$this->db->insert('jurnal', $data);
		return $this->db->insert_id();
	}
	
	public function insert_saldo($data)
	{
		return $this->db->insert('saldo', $data);
		
	}

	public function update_jurnal($where, $data)
	{
		$this->db->update('jurnal', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function non_aktif_blud($status)
	{
		if($status != 1){
			$this->db->set('status', 'Tidak Aktif');
			$this->db->where('tgl_blud BETWEEN LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY AND LAST_DAY(NOW())');
			$this->db->update('trs_blud');
			
			$this->db->set('status', 'Tidak Aktif');
			$this->db->where('tanggal_jurnal BETWEEN LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY AND LAST_DAY(NOW())');
			$this->db->update('jurnal');
		}else{
			$this->db->set('status', 'Tidak Aktif');
			$this->db->where('tgl_blud BETWEEN LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY AND LAST_DAY(NOW() - INTERVAL 1 MONTH)');
			$this->db->update('trs_blud');
			
			$this->db->set('status', 'Tidak Aktif');
			$this->db->where('tanggal_jurnal BETWEEN LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY AND LAST_DAY(NOW() - INTERVAL 1 MONTH)');
			$this->db->update('jurnal');
		}
		return $this->db->affected_rows();
	}

	
	public function replace($data)
	{
		$this->db->replace_batch($this->table, $data);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where("id_blud", $id);
		$this->db->delete($this->table);
	}

	public function delete($id)
	{
		$this->db->where_in("id_blud", $id);
		$this->db->delete($this->table);
	}
	
	public function delete_jurnal($id)
	{
		$this->db->where_in("id_blud", $id);
		$this->db->delete('jurnal');
	}
	
	public function delete_jurnal_by_urut($id,$urut)
	{
		$this->db->where("id_blud", $id);
		$this->db->where("urut", $urut);
		$this->db->delete('jurnal');
	}
	
	public function list_fields($list_fields){
		$this->db->select(implode(",",$list_fields));
		$this->db->limit(1,0);
		$query = $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph')
		->get($this->table);
		return $query->field_data();
	}
	
	public function data_excel($field=""){
		$field = (!empty($field))?$field:$this->column_excel;
		$this->db->select($this->column_excel);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
	public function data_pdf1(){
		$query = $this->db->select('trs_blud.tgl_blud,trs_blud.no_cek,ms_kategori_pph.nama_pph')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph')
		->group_by('trs_blud.tgl_blud')
		->order_by('trs_blud.tgl_blud','ASC')
		->get($this->table);
		return $query->result_array();
	}
	
	public function data_pdf2($field="",$tgl_blud){
		$field = (!empty($field))?$field:$this->column_pdf;
		$this->db->select($field);
		$query = $this->db
		->join('anggaran','anggaran.id = trs_blud.id_anggaran')
		->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.`id_kategori_pph')
		->where('trs_blud.tgl_blud',$tgl_blud)
		->get($this->table);
		return $query->result_array();
	}

	public function get_jenis_biaya(){
		$result = $this->db->select('nama_anggaran as jenis_biaya')
		->where('id',$r['parent_id'])
		->get('anggaran')->row_array();

		return $result['jenis_biaya'];
	}

	public function get_cek_saldo(){
		$result = $this->db->select('saldo')->where('tanggal_saldo','LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY')->get('saldo');
		if($result->num_rows() != 0){
			return false;
		}else{
			return true;
		}
	}
}

