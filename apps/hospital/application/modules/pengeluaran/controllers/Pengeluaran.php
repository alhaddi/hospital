
<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Anggaran Pengeluaran Controller
	* @author          
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends MY_Controller
{
	var $time_blud = 0;
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pengeluaran_model');
		$config['table'] = 'trs_blud';
		$config['column_order'] = array(null,'id_blud','id_anggaran','no_cek','tgl_blud','uraian','jumlah','ppn','id_kategori_pph','pph','setoran','kategori_belanja',null);
		$config['column_search'] = array('nama_anggaran','no_rekening','no_cek','date_format(tgl_blud,"%d-%m-%Y")','uraian','jumlah','ppn','id_kategori_pph','pph','setoran','kategori_belanja');
		$config['column_excel'] = array('id_blud','id_anggaran','no_cek','tgl_blud','uraian','jumlah','ppn','id_kategori_pph','pph','setoran','kategori_belanja');
		$config['column_pdf'] = array('id_blud','nama_anggaran','no_rekening','no_cek','tgl_blud','uraian','jumlah','ppn','id_kategori_pph','pph','parent_id');
		$config['order'] = array('id_blud' => 'asc');
		$this->Pengeluaran_model->initialize($config);
    }

    public function index()
    {
		$data['title'] = 'Data Pendukung Pengeluaran';
		$data['id_table'] = 'pengeluaran';
		$data['datatable_list'] = 'pengeluaran/ajax_list';
		$data['datatable_edit'] = 'pengeluaran/ajax_edit';
		$data['datatable_delete'] = 'pengeluaran/ajax_delete';
		$data['datatable_save'] = 'pengeluaran/ajax_save';
				
		$data['load_form'] = $this->load_form($data);
		$this->template->display('pengeluaran',$data);
    }

    public function load_form($data)
	{
		$data['kategori_pph'] = $this->db->select('id,nama_pph')
		->get('ms_kategori_pph')->result_array();
		$data['anggaran'] = $this->db->select('id,nama_anggaran,no_rekening')
		->where('status_anggaran','0')
		->get('anggaran')->result_array();
		return $this->load->view('form_pengeluaran',$data,true);
	}

    public function ajax_list()
	{	
		$list = $this->Pengeluaran_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$no++;
			$fields = array();
				$fields[] = ($row->status == 'Aktif')?'<input type="checkbox" data-datatable-bulk_delete="true" name="id[]" value="'.$row->id_blud.'">':'';
			$fields[] = $no;
			
			 $fields[] = $row->nama_anggaran;
			 $fields[] = $row->no_rekening;
			 $fields[] = $row->no_cek;
			 $fields[] = convert_tgl($row->tgl_blud,'d-m-Y',1);
			 $fields[] = $row->uraian;
			 $fields[] = rupiah($row->jumlah);
			 $fields[] = rupiah($row->ppn);
			 $fields[] = $row->nama_pph;
			 $fields[] = rupiah($row->pph);
			 $fields[] = rupiah($row->setoran);
			 $fields[] = $row->kategori_belanja;
			 
				$fields[] = ($row->status == 'Aktif')?'<button onclick="modal_pengeluaran('.$row->id_blud.')" type="button" class="btn btn-default" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>':'';
			
			$data[] = $fields;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pengeluaran_model->count_all(),
			"recordsFiltered" => $this->Pengeluaran_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function ajax_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		$data_object = (array) $this->Pengeluaran_model->get_by_id($id);
		$data_object['ls'] = $data_object['kategori_belanja'];
		if($data_object)
		{
			$list_fields = array(
			 'id_blud',
			 'id_anggaran',
			 'no_cek',
			 'tgl_blud',
			 'uraian',
			 'jumlah',
			 'ppn',
			 'id_kategori_pph',
			 'pph',
			 'kategori_belanja'
			);
			
			$fields = $this->Pengeluaran_model->list_fields($list_fields);
			$data = (array) $data_object;
								
			foreach($fields as $meta){
				if($meta->name != 'ppn'){
					if($meta->name == 'tgl_blud'){
						$tgl = explode(" ",$data[$meta->name]);
						$data_new['value'] = $tgl[1];
						$data_new['name'] = 'time_blud';
						$data_array[] = $data_new;
						
						$data_new['value'] = convert_tgl($tgl[0],'d/m/Y',1);
						$data_new['name'] = $meta->name;
						$data_array[] = $data_new;
					}else{
						$data_new['value'] = $data[$meta->name];
						$meta->name =($meta->name == 'kategori_belanja')? 'ls' : $meta->name;
						$data_new['name'] = $meta->name;
						$data_array[] = $data_new;
					}
				}else{
					$data_new['value'] = $data[$meta->name];
					$data_new['name'] = $meta->name;
					$data_array[] = $data_new;
					
					$data_new['value'] = $data[$meta->name];
					$meta->name = 'ppn_money';
					$data_new['name'] = $meta->name;
					$data_array[] = $data_new;
				}
			}
			
			$result['status'] = 0;
			$result['data_array'] = $data_array;
			unset($data_object['kategori_belanja']);
			$data_object = (object) $data_object;
			$result['data_object'] = $data_object;
			$response = $data_array;
		}
		else
		{
			$result['status'] = '99';
			$response['response'] = $result;
		}
		echo json_encode($response);
	}

	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
		$jumlah = (int)rupiah_to_number($post['jumlah']);
		$ppn = 0;
		$pph = 0;
		
		if(isset($post['ppn'])){
			$ppn = $post['ppn_money'];
		}
		
		if($post['id_kategori_pph'] == '2'){
			$pph = $post['pph'];
		}else{
			$pph = (int)rupiah_to_number($post['pph']);
		}
		
		if(isset($post['ppn']) || isset($pph)){
			$setoran = $jumlah-($ppn+$pph);
		}
	
		if(empty($post['id_blud']))
		{
			$data = array(
			 'id_anggaran' => $post['id_anggaran'],	
			 'no_cek' => $post['no_cek'],	
			 'tgl_blud' => convert_tgl($post['tgl_blud'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
			 'uraian' => $post['uraian'],	
			 'jumlah' => $jumlah,	
			 'ppn' => $ppn,	
			 'id_kategori_pph' => $post['id_kategori_pph'],	
			 'pph' => $pph,	
			 'setoran' => $setoran,
			 'kategori_belanja' => $post['ls']
			);
			$data = array_string_to_null($data);
			$this->db->trans_start();
		
			$this->Pengeluaran_model->insert($data);
			
			$anggaran = $this->db->select('nama_anggaran')->where('id',$post['id_anggaran'])->get('anggaran')->row_array();
			$data2 = array(
			 'jumlah_jurnal' => $setoran,	
			 'id_blud' => $this->db->insert_id(),
			 'id_anggaran' => $post['id_anggaran'],	
			 'tipe_jurnal' => 'kredit',	
			 'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
			 'uraian' => $anggaran['nama_anggaran'].' '.$post['uraian'],
			 'urut' => '1'
			 
			);
			$data2 = array_string_to_null($data2);
		
			if($ppn!=0){
				$data3 = array(
				'jumlah_jurnal' => $ppn,
				'id_blud' => $data2['id_blud'],				
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas PPN",
				'urut' => '2'
				);
				$data3 = array_string_to_null($data3);
			}
			
			if($pph!=0){
				$nama_pph = $this->db->select('nama_pph')
				->where('id',$post['id_kategori_pph'])
				->get('ms_kategori_pph')->row_array();
				
				$data4 = array(
				'jumlah_jurnal' => $pph,
				'id_blud' => $data2['id_blud'],
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas ".$nama_pph['nama_pph'],
				'urut' => '3'
				);
				$data4 = array_string_to_null($data4);
			}
			
			$this->Pengeluaran_model->insert_jurnal($data2);
			if($ppn!=0){
			$this->Pengeluaran_model->insert_jurnal($data3);
			}
			if($pph!=0){
			$this->Pengeluaran_model->insert_jurnal($data4);
			}
			
			$this->db->trans_complete();
		}
		else
		{
			$data5 = array(
			 'id_anggaran' => $post['id_anggaran'],	
			 'no_cek' => $post['no_cek'],	
			 'tgl_blud' => convert_tgl($post['tgl_blud'].' '.$post['time_blud'],'Y-m-d H:i:s',1),
			 'uraian' => $post['uraian'],	
			 'jumlah' => $jumlah,	
			 'ppn' => $ppn,	
			 'id_kategori_pph' => $post['id_kategori_pph'],	
			 'pph' => $pph,	
			 'setoran' => $setoran,
			 'kategori_belanja' => $post['ls']
			);
			$data5 = array_string_to_null($data5);
			
			$anggaran = $this->db->select('nama_anggaran')->where('id',$post['id_anggaran'])->get('anggaran')->row_array();
			$data6 = array(
			 'jumlah_jurnal' => $setoran,
			 'id_anggaran' => $post['id_anggaran'],	
			 'tipe_jurnal' => 'kredit',	
			 'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.$post['time_blud'],'Y-m-d H:i:s',1),
			 'uraian' => $anggaran['nama_anggaran'].' '.$post['uraian'],
			 'urut' => '1'
			);
			$data6 = array_string_to_null($data6);
			
			$ppn_db = $this->db->select('ppn')->where('id_blud',$post['id_blud'])->get('trs_blud')->row_array();
			if($ppn_db['ppn'] != $ppn && $ppn != 0){
				$data7 = array(
				'jumlah_jurnal' => $ppn,
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.$post['time_blud'],'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas PPN"
				);
				$data7 = array_string_to_null($data7);
				$this->Pengeluaran_model->update_jurnal(array('id' => $post['id_blud'],'urut' => '2'), $data7);
			}else if($ppn_db['ppn'] != 0 && $ppn == 0){
				$this->Pengeluaran_model->delete_jurnal_by_urut($post['id_blud'],'2');
			}else if($ppn_db['ppn'] == 0 && $ppn != 0){
				$data7 = array(
				'jumlah_jurnal' => $ppn,
				'id_blud' => $post['id_blud'],				
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.$post['time_blud'],'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas PPN",
				'urut' => '2'
				);
				$data7 = array_string_to_null($data7);
				$this->Pengeluaran_model->insert_jurnal($data7);
				
			}else{}
			
			$pph_db = $this->db->select('id_kategori_pph,pph')->where('id_blud',$post['id_blud'])->get('trs_blud')->row_array();
			if($pph != 0 && $pph_db['pph'] != $pph && $pph_db['id_kategori_pph'] == $post['id_kategori_pph']){
				$nama_pph = $this->db->select('nama_pph')
				->where('id',$post['id_kategori_pph'])
				->get('ms_kategori_pph')->row_array();
				
				$data8 = array(
				'jumlah_jurnal' => $pph,
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.date('H:i:s'),'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas ".$nama_pph['nama_pph']
				);
				$data8 = array_string_to_null($data8);
				$this->Pengeluaran_model->update_jurnal(array('id' => $post['id_blud'],'urut' => '3'), $data8);
			}else if($pph != 0 && $pph_db['id_kategori_pph'] != $post['id_kategori_pph']){
				$nama_pph = $this->db->select('nama_pph')
				->where('id',$post['id_kategori_pph'])
				->get('ms_kategori_pph')->row_array();
				
				$data8 = array(
				'jumlah_jurnal' => $pph,
				'id_blud' => $post['id_blud'],
				'id_anggaran' => '',	
				'tipe_jurnal' => 'kredit',	
				'tanggal_jurnal' => convert_tgl($post['tgl_blud'].' '.$post['time_blud'],'Y-m-d H:i:s',1),
				'uraian' => "Dibayarkan atas ".$nama_pph['nama_pph'],
				'urut' => '3'
				);
				$data8 = array_string_to_null($data8);
				$this->Pengeluaran_model->delete_jurnal_by_urut($post['id_blud'],'3');
				$this->Pengeluaran_model->insert_jurnal($data8);
			}else if($pph == 0){
				$this->Pengeluaran_model->delete_jurnal_by_urut($post['id_blud'],'3');
			}else{}
			
			
			$this->db->trans_start();
			
			$this->Pengeluaran_model->update(array('id_blud' => $post['id_blud']), $data5);
			$this->Pengeluaran_model->update_jurnal(array('id_blud' => $post['id_blud'],'urut' => '1'), $data6);
			
			$this->db->trans_complete();
			
			
		}
		
		echo json_encode(array("status" => true));
	}
  

	public function ajax_delete()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post['id'];
		if(!is_array($id)){
			$id[] = $id;
		}
		$this->Pengeluaran_model->delete($id);
		$this->Pengeluaran_model->delete_jurnal($id);
		echo json_encode(array("status" => TRUE));
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Pengeluaran_model->data_excel("trs_blud");
		$this->excel->export($query);
	}
	
	public function pdf_pendukung()
	{
		$this->load->model('Pengeluaran_model');


		$this->load->library("fpdf");
		$this->load->library('currency');
		
		$data = array();
		$query1 = $this->Pengeluaran_model->data_pdf1();
		$data['query1'] = $query1;
		$this->load->view('pdf_pendukung_rencana_pengeluaran',$data);
	}
	
	public function tutup_buku()
	{
		$post = $this->input->post(NULL,TRUE);
		
		if($post['status']!='1'){
			$q0 = $this->db->query('select LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY as tgl_saldo')->row_array();
			$q1 = $this->db->select('saldo')
			->where('tanggal_saldo = LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY')
			->get('saldo')->row_array();
			$q2 = $this->db->select('sum(if(tipe_jurnal="debit",jumlah_jurnal,0)) as penerimaan, sum(if(tipe_jurnal="kredit",jumlah_jurnal,0)) as pengeluaran')
			->where('tanggal_jurnal between LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY and LAST_DAY(NOW())')
			->get('jurnal')->row_array();
			
			
		}else{
			$q0 = $this->db->query('select LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY as tgl_saldo')->row_array();
			$q1 = $this->db->select('saldo')
			->where('tanggal_saldo = LAST_DAY(NOW() - INTERVAL 3 MONTH) + INTERVAL 1 DAY')
			->get('saldo')->row_array();
			$q2 = $this->db->select('sum(if(tipe_jurnal="debit",jumlah_jurnal,0)) as penerimaan, sum(if(tipe_jurnal="kredit",jumlah_jurnal,0)) as pengeluaran')
			->where('tanggal_jurnal between LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY and LAST_DAY(NOW() - INTERVAL 1 MONTH)')
			->get('jurnal')->row_array();
			
			$data['tanggal_saldo'] = $q0['tgl_saldo'];
			$data['saldo_debit'] = $q2['penerimaan'];
			$data['saldo_kredit'] = $q2['pengeluaran'];
			$data['saldo'] = $q1['saldo']+$q2['pengeluaran']-$q2['penerimaan'];
		}
		
		$success1 = $this->Pengeluaran_model->insert_saldo($data);
		$success2 = $this->Pengeluaran_model->non_aktif_blud($post['status']);
	
		if($success1 = 1)
		{
			if($success1 > 0) {
				$response = array(
					'status' => true,
					'message' => 'Berhasil Tutup Buku',
					'redirect' => ''
				);
				die(json_encode($response));
			}
			
		}
	}
	
	public function setTime_blud($time_blud){
		$this->time_blud = $time_blud;
	}
	
	public function getTime_blud(){
		return $this->time_blud;
	}
	
	public function ceksaldo(){
		echo $cek = $this->Pengeluaran_model->get_cek_saldo();
	}
}
?>
