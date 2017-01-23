<?php
if($payment['id_komponen'] == 5){
	
$data = $this->db->query("SELECT
	CONCAT(ms_kategori_penunjang.kelompok,' ',ms_kategori_penunjang.nama) as nama
FROM
	ms_kategori_penunjang
INNER JOIN trs_billing_manual ON ms_kategori_penunjang.id IN (trs_billing_manual.kategori)
WHERE trs_billing_manual.id='".$payment['id']."'")->result();
		
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
$tinggi=($jum < 8)?9:$tinggi;
$arr=array(17,$tinggi);
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
$this->fpdf->Cell(8.7,0.5,$identitas['nama'],0,0,'L');
$this->fpdf->setXY(0.5,0.75);
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->Cell(8.7,0.5,$identitas['alamat'],0,0,'L');
$this->fpdf->setXY(0.5,1.15);
$this->fpdf->Cell(8.7,0.5,"TELP. ".$identitas['tlp'],0,0,'L');

$this->fpdf->SetFillColor(50,205,50);
$this->fpdf->setXY(0,1.7);
$this->fpdf->Cell(20,0.1,"",1,1,'C',true);

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->SetFillColor(255,255,255);
$this->fpdf->setXY(12.2,0.3);
$this->fpdf->Cell(3.4,0.8,"KWITANSI",1,1,'C',true);
$this->fpdf->SetFont('Arial','I',9);
$this->fpdf->setXY(12.2,1.1);
$this->fpdf->Cell(3.4,0.5,"No. ".$payment["no_tagihan"],0,0,'C');

if(strlen($rm) > 8) {
    $no_rm = str_pad($rm, (strlen($rm)+2), "0", STR_PAD_LEFT);
} else {
    $no_rm = str_pad($rm, 8, "0", STR_PAD_LEFT);
}

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->setXY(0.5,2.5);
$this->fpdf->Cell(2,0.5,"RM/Pasien",0,1,'L',true);
$this->fpdf->setXY(4,2.5);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,2.5);
$this->fpdf->Cell(4.7,0.5,$no_rm."/".strtoupper($pasien['nama_lengkap']),0,1,'L',true);

$this->fpdf->setXY(0.5,3);
$this->fpdf->Cell(2,0.5,"Uang Sebesar",0,1,'L',true);
$this->fpdf->setXY(4,3);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);

$this->fpdf->setXY(0.5,3.5);
$this->fpdf->Cell(2,0.5,"Untuk Pembayaran",0,1,'L',true);
$this->fpdf->setXY(4,3.5);
$this->fpdf->Cell(0.5,0.5,":",0,1,'L',true);
$this->fpdf->setXY(4.5,3.5);
$this->fpdf->Cell(4.7,0.5,"",0,1,'L',true);

$this->fpdf->SetFont('Arial','B',14);
$this->fpdf->setXY(12.5,4);
$this->fpdf->Cell(4.4,0.8,"Rp.",0,0,'L');

		$this->fpdf->SetFont('Arial','B',7);
		$this->fpdf->setXY(0.6,4);
		$this->fpdf->Cell(0.5,0.5,"No",1,0,'C');
		$this->fpdf->Cell(8,0.5,"Biaya",1,0,'C');
	//	$this->fpdf->Cell(2.5,0.5,"Harga",1,0,'C');

$n=1;
$z=0.5;
$this->fpdf->SetFont('Arial','',7);
	foreach($data as $row){
		
		$this->fpdf->setXY(0.6,4+$z);
		$this->fpdf->Cell(0.5,0.5,$n,1,0,'L');
		$this->fpdf->Cell(8,0.5,$row->nama,1,0,'L');
		//$this->fpdf->Cell(2.5,0.5,rupiah($row->biaya),1,0,'L');
		$n++;
		$z=$z+0.5;
		$jumlah=$jumlah+$row->biaya;
	}		

$this->fpdf->SetFont('Arial','B',14);	
$this->fpdf->setXY(12,4);
$this->fpdf->Cell(4.4,0.8,number_format($payment['total_bayar'],"0",".","."),1,1,'R');
$this->fpdf->setXY(4.5,3);

$this->fpdf->SetFont('Arial','B',9);
$this->fpdf->Cell(4.7,0.5,$this->currency->terbilang_rupiah($payment['total_bayar']),0,1,'L',true);		
$this->fpdf->SetFont('Arial','',9);
$this->fpdf->setXY(12,5);
$this->fpdf->Cell(4.5,0.8,"Bendahara Penerima",0,0,'C');
$this->fpdf->setXY(12.6,7);
$this->fpdf->SetFont('Arial','',8);
$this->fpdf->Cell(4.5,0.05,"Tita Kusmiati, SE",0,0,'L');
$this->fpdf->setXY(12.6,7.3);
$this->fpdf->Cell(4.5,0.05,"NIP:1980082820070126",0,0,'L');



$this->fpdf->SetFont('Arial','',7);
/*$this->fpdf->SetFillColor(50,205,50);
$this->fpdf->setXY(0,8.8);
$this->fpdf->Cell(20,0.1,"",1,1,'C',true);*/

//$this->fpdf->SetFont('Arial','I',7);
//$this->fpdf->SetFillColor(255,255,255);
//$this->fpdf->setXY(0.5,8.2);
//$this->fpdf->Cell(9.6,0.9,"Penyetor : Seseorang atau suatu perusahaan yang menyetor uang kepada kasir.",0,0,'L',true);

$this->fpdf->setXY(12,$tinggi-0.7);
$this->fpdf->Cell(4,0.9," Tgl. Cetak ".date("d-m-Y h:i"),0,0,'R',true);
$this->fpdf->Output();