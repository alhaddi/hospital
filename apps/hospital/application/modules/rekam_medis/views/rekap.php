<?php
$nama_poli = ($poliklinik != null)?get_field($poliklinik,'ms_poliklinik'):'Semua Poliklinik';

/**

     * APLICATION INFO  : PDF Report with FPDF 1.6

     * DATE CREATED     : 21 juni 2013

   * DEVELOPED BY     : Radi Ganteng 

   */



/* setting zona waktu */ 

//date_default_timezone_set('Asia/Jakarta');



/* konstruktor halaman pdf sbb :    

   P  = Orientasinya "Potrait"

   cm = ukuran halaman dalam satuan centimeter

   A4 = Format Halaman

   

   jika ingin mensetting sendiri format halamannya, gunakan array(width, height)  

   contoh : $this->fpdf->FPDF("P","cm", array(20, 20));  

*/



$this->fpdf = new fpdf();



//$this->fpdf->FPDF("P","cm","Legal");

$this->fpdf->FPDF('L','cm',"A4");



// kita set marginnya dimulai dari kiri, atas, kanan. jika tidak diset, defaultnya 1 cm

$this->fpdf->SetMargins(0,0.5,0.5,0);

$this->fpdf->SetAutoPageBreak(false);



/* AliasNbPages() merupakan fungsi untuk menampilkan total halaman

   di footer, nanti kita akan membuat page number dengan format : number page / total page

*/

$this->fpdf->AliasNbPages();



// AddPage merupakan fungsi untuk membuat halaman baru

$this->fpdf->AddPage();

$this->fpdf->SetFont('Arial','B',9); 
$this->fpdf->setXY(0,2);
$this->fpdf->Cell(30,0.5,'REKAPITULASI HARIAN KUNJUNGAN PASIEN / TINDAKAN / PEMERIKSAAN PENDAPATAN',0,0,'C');
$this->fpdf->setXY(0,2.5);
$this->fpdf->Cell(30,0.5,'POLIKLINIK INSTALASI RAWAT JALAN RSUD dr. SLAMET GARUT',0,0,'C');

$this->fpdf->SetFont('Arial','',8); 

$this->fpdf->setXY(1.5,3.1);
$this->fpdf->Cell(2,0.5,'POLI',0,0,'L');
$this->fpdf->Cell(3,0.5,': '.$nama_poli,0,0,'L');

$this->fpdf->setXY(1.5,3.5);
$this->fpdf->Cell(2,0.5,'TANGGAL',0,0,'L');
$this->fpdf->Cell(3,0.5,': '.convert_tgl($tgl2,'d F Y',1),0,0,'L');

$this->fpdf->SetFont('Arial','B',8); 

$this->fpdf->setXY(0.7,4.5);

$this->fpdf->Cell(0.6,1.4,'NO',1,0,'C');
$this->fpdf->Cell(2.5,1.4,'STATUS PASIEN',1,0,'C');
$this->fpdf->Cell(2,0.4,'KUNJUNGAN',1,0,'C');
$this->fpdf->Cell(3.5,0.4,'JUMLAH',1,0,'C');
$this->fpdf->Cell(2.8,0.4,'TINDAKAN',1,0,'C');
$this->fpdf->Cell(1,1.4,'JML',1,0,'C');
$this->fpdf->Cell(5,0.4,'PENUNJANG',1,0,'C');
$this->fpdf->Cell(8.3,0.4,'PENDAPATAN',1,0,'C');
$this->fpdf->Cell(2.5,1.4,'JUMLAH TOTAL',1,0,'C');

$this->fpdf->setXY(3.8,4.9);
$this->fpdf->Cell(1,1,'BARU',1,0,'C');
$this->fpdf->Cell(1,1,'LAMA',1,0,'C');
$this->fpdf->Cell(1,1,'KUNJ',1,0,'C');
$this->fpdf->Cell(1.3,1,'KONSUL',1,0,'C');
$this->fpdf->Cell(1.2,1,'CEK UP',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'3A',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'3B',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'3C',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'L.P',1,0,'C');

$this->fpdf->setXY(13.1,4.9);
$this->fpdf->Cell(0.7,1,'EKG',1,0,'C');
$this->fpdf->Cell(0.7,1,'EEG',1,0,'C');
$this->fpdf->Cell(0.7,1,'USG',1,0,'C');
$this->fpdf->Cell(1,1,'AUDIO',1,0,'C');
$this->fpdf->Cell(1,1,'SPIRO',1,0,'C');
$this->fpdf->Cell(0.9,1,'LAIN2',1,0,'C');
$this->fpdf->Cell(2,0.5,'KUNJUNGAN',1,0,'C');
$this->fpdf->Cell(2,0.5,'TINDAKAN',1,0,'C');
$this->fpdf->Cell(2.2,0.5,'PEMERIKSAAN',1,0,'C');
$this->fpdf->Cell(2.1,0.5,'PEM. KONSUL',1,0,'C');

$this->fpdf->setXY(9.3,5.4);
$this->fpdf->Cell(0.7,0.5,'SDH',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'KCL',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'SDG',1,0,'C');
$this->fpdf->Cell(0.7,0.5,'BSR',1,0,'C');

$this->fpdf->setXY(18.1,5.4);
$this->fpdf->Cell(2,0.5,'Rp.',1,0,'C');
$this->fpdf->Cell(2,0.5,'Rp.',1,0,'C');
$this->fpdf->Cell(2.2,0.5,'Rp.',1,0,'C');
$this->fpdf->Cell(2.1,0.5,'Rp.',1,0,'C');

$x = 0;

$y = 5.9;

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

$this->fpdf->SetFont('Arial','',8); 

foreach ($query as $row) :
	
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

	  if(($x+1) % 21 == 0){
		  
		$this->fpdf->AddPage();

		$this->fpdf->SetFont('Arial','B',8); 

		$this->fpdf->setXY(0.7,4.5);

		$this->fpdf->Cell(0.6,1.4,'NO',1,0,'C');
		$this->fpdf->Cell(2.5,1.4,'STATUS PASIEN',1,0,'C');
		$this->fpdf->Cell(2,0.4,'KUNJUNGAN',1,0,'C');
		$this->fpdf->Cell(3.5,0.4,'JUMLAH',1,0,'C');
		$this->fpdf->Cell(2.8,0.4,'TINDAKAN',1,0,'C');
		$this->fpdf->Cell(1,1.4,'JML',1,0,'C');
		$this->fpdf->Cell(5,0.4,'PENUNJANG',1,0,'C');
		$this->fpdf->Cell(8.3,0.4,'PENDAPATAN',1,0,'C');
		$this->fpdf->Cell(2.5,1.4,'JUMLAH TOTAL',1,0,'C');

		$this->fpdf->setXY(3.8,4.9);
		$this->fpdf->Cell(1,1,'BARU',1,0,'C');
		$this->fpdf->Cell(1,1,'LAMA',1,0,'C');
		$this->fpdf->Cell(1,1,'KUNJ',1,0,'C');
		$this->fpdf->Cell(1.3,1,'KONSUL',1,0,'C');
		$this->fpdf->Cell(1.2,1,'CEK UP',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'3A',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'3B',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'3C',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'L.P',1,0,'C');

		$this->fpdf->setXY(13.1,4.9);
		$this->fpdf->Cell(0.7,1,'EKG',1,0,'C');
		$this->fpdf->Cell(0.7,1,'EEG',1,0,'C');
		$this->fpdf->Cell(0.7,1,'USG',1,0,'C');
		$this->fpdf->Cell(1,1,'AUDIO',1,0,'C');
		$this->fpdf->Cell(1,1,'SPIRO',1,0,'C');
		$this->fpdf->Cell(0.9,1,'LAIN2',1,0,'C');
		$this->fpdf->Cell(2,0.5,'KUNJUNGAN',1,0,'C');
		$this->fpdf->Cell(2,0.5,'TINDAKAN',1,0,'C');
		$this->fpdf->Cell(2.2,0.5,'PEMERIKSAAN',1,0,'C');
		$this->fpdf->Cell(2.1,0.5,'PEM. KONSUL',1,0,'C');

		$this->fpdf->setXY(9.3,5.4);
		$this->fpdf->Cell(0.7,0.5,'SDH',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'KCL',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'SDG',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,'BSR',1,0,'C');

		$this->fpdf->setXY(18.1,5.4);
		$this->fpdf->Cell(2,0.5,'Rp.',1,0,'C');
		$this->fpdf->Cell(2,0.5,'Rp.',1,0,'C');
		$this->fpdf->Cell(2.2,0.5,'Rp.',1,0,'C');
		$this->fpdf->Cell(2.1,0.5,'Rp.',1,0,'C');

	  }
		
		$this->fpdf->setXY(0.7,$y+($x*0.5));
		$this->fpdf->Cell(0.6,0.5,($row['nama'] == 'BPJS')?$x:($x+1),1,0,'C');
		$this->fpdf->Cell(2.5,0.5,$row['nama'],1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],'','');
		$totalBaru += (isset($baru) && $row['nama'] != 'BPJS' && $baru != '0')?$baru:0;
		$this->fpdf->Cell(1,0.5,(isset($baru) && $row['nama'] != 'BPJS' && $baru != '0')?$baru:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$lama = $this->Rekam_mediss->get_pasien('lama',$row['nama'],'','');
		$totalLama += (isset($lama) && $row['nama'] != 'BPJS' && $lama != '0')?$lama:0;
		$this->fpdf->Cell(1,0.5,(isset($lama) && $row['nama'] != 'BPJS' && $lama != '0')?$lama:'',1,0,'C');
		$kunj += $baru+$lama;
		$totalKunj += (isset($kunj) && $row['nama'] != 'BPJS' && $kunj != '0')?$kunj:0;
		$this->fpdf->Cell(1,0.5,(isset($kunj) && $row['nama'] != 'BPJS' && $kunj != '0')?$kunj:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$konsul = (!empty($poliklinik))?$this->Rekam_mediss->get_konsul($row['nama'],'',$poliklinik):'';
		$totalKonsul += (isset($konsul) && $row['nama'] != 'BPJS' && $konsul != '0')?$konsul:0;
		$this->fpdf->Cell(1.3,0.5,(isset($konsul) && $row['nama'] != 'BPJS' && $konsul != '0')?$konsul:'',1,0,'C');
		$this->fpdf->Cell(1.2,0.5,'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$sdh = $this->Rekam_mediss->get_tindakan($row['nama'],'','Sederhana');
		$totalSdh += (isset($sdh) && $row['nama'] != 'BPJS' && $sdh != '0')?$sdh:0;
		$this->fpdf->Cell(0.7,0.5,(isset($sdh) && $row['nama'] != 'BPJS' && $sdh != '0')?$sdh:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$kcl = $this->Rekam_mediss->get_tindakan($row['nama'],'','Kecil');
		$totalKcl += (isset($kcl) && $row['nama'] != 'BPJS' && $kcl != '0')?$kcl:0;
		$this->fpdf->Cell(0.7,0.5,(isset($kcl) && $row['nama'] != 'BPJS' && $kcl != '0')?$kcl:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$sdg = $this->Rekam_mediss->get_tindakan($row['nama'],'','Sedang');
		$totalSdg += (isset($sdg) && $row['nama'] != 'BPJS' && $sdg != '0')?$sdg:0;
		$this->fpdf->Cell(0.7,0.5,(isset($sdg) && $row['nama'] != 'BPJS' && $sdg != '0')?$sdg:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$bsr = $this->Rekam_mediss->get_tindakan($row['nama'],'','Besar');
		$totalBsr += (isset($bsr) && $row['nama'] != 'BPJS' && $bsr != '0')?$bsr:0;	
		$this->fpdf->Cell(0.7,0.5,(isset($bsr) && $row['nama'] != 'BPJS' && $bsr != '0')?$bsr:'',1,0,'C');
		$jmlTindakan += $sdh+$kcl+$sdg+$bsr;
		$totalJml += (isset($jmlTindakan) && $row['nama'] != 'BPJS' && $jmlTindakan != '0')?$jmlTindakan:0;
		$this->fpdf->Cell(1,0.5,(isset($jmlTindakan) && $row['nama'] != 'BPJS' && $jmlTindakan != '0')?$jmlTindakan:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$ekg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang EKG');
		$totalEkg += (isset($ekg) && $row['nama'] != 'BPJS' && $ekg != '0')?$ekg:0;
		$this->fpdf->Cell(0.7,0.5,(isset($ekg) && $row['nama'] != 'BPJS' && $ekg != '0')?$ekg:'',1,0,'C');
		$eeg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang EEG');
		$totalEeg += (isset($eeg) && $row['nama'] != 'BPJS' && $eeg != '0')?$eeg:0;
		$this->fpdf->Cell(0.7,0.5,(isset($eeg) && $row['nama'] != 'BPJS' && $eeg != '0')?$eeg:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$usg = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang USG Kebidanan');
		$totalUsg += (isset($usg) && $row['nama'] != 'BPJS' && $usg != '0')?$usg:0;
		$this->fpdf->Cell(0.7,0.5,(isset($usg) && $row['nama'] != 'BPJS' && $usg != '0')?$usg:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$audio = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang Audiologi');
		$totalAudio += (isset($audio) && $row['nama'] != 'BPJS' && $audio != '0')?$audio:0;
		$this->fpdf->Cell(1,0.5,(isset($audio) && $row['nama'] != 'BPJS' && $audio != '0')?$audio:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$spiro = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','Penunjang Spirometri');
		$totalSpiro += (isset($spiro) && $row['nama'] != 'BPJS' && $spiro != '0')?$spiro:0;
		$this->fpdf->Cell(1,0.5,(isset($spiro) && $row['nama'] != 'BPJS' && $spiro != '0')?$spiro:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$lain2 = $this->Rekam_mediss->get_pasien('',$row['nama'],'','','','lain2');
		$totalLain2 += (isset($lain2) && $row['nama'] != 'BPJS' && $lain2 != '0')?$lain2:0;
		$this->fpdf->Cell(0.9,0.5,(isset($lain2) && $row['nama'] != 'BPJS' && $lain2 != '0')?$lain2:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$kunjungan = $this->Rekam_mediss->get_nominal($row['nama'],'','1');
		$jmlTotal += (isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:0;
		$totalKunjungan += (isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:0;
		$this->fpdf->Cell(2,0.5,(isset($kunjungan) && $row['nama'] != 'BPJS' && $kunjungan != '0')?$kunjungan:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$tindakan = $this->Rekam_mediss->get_nominal($row['nama'],'','4');
		$jmlTotal += (isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:0;
		$totalTindakan += (isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:0;
		$this->fpdf->Cell(2,0.5,(isset($tindakan) && $row['nama'] != 'BPJS' && $tindakan != '0')?$tindakan:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$pemeriksaan = $this->Rekam_mediss->get_nominal($row['nama'],'','5');
		$totalPemeriksaan += (isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:0;
		$jmlTotal += (isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:0;
		$this->fpdf->Cell(2.2,0.5,(isset($pemeriksaan) && $row['nama'] != 'BPJS' && $pemeriksaan != '0')?$pemeriksaan:'',1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		$pemkonsul = $this->Rekam_mediss->get_nominal_konsul($row['nama'],'','3');
		$jmlTotal += (isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:0;
		$totalPemkonsul += (isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:0;
		$this->fpdf->Cell(2.1,0.5,(isset($pemkonsul) && $row['nama'] != 'BPJS' && $pemkonsul != '0')?$pemkonsul:'',1,0,'C');
		$totalJmltotal += (isset($jmlTotal) && $row['nama'] != 'BPJS' && $jmlTotal != '0')?$jmlTotal:0;
		$this->fpdf->Cell(2.5,0.5,(isset($jmlTotal) && $row['nama'] != 'BPJS' && $jmlTotal != '0')?$jmlTotal:'',1,0,'C');
		
		if($row['nama'] == 'RSU'){
			$x++;
			$this->fpdf->setXY(0.7,$y+($x*0.5));
			$this->fpdf->Cell(0.6,0.5,'',1,0,'C');
			$this->fpdf->Cell(2.5,0.5,'JUMLAH',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalBaru) && $totalBaru != '0')?$totalBaru:'',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalLama) && $totalLama != '0')?$totalLama:'',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalKunj) && $totalKunj != '0')?$totalKunj:'',1,0,'C');
			$this->fpdf->Cell(1.3,0.5,(isset($totalKonsul) && $totalKonsul != '0')?$totalKonsul:'',1,0,'C');
			$this->fpdf->Cell(1.2,0.5,'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalSdh) && $totalSdh != '0')?$totalSdh:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalKcl) && $totalKcl != '0')?$totalKcl:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalSdg) && $totalSdg != '0')?$totalSdg:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalBsr) && $totalBsr != '0')?$totalBsr:'',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalJml) && $totalJml != '0')?$totalJml:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalEkg) && $totalEkg != '0')?$totalEkg:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalEeg) && $totalEeg != '0')?$totalEeg:'',1,0,'C');
			$this->fpdf->Cell(0.7,0.5,(isset($totalUsg) && $totalUsg != '0')?$totalUsg:'',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalAudio) && $totalAudio != '0')?$totalAudio:'',1,0,'C');
			$this->fpdf->Cell(1,0.5,(isset($totalSpiro) && $totalSpiro != '0')?$totalSpiro:'',1,0,'C');
			$this->fpdf->Cell(0.9,0.5,(isset($totalLain2) && $totalLain2 != '0')?$totalLain2:'',1,0,'C');
			$this->fpdf->Cell(2,0.5,(isset($totalKunjungan) && $totalKunjungan != '0')?$totalKunjungan:'',1,0,'C');
			$this->fpdf->Cell(2,0.5,(isset($totalTindakan) && $totalTindakan != '0')?$totalTindakan:'',1,0,'C');
			$this->fpdf->Cell(2.2,0.5,(isset($totalPemeriksaan) && $totalPemeriksaan != '0')?$totalPemeriksaan:'',1,0,'C');
			$this->fpdf->Cell(2.1,0.5,(isset($totalPemkonsul) && $totalPemkonsul != '0')?$totalPemkonsul:'',1,0,'C');
			$this->fpdf->Cell(2.5,0.5,(isset($totalJmltotal) && $totalJmltotal != '0')?$totalJmltotal:'',1,0,'C');
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
				$x++;
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
				$this->fpdf->setXY(0.7,$y+($x*0.5));
				$this->fpdf->Cell(0.6,0.5,'',1,0,'C');
				$this->fpdf->Cell(2.5,0.5,$r['nama'],1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$baru = $this->Rekam_mediss->get_pasien('baru',$row['nama'],$r['nama'],'');
				$totalBaru += $baru;
				$this->fpdf->Cell(1,0.5,(isset($baru) && $baru != '0')?$baru:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$lama = $this->Rekam_mediss->get_pasien('lama',$row['nama'],$r['nama'],'');
				$totalLama += $lama;
				$this->fpdf->Cell(1,0.5,(isset($lama) && $lama != '0')?$lama:'',1,0,'C');
				$kunj += $baru+$lama;
				$totalKunj += $kunj;
				$this->fpdf->Cell(1,0.5,(isset($kunj) && $kunj != '0')?$kunj:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$konsul = (!empty($poliklinik))?$this->Rekam_mediss->get_konsul($row['nama'],$r['nama'],$poliklinik):'';
				$totalKonsul += $konsul;
				$this->fpdf->Cell(1.3,0.5,(isset($konsul) && $konsul != '0')?$konsul:'',1,0,'C');
				$this->fpdf->Cell(1.2,0.5,'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$sdh = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Sederhana');
				$totalSdh += $sdh;
				$this->fpdf->Cell(0.7,0.5,(isset($sdh) && $sdh != '0')?$sdh:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$kcl = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Kecil');
				$totalKcl += $kcl;
				$this->fpdf->Cell(0.7,0.5,(isset($kcl) && $kcl != '0')?$kcl:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$sdg = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Sedang');
				$totalSdg += $sdg;
				$this->fpdf->Cell(0.7,0.5,(isset($sdg) && $sdg != '0')?$sdg:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$bsr = $this->Rekam_mediss->get_tindakan($row['nama'],$r['nama'],'Besar');
				$totalBsr += $bsr;
				$this->fpdf->Cell(0.7,0.5,(isset($bsr) && $bsr != '0')?$bsr:'',1,0,'C');
				$jmlTindakan += $sdh+$kcl+$sdg+$bsr;
				$totalJml += $jmlTindakan;
				$this->fpdf->Cell(1,0.5,(isset($jmlTindakan) && $jmlTindakan != '0')?$jmlTindakan:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$ekg = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang EKG');
				$totalEkg += $ekg;
				$this->fpdf->Cell(0.7,0.5,(isset($ekg) && $ekg != '0')?$ekg:'',1,0,'C');
				$eeg = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang EEG');
				$totalEeg += $eeg;
				$this->fpdf->Cell(0.7,0.5,(isset($eeg) && $eeg != '0')?$eeg:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$usg = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang USG Kebidanan');
				$totalUsg += $usg;
				$this->fpdf->Cell(0.7,0.5,(isset($usg) && $usg != '0')?$usg:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$audio = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang Audiologi');
				$totalAudio += $audio;
				$this->fpdf->Cell(1,0.5,(isset($audio) && $audio != '0')?$audio:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$spiro = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','Penunjang Spirometri');
				$totalSpiro += $spiro;
				$this->fpdf->Cell(1,0.5,(isset($spiro) && $spiro != '0')?$spiro:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$lain2 = $this->Rekam_mediss->get_pasien('',$row['nama'],$r['nama'],'','','lain2');
				$totalLain2 += $lain2;
				$this->fpdf->Cell(0.9,0.5,(isset($lain2) && $lain2 != '0')?$lain2:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$kunjungan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'1');
				$totalKunjungan += $kunjungan;
				$jmlTotal += $kunjungan;
				$this->fpdf->Cell(2,0.5,(isset($kunjungan) && $kunjungan != '0')?$kunjungan:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$tindakan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'4');
				$totalTindakan += $tindakan;
				$jmlTotal += $tindakan;
				$this->fpdf->Cell(2,0.5,(isset($tindakan) && $tindakan != '0')?$tindakan:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$pemeriksaan = $this->Rekam_mediss->get_nominal($row['nama'],$r['nama'],'5');
				$totalPemeriksaan += $pemeriksaan;
				$jmlTotal += $pemeriksaan;
				$this->fpdf->Cell(2.2,0.5,(isset($pemeriksaan) && $pemeriksaan != '0')?$pemeriksaan:'',1,0,'C');
				if($poliklinik != null){
					$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
				}
				$this->db->where('date_format(trs_appointment.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
				$pemkonsul = $this->Rekam_mediss->get_nominal_konsul($row['nama'],$r['nama'],'3');
				$totalPemkonsul += $pemkonsul;
				$jmlTotal += $pemkonsul;
				$this->fpdf->Cell(2.1,0.5,(isset($pemkonsul) && $pemkonsul != '0')?$pemkonsul:'',1,0,'C');
				$totalJmltotal += $jmlTotal;
				$this->fpdf->Cell(2.5,0.5,(isset($jmlTotal) && $jmlTotal != '0')?$jmlTotal:'',1,0,'C');
			}
		}

	  $x++;
	}

endforeach;

		$this->fpdf->setXY(0.7,$y+($x*0.5));
		$this->fpdf->Cell(0.6,0.5,'',1,0,'C');
		$this->fpdf->Cell(2.5,0.5,'JUMLAH',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalBaru) && $totalBaru != '0')?$totalBaru:'',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalLama) && $totalLama != '0')?$totalLama:'',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalKunj) && $totalKunj != '0')?$totalKunj:'',1,0,'C');
		$this->fpdf->Cell(1.3,0.5,(isset($totalKonsul) && $totalKonsul != '0')?$totalKonsul:'',1,0,'C');
		$this->fpdf->Cell(1.2,0.5,'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalSdh) && $totalSdh != '0')?$totalSdh:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalKcl) && $totalKcl != '0')?$totalKcl:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalSdg) && $totalSdg != '0')?$totalSdg:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalBsr) && $totalBsr != '0')?$totalBsr:'',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalJml) && $totalJml != '0')?$totalJml:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalEkg) && $totalEkg != '0')?$totalEkg:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalEeg) && $totalEeg != '0')?$totalEeg:'',1,0,'C');
		$this->fpdf->Cell(0.7,0.5,(isset($totalUsg) && $totalUsg != '0')?$totalUsg:'',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalAudio) && $totalAudio != '0')?$totalAudio:'',1,0,'C');
		$this->fpdf->Cell(1,0.5,(isset($totalSpiro) && $totalSpiro != '0')?$totalSpiro:'',1,0,'C');
		$this->fpdf->Cell(0.9,0.5,(isset($totalLain2) && $totalLain2 != '0')?$totalLain2:'',1,0,'C');
		$this->fpdf->Cell(2,0.5,(isset($totalKunjungan) && $totalKunjungan != '0')?$totalKunjungan:'',1,0,'C');
		$this->fpdf->Cell(2,0.5,(isset($totalTindakan) && $totalTindakan != '0')?$totalTindakan:'',1,0,'C');
		$this->fpdf->Cell(2.2,0.5,(isset($totalPemeriksaan) && $totalPemeriksaan != '0')?$totalPemeriksaan:'',1,0,'C');
		$this->fpdf->Cell(2.1,0.5,(isset($totalPemkonsul) && $totalPemkonsul != '0')?$totalPemkonsul:'',1,0,'C');
		$this->fpdf->Cell(2.5,0.5,(isset($totalJmltotal) && $totalJmltotal != '0')?$totalJmltotal:'',1,0,'C');
		
		$x+=2;
		$this->fpdf->setXY(3.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Mengetahui :',0,0,'C');
		$this->fpdf->setXY(20.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Garut, '.convert_tgl($tgl2,'d F Y',1),0,0,'C');
		$x++;
		$this->fpdf->setXY(3.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Kepala Poliklinik,',0,0,'C');
		$this->fpdf->setXY(20.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Petugas Administrasi,',0,0,'C');
		$this->fpdf->setXY(3.7,$y+($x*0.5));
		$x+=4;
		$this->fpdf->setXY(3.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Nip.                   ','T',0,'L');
		$this->fpdf->setXY(20.7,$y+($x*0.5));
		$this->fpdf->Cell(4,0.5,'Nip.                   ','T',0,'L');
		

    $this->fpdf->Output("Rekapitulasi_Kunjungan_Pasien.pdf","I");


?>

