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
			$config['table3'] = 'ms_icd';
			$config['column_order1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_order2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['column_order3'] = array(null,'tb_data_icd.code','tb_data_icd.deskripsi',null);
			$config['column_search1'] = array('ms_poliklinik.id','ms_poliklinik.nama');
			$config['column_search2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama');
			$config['column_search3'] =array('tb_data_icd.code','tb_data_icd.deskripsi');
			$config['column_excel1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_excel2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['column_excel3'] = array('tb_data_icd.code','tb_data_icd.deskripsi',null);
			$config['column_pdf1'] = array('ms_poliklinik.id','ms_poliklinik.nama',null);
			$config['column_pdf2'] = array('ms_cara_bayar.id','ms_cara_bayar.nama',null);
			$config['column_pdf3'] = array('tb_data_icd.code','tb_data_icd.deskripsi',null);
			$config['order1'] = array('ms_poliklinik.id' => 'ASC');
			$config['order2'] = array('ms_cara_bayar.urut' => 'ASC');
			$config['order3'] = array('count(ms_icd.code)' => 'DESC');
			$this->Rekam_mediss->initialize($config);
		}
		
		public
		function index()    {
			$data['data']['title'] = 'Rekam Medis';
			$data['data']['id_table1'] = 'kunjungan_pasien';
			$data['data']['id_table2'] = 'rekapitulasi_kunjungan_pasien';
			$data['data']['id_table3'] = 'rekapitulasi_diagnosa';
			$data['data']['datatable_list1'] = 'rekam_medis/ajax_list1';
			$data['data']['datatable_list2'] = 'rekam_medis/ajax_list2';
			$data['data']['datatable_list3'] = 'rekam_medis/ajax_list3';
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
				$umum = $this->Rekam_mediss->get_pasien('','UMUM','','');
				$totalumum += $umum;
				$fields[] = (isset($umum) || $umum!='')?$umum:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kontrak = $this->Rekam_mediss->get_pasien('','KONTRAKTOR','','');
				
			$totalkontrak += $kontrak;
				$fields[] = (isset($kontrak) || $kontrak!='')?$kontrak:'0';
				$this->cekFilter('1');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$rsu = $this->Rekam_mediss->get_pasien('','RSU','','');
				
			$totalrsu += $rsu;
				$fields[] = (isset($rsu) || $rsu!='')?$rsu:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kate_baru = $this->Rekam_mediss->get_pasien('baru','','','');
				
			$totalkatebaru += $kate_baru;
				$fields[] = (isset($kate_baru) || $kate_baru!='')?$kate_baru:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama != "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kate_lama = $this->Rekam_mediss->get_pasien('lama','','','');
				
			$totalkatelama += $kate_lama;
				$fields[] = (isset($kate_lama) || $kate_baru!='')?$kate_lama:'0';
				$jml_kate = $kate_lama+$kate_baru;
				
			$totaljmlkate += $jml_kate;
				$fields[] = $jml_kate;
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama ="BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$akses = $this->Rekam_mediss->get_pasien('','BPJS','AKSES','');
				
			$totalakses += $akses;
				$fields[] = (isset($akses) || $akses!='')?$akses:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$kis = $this->Rekam_mediss->get_pasien('','BPJS','KIS','');
				
			$totalkis += $kis;
				$fields[] = (isset($kis) || $kis!='')?$kis:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$jmsstk = $this->Rekam_mediss->get_pasien('','BPJS','JAMSOSTEK','');
				
			$totaljmsstk += $jmsstk;
				$fields[] = (isset($jmsstk) || $jmsstk!='')?$jmsstk:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$tni = $this->Rekam_mediss->get_pasien('','BPJS','TNI dan POLRI','');
				
			$totaltni += $tni;
				$fields[] = (isset($tni) || $tni!='')?$tni:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$mandiri = $this->Rekam_mediss->get_pasien('','BPJS','Mandiri','');
				
			$totalmandiri += $mandiri;
				$fields[] = (isset($mandiri) || $mandiri!='')?$mandiri:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$bayar_baru = $this->Rekam_mediss->get_pasien('baru','BPJS','','');
				
			$totalbayarbaru += $bayar_baru;
				$fields[] = (isset($bayar_baru) || $bayar_baru!='')?$bayar_baru:'0';
				$this->cekFilter('1');
				$this->db->where('ms_cara_bayar.nama = "BPJS"');
				$this->db->where('ms_poliklinik.nama',$row['nama']);
				$bayar_lama = $this->Rekam_mediss->get_pasien('lama','BPJS','','');
				
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
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Rekam_mediss->count_all('1'),"recordsFiltered" => $this->Rekam_mediss->count_all('1'),"data" => $data);
			echo json_encode($output);		
		}
		
		public
		function ajax_list2(){
			$list = $this->Rekam_mediss->get_datatables('2');
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
				$kunj = 0;
				$konsul = 0;
				$cekup = 0;
				$sdh = 0;
				$kcl = 0;
				$sdg = 0;
				$bsr = 0;
				$jmlTindakan = 0;
				$ekg = 0;
				$eeg = 0;
				$usg = 0;
				$audio = 0;
				$spiro = 0;
				$lain2 = 0;
				$kunjungan = 0;
				$tindakan = 0;
				$pemeriksaan = 0;
				$pemkonsul = 0;
				$jmlTotal = 0;
				if($row['nama'] != 'ASURANSI'){
					$no++;
					$fields = array();
					
					$fields[] = $no;
					$fields[] = $row['nama'];
					$this->cekFilter('2');
					$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],'','');
					$totalBaru += (isset($baru) && $row['nama'] != 'BPJS' && $baru != '0')?$baru:0;
					$fields[] = (isset($baru) && $row['nama'] != 'BPJS' && $baru != '0')?$baru:'';
					$this->cekFilter('2');
					$lama = $this->Rekam_mediss->get_pasien('lama',$row['nama'],'','');
					$totalLama += (isset($lama) && $row['nama'] != 'BPJS' && $lama != '0')?$lama:0;
					$fields[] = (isset($lama) && $row['nama'] != 'BPJS' && $lama != '0')?$lama:'';
					$kunj += $baru+$lama;
					$totalKunj += (isset($kunj) && $row['nama'] != 'BPJS' && $kunj != '0')?$kunj:0;
					$fields[] = (isset($kunj) && $row['nama'] != 'BPJS' && $kunj != '0')?$kunj:'';
					$konsul = (!empty($this->get_filter()))?$this->Rekam_mediss->get_konsul($row['nama'],'',''.$this->get_filter()):'';
					$totalKonsul += (isset($konsul) && $row['nama'] != 'BPJS' && $konsul != '0')?$konsul:0;
					$fields[] = (isset($konsul) && $row['nama'] != 'BPJS' && $konsul != '0')?$konsul:'';
					$fields[] = '';
					$this->cekFilter('2');
					$sdh = $this->Rekam_mediss->get_tindakan($row['nama'],'','Sederhana');
					$totalSdh += (isset($sdh) && $row['nama'] != 'BPJS' && $sdh != '0')?$sdh:0;
					$fields[] = (isset($sdh) && $row['nama'] != 'BPJS' && $sdh != '0')?$sdh:'';
					$this->cekFilter('2');
					$kcl = $this->Rekam_mediss->get_tindakan($row['nama'],'','Kecil');
					$totalKcl += (isset($kcl) && $row['nama'] != 'BPJS' && $kcl != '0')?$kcl:0;
					$fields[] = (isset($kcl) && $row['nama'] != 'BPJS' && $kcl != '0')?$kcl:'';
					$this->cekFilter('2');
					$sdg = $this->Rekam_mediss->get_tindakan($row['nama'],'','Sedang');
					$totalSdg += (isset($sdg) && $row['nama'] != 'BPJS' && $sdg != '0')?$sdg:0;
					$fields[] = (isset($sdg) && $row['nama'] != 'BPJS' && $sdg != '0')?$sdg:'';
					$this->cekFilter('2');
					$bsr = $this->Rekam_mediss->get_tindakan($row['nama'],'','Besar');
					$totalBsr += (isset($bsr) && $row['nama'] != 'BPJS' && $bsr != '0')?$bsr:0;
					$fields[] = (isset($bsr) && $row['nama'] != 'BPJS' && $bsr != '0')?$bsr:'';
					$jmlTindakan += $sdh+$kcl+$sdg+$bsr;
					$totalJml += (isset($jmlTindakan) && $row['nama'] != 'BPJS' && $jmlTindakan != '0')?$jmlTindakan:0;
					$fields[] = (isset($jmlTindakan) && $row['nama'] != 'BPJS' && $jmlTindakan != '0')?$jmlTindakan:'';
					$this->cekFilter('2');
					$ekg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang EKG');
					$totalEkg += (isset($ekg) && $row['nama'] != 'BPJS' && $ekg != '0')?$ekg:0;
					$fields[] = (isset($ekg) && $row['nama'] != 'BPJS' && $ekg != '0')?$ekg:'';
					$this->cekFilter('2');
					$eeg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang EEG');
					$totalEeg += (isset($eeg) && $row['nama'] != 'BPJS' && $eeg != '0')?$eeg:0;
					$fields[] = (isset($eeg) && $row['nama'] != 'BPJS' && $eeg != '0')?$eeg:'';
					$this->cekFilter('2');
					$usg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang USG Kebidanan');
					$totalUsg += (isset($usg) && $row['nama'] != 'BPJS' && $usg != '0')?$usg:0;
					$fields[] = (isset($usg) && $row['nama'] != 'BPJS' && $usg != '0')?$usg:'';
					$this->cekFilter('2');
					$audio = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang Audiologi');
					$totalAudio += (isset($audio) && $row['nama'] != 'BPJS' && $audio != '0')?$audio:0;
					$fields[] = (isset($audio) && $row['nama'] != 'BPJS' && $audio != '0')?$audio:'';
					$this->cekFilter('2');
					$spiro = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang Spirometri');
					$totalSpiro += (isset($spiro) && $row['nama'] != 'BPJS' && $spiro != '0')?$spiro:0;
					$fields[] = (isset($spiro) && $row['nama'] != 'BPJS' && $spiro != '0')?$spiro:'';
					$this->cekFilter('2');
					$lain2 = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','lain2');
					$totalLain2 += (isset($lain2) && $row['nama'] != 'BPJS' && $lain2 != '0')?$lain2:0;
					$fields[] = (isset($lain2) && $row['nama'] != 'BPJS' && $lain2 != '0')?$lain2:'';
					$this->cekFilter('3');
					$kunjungan = $this->Rekam_mediss->get_nominal($row['nama'],'','1');
					$jmlTotal += (isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:0;
					$totalKunjungan += (isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:0;
					$fields[] = (isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:'';
					$this->cekFilter('3');
					$tindakan = $this->Rekam_mediss->get_nominal($row['nama'],'','4');
					$jmlTotal += (isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:0;
					$totalTindakan += (isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:0;
					$fields[] = (isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:'';
					$this->cekFilter('3');
					$pemeriksaan = $this->Rekam_mediss->get_nominal($row['nama'],'','5');
					$totalPemeriksaan += (isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:0;
					$jmlTotal += (isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:0;
					$fields[] = (isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:'';
					$this->cekFilter('3');
					$pemkonsul = $this->Rekam_mediss->get_nominal_konsul($row['nama'],'','3');
					$jmlTotal += (isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:0;
					$totalPemkonsul += (isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:0;
					$fields[] = (isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:'';
					$totalJmltotal += (isset($jmlTotal) && $row['nama'] != 'BPJS' && $jmlTotal != '0')?$jmlTotal:0;
					$fields[] = (isset($jmlTotal) && $row['nama'] != 'BPJS' && $jmlTotal != '0')?$jmlTotal:'';

					
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
						$fields[] = (isset($totalSdh) && $totalSdh != '0')?$totalSdh:'';
						$fields[] = (isset($totalKcl) && $totalKcl != '0')?$totalKcl:'';
						$fields[] = (isset($totalSdg) && $totalSdg != '0')?$totalSdg:'';
						$fields[] = (isset($totalBsr) && $totalBsr != '0')?$totalBsr:'';
						$fields[] = (isset($totalJml) && $totalJml != '0')?$totalJml:'';
						$fields[] = (isset($totalEkg) && $totalEkg != '0')?$totalEkg:'';
						$fields[] = (isset($totalEeg) && $totalEeg != '0')?$totalEeg:'';
						$fields[] = (isset($totalUsg) && $totalUsg != '0')?$totalUsg:'';
						$fields[] = (isset($totalAudio) && $totalAudio != '0')?$totalAudio:'';
						$fields[] = (isset($totalSpiro) && $totalSpiro != '0')?$totalSpiro:'';
						$fields[] = (isset($totalLain2) && $totalLain2 != '0')?$totalLain2:'';
						$fields[] = (isset($totalKunjungan) && $totalKunjungan != '0')?$totalKunjungan:'';
						$fields[] = (isset($totalTindakan) && $totalTindakan != '0')?$totalTindakan:'';
						$fields[] = (isset($totalPemeriksaan) && $totalPemeriksaan != '0')?$totalPemeriksaan:'';
						$fields[] = (isset($totalPemkonsul) && $totalPemkonsul != '0')?$totalPemkonsul:'';
						$fields[] = (isset($totalJmltotal) && $totalJmltotal != '0')?$totalJmltotal:'';
					
						$data[] = $fields;
					}
					if($row['nama'] == 'BPJS'){
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
							$query = $this->db->get('ms_bpjs_type')->result_array();
								foreach($query as $r){
								$baru = 0;
								$lama = 0;
								$kunj = 0;
								$konsul = 0;
								$cekup = 0;
								$sdh = 0;
								$kcl = 0;
								$sdg = 0;
								$bsr = 0;
								$jmlTindakan = 0;
								$ekg = 0;
								$eeg = 0;
								$usg = 0;
								$audio = 0;
								$spiro = 0;
								$lain2 = 0;
								$kunjungan = 0;
								$tindakan = 0;
								$pemeriksaan = 0;
								$pemkonsul = 0;
								$jmlTotal = 0;
								$fields = array();
								$fields[] = '';
								$fields[] = $r['nama'];
								$this->cekFilter('2');
								$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],$r['nama'],'');
								$totalBaru += $baru;
								$fields[] = (isset($baru) && $baru != '0')?$baru:'';
								$this->cekFilter('2');
								$lama = $this->Rekam_mediss->get_pasien('lama',$row['nama'],$r['nama'],'');
								$totalLama += $lama;
								$fields[] = (isset($lama) && $lama != '0')?$lama:'';
								$kunj += $baru+$lama;
								$totalKunj += $kunj;
								$fields[] = (isset($kunj) && $kunj != '0')?$kunj:'';
								$konsul = (!empty($this->get_filter()))?$this->Rekam_mediss->get_konsul($row['nama'],$r['nama'],''.$this->get_filter()):'';
								$totalKonsul += $konsul;
								$fields[] = (isset($konsul) && $konsul != '0')?$konsul:'';
								$fields[] = '';
								$this->cekFilter('2');
								$sdh = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Sederhana');
								$totalSdh += $sdh;
								$fields[] = (isset($sdh) && $sdh != '0')?$sdh:'';
								$this->cekFilter('2');
								$kcl = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Kecil');
								$totalKcl += $kcl;
								$fields[] = (isset($kcl) && $kcl != '0')?$kcl:'';
								$this->cekFilter('2');
								$sdg = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Sedang');
								$totalSdg += $sdg;
								$fields[] = (isset($sdg) && $sdg != '0')?$sdg:'';
								$this->cekFilter('2');
								$bsr = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Besar');
								$totalBsr += $bsr;
								$fields[] = (isset($bsr) && $bsr != '0')?$bsr:'';
								$jmlTindakan += $sdh+$kcl+$sdg+$bsr;
								$totalJml += $jmlTindakan;
								$fields[] = (isset($jmlTindakan) && $jmlTindakan != '0')?$jmlTindakan:'';
								$this->cekFilter('2');
								$ekg = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang EKG');
								$totalEkg += $ekg;
								$fields[] = (isset($ekg) && $ekg != '0')?$ekg:'';
								$this->cekFilter('2');
								$eeg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang EEG');
								$totalEeg += $eeg;
								$fields[] = (isset($eeg) && $eeg != '0')?$eeg:'';
								$this->cekFilter('2');
								$usg = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang USG Kebidanan');
								$totalUsg += $usg;
								$fields[] = (isset($usg) && $usg != '0')?$usg:'';
								$this->cekFilter('2');
								$audio = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang Audiologi');
								$totalAudio += $audio;
								$fields[] = (isset($audio) && $audio != '0')?$audio:'';
								$this->cekFilter('2');
								$spiro = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang Spirometri');
								$totalSpiro += $spiro;
								$fields[] = (isset($spiro) && $spiro != '0')?$spiro:'';
								$this->cekFilter('2');
								$lain2 = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','lain2');
								$totalLain2 += $lain2;
								$fields[] = (isset($lain2) && $lain2 != '0')?$lain2:'';
								$this->cekFilter('3');
								$kunjungan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'1');
								$totalKunjungan += $kunjungan;
								$jmlTotal += $kunjungan;
								$fields[] = (isset($kunjungan) && $kunjungan != '0')?$kunjungan:'';
								$this->cekFilter('3');
								$tindakan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'4');
								$totalTindakan += $tindakan;
								$jmlTotal += $tindakan;
								$fields[] = (isset($tindakan) && $tindakan != '0')?$tindakan:'';
								$this->cekFilter('3');
								$pemeriksaan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'5');
								$totalPemeriksaan += $pemeriksaan;
								$jmlTotal += $pemeriksaan;
								$fields[] = (isset($pemeriksaan) && $pemeriksaan != '0')?$pemeriksaan:'';
								$this->cekFilter('3');
								$pemkonsul = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'3');
								$totalPemkonsul += $pemkonsul;
								$jmlTotal += $pemkonsul;
								$fields[] = (isset($pemkonsul) && $pemkonsul != '0')?$pemkonsul:'';
								$totalJmltotal += $jmlTotal;
								$fields[] = (isset($jmlTotal) && $jmlTotal != '0')?$jmlTotal:'';
								
								$data[] = $fields;
							}
					}
				}
			}
			
			$fields = array();
			$fields[] = '';
			$fields[] = 'Jumlah';
			$fields[] = (isset($totalBaru) && $totalBaru != '0')?$totalBaru:'';
			$fields[] = (isset($totalLama) && $totalLama != '0')?$totalLama:'';
			$fields[] = (isset($totalKunj) && $totalKunj != '0')?$totalKunj:'';
			$fields[] = (isset($totalKonsul) && $totalKonsul != '0')?$totalKonsul:'';
			$fields[] = '';
			$fields[] = (isset($totalSdh) && $totalSdh != '0')?$totalSdh:'';
			$fields[] = (isset($totalKcl) && $totalKcl != '0')?$totalKcl:'';
			$fields[] = (isset($totalSdg) && $totalSdg != '0')?$totalSdg:'';
			$fields[] = (isset($totalBsr) && $totalBsr != '0')?$totalBsr:'';
			$fields[] = (isset($totalJml) && $totalJml != '0')?$totalJml:'';
			$fields[] = (isset($totalEkg) && $totalEkg != '0')?$totalEkg:'';
			$fields[] = (isset($totalEeg) && $totalEeg != '0')?$totalEeg:'';
			$fields[] = (isset($totalUsg) && $totalUsg != '0')?$totalUsg:'';
			$fields[] = (isset($totalAudio) && $totalAudio != '0')?$totalAudio:'';
			$fields[] = (isset($totalSpiro) && $totalSpiro != '0')?$totalSpiro:'';
			$fields[] = (isset($totalLain2) && $totalLain2 != '0')?$totalLain2:'';
			$fields[] = (isset($totalKunjungan) && $totalKunjungan != '0')?$totalKunjungan:'';
			$fields[] = (isset($totalTindakan) && $totalTindakan != '0')?$totalTindakan:'';
			$fields[] = (isset($totalPemeriksaan) && $totalPemeriksaan != '0')?$totalPemeriksaan:'';
			$fields[] = (isset($totalPemkonsul) && $totalPemkonsul != '0')?$totalPemkonsul:'';
			$fields[] = (isset($totalJmltotal) && $totalJmltotal != '0')?$totalJmltotal:'';
		
			$data[] = $fields;
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Rekam_mediss->count_all('2'),"recordsFiltered" => $this->Rekam_mediss->count_filtered('2'),"data" => $data);
			echo json_encode($output);		
		}
		
		public
		function ajax_list3(){
			$list = $this->Rekam_mediss->get_datatables('3');
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				$l = 0;
				$p = 0;
				$jml = 0;
					$no++;
					$fields = array();
					
					$fields[] = convert_tgl($row['add_time'],'F',1);
					$fields[] = $no;
					$fields[] = $row['code'];
					$fields[] = $row['deskripsi'];
					$this->cekFilter('4');
					$l = $this->Rekam_mediss->get_diagnosa('L',$row['code']);
					$jml += $l;
					$fields[] = (isset($l))?$l:'0';
					$this->cekFilter('4');
					$p = $this->Rekam_mediss->get_diagnosa('P',$row['code']);
					$jml += $p;
					$fields[] = (isset($p))?$p:'0';
					$fields[] = $jml;
					$fields[] = $jml;
					
					$data[] = $fields;
			}
			
			$output = array("draw" => $_POST['draw'],"recordsTotal" => $this->Rekam_mediss->count_all('3'),"recordsFiltered" => $this->Rekam_mediss->count_filtered('3'),"data" => $data);
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
		
		public function showRekap(){
			$get = $this->input->get(NULL,TRUE);
			$data['tgl1'] = $get['tgl1'];
			$data['tgl2'] = $get['tgl2'];
			$data['poliklinik'] = $get['id_poliklinik'];
			$data['query'] = $this->db->order_by('urut')->get('ms_cara_bayar')->result_array();
			$this->load->view('rekap',$data);
		}
		
		public function showDiagnosa(){
			$get = $this->input->get(NULL,TRUE);
			$data['tgl1'] = $get['tgl1'];
			$data['tgl2'] = $get['tgl2'];
			$data['type'] = $get['type'];
			$data['kategori'] = $get['kategori'];
			$data['poliklinik'] = $get['id_poliklinik'];
			
			$this->db->select('trs_diagnosa.code,trs_konsultasi.add_time,ms_icd.deskripsi_ing as deskripsi')
			->join('trs_diagnosa','trs_diagnosa.code = ms_icd.code','inner')
			->join('trs_konsultasi','trs_diagnosa.id_konsultasi = trs_konsultasi.id','inner')
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner');
			
			if($get['id_poliklinik'] != null){
				$this->db->where('trs_appointment.id_poliklinik',$get['id_poliklinik']);
			}
			if($get['type'] != null){
				$this->db->where('trs_diagnosa.type','ICD'.$get['type']);
			}
			if($get['kategori'] != null){
				$this->db->limit($get['kategori'],0);
			} 
			
			$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$get['tgl1'].'" and "'.$get['tgl2'].'"');
			
			$data['query'] = $this->db->group_by('ms_icd.code')
			->order_by('count(ms_icd.code)','DESC')
			->get('ms_icd')->result_array();
			
			$this->load->view('diagnosa',$data);
		}

		public function cekFilter($p){
			
			$data_filter = array(
				'1' => 'trs_konsultasi',
				'2' => 'trs_konsultasi',
				'3' => 'trs_billing',
				'4' => 'trs_konsultasi'
			);
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
								if($index == 'kategori'){
									
								}
								else if($index == 'type'){
									$where_filter['trs_diagnosa.'.$index] = $value;
								}
								else if($index != 'id_poliklinik'){
									$where_filter[$index] = $value;
								}
								else{
									$where_filter['trs_appointment.'.$index] = $value;
								}
							}
						}
						
						if(!empty($date1) && !empty($date2))
						{
							$this->db->where('DATE('.$data_filter[$p].'.add_time) >=',convert_tgl($date1,'Y-m-d'));
							$this->db->where('DATE('.$data_filter[$p].'.add_time) <=',convert_tgl($date2,'Y-m-d'));
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