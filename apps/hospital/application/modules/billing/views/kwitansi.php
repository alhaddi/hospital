<?php
if($payment['id_komponen'] == 5){
	
$data = $this->db->query("SELECT
	ms_kategori_penunjang.biaya,
	CONCAT(ms_kategori_penunjang.kelompok,' ',ms_kategori_penunjang.nama) as nama
FROM
ms_kategori_penunjang,trs_anamesa,trs_appointment,trs_penunjang,trs_konsultasi, ms_penunjang 
WHERE ms_kategori_penunjang.id_ms_penunjang = ms_penunjang.id
AND trs_anamesa.id_appointment = trs_appointment.id
AND trs_penunjang.id_ms_penunjang = ms_penunjang.id
AND trs_konsultasi.id_anamesa = trs_anamesa.id 
AND trs_penunjang.id_konsultasi = trs_konsultasi.id
AND trs_appointment.id='".$payment['id_appointment']."'
GROUP BY ms_kategori_penunjang.kategori")->result();
		
}else{
			
$data = $this->db->query("SELECT
ms_tindakan.nama,
trs_tindakan.biaya
FROM
trs_anamesa
INNER JOIN trs_appointment ON trs_anamesa.id_appointment = trs_appointment.id
INNER JOIN trs_konsultasi ON trs_konsultasi.id_anamesa = trs_anamesa.id
INNER JOIN trs_tindakan ON trs_tindakan.id_konsultasi = trs_konsultasi.id
INNER JOIN ms_tindakan ON trs_tindakan.id_ms_tindakan = ms_tindakan.id
WHERE trs_appointment.id='".$payment['id_appointment']."'")->result();


}
$jum=count($data);
$tinggi=$jum+1;
$tinggi=($jum < 8)?9.3:$tinggi;
$arr=array(34,$tinggi);
$this->fpdf->FPDF('L','cm',$arr);
$this->fpdf->SetAutoPageBreak(false);
$this->fpdf->SetMargins(5,0.5,2.5,0);

$this->fpdf->AliasNbPages();
$this->fpdf->SetAutoPageBreak(false);

$this->fpdf->SetMargins(5,0.5,2.5,0);
$this->fpdf->AliasNbPages();

$this->fpdf->SetFillColor(0xff,0xff,0xff);

$this->fpdf->AddPage("L");
$this->fpdf->SetDisplayMode("real","single");

$rm = strtoupper($pasien['rm']);

$this->fpdf->SetFont('courier','B',9);
//$this->fpdf->image("assets/images/logo1.jpg",0.5,1,2);
//$this->fpdf->image("assets/images/gunting.png",23,13.1,1);

$this->fpdf->setXY(0.5,0.3);
$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->Cell(8.7,0.5,chunk_split($identitas['nama'],1,' '),0,0,'L');
$this->fpdf->setXY(0.5,0.75);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(8.7,0.5,chunk_split($identitas['alamat'],1,' '),0,0,'L');
$this->fpdf->setXY(0.5,1.15);
$this->fpdf->Cell(8.7,0.5,"T E L P . ".chunk_split($identitas['tlp'],1,' '),0,0,'L');

$this->fpdf->SetFillColor(50,205,50);
$this->fpdf->setXY(0,1.7);
$this->fpdf->Cell(40,0.1,"",1,1,'C',true);

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->SetFillColor(255,255,255);
$this->fpdf->setXY(29.2,0.3);
$this->fpdf->Cell(3.8,0.8,"K W I T A N S I",1,1,'C',true);
$this->fpdf->SetFont('Arial','I',9);
$this->fpdf->setXY(29.4,1.1);
$this->fpdf->Cell(3.4,0.5,"N o . ".chunk_split(get_field($payment['id_komponen'],'ms_komponen_registrasi','kode').$payment["no_tagihan"],1,' '),0,0,'C');

if(strlen($rm) > 8) {
    $no_rm = str_pad($rm, (strlen($rm)+2), "0", STR_PAD_LEFT);
} else {
    $no_rm = str_pad($rm, 8, "0", STR_PAD_LEFT);
}

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->setXY(0.5,2.5);
$this->fpdf->Cell(2,0.5,"R M / P a s i e n",0,1,'L',true);
$this->fpdf->setXY(5.0,2.5);
$this->fpdf->Cell(0.9,0.5,":",0,1,'L',true);
$this->fpdf->setXY(5.5,2.5);
$this->fpdf->Cell(4.7,0.5,chunk_split($no_rm,1,' ')." / ".strtoupper(chunk_split($pasien['nama_lengkap'],1,' ')),0,1,'L',true);

$this->fpdf->setXY(0.5,3);
$this->fpdf->Cell(2,0.5,"U a n g S e b e s a r",0,1,'L',true);
$this->fpdf->setXY(5.0,3);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);

$this->fpdf->setXY(0.5,3.5);
$this->fpdf->Cell(2,0.5,"U n t u k  P e m b a y a r a n",0,1,'L',true);
$this->fpdf->setXY(5.0,3.5);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(5.5,3.5);
$this->fpdf->Cell(4.7,0.5,chunk_split(get_field($payment['id_komponen'],'ms_komponen_registrasi'),1,' '),0,1,'L',true);

if($payment['id_komponen'] == 1){
	$this->fpdf->setXY(0.5,4);
	$this->fpdf->Cell(2,0.5,"P o l i k l i n i k  T u j u a n",0,1,'L',true);
	$this->fpdf->setXY(5.0,4);
	$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
	$this->fpdf->setXY(5.5,4);
	$this->fpdf->Cell(4.7,0.5,chunk_split(get_field($poliklinik['id_poliklinik'],'ms_poliklinik'),1,' '),0,1,'L',true);
	
	$this->fpdf->SetFont('Arial','B',14);
		$this->fpdf->setXY(12.1,4.9);
		$this->fpdf->Cell(4.4,0.8,"Rp.",0,0,'L');

				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->setXY(0.6,4.9);
				$this->fpdf->Cell(0.5,0.5,"N o",1,0,'C');
				$this->fpdf->Cell(8,0.5,"B i a y a",1,0,'C');
				$this->fpdf->Cell(2.5,0.5,"H a r g a",1,0,'C');

		$n=1;
		$z=0.5;
		$this->fpdf->SetFont('Arial','',7);

				$this->fpdf->setXY(0.6,4.9+$z);
				$this->fpdf->Cell(0.5,0.5,1,1,0,'L');
				$this->fpdf->Cell(8,0.5,chunk_split(get_field($payment['id_komponen'],'ms_komponen_registrasi','nama'),1,' '),1,0,'L');
				$this->fpdf->Cell(2.5,0.5,chunk_split(rupiah($payment["nominal"]),1,' '),1,0,'L');
				$n++;
				$z=$z+0.5;
				$jumlah=$payment["nominal"];
					
				$this->fpdf->setXY(0.6,4.9+$z);
				$this->fpdf->Cell(8.5,0.5,"J u m l a h",1,0,'C');
				$this->fpdf->Cell(2.5,0.5,chunk_split(rupiah($jumlah),1,' '),1,0,'L');

			$this->fpdf->SetFont('Arial','B',14);	
			$this->fpdf->setXY(12,4.9);
			$this->fpdf->Cell(4.4,0.8,chunk_split(number_format($jumlah,"0",".","."),1,' '),1,1,'R');
			$this->fpdf->setXY(5.5,3);

			$this->fpdf->SetFont('Arial','B',9);
			$this->fpdf->Cell(4.5,0.5,chunk_split($this->currency->terbilang_rupiah($jumlah),1,' ').' r u p i a h',0,1,'L',true);		
			$this->fpdf->SetFont('Arial','',9);
			
}else{

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->setXY(12.5,4.9);
$this->fpdf->Cell(4.4,0.8,"Rp.",0,0,'L');

		$this->fpdf->SetFont('Arial','B',7);
		$this->fpdf->setXY(0.6,4.9);
		$this->fpdf->Cell(0.5,0.5,"N o",1,0,'C');
		$this->fpdf->Cell(8,0.5,"B i a y a",1,0,'C');
		$this->fpdf->Cell(2.5,0.5,"H a r g a",1,0,'C');

$n=1;
$z=0.5;
$this->fpdf->SetFont('Arial','',7);

		$this->fpdf->setXY(0.6,4.9+$z);
		$this->fpdf->Cell(0.5,0.5,1,1,0,'L');
		$this->fpdf->Cell(8,0.5,get_field($payment['id_komponen'],'ms_komponen_registrasi','nama'),1,0,'L');
		$this->fpdf->Cell(2.5,0.5,rupiah($payment["nominal"]),1,0,'L');
		$n++;
		$z=$z+0.5;
		$jumlah=$payment["nominal"];
			
		$this->fpdf->setXY(0.6,4.9+$z);
		$this->fpdf->Cell(8.5,0.5,"J u m l a h",1,0,'C');
		$this->fpdf->Cell(2.5,0.5,rupiah($jumlah),1,0,'L');

$this->fpdf->SetFont('Arial','B',14);	
$this->fpdf->setXY(12,4.9);
$this->fpdf->Cell(4.4,0.8,number_format($jumlah,"0",".","."),1,1,'R');
$this->fpdf->setXY(5.5,3);

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->Cell(5.5,0.5,$this->currency->terbilang_rupiah($jumlah),0,1,'L',true);		
$this->fpdf->SetFont('Arial','',9);
}

$this->fpdf->setXY(26.5,6.4);
$this->fpdf->SetFont('Arial','B',8.5);
$this->fpdf->Cell(4.5,0.8,"B e n d a h a r a  P e n e r i m a",0,0,'C');

$this->fpdf->setXY(26.5,7.5);
$this->fpdf->SetFont('Arial','',8);
$this->fpdf->Cell(4.5,0.05,chunk_split($penanggung_jawab,1,' '),0,0,'L');

$this->fpdf->setXY(26.5,7.9);
$this->fpdf->Cell(4.5,0.05,"N I P : ".chunk_split($nip,1,' '),0,0,'L');

$this->fpdf->SetFont('Arial','',7);
/*$this->fpdf->SetFillColor(50,205,50);
$this->fpdf->setXY(0,8.8);
$this->fpdf->Cell(20,0.1,"",1,1,'C',true);*/

//$this->fpdf->SetFont('Arial','I',7);
//$this->fpdf->SetFillColor(255,255,255);
//$this->fpdf->setXY(0.5,8.2);
//$this->fpdf->Cell(9.6,0.9,"Penyetor : Seseorang atau suatu perusahaan yang menyetor uang kepada kasir.",0,0,'L',true);

$this->fpdf->setXY(27,8.3);
$this->fpdf->Cell(4.4,0.9," T g l. C e t a k ".chunk_split(date("d-m-Y h:i"),1,' '),0,0,'R',true);

$this->fpdf->Output();