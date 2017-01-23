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

$this->fpdf->SetFont('Arial','B',9); 
$this->fpdf->setXY(0,2);
$this->fpdf->Cell(30,0.5,'RL 5.4 10 BESAR PENYAKIT RAWAT JALAN',0,0,'C');
$this->fpdf->setXY(0,2.5);

$this->fpdf->SetFont('Arial','',8); 

$this->fpdf->setXY(1.5,3.1);
$this->fpdf->Cell(2,0.5,'Kode RS',0,0,'L');
$this->fpdf->Cell(3,0.5,'3205010',0,0,'C');

$this->fpdf->setXY(1.5,3.5);
$this->fpdf->Cell(2,0.5,'Nama RS',0,0,'L');
$this->fpdf->Cell(3,0.5,'RSUD dr.Slamet Garut',0,0,'C');

$this->fpdf->SetFont('Arial','B',8); 

$this->fpdf->setXY(0.7,4.5);

$this->fpdf->Cell(2,0.5,'Bulan',1,0,'C');
$this->fpdf->Cell(1.5,0.5,'No. Urut',1,0,'C');
$this->fpdf->Cell(2,0.5,($type != null)?'Kode ICD '.$type:'Kode ICD',1,0,'C');
$this->fpdf->Cell(7.5,0.5,'Deskripsi',1,0,'C');
$this->fpdf->Cell(3,0.5,'Jenis Kelamin LK',1,0,'C');
$this->fpdf->Cell(3,0.5,'Jenis Kelamin PR',1,0,'C');
$this->fpdf->Cell(4,0.5,'Jumlah Kasus Baru(4+5)',1,0,'C');
$this->fpdf->Cell(4,0.5,'Jumlah Kunjungan',1,0,'C');

$x = 0;

$y = 5;

$this->fpdf->SetFont('Arial','',8); 

foreach ($query as $row) :
	
	$l = 0;
	$p = 0;
	$jml = 0;

	  if(($x+1) % 21 == 0){
		  
		$this->fpdf->AddPage();

		$this->fpdf->SetFont('Arial','B',8); 

		$this->fpdf->setXY(0.7,4.5);

		$this->fpdf->Cell(2,0.5,'Bulan',1,0,'C');
		$this->fpdf->Cell(1.5,0.5,'No. Urut',1,0,'C');
		$this->fpdf->Cell(2,0.5,($type != null)?'Kode ICD '.$type:'Kode ICD',1,0,'C');
		$this->fpdf->Cell(7.5,0.5,'Deskripsi',1,0,'C');
		$this->fpdf->Cell(3,0.5,'Kasus Baru menurut Jenis Kelamin LK',1,0,'C');
		$this->fpdf->Cell(3,0.5,'Kasus Baru Menuru Jenis Kelamin PR',1,0,'C');
		$this->fpdf->Cell(4,0.5,'Jumlah Kasus Baru(4+5)',1,0,'C');
		$this->fpdf->Cell(4,0.5,'Jumlah Kunjungan',1,0,'C');

	  }
		
		$this->fpdf->setXY(0.7,$y+($x*0.5));
		$this->fpdf->Cell(2,0.5,convert_tgl($row['add_time'],'F',1),1,0,'C');
		$this->fpdf->Cell(1.5,0.5,($x+1),1,0,'C');
		$this->fpdf->Cell(2,0.5,$row['code'],1,0,'C');
		$this->fpdf->Cell(7.5,0.5,$row['deskripsi'],1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		if($type != null){
			$this->db->where('trs_diagnosa.type','ICD'.$type);
		}
		$l = $this->Rekam_mediss->get_diagnosa('L',$row['code']);
		$jml += (isset($l))?$l:0;
		$this->fpdf->Cell(3,0.5,(isset($l))?$l:0,1,0,'C');
		if($poliklinik != null){
			$this->db->where('trs_appointment.id_poliklinik',$poliklinik);
		}
		$this->db->where('date_format(trs_konsultasi.add_time,"%Y-%m-%d") between "'.$tgl1.'" and "'.$tgl2.'"');
		if($type != null){
			$this->db->where('trs_diagnosa.type','ICD'.$type);
		}
		$p = $this->Rekam_mediss->get_diagnosa('P',$row['code']);
		$jml += (isset($p))?$p:0;
		$this->fpdf->Cell(3,0.5,(isset($p))?$p:0,1,0,'C');
		$this->fpdf->Cell(4,0.5,$jml,1,0,'C');
		$this->fpdf->Cell(4,0.5,$jml,1,0,'C');

	  $x++;

endforeach;
		

    $this->fpdf->Output("Rekapitulasi_Kunjungan_Pasien.pdf","I");


?>

