<?php
$this->fpdf->FPDF('L','cm',array(9.56,6));
$this->fpdf->SetAutoPageBreak(false);
$this->fpdf->SetMargins(7,0.5,2.5,0);

$this->fpdf->AliasNbPages();
$this->fpdf->SetAutoPageBreak(false);

$this->fpdf->SetMargins(5,0.5,2.5,0);
$this->fpdf->AliasNbPages();

$this->fpdf->AddPage("L");

$rm = strtoupper($pasien['rm']);

//$this->fpdf->image("assets/images/logo1.jpg",0.5,1,2);
//$this->fpdf->image("assets/images/gunting.png",23,13.1,1);
$this->fpdf->image(FILES_PATH."/img/kartu_bg.png",0,0,9.56,6);

$this->fpdf->SetFont('Arial','B',7);
$this->fpdf->setXY(0.5,2);
$this->fpdf->Cell(4.7,0.5,'Nama',0,0,'L');
$this->fpdf->setXY(2.3,2);
$this->fpdf->Cell(4.7,0.5,':',0,0,'L');
$this->fpdf->setXY(2.7,2);
$this->fpdf->Cell(4.7,0.5,$pasien['nama_lengkap'],0,0,'L');

$this->fpdf->setXY(0.5,2.3);
$this->fpdf->Cell(4.7,0.5,'Jenis Kelamin',0,0,'L');
$this->fpdf->setXY(2.3,2.3);
$this->fpdf->Cell(4.7,0.5,':',0,0,'L');
$this->fpdf->setXY(2.7,2.3);
$this->fpdf->Cell(4.7,0.5,($pasien['jk'] == 'L')?'Laki-Laki':'Perempuan',0,0,'L');

$this->fpdf->setXY(0.5,2.6);
$this->fpdf->Cell(4.7,0.5,'Tanggal Lahir',0,0,'L');
$this->fpdf->setXY(2.3,2.6);
$this->fpdf->Cell(4.7,0.5,':',0,0,'L');
$this->fpdf->setXY(2.7,2.6);
$this->fpdf->Cell(4.7,0.5,$pasien['tempat_lahir'].', '.$pasien['tanggal_lahir'],0,0,'L');

$this->fpdf->setXY(0.5,2.9);
$this->fpdf->Cell(4.7,0.5,'Alamat',0,0,'L');
$this->fpdf->setXY(2.3,2.9);
$this->fpdf->Cell(4.7,0.5,':',0,0,'L');
$this->fpdf->setXY(2.7,2.9);
$this->fpdf->Cell(4.7,0.5,trim(strtoupper(substr($pasien['alamat'],0,52))),0,0,'L');

$this->fpdf->setXY(2.8,3.2);

if(!empty($pasien['id_wilayah']) && !empty($pasien['alamat']))

{

	$wilayah = get_wilayah($pasien['id_wilayah']);
	$this->fpdf->Cell(4.7,0.5,strtoupper($wilayah->Kota).", ".strtoupper($wilayah->Propinsi),0,1,'L');

}

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->SetTextColor(255,0,0);
$this->fpdf->setXY(1.7,4.5);
if(strlen($rm) > 8) {
	$this->fpdf->Cell(4.7,0.5,str_pad($rm, (strlen($rm)+2), "0", STR_PAD_LEFT),0,0,'L');
} else {
	$this->fpdf->Cell(4.7,0.5,str_pad($rm, 8, "0", STR_PAD_LEFT),0,0,'L');
}


if(strlen($rm) > 8) {
	//$this->fpdf->image(QRcode::png(str_pad($rm, (strlen($rm)+2), "0", STR_PAD_LEFT))),7.5,4,2);
} else {
	//$this->fpdf->image(QRcode::png(str_pad($rm, 8, "0", STR_PAD_LEFT))),7.5,4,2);
}


$this->fpdf->Output();