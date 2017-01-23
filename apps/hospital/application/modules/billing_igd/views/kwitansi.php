<?php
$this->fpdf->FPDF('L','cm',array(22,10));
$this->fpdf->SetAutoPageBreak(false);
$this->fpdf->SetMargins(5,0.5,2.5,0);

$namabulan = date('n');
switch ($namabulan) {
    case '1':
    $namabulan2 = "Januari";
    break;
    case '2':
    $namabulan2 = "Februari";
    break;
    case '3':
    $namabulan2 = "Maret";
    break;
    case '4':
    $namabulan2 = "April";
    break;
    case '5':
    $namabulan2 = "Mei";
    break;
    case '6':
    $namabulan2 = "Juni";
    break;
    case '7':
    $namabulan2 = "Juli";
    break;
    case '8':
    $namabulan2 = "Agustus";
    break;
    case '9':
    $namabulan2 = "September";
    break;
    case '10':
    $namabulan2 = "Oktober";
    break;
    case '11':
    $namabulan2 = "November";
    break;
    case '12':
    $namabulan2 = "Desember";
    break;
    
    default:
      break;
  }

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

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->SetFillColor(255,255,255);
$this->fpdf->setXY(10.2,1.3);
$this->fpdf->Cell(3.4,0.8,"KWITANSI",0,1,'C',true);

if(strlen($rm) > 8) {
    $no_rm = str_pad($rm, (strlen($rm)+2), "0", STR_PAD_LEFT);
} else {
    $no_rm = str_pad($rm, 8, "0", STR_PAD_LEFT);
}

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->setXY(0.5,2.5);
$this->fpdf->Cell(2,0.5,"No Kuitansi",0,1,'L',true);
$this->fpdf->setXY(4,2.5);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,2.5);
$this->fpdf->Cell(4.7,0.5,$payment["no_tagihan"],0,1,'L',true);

$this->fpdf->setXY(0.5,3);
$this->fpdf->Cell(2,0.5,"Sudah Terima Dari",0,1,'L',true);
$this->fpdf->setXY(4,3);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,3);
$this->fpdf->Cell(4.7,0.5,$no_rm."-".strtoupper($pasien['nama_lengkap'])."-".strtoupper($pasien['alamat']),0,1,'L',true);

$this->fpdf->setXY(0.5,3.5);
$this->fpdf->Cell(2,0.5,"Banyak Uang Untuk",0,1,'L',true);
$this->fpdf->setXY(4,3.5);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,3.5);
$this->fpdf->Cell(4.7,0.5,$this->currency->terbilang_rupiah($payment["total_bayar"])." rupiah",0,1,'L',true);

$this->fpdf->setXY(0.5,4);
$this->fpdf->Cell(2,0.5,"Uang Pembayaran",0,1,'L',true);
$this->fpdf->setXY(4,4);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,4);
$this->fpdf->Cell(4.7,0.5,get_field($payment["id_komponen"],"ms_komponen_registrasi","nama"),0,1,'L',true);

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->SetTextColor(255,0,0);
$this->fpdf->setXY(3,5);
$this->fpdf->Cell(4.4,0.8,number_format($payment["total_bayar"],"0",".","."),0,1,'R');
$this->fpdf->setXY(4.7,5);
$this->fpdf->Cell(4.4,0.8,"Rp.",0,0,'L');

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->SetTextColor(0,0,0);
$this->fpdf->setXY(15.5,5.5);
$this->fpdf->Cell(3.4,0.8,"Garut, ".date("d")." ".$nama_bulan2." ".date("Y"),0,0,'L');
$this->fpdf->setXY(15.5,5.9);
$this->fpdf->Cell(3.4,0.8,"Bendahara Penerima,",0,0,'L');

$this->fpdf->setXY(15.5,8);
$this->fpdf->Cell(3.4,0.8,"Tita Kusmiati, SE",0,0,'L');
$this->fpdf->setXY(15.5,8.4);
$this->fpdf->Cell(3.4,0.8,"NIP:1980082820070126",0,0,'L');

$this->fpdf->setXY(15.5,9);
$this->fpdf->Cell(3.4,0.8,"10/10/2016 06:40 AM",0,0,'L');

$this->fpdf->Output();