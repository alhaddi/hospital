<?php
$this->fpdf->FPDF('P','cm',"A4");
$this->fpdf->SetAutoPageBreak(false);
$this->fpdf->SetMargins(1,2,1,0);

$this->fpdf->AliasNbPages();

$this->fpdf->AddPage("P");


$this->fpdf->Cell(9.5,4.4,'',0,0,'L');
$this->fpdf->Cell(9.5,4.4,'',1,0,'L');

$this->fpdf->setXY(1,6.7);
$this->fpdf->Cell(9.5,4.4,'',1,0,'L');
$this->fpdf->Cell(9.5,4.4,'',1,0,'L');

$this->fpdf->setXY(1,11.6);
$this->fpdf->Cell(1.7,1.6,'',1,0,'L');
$this->fpdf->Cell(11.8,1.6,'',1,0,'L');
$this->fpdf->Cell(2,1.6,'',1,0,'L');
$this->fpdf->Cell(3.5,1.6,'',1,0,'L');

$this->fpdf->setXY(1,13.2);
$this->fpdf->Cell(1.7,15.1,'',1,0,'L');
$this->fpdf->Cell(11.8,15.1,'',1,0,'L');
$this->fpdf->Cell(2,15.1,'',1,0,'L');
$this->fpdf->Cell(3.5,15.1,'',1,0,'L');


$this->fpdf->SetFont('Arial','B',13);
$this->fpdf->setXY(1,2.5);
$this->fpdf->Cell(9,0,'PEMERINTAH KABUPATEN GARUT',0,0,'C');
$this->fpdf->setXY(1,3.1);
$this->fpdf->Cell(9,0,'RUMAH SAKIT UMUM dr. SLAMET',0,0,'C');
$this->fpdf->setXY(1,3.9);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(9,0,'Jl. RSU No. 12 Telp. (0262) 232720 Fax. (0262) 541327',0,0,'C');
$this->fpdf->setXY(1,4.5);
$this->fpdf->Cell(9,0,'Garut',0,0,'C');

$this->fpdf->setXY(10.8,4);
$this->fpdf->SetFont('Arial','B',16);
$this->fpdf->Cell(9,0,'CATATAN DOKTER',0,0,'C');
$this->fpdf->setXY(10.8,4.7);
$this->fpdf->SetFont('Arial','B',16);
$this->fpdf->Cell(9,0,'POLIKLINIK',0,0,'C');


$this->fpdf->setXY(1.2,7.3);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(3.1,0,'NO. REKAM MEDIS ',0,0,'L');
$this->fpdf->Cell(9,0,': _____________________________',0,0,'L');

$this->fpdf->setXY(1.2,8.3);
$this->fpdf->Cell(3.1,0,'NAMA PASIEN',0,0,'L');
$this->fpdf->Cell(9,0,': _____________________________',0,0,'L');

$this->fpdf->setXY(1.2,9.3);
$this->fpdf->Cell(3.1,0,'TGL. LAHIR',0,0,'L');
$this->fpdf->Cell(9,0,': _____________________________',0,0,'L');


$this->fpdf->setXY(1.2,10.3);
$this->fpdf->Cell(3.1,0,'UMUR',0,0,'L');
$this->fpdf->Cell(9,0,': _____________________________',0,0,'L');

$this->fpdf->setXY(11,7.3);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(3.1,0,'Laki - laki',0,0,'L');
$this->fpdf->setXY(13,7);
$this->fpdf->Cell(1,0.5,'',1,0,'L');

$this->fpdf->setXY(15,7.3);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(3.1,0,'Perempuan',0,0,'L');
$this->fpdf->setXY(17,7);
$this->fpdf->Cell(1,0.5,'',1,0,'L');

$this->fpdf->setXY(11,8.3);
$this->fpdf->Cell(1.6,0,'Alamat',0,0,'L');
$this->fpdf->Cell(9,0,': ___________________________________',0,0,'L');

$this->fpdf->setXY(11,8.9);
$this->fpdf->Cell(1.6,0,'',0,0,'L');
$this->fpdf->Cell(9,0,'  ___________________________________',0,0,'L');
$this->fpdf->setXY(11,9.6);
$this->fpdf->Cell(1.6,0,'',0,0,'L');
$this->fpdf->Cell(9,0,'  ___________________________________',0,0,'L');

$this->fpdf->setXY(1.1,12.2);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(3.1,0,'Tanggal/',0,0,'L');
$this->fpdf->setXY(1.1,12.6);
$this->fpdf->Cell(3.1,0,'Jam',0,0,'L');


$this->fpdf->AddPage("P");


$this->fpdf->setXY(1,2);
$this->fpdf->Cell(1.7,1.6,'',1,0,'L');
$this->fpdf->Cell(11.8,1.6,'',1,0,'L');
$this->fpdf->Cell(2,1.6,'',1,0,'L');
$this->fpdf->Cell(3.5,1.6,'',1,0,'L');

$this->fpdf->setXY(1,3.6);
$this->fpdf->Cell(1.7,25,'',1,0,'L');
$this->fpdf->Cell(11.8,25,'',1,0,'L');
$this->fpdf->Cell(2,25,'',1,0,'L');
$this->fpdf->Cell(3.5,25,'',1,0,'L');


$this->fpdf->Output();