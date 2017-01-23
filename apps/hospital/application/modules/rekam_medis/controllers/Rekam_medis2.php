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
	class Rekam_medis extends MY_Controller{
		
		function __construct()    {
			parent::__construct();
			$this->load->library("fpdf");
			$this->load->model('Rekam_mediss');
			$config['table1'] = 'ms_poliklinik';
			$config['table2'] = 'ms_cara_bayar';
			$config['column_order1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_order2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['column_search1'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama');
			$config['column_excel1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['column_pdf1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['order1'] = array('ms_poliklinik.id' => 'ASC');
			$config['order2'] = array('ms_cara_bayar.id' => 'ASC');
			$this->Rekam_mediss->initialize($config);
		}
		
		public
		function index()    {
			$data['data']['title'] = 'Rekam Medis';
			$data['data']['id_table1'] = 'kunjungan_pasien';
			$data['data']['id_table2'] = 'rekapitulasi_kunjungan_pasien';
			$data['data']['datatable_list1'] = 'rekam_medis/ajax_list1';
			$data['data']['datatable_list2'] = 'rekam_medis/ajax_list2';
			$data['data']['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
			$this->template->display('dashboard',$data);
		}
		
		public
		function ajax_list1(){
			$list = $this->Rekam_mediss->get_datatables('1');
			$jml_kate = 0;
			$jml_bayar = 0;
			$ttl_baru = 0;
			$ttl_lama = 0;
			$total = 0;
			$totalumum = 0;
			$totalkontrak = 0;
			$totalrsu = 0;
			$totalkatebaru = 0;
			$totalkatelama = 0;
			$totaljmlkate = 0;
			$totalakses = 0;
			$totalkis = 0;
			$totaljmsstk = 0;
			$totaltni = 0;
			$totalmandiri = 0;
			$totalbayarbaru = 0;
			$totalbayarlama = 0;
			$totaljmlbayar = 0;
			$totalttlbaru = 0;
			$totalttllama = 0;
			$totaltotal = 0;
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				$no++;
				$fields = array();
				$fields[] = $no;
				$fields[] = $row['nama'];
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$umum = $this->Rekam_mediss->get_pasien('','UMUM','','','');
				$totalumum += $umum;
				$fields[] = (isset($umum) || $umum!='')?$umum:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kontrak = $this->Rekam_mediss->get_pasien('','KONTRAKTOR','','','');
				
			$totalkontrak += $kontrak;
				$fields[] = (isset($kontrak) || $kontrak!='')?$kontrak:'0';
				$this->cekFilter('1');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$rsu = $this->Rekam_mediss->get_pasien('','RSU','','','');
				
			$totalrsu += $rsu;
				$fields[] = (isset($rsu) || $rsu!='')?$rsu:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kate_baru = $this->Rekam_mediss->get_pasien('baru','','','','');
				
			$totalkatebaru += $kate_baru;
				$fields[] = (isset($kate_baru) || $kate_baru!='')?$kate_baru:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kate_lama = $this->Rekam_mediss->get_pasien('lama','','','','');
				
			$totalkatelama += $kate_lama;
				$fields[] = (isset($kate_lama) || $kate_baru!='')?$kate_lama:'0';
				$jml_kate = $kate_lama+$kate_baru;
				
			$totaljmlkate += $jml_kate;
				$fields[] = $jml_kate;
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama ="BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$akses = $this->Rekam_mediss->get_pasien('','BPJS','AKSES','','');
				
			$totalakses += $akses;
				$fields[] = (isset($akses) || $akses!='')?$akses:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kis = $this->Rekam_mediss->get_pasien('','BPJS','KIS','','');
				
			$totalkis += $kis;
				$fields[] = (isset($kis) || $kis!='')?$kis:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$jmsstk = $this->Rekam_mediss->get_pasien('','BPJS','JAMSOSTEK','','');
				
			$totaljmsstk += $jmsstk;
				$fields[] = (isset($jmsstk) || $jmsstk!='')?$jmsstk:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$tni = $this->Rekam_mediss->get_pasien('','BPJS','TNI dan POLRI','','');
				
			$totaltni += $tni;
				$fields[] = (isset($tni) || $tni!='')?$tni:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$mandiri = $this->Rekam_mediss->get_pasien('','BPJS','Mandiri','','');
				
			$totalmandiri += $mandiri;
				$fields[] = (isset($mandiri) || $mandiri!='')?$mandiri:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$bayar_baru = $this->Rekam_mediss->get_pasien('baru','BPJS','','','');
				
			$totalbayarbaru += $bayar_baru;
				$fields[] = (isset($bayar_baru) || $bayar_baru != '')?$bayar_baru:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$bayar_lama = $this->Rekam_mediss->get_pasien('lama','BPJS','','','');
				
			$totalbayarlama += $bayar_lama;
				$fields[] = (isset($bayar_lama) || $bayar_lama!='')?$bayar_lama:'0';
				$jml_bayar = $bayar_baru+$bayar_lama;
				
			$totaljmlbayar += $jml_bayar;
				$fields[] = $jml_bayar;
				$ttl_baru = $kate_baru+$bayar_baru;
				
			$totalttlbaru += $ttl_baru;
				$fields[] = $ttl_baru;
				$ttl_lama = $kate_lama+$bayar_lama;
				
			$totalttllama += $ttl_lama;
				$fields[] = $ttl_lama;
				$total = $ttl_baru+$ttl_lama;
				
			$totaltotal += $total;
				$fields[] = $total;
				$data[] = $fields;
			}
			
			// all you need
				$no++;
				$fields = array();
				$fields[] = "";
				$fields[] = "<center><b>Total</b></center>";
				$fields[] = "<b>".$totalumum."</b>";
				$fields[] = "<b>".$totalkontrak."</b>";
				$fields[] = "<b>".$totalrsu."</b>";
				$fields[] = "<b>".$totalkatebaru."</b>";
				$fields[] = "<b>".$totalkatelama."</b>";
				$fields[] = "<b>".$totaljmlkate."</b>";
				$fields[] = "<b>".$totalakses."</b>";
				$fields[] = "<b>".$totalkis."</b>";
				$fields[] = "<b>".$totaljmsstk."</b>";
				$fields[] = "<b>".$totaltni."</b>";
				$fields[] = "<b>".$totalmandiri."</b>";
				$fields[] = "<b>".$totalbayarbaru."</b>";
				$fields[] = "<b>".$totalbayarlama."</b>";
				$fields[] = "<b>".$totaljmlbayar."</b>";
				$fields[] = "<b>".$totalttlbaru."</b>";
				$fields[] = "<b>".$totalbayarlama."</b>";
				$fields[] = "<b>".$totaltotal."</b>";
				
				$data[] = $fields;
			//until this
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Rekam_mediss->count_all('1'),"recordsFiltered" => $this->Rekam_mediss->count_filtered('1'),"data" => $data);
			echo json_encode($output);		
		}
		
		public
		function ajax_list2(){
			$list = $this->Rekam_mediss->get_datatables('2');
			$kunj = 0;
			$konsul = 0;
			$cekup = 0;
			$sdh = 0;
			$kcl = 0;
			$sdg = 0;
			$bsr = 0;
			$jmlTindakan = 0;
			$jmlTotal = 0;
			$totalBaru = 0;
			$totalLama = 0;
			$totalKunj = 0;
			$totalKonsul = 0;
			$totalCekup = 0;
			$totalSdh = 0;
			$totalKcl = 0;
			$totalSdg = 0;
			$totalBsr = 0;
			$totalJml = 0;
			$totalEkg = 0;
			$totalEeg = 0;
			$totalUsg = 0;
			$totalAudio = 0;
			$totalSpiro = 0;
			$totalLain2 = 0;
			$totalKunjungan = 0;
			$totalTindakan = 0;
			$totalPemeriksaan = 0;
			$totalPemkonsul = 0;
			$totalJmltotal = 0;
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				if($row['nama'] != 'ASURANSI'){
					$no++;
					$fields = array();
					
					$fields[] = $no;
					$fields[] = $row['nama'];
					$this->cekFilter('2');
					$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],'','','');
					$totalBaru += $baru;
					$fields[] = (isset($baru) && $row['nama'] != 'BPJS' && $baru != '0')?$baru:'';
					$lama = $this->Rekam_mediss->get_pasien('lama',$row['nama'],'','','');
					$totalLama += $lama;
					$fields[] = (isset($lama) && $row['nama'] != 'BPJS' && $lama != '0')?$lama:'';
					$jmlTotal = $baru+$lama;
					$totalKunj += $jmlTotal;
					$fields[] = ($row['nama'] != 'BPJS' && $jmlTotal != '0')?$jmlTotal:'';
					$konsul = (!empty($this->get_filter()))?$this->Rekam_mediss->get_pasien('',$row['nama'],'',''.$this->get_filter(),''):'';
					$totalKonsul += $konsul;
					$fields[] = (isset($konsul) && $row['nama'] != 'BPJS' && $konsul != '0')?$konsul:'';
					$fields[] = '';
					$this->cekFilter('2');
					$sdh = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','Sederhana');
					$totalSdh += $sdh;
					$fields[] = (isset($sdh) && $row['nama'] != 'BPJS' && $sdh != '0')?$sdh:'';
					$this->cekFilter('2');
					$kcl = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','Kecil');
					$totalKcl += $kcl;
					$fields[] = (isset($kcl) && $row['nama'] != 'BPJS' && $kcl != '0')?$kcl:'';
					$this->cekFilter('2');
					$sdg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','Sedang');
					$totalSdg += $sdg;
					$fields[] = (isset($sdg) && $row['nama'] != 'BPJS' && $sdg != '0')?$sdg:'';
					$this->cekFilter('2');
					$bsr = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','Besar');
					$totalBsr += $bsr;
					$fields[] = (isset($bsr) && $row['nama'] != 'BPJS' && $bsr != '0')?$bsr:'';
					$jmlTindakan += $sdh+$kcl+$sdg+$bsr;
					$fields[] = (isset($jmlTindakan) && $row['nama'] != 'BPJS' && $jmlTindakan != '0')?$jmlTindakan:'';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';
					$fields[] = '';

					
					$data[] = $fields;
					
					if($row['nama'] == 'RSU'){
						$fields = array();
						$fields[] = '';
						$fields[] = 'Jumlah';
						$fields[] = (isset($totalBaru) && $totalBaru != '0')?$totalBaru:'';
						$fields[] = (isset($totalLama) && $totalLama != '0')?$totalLama:'';
						$fields[] = (isset($totalKunj) && $totalKunj != '0')?$totalKunj:'';
						$fields[] = (isset($totalKonsul) && $totalKonsul != '0')?$totalKonsul:'';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
						$fields[] = '';
					
						$data[] = $fields;
					}
					if($row['nama'] == 'BPJS'){
							$query = $this->db->get('ms_bpjs_type')->result_array();
								foreach($query as $r){
								$fields = array();
								$fields[] = '';
								$fields[] = $r['nama'];
								$this->cekFilter('2');
								$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],$r['nama'],'','');
								$totalBaru += $baru;
								$fields[] = (isset($baru) && $baru != '0')?$baru:'';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								$fields[] = '';
								
								$data[] = $fields;
							}
					}
				}
			}
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Rekam_mediss->count_all('2'),"recordsFiltered" => $this->Rekam_mediss->count_filtered('2'),"data" => $data);
			echo json_encode($output);		
		}
		
		public
		function excel($p){
			$this->load->library("Excel");
			$query = $this->Rekam_mediss->data_excel('',$p);
			
			$this->excel->export($query);
		}
		
		public
		function showKunjungan()    {
			$get = $this->input->get(NULL,TRUE);			

			$data['tgl1'] = $get['tgl1'];
			$data['tgl2'] = $get['tgl2'];
			$data['polikliniks'] = $this->db->get('ms_poliklinik')->result_array();
			$this->load->view('kunjungan_pasien_report',$data);
		}

		public function cekFilter($p){
			
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
							$this->db->where('DATE(trs_konsultasi.add_time) >=',convert_tgl($date1,'Y-m-d'));
							$this->db->where('DATE(trs_konsultasi.add_time) <=',convert_tgl($date2,'Y-m-d'));
						}
						
						if($p != '1'){
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
			}
		}
		
		public function get_filter(){
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
								if(!empty($where_filter)){
									return $value;
								}else{
									return '0';
								}
							}
						}
					}
				}
			}
		}
	}
	
?>