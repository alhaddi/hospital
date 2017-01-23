<?php



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



$this->fpdf->SetFont('Arial','',8); 

$this->fpdf->setXY(0.5,3);

$this->fpdf->Cell(5.5,2,'HARI/TANGGAL : ',0,0,'C');



$namahari = date('l');

$namabulan = date('n');

  

  if ($namahari == "Sunday") $namahari2 = "Minggu"; 

  else if ($namahari == "Monday") $namahari2 = "Senin"; 

  else if ($namahari == "Tuesday") $namahari2 = "Selasa"; 

  else if ($namahari == "Wednesday") $namahari2 = "Rabu"; 

  else if ($namahari == "Thursday") $namahari2 = "Kamis"; 

  else if ($namahari == "Friday") $namahari2 = "Jumat"; 

  else if ($namahari == "Saturday") $namahari2 = "Sabtu";



$this->fpdf->SetFont('Arial','',8); 

$this->fpdf->SetFont('Arial','B',9); 
$this->fpdf->setXY(0,2);
$this->fpdf->Cell(30,0.5,'REKAPITULASI HARIAN KUNJUNGAN PASIEN / TINDAKAN / PEMERIKSAAN PENDAPATAN',0,0,'C');
$this->fpdf->setXY(0,2.5);
$this->fpdf->Cell(30,0.5,'POLIKLINIK INSTALASI RAWAT JALAN RSUD dr. SLAMET GARUT',0,0,'C');

$this->fpdf->setXY(3.7,3);

$this->fpdf->Cell(5.5,2,$namahari2.', '.convert_tgl(date('d F Y'),'d F Y',1),0,0,'C');



$this->fpdf->SetFont('Arial','B',8); 

$this->fpdf->setXY(0.7,4.5);



$this->fpdf->Cell(0.5,1.4,'NO',1,0,'C');

$this->fpdf->Cell(12.5,0.7,'KATEGORI',1,0,'C');

$this->fpdf->Cell(11,0.7,'PEMBAYARAN',1,0,'C');

$this->fpdf->Cell(1.5,1.4,'TTL BARU',1,0,'C');

$this->fpdf->Cell(1.5,1.4,'TTL LAMA',1,0,'C');

$this->fpdf->Cell(1.5,1.4,'TOTAL',1,0,'C');



$this->fpdf->setXY(1.2,5.2);

$this->fpdf->Cell(3.5,0.7,'KLINIK',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'UMUM',1,0,'C');

$this->fpdf->Cell(2,0.7,'KONTRAK',1,0,'C');

$this->fpdf->Cell(1,0.7,'RSU',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'BARU',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'LAMA',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'JML',1,0,'C');



$this->fpdf->Cell(1.5,0.7,'AKSES',1,0,'C');

$this->fpdf->Cell(1,0.7,'KIS',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'JMSSTK',1,0,'C');

$this->fpdf->Cell(1,0.7,'TNI',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'MANDIRI',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'BARU',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'LAMA',1,0,'C');

$this->fpdf->Cell(1.5,0.7,'JML',1,0,'C');



$x = 0;

$y = 5.9;



foreach ($polikliniks as $row) :

	$jmlkate = 0; 

	$jmlbayar = 0;

	$ttllama = 0;

	$ttlbaru = 0;

  if(($x+1) % 21 == 0){



    $this->fpdf->AddPage();



    $this->fpdf->SetFont('Arial','',8); 

    $this->fpdf->setXY(0.5,3);

    $this->fpdf->Cell(5.5,2,'HARI/TANGGAL : ',0,0,'C');



    $this->fpdf->setXY(3.7,3);

    $this->fpdf->Cell(5.5,2,$namahari2.', '.convert_tgl(date('d F Y'),'d F Y',1),0,0,'C');


    $this->fpdf->SetFont('Arial','B',8); 

    $this->fpdf->setXY(0.7,4.5);



    $this->fpdf->Cell(0.5,1.4,'NO',1,0,'C');

    $this->fpdf->Cell(12.5,0.7,'KATEGORI',1,0,'C');

    $this->fpdf->Cell(11,0.7,'PEMBAYARAN',1,0,'C');

    $this->fpdf->Cell(1.5,1.4,'TTL BARU',1,0,'C');

    $this->fpdf->Cell(1.5,1.4,'TTL LAMA',1,0,'C');

    $this->fpdf->Cell(1.5,1.4,'TOTAL',1,0,'C');



    $this->fpdf->setXY(1.2,5.2);

    $this->fpdf->Cell(3.5,0.7,'KLINIK',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'UMUM',1,0,'C');

    $this->fpdf->Cell(2,0.7,'KONTRAK',1,0,'C');

    $this->fpdf->Cell(1,0.7,'RSU',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'BARU',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'LAMA',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'JML',1,0,'C');


    $this->fpdf->Cell(1.5,0.7,'AKSES',1,0,'C');

    $this->fpdf->Cell(1,0.7,'KIS',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'JMSSTK',1,0,'C');

    $this->fpdf->Cell(1,0.7,'TNI',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'MANDIRI',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'BARU',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'LAMA',1,0,'C');

    $this->fpdf->Cell(1.5,0.7,'JML',1,0,'C');

  }



  $this->fpdf->SetFont('Arial','',8); 

  $this->fpdf->setXY(0.7,$y+($x*0.7));

  $this->fpdf->Cell(0.5,0.7,$x+1,1,0,'C');

  $this->fpdf->Cell(3.5,0.7,$row['nama'],1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama != "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$umum = $this->Rekam_mediss->get_pasien('','UMUM','','');
$this->fpdf->Cell(1.5,0.7,$umum,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama != "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$kontrak = $this->Rekam_mediss->get_pasien('','KONTRAKTOR','','');
$this->fpdf->Cell(2,0.7,$kontrak,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama != "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$rsu = $this->Rekam_mediss->get_pasien('','RSU','','');
$this->fpdf->Cell(1,0.7,$rsu,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama != "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$kate_baru = $this->Rekam_mediss->get_pasien('baru','','','');
$jmlkate += $kate_baru;
$ttlbaru += $kate_baru;
$this->fpdf->Cell(1.5,0.7,$kate_baru,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama != "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$kate_lama = $this->Rekam_mediss->get_pasien('lama','','','');
$jmlkate += $kate_lama;
$ttllama += $kate_lama;
$this->fpdf->Cell(1.5,0.7,$kate_lama,1,0,'C');
$this->fpdf->Cell(1.5,0.7,$jmlkate,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$akses = $this->Rekam_mediss->get_pasien('','BPJS','AKSES','');
$jmlbayar += $akses;
$this->fpdf->Cell(1.5,0.7,$akses,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$kis = $this->Rekam_mediss->get_pasien('','BPJS','KIS','');
$this->fpdf->Cell(1,0.7,$kis,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$jmsstk = $this->Rekam_mediss->get_pasien('','BPJS','JAMSOSTEK','');
$this->fpdf->Cell(1.5,0.7,$jmsstk,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$tni = $this->Rekam_mediss->get_pasien('','BPJS','TNI dan POLRI','');
$this->fpdf->Cell(1,0.7,$tni,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$mandiri = $this->Rekam_mediss->get_pasien('','BPJS','Mandiri','');
$this->fpdf->Cell(1.5,0.7,$mandiri,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$bayar_baru = $this->Rekam_mediss->get_pasien('baru','BPJS','','');
$jmlbayar += $bayar_baru;
$this->fpdf->Cell(1.5,0.7,$bayar_baru,1,0,'C');

$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
$this->db->where('ms_cara_bayar.nama = "BPJS"');
$this->db->where('ms_poliklinik.nama',$row['nama']);
$bayar_lama = $this->Rekam_mediss->get_pasien('lama','BPJS','','');
$jmlbayar += $bayar_lama;
$this->fpdf->Cell(1.5,0.7,$bayar_lama,1,0,'C');

$this->fpdf->Cell(1.5,0.7,$jmlbayar,1,0,'C');

$this->fpdf->Cell(1.5,0.7,$ttlbaru,1,0,'C');
$this->fpdf->Cell(1.5,0.7,$ttllama,1,0,'C');

$this->fpdf->Cell(1.5,0.7,($jmlkate+$jmlbayar),1,0,'C');



  $x++;

endforeach;

	


    $this->fpdf->Output("kunjungan_pasien.pdf","I");


?>

