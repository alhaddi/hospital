<?php
	/**
		* CodeIgniter Core Model
		*
		* @package         CodeIgniter
		* @subpackage      Controller
		* @category        Pasien Controller
		* @author          Amir Mufid
		* @version         1.1
	*/defined('BASEPATH') OR exit('No direct script access allowed');
	class Report extends MY_Controller{
		
		function __construct()    {
			parent::__construct();
			$this->load->model('Reports');
			$config['table1'] = 'ms_pasien';
			$config['table2'] = 'ms_poliklinik';
			$config['table3'] = 'ms_penunjang';
			$config['column_order1'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','ms_pasien.jk','ms_pasien.usia_thn','ms_pasien.hp','ms_pasien.alamat','ms_pasien.add_time',null);
			$config['column_order2'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','trs_billing.id_komponen',null,'trs_billing.nominal','trs_billing.last_update','trs_billing.keterangan',null);
			$config['column_order3'] = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			$config['column_order4'] = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			$config['column_order5'] = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			$config['column_order6'] = array(null,'ms_penunjang.id','ms_penunjang.nama',null,null,null,null);
			$config['column_order7'] = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			$config['column_order8'] = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			$config['column_search1'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','ms_pasien.jk','ms_pasien.usia_thn','ms_pasien.hp','ms_pasien.alamat','ms_pasien.add_time');
			$config['column_search2'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','ms_pasien.jk','ms_pasien.usia','trs_appointment.last_update','trs_billing.nominal','ms_pasien.status','trs_billing.keterangan');
			$config['column_search3'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search4'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search5'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search6'] = array('ms_penunjang.id','ms_penunjang.nama');
			$config['column_search7'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search8'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_excel1'] = array(null,'ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama as cara_bayar','ms_pasien.jk','ms_pasien.usia_thn','ms_pasien.hp','ms_pasien.alamat','ms_pasien.add_time',null);
			$config['column_excel2'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama as cara_bayar','ms_pasien.jk','ms_pasien.usia','trs_appointment.last_update as tgl_datang','trs_billing.nominal as ongkos','ms_pasien.status','trs_billing.keterangan',null);
			$config['column_excel3'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel4'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel5'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel6'] = array('ms_penunjang.id','ms_penunjang.nama',null);
			$config['column_excel8'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel8'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf1'] = array(null,'ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama as cara_bayar','ms_pasien.jk','ms_pasien.usia_thn','ms_pasien.hp','ms_pasien.alamat','ms_pasien.add_time',null);
			$config['column_pdf2'] = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama as cara_bayar','ms_pasien.jk','ms_pasien.usia_thn','trs_appointment.last_update as tgl_datang','trs_billing.nominal as ongkos','ms_pasien.status','trs_billing.keterangan',null);
			$config['column_pdf3'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf4'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf5'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf6'] = array('ms_penunjang.id','ms_penunjang.nama',null);
			$config['column_pdf7'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf8'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['order1'] = array('ms_pasien.rm' => 'ASC');
			$config['order2'] = array('ms_poliklinik.id' => 'ASC');
			$config['order3'] = array('ms_penunjang.id' => 'ASC');
			$this->Reports->initialize($config);
		}
		
		public
		function index()    {
			
			$data['total_pembayaran']=0;
			$data['data']['title'] = 'Mis Report';
			$data['data']['id_table1'] = 'pasien';
			$data['data']['id_table2'] = 'total_pembayaran';
			$data['data']['id_table3'] = 'setoran_loket';
			$data['data']['id_table4'] = 'setoran_internal_konsultasi';
			$data['data']['id_table5'] = 'setoran_konsultasi';
			$data['data']['id_table6'] = 'setoran_penunjang';
			$data['data']['id_table7'] = 'setoran_loket_igd';
			$data['data']['id_table8'] = 'setoran_internal_igd';
			$data['data']['datatable_list1'] = 'report/ajax_list1';
			$data['data']['datatable_list2'] = 'report/ajax_list2';
			$data['data']['datatable_list3'] = 'report/ajax_list3';
			$data['data']['datatable_list4'] = 'report/ajax_list4';
			$data['data']['datatable_list5'] = 'report/ajax_list5';
			$data['data']['datatable_list6'] = 'report/ajax_list6';
			$data['data']['datatable_list7'] = 'report/ajax_list7';
			$data['data']['datatable_list8'] = 'report/ajax_list8';
			
			$data['data']['cara_bayar'] = $this->db->get('ms_cara_bayar')->result_array();
			
			$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="ms_poliklinik.id IN ($otoritas)";
			$this->db->where($ww);
			}
			$data['data']['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
			$data['data']['penunjang'] = $this->db->select('id,nama')
			->get('ms_penunjang')->result_array();
			
			$this->template->display('dashboard',$data);
		}
		
		public
		function ajax_list1(){
			$list = $this->Reports->get_datatables('1');
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				$usia = (!empty($row->usia_thn))?$row->usia_thn." Tahun":'';
				$usia .= (!empty($row->usia_bln))?$row->usia_bln." Bulan":"";
				$usia .= (!empty($row->usia_hari))?$row->usia_hari." Hari":"";
				
				$no++;
				$fields = array();
				$fields[] = $row->rm;
				$fields[] = $row->no_identitas;
				$fields[] = $row->nama_lengkap;
				$fields[] = $row->cara_bayar;
				$fields[] = $row->jk;
				$fields[] = $usia;
				$fields[] = $row->hp;
				$fields[] = $row->alamat;
				$fields[] = $row->poliklinik;
				$fields[] = convert_tgl($row->tgl_bergabung,'d M Y H:i',1);
				$data[] = $fields;
			}
			ini_set('memory_limit', '-1');
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('1'),"recordsFiltered" => $this->Reports->count_filtered('1'),"data" => $data,);
			echo json_encode($output);
		}
		
		function ajax_list2(){
			$list = $this->Reports->get_datatables('2');
			$data = array();
			$no = $_POST['start'];
			$jumlah=0;
			foreach ($list as $row) {
				$no++;
				$jumlah+=$row->nominal;
				$fields = array();
				$fields[] = $row->rm;
				$fields[] = $row->no_identitas;
				$fields[] = $row->nama_lengkap;
				$fields[] = $row->cara_bayar;
				if($row->id_komponen == 5 ){
				$fields[] = get_field(get_field($row->id_penunjang,'trs_penunjang','id_ms_penunjang'),'ms_penunjang');
				$fields[] = ($row->dokter)?$row->dokter:'-';
				}elseif($row->id_komponen == 4){
				$fields[] = get_field($row->id_komponen,'ms_komponen_registrasi');
				$fields[] = ($row->dokter)?$row->dokter:'-';
				}
				else{
				$fields[] = get_field($row->id_komponen,'ms_komponen_registrasi');
				$fields[] = "-";
				}
				$fields[] = rupiah($row->nominal);
				$fields[] = convert_tgl($row->tgl_datang,'d M Y H:i',1);
				$fields[] = $row->keterangan;
				
				$data[] = $fields;
			}
			// all you need
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "";
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".rupiah($jumlah)."</b>";
				$fields[] = "";
				$fields[] = "";
				
				$data[] = $fields;
			//until this
			ini_set('memory_limit', '-1');
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('2'),"recordsFiltered" => $this->Reports->count_filtered('2'),"data" => $data,);
			echo json_encode($output);
			
		}
		
		public
		function ajax_list3(){
			$list = $this->Reports->get_datatables('3');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa1 = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] = $no;
				$fields[] = $row->poliklinik;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = rupiah($row->jml_pasien*7000);
				$fields[] = rupiah($row->jml_pasien*5000);
				$fields[] = rupiah($row->jml_pasien*7000+$row->jml_pasien*5000);
				$data[] = $fields;

				$jml_pasien += $row->jml_pasien;
				$jasa1 += $row->jml_pasien*7000;
				$jasa2 += $row->jml_pasien*5000;
				$total += $row->jml_pasien*7000+$row->jml_pasien*5000;

			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "<b>".rupiah($jasa1)."</b>";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;

			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('3'),"recordsFiltered" => $this->Reports->count_filtered('3'),"data" => $data,);
			echo json_encode($output);
		}
		
		public
		function ajax_list4(){
			$list = $this->Reports->get_datatables('4');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] =$no;
				$fields[] = $row->poliklinik;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = '';
				$fields[] = rupiah($row->total);
				$fields[] = rupiah($row->total);
				$data[] = $fields;

				$jml_pasien += $row->jml_pasien;
				$jasa2 += $row->total;
				$total += $row->total;

			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('4'),"recordsFiltered" => $this->Reports->count_filtered('4'),"data" => $data,);
			echo json_encode($output);
		}
				
		public
		function ajax_list5(){
			$list = $this->Reports->get_datatables('5');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa1 = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] = $no;
				$fields[] = $row->poliklinik;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = rupiah($row->total*(60/100));
				$fields[] = rupiah($row->total*(40/100));
				$fields[] = rupiah($row->total);
				$data[] = $fields;


				$jml_pasien += $row->jml_pasien;
				$jasa1 += $row->total*(60/100);
				$jasa2 += $row->total*(40/100);
				$total += $row->total;
				
			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "<b>".rupiah($jasa1)."</b>";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;

			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('5'),"recordsFiltered" => $this->Reports->count_filtered('5'),"data" => $data,);
			echo json_encode($output);
		}
		
		public
		function ajax_list6(){
			$list = $this->Reports->get_datatables('6');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa1 = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] = $no;
				$fields[] = $row->penunjang;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = rupiah($row->total*(60/100));
				$fields[] = rupiah($row->total*(40/100));
				$fields[] = rupiah($row->total);
				$data[] = $fields;


				$jml_pasien += $row->jml_pasien;
				$jasa1 += $row->total*(60/100);
				$jasa2 += $row->total*(40/100);
				$total += $row->total;
				
			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "<b>".rupiah($jasa1)."</b>";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;

			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('6'),"recordsFiltered" => $this->Reports->count_filtered('6'),"data" => $data,);
			echo json_encode($output);
		}
		
		public
		function ajax_list7(){
			$list = $this->Reports->get_datatables('7');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa1 = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] = $no;
				$fields[] = $row->poliklinik;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = rupiah($row->jml_pasien*7000);
				$fields[] = rupiah($row->jml_pasien*5000);
				$fields[] = rupiah($row->jml_pasien*7000+$row->jml_pasien*5000);
				$data[] = $fields;

				$jml_pasien += $row->jml_pasien;
				$jasa1 += $row->jml_pasien*7000;
				$jasa2 += $row->jml_pasien*5000;
				$total += $row->jml_pasien*7000+$row->jml_pasien*5000;

			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "<b>".rupiah($jasa1)."</b>";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;

			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('7'),"recordsFiltered" => $this->Reports->count_filtered('7'),"data" => $data,);
			echo json_encode($output);
		}
		
		public
		function ajax_list8(){
			$list = $this->Reports->get_datatables('8');
			$data = array();
			$no = $_POST['start'];
			$jml_pasien = 0;
			$jasa2 = 0;
			$total = 0;
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] =$no;
				$fields[] = $row->poliklinik;
				$fields[] = '';
				$fields[] = $row->jml_pasien;
				$fields[] = '';
				$fields[] = rupiah($row->total);
				$fields[] = rupiah($row->total);
				$data[] = $fields;

				$jml_pasien += $row->jml_pasien;
				$jasa2 += $row->total;
				$total += $row->total;

			}
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$jml_pasien."</b>";
				$fields[] = "";
				$fields[] = "<b>".rupiah($jasa2)."</b>";
				$fields[] = "<b>".rupiah($total)."</b>";
				
				$data[] = $fields;
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Reports->count_all('8'),"recordsFiltered" => $this->Reports->count_filtered('8'),"data" => $data,);
			echo json_encode($output);
		}
		
		public
		function excel($p){
			$this->load->library("Excel");
			$get = $this->input->get(NULL,TRUE);
			
			$tgl_awal = $get['tgl1'];
			$tgl_akhir = $get['tgl2'];
			
			$query = $this->Reports->data_excel($p,$tgl_awal,$tgl_akhir);
			
			$data = array();
			$no = 0;
			$jml_pasien = 0;
			$jasa1 = 0;
			$jasa2 = 0;
			$total = 0;
			foreach($query as $row){
				$fields = array();
				$no++;
				switch($p){
					case '3' :
					case '4' :
					case '5' :
						$fields['No'] = $no;
						$fields['Klinik'] = $row['poliklinik'];
						$fields['Referensi'] = '';
						$fields['Jml Pasien'] = $row['jml_pasien'];
						$fields['Jasa Rumah Sakit'] = rupiah($row['total']*(60/100));
						$fields['Jasa Medis'] = rupiah($row['total']*(40/100));
						$fields['Total'] = rupiah($row['total']);

						$jml_pasien += $row['jml_pasien'];
						$jasa1 += $row['total']*(60/100);
						$jasa2 += $row['total']*(40/100);
						$total += $row['total'];
						break;
					default : $fields = $row; break;
				}
				$data[] = $fields;
			}
			switch($p){
				case '3' :
				case '4' :
				case '5' :
					$fields['No'] = '';
					$fields['Klinik'] = 'Total:';
					$fields['Referensi'] = '';
					$fields['Jml Pasien'] = $jml_pasien;
					$fields['Jasa Rumah Sakit'] = rupiah($jasa1);
					$fields['Jasa Medis'] = rupiah($jasa2);
					$fields['Total'] = rupiah($total);
					
					$data[] = $fields;
					break;
			}
			
			echo '<pre>';
			var_dump($data);
			exit();
			$this->excel->export($data);
		}
		
				
		public
		function showPasien(){
			$get = $this->input->get(NULL,TRUE);			
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$column_order1 = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','ms_pasien.jk','ms_pasien.usia','ms_pasien.hp','ms_pasien.alamat','ms_poliklinik.nama','ms_pasien.add_time',null);

			$this->db->select('
			ms_pasien.rm,
			ms_pasien.tipe_identitas,
			ms_pasien.no_identitas,
			ms_pasien.nama_lengkap,
			ms_cara_bayar.nama as cara_bayar,
			ms_pasien.jk,
			ms_pasien.usia,
			ms_pasien.hp,
			ms_pasien.alamat,
			ms_poliklinik.nama as poliklinik,
			ms_pasien.add_time as tgl_bergabung')
			->group_by('ms_pasien.id')
			->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
			->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
			->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id')
			->where('ms_pasien.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"');
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			if(!empty($get['id_poliklinik'])){
				$this->db->where('id_poliklinik',$get['id_poliklinik']);
			}
			
			if(!empty($get['column_order1']) || !empty($column_order1[$get['column_order1']])){
				$this->db->order_by($column_order1[$get['column_order1']],$get['dir_order1']);
			}else{
				$this->db->order_by('ms_pasien.rm','DESC');
			}
			ini_set('memory_limit', '-1');
			$query = $this->db->get('ms_pasien')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			$content = $this->load->view('pasien_report',$data,true);
			$this->chtml2pdf->cetak("L","A4",$content,"Pasien","I"); 
		}

		public
		function showPembayaran()   {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order = array('ms_pasien.rm','ms_pasien.no_identitas','ms_pasien.nama_lengkap','ms_cara_bayar.nama','trs_billing.id_ms_penunjang','trs_billing.nominal','trs_billing.last_update','trs_billing.keterangan',null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
			ms_pasien.rm,
			ms_pasien.no_identitas,
			ms_pasien.nama_lengkap,
			ms_cara_bayar.nama as cara_bayar,
			ms_komponen_registrasi.nama as nama_pembayaran,
			trs_billing.id_komponen,
			trs_billing.id_penunjang,
			ms_pegawai.nama as dokter,
			trs_billing.nominal,
			trs_billing.last_update as tgl_datang,
			trs_billing.keterangan')
			->join('trs_appointment','trs_appointment.id_pasien = ms_pasien.id')
			->join('trs_anamesa','trs_appointment.id = trs_anamesa.id_appointment')
			->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id')
			->join('ms_pegawai','trs_anamesa.id_dokter = ms_pegawai.id','left')
			->join('trs_billing','trs_appointment.id = trs_billing.id_appointment')
			->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing.id_komponen')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"');
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			if(!empty($get['id_ms_penunjang'])){
				$this->db->where('id_ms_penunjang',$get['id_ms_penunjang']);
			}
			
			if(!empty($get['column_order2']) || !empty($column_order2[$get['column_order2']])){
				$this->db->order_by($column_order[$get['column_order2']],$get['dir_order2']);
			}else{
				$this->db->order_by('ms_pasien.rm','DESC');
			}
			ini_set('memory_limit', '-1');
			$query = $this->db->get('ms_pasien')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('total_pembayaran_report',$data,true);
			$this->chtml2pdf->cetak("L","A4",$content,"Total_Pembayaran","I"); 
		}

		public
		function showLoket()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order3 = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_poliklinik.nama as poliklinik,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_poliklinik.id')
			->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (1)','left')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"')
			->where('status',1)
			;
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			if(!empty($get['column_order3']) || !empty($column_order3[$get['column_order3']])){
				$this->db->order_by($column_order3[$get['column_order3']],$get['dir_order3']);
			}else{
				$this->db->order_by('ms_poliklinik.id','ASC');
			}
			
			$query = $this->db->get('ms_poliklinik')->result_array();
			
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_loket_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Registrasi","I"); 
		}

		public
		function showInternalKonsultasi()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order4 = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_poliklinik.nama as poliklinik,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_poliklinik.id')
			->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"');
			
			if(!empty($get['column_order4']) || !empty($column_order4[$get['column_order4']])){
				$this->db->order_by($column_order[$get['column_order4']],$$get['dir_order4']);
			}else{
				$this->db->order_by('ms_poliklinik.id','ASC');
			}
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			$query = $this->db->get('ms_poliklinik')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_internal_konsultasi_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Internal_Konsultasi","I"); 
		}
		
		public
		function showLoketIGD()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order7 = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_poliklinik.nama as poliklinik,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_poliklinik.id')
			->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (2)','left')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"')
			->where('status',1)
			->where
			;
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			if(!empty($get['column_order7']) || !empty($column_order7[$get['column_order7']])){
				$this->db->order_by($column_order7[$get['column_order7']],$get['dir_order7']);
			}else{
				$this->db->order_by('ms_poliklinik.id','ASC');
			}
			
			$query = $this->db->get('ms_poliklinik')->result_array();
			
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_loket_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Registrasi","I"); 
		}

		public
		function showInternalIGD()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order8 = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_poliklinik.nama as poliklinik,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_poliklinik.id')
			->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (3)','left')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"')
			->where('trs_appointment.id_poliklinik NOT IN (20,28)');
			
			if(!empty($get['column_order8']) || !empty($column_order8[$get['column_order8']])){
				$this->db->order_by($column_order[$get['column_order8']],$$get['dir_order8']);
			}else{
				$this->db->order_by('ms_poliklinik.id','ASC');
			}
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			$query = $this->db->get('ms_poliklinik')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_internal_konsultasi_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Internal_Konsultasi","I"); 
		}
		
		public
		function showKonsultasi()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order5 = array(null,'ms_poliklinik.id','ms_poliklinik.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_poliklinik.nama as poliklinik,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_poliklinik.id')
			->join('trs_appointment','trs_appointment.id_poliklinik = ms_poliklinik.id','left')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id AND trs_billing.id_komponen IN (4)','left')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"');
			
			if(!empty($get['column_order5']) || !empty($column_order5[$get['column_order5']])){
				$this->db->order_by($column_order5[$get['column_order5']],$get['dir_order5']);
			}else{
				$this->db->order_by('ms_poliklinik.id','ASC');
			}
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			$query = $this->db->get('ms_poliklinik')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_konsultasi_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Konsultasi","I"); 
		}		
		public
		function showPenunjang()    {
			$get = $this->input->get(NULL,TRUE);			
			
			$column_order6 = array(null,'ms_penunjang','ms_penunjang.nama',null,null,null,null);
			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$this->db->select('
				ms_penunjang.nama as penunjang,
				IFNULL(COUNT(trs_billing.id),0) as jml_pasien,
				IFNULL(SUM(trs_billing.nominal),0) as total
			',false)
			->group_by('ms_penunjang.id')
			->join('trs_billing','trs_billing.id_ms_penunjang = ms_penunjang.id AND trs_billing.id_komponen IN (5)','left')
			->join('trs_appointment','trs_billing.id_appointment = trs_appointment.id')
			->where('trs_billing.last_update between "'.$get['tgl1'].' 00:00:00" and "'.$get['tgl2'].' 23:59:59"');
			
			if(!empty($get['cara_bayar'])){
				$this->db->where('id_cara_bayar',$get['cara_bayar']);
			}
			
			if(!empty($get['column_order6']) || !empty($column_order6[$get['column_order6']])){
				$this->db->order_by($column_order6[$get['column_order6']],$$get['dir_order6']);
			}else{
				$this->db->order_by('ms_penunjang.id','ASC');
			}
			
			$query = $this->db->get('ms_penunjang')->result_array();
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			
			$content = $this->load->view('setoran_penunjang_report',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Setoran_Penunjang","I"); 
		}		
	}
	
?>