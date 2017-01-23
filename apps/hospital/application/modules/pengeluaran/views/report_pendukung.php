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

$this->fpdf->FPDF('P','cm',"A4");



// kita set marginnya dimulai dari kiri, atas, kanan. jika tidak diset, defaultnya 1 cm

$this->fpdf->SetMargins(0,0.5,0.5,0);

$this->fpdf->SetAutoPageBreak(false);



/* AliasNbPages() merupakan fungsi untuk menampilkan total halaman

   di footer, nanti kita akan membuat page number dengan format : number page / total page

*/

$this->fpdf->AliasNbPages();



// AddPage merupakan fungsi untuk membuat halaman baru

$this->fpdf->AddPage();

$this->fpdf->SetFont('Arial','B',8); 

$this->fpdf->setXY(0,0.5);
$this->fpdf->Cell(21,2,'DOKUMEN PENDUKUNG',0,0,'C');
$this->fpdf->setXY(0,1);
$this->fpdf->Cell(21,2,'RENCANA PENGELUARAN',0,0,'C');
$this->fpdf->setXY(0,1.5);
$this->fpdf->Cell(21,2,'BULAN  : 31 Maret 2016',0,0,'C');
$this->fpdf->setXY(0,2);
$this->fpdf->Cell(21,2,'NO.CEK: 886795',0,0,'C');

$this->fpdf->SetFont('Arial','B',8); 

$this->fpdf->setXY(1,4.5);
$this->fpdf->Cell(0.7,1,'NO',1,0,'C');
$this->fpdf->Cell(4,1,'JENIS BIAYA & KODREK',1,0,'C');
$this->fpdf->Cell(4.5,1,'URAIAN',1,0,'C');
$this->fpdf->Cell(2,1,'JUMLAH',1,0,'C');
$this->fpdf->Cell(2,1,'PPn',1,0,'C');
$this->fpdf->Cell(2.5,1,'PPh',1,0,'C');

$x = 0;
$y = 5.5;



    $this->fpdf->Output("dokumen_pendukung.pdf","I");
?>

