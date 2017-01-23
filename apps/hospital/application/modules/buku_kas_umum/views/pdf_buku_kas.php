<?php  



/**

 * @author Achmad Solichin

 * @website http://achmatim.net

 * @email achmatim@gmail.com

 */


class FPDF_AutoWrapTable extends FPDF {

  	private $data = array();

  	private $options = array(

  		'filename' => '',

  		'destinationfile' => '',

  		'paper_size'=>'A4',

  		'orientation'=>'P'

  	);
	
	private $saldo = array();
	
	private $jmlpenerimaan = 0;

	private $jmlpengeluaran = 0;

	private $jmlpengeluaranlalu = 0;
	
	private $jmlpenerimaanlalu = 0;
	
	private $tanggal = 0;

  	function __construct($data = array(), $options = array(), $saldo = array(), $jmlpengeluaranlalu = 0, $jmlpenerimaanlalu = 0, $tanggal) {

    	parent::__construct();

    	$this->data = $data;

    	$this->options = $options;
	
	$this->saldo = $saldo;

	$this->jmlpengeluaranlalu = $jmlpengeluaranlalu;
	
	$this->jmlpenerimaanlalu = $jmlpenerimaanlalu;
	
	$this->tanggal = $tanggal;

	}

	

	public function rptDetailData () {

		//

		$border = 0;

		$this->AddPage();

		$this->SetAutoPageBreak(true,60);

		$this->AliasNbPages();

		$left = 25;

		

		//header

		$this->SetFont('Arial','B',16); 

		$this->MultiCell(0, 12, 'PEMERINTAHAN KABUPATEN GARUT',0,'C');

		$this->Ln(10);

		$this->MultiCell(0, 12, 'RUMAH SAKIT UMUM dr. SLAMET GARUT',0,'C');

		$this->Ln(10);

		$this->SetFont('Arial','',8); 

		$this->MultiCell(0, 12, 'Jalan Rumah Sakit No. 12 Garut Tlp.(0262)232720, Fax No. (0262)541372',0,'C');

		$this->Cell(0, 1, " ", "B");

		$this->Ln(10);

		$this->SetFont("", "B", 10);

		$this->SetX($left); $this->Cell(0, 10, 'BUKU KAS UMUM BLUD', 0, 1,'C');

		$this->Ln(10);

		
		$this->SetFont("", "", 8);

		$this->SetX($left+60); 
		$this->Cell(0, 10, 'SKPD',0,1,'L');
		$this->SetXY($left+300,$this->getY()-10);
		$this->Cell(0, 10, ': RSU dr SLAMET GARUT',0,1,'L');

		$this->Ln(5);

		$this->SetX($left+60); $this->Cell(0, 10, 'Pengguna Anggaran',0,1,'L');
		$this->SetXY($left+300,$this->getY()-10);
		$this->Cell(0, 10, ': Dr.H.Maskut Farid, MM',0,1,'L');

		$this->Ln(5);

		$this->SetX($left+60); $this->Cell(0, 10, 'Bendahara Pengeluran',0,1,'L');
		$this->SetXY($left+300,$this->getY()-10);
		$this->Cell(0, 10, ': Temmy Dewi Utami, SE',0,1,'L');

		$this->Ln(5);

		$this->SetX($left+60); $this->Cell(0, 10, 'Bulan',0,1,'L');
		$this->SetXY($left+300,$this->getY()-10);
		$this->Cell(0, 10, ': '.convert_tgl($this->tanggal,'F Y',1),0,1,'L');

		$this->Ln(10);

		

		$h = 13;

		$left = 40;

		$top = 80;	

		#tableheader

		$this->SetFillColor(255);

		$left = $this->GetX();
		$this->MultiCell(22, $h, 'No. Urut',1,0,'C');
		$this->SetXY($left += 22,$this->getY()-$h*2); $this->Cell(45, $h*2, 'Tanggal', 1, 0, 'C');
		$this->SetXY($left += 45,$this->getY()); $this->Cell(190, $h*2, 'Uraian', 1, 0, 'C');
		$this->SetXY($left += 190,$this->getY()); $this->Cell(100, $h*2, 'Kode Rekening', 1, 0, 'C');
		$this->SetXY($left += 100,$this->getY()); $this->MultiCell(60, $h, 'Penerimaan Rp.', 1, 0, 'C');
		$this->SetXY($left += 60,$this->getY()-$h*2); $this->MultiCell(59, $h, 'Pengeluaran Rp.', 1, 0, 'L');
		$this->SetXY($left += 59,$this->getY()-$h*2); $this->MultiCell(66, $h*2, 'Saldo Rp.', 1, 0, 'L');

		$left = $this->GetX();				
		$this->Cell(22,$h,'1',1,0,'C');
		$this->Cell(45,$h,'2',1,0,'C');
		$this->Cell(190,$h,'3',1,0,'C');
		$this->Cell(100,$h,'4',1,0,'C');
		$this->Cell(60,$h,'5',1,0,'C');
		$this->Cell(59,$h,'6',1,0,'C');
		$this->Cell(66,$h,'7',1,0,'C');
		$this->Ln($h);

		$this->SetFont('Arial','',7.5);

		$left = $this->GetX();				
		$this->Cell(22,$h,'','LR',0,'C');
		$this->Cell(45,$h,'','LR',0,'C');
		$this->Cell(190,$h,'Saldo bulan lalu','LR',0,'C');
		$this->Cell(10,$h,'','LR',0,'C');
		$this->Cell(10,$h,'','LR',0,'C');
		$this->Cell(10,$h,'','LR',0,'C');
		$this->Cell(16,$h,'','LR',0,'C');
		$this->Cell(16,$h,'','LR',0,'C');
		$this->Cell(10,$h,'','LR',0,'C');
		$this->Cell(10,$h,'','LR',0,'C');
		$this->Cell(18,$h,'','LR',0,'C');
		$this->Cell(60,$h,'','LR',0,'C');
		$this->Cell(59,$h,'','LR',0,'C');
		$this->Cell(66,$h,str_replace("Rp ","",rupiah($this->saldo['saldo'])),'LR',0,'R');
		$this->Ln($h);

		$this->SetWidths(array(22,45,190,10,10,10,16,16,10,10,18,60,59,66));

		$this->SetAligns(array('C','C','L','L','L','L','L','L','L','L','L','R','R','R'));

		$no = 1;

		foreach ($this->data as $baris) {

			if($baris['no_rekening'] != null || $baris['no_rekening'] != 0){
				$no_rekening = explode('.',$baris['no_rekening']);
				$no1 = $no_rekening[0];
				$no2 = $no_rekening[1];
				$no3 = $no_rekening[2];
				$no4 = $no_rekening[3];
				$no5 = $no_rekening[4];
				$no6 = $no_rekening[5];
				$no7 = $no_rekening[6];
				$no8 = $no_rekening[7];
				$no9 = $no_rekening[8];
			}
			else{
				$no1 = '';
				$no2 = '';
				$no3 = '';
				$no4 = '';
				$no5 = '';
				$no6 = '';
				$no7 = '';
				$no8 = '';
				$no9 = '';
			}

			$this->saldo['saldo'] += $baris['pemasukan']-$baris['pengeluaran'];
			$this->jmlpenerimaan += $baris['pemasukan'];
			$this->jmlpengeluaran += $baris['pengeluaran'];

			$this->Row(

				array(
				$no, 
				convert_tgl($baris['tanggal'],'d-M-y',1), 
				$baris['uraian'], 
				$no1, 
				$no2,
				$no3,
				$no4,
				$no5,
				$no6,
				$no7,
				$no8.'.'.$no9,
				($baris['pemasukan']!=0)?str_replace("Rp ","",rupiah($baris['pemasukan'])):'', 
				($baris['pengeluaran']!=0)?str_replace("Rp ","",rupiah($baris['pengeluaran'])):'', 
				str_replace("Rp ","",rupiah($this->saldo['saldo']))

			));

			$no++;

		}

			$left = $this->GetX();				
			$this->Cell(357,13,'Jumlah bulan ini','LTR',0,'C');
			$this->Cell(60,13,str_replace("Rp ","",rupiah($this->jmlpenerimaan)),'LTR',0,'R');
			$this->Cell(59,13,str_replace("Rp ","",rupiah($this->jmlpengeluaran)),'LTR',0,'R');
			$this->Cell(66,13,'','LTR',0,'C');
			
			$this->Ln(13);

			$left = $this->GetX();				
			$this->Cell(357,13,'Jumlah s.d bulan lalu','LR',0,'C');
			$this->Cell(60,13,str_replace("Rp ","",rupiah($this->jmlpenerimaanlalu)),1,0,'R');
			$this->Cell(59,13,str_replace("Rp ","",rupiah($this->jmlpengeluaranlalu)),1,0,'R');
			$this->Cell(66,13,str_replace("Rp ","",rupiah($this->saldo['saldo'])),'LR',0,'R');

			$this->Ln(13);

			$left = $this->GetX();				
			$this->Cell(357,13,'Jumlah s.d bulan ini ','LBR',0,'C');
			$this->Cell(60,13,str_replace("Rp ","",rupiah($this->jmlpenerimaan+$this->jmlpenerimaanlalu)),1,0,'R');
			$this->Cell(59,13,str_replace("Rp ","",rupiah($this->jmlpengeluaran+$this->jmlpengeluaranlalu)),1,0,'R');
			$this->Cell(66,13,'','LBR',0,'C');
			$this->Ln(15);
			
			$left = $this->GetX();				
			$this->Cell(22,$h,'',0,0,'C');
			$this->Cell(239,$h,'Kas di Bendahara Pengeluaran   : NIHIL',0,0,'L');
			$this->Ln(12);
			
			$this->Cell(22,$h,'',0,0,'C');
			$this->Cell(239,$h,'Terdiri dari :',0,0,'L');
			$this->Ln(12);
					
			$this->Cell(22,$h,'',0,0,'C');
			$this->Cell(239,$h,'a. Saldo Tunai',0,0,'L');
			$this->Cell(10,$h,':',0,0,'C');
			$this->Cell(10,$h,'Rp.',0,0,'C');
			$this->Cell(60,$h,'NIHIL',0,0,'C');
			$this->Ln(12);
			
			$this->Cell(22,$h,'',0,0,'C');
			$this->Cell(239,$h,'b. Saldo Bank',0,0,'L');
			$this->Cell(10,$h,':',0,0,'C');
			$this->Cell(10,$h,'Rp.',0,0,'C');
			$this->Cell(60,$h,str_replace("Rp ","",rupiah($this->saldo['saldo'])),0,0,'C');
			$this->Ln(12);
			
			$this->Cell(22,$h,'',0,0,'C');
			$this->Cell(239,$h,'c. Surat Berharga',0,0,'L');
			$this->Cell(10,$h,':',0,0,'C');
			$this->Cell(10,$h,'Rp.',0,0,'C');
			$this->Cell(60,$h,'NIHIL',0,0,'C');
			$this->Ln(55);
			
			$left = 25;
			$this->SetX($left+80); $this->Cell(0, 3, 'Mengetahui',0,1,'L');
			$this->SetXY($left+350,$this->GetY()-3); $this->Cell(0, 3, 'Garut, '.convert_tgl($this->tanggal,'d F Y',1),0,1,'L');
			$this->Ln(15);

			$this->SetX($left+80); $this->Cell(0, 3, 'Pengguna Anggaran',0,1,'L');
			$this->SetXY($left+350,$this->GetY()-3); $this->Cell(0, 3, 'Bendahara Pengeluaran',0,1,'L');
			$this->Ln(40);
		
			$this->SetX($left+80); $this->Cell(0, 3, 'dr.H.Maskut Farid.MM',0,1,'L');
			$this->SetXY($left+350,$this->GetY()-3); $this->Cell(0, 3, 'Temmy Dewi Utami, SE',0,1,'L');
			$this->Ln(10);
			
			$this->SetX($left+75); $this->Cell(0, 3, 'NIP. 196706251998031004',0,1,'L');
			$this->SetXY($left+350,$this->GetY()-3); $this->Cell(0, 3, 'NIP. 197405082009022003',0,1,'L');
			$this->Ln(1);

	}



	public function printPDF () {

				

		if ($this->options['paper_size'] == "F4") {

			$a = 8.3 * 72; //1 inch = 72 pt

			$b = 13.0 * 72;

			$this->FPDF($this->options['orientation'], "pt", array($a,$b));

		} else {

			$this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);

		}

		

	    $this->SetAutoPageBreak(false);

	    $this->AliasNbPages();

	    $this->SetFont("helvetica", "B", 10);

	    //$this->AddPage();

	

	    $this->rptDetailData();

			    

	    $this->Output($this->options['filename'],$this->options['destinationfile']);

  	}

  	

  	

  	

  	private $widths;

	private $aligns;


	function SetWidths($w)

	{

		//Set the array of column widths

		$this->widths=$w;

	}



	function SetAligns($a)

	{

		//Set the array of column alignments

		$this->aligns=$a;

	}



	function Row($data)

	{

		//Calculate the height of the row

		$nb=0;

		for($i=0;$i<count($data);$i++)

			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));

		$h=10*$nb;

		//Issue a page break first if needed

		$this->CheckPageBreak($h);

		//Draw the cells of the row

		for($i=0;$i<count($data);$i++)

		{

			$w=$this->widths[$i];

			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

			//Save the current position

			$x=$this->GetX();

			$y=$this->GetY();

			//Draw the border

			$this->Line($x,$y,$x,$y+$h);
			$this->Line($x+$w,$y,$x+$w,$y+$h);

			//Print the text

			$this->MultiCell($w,10,$data[$i],0,$a);

			//Put the position to the right of the cell

			$this->SetXY($x+$w,$y);

		}

		//Go to the next line

		$this->Ln($h);

	}



	function CheckPageBreak($h2)

	{

		//If the height h would cause an overflow, add a new page immediately

		if($this->GetY()+$h2+13>$this->PageBreakTrigger){
			
			$left = $this->GetX();				
			$this->Cell(357,13,'JUMLAH DIPINDAHKAN',1,0,'C');
			$this->Cell(60,13,str_replace("Rp ","",rupiah($this->jmlpenerimaan)),1,0,'R');
			$this->Cell(59,13,str_replace("Rp ","",rupiah($this->jmlpengeluaran)),1,0,'R');
			$this->Cell(66,13,'',1,0,'C');

			$this->AddPage($this->CurOrientation);
			
			$this->SetFont("", "", 8);

			$h = 13;

			$left = 40;

			$top = 80;	

			#tableheader

			$this->SetFillColor(255);

			$left = $this->GetX();
			$this->MultiCell(22, $h, 'No. Urut',1,0,'C');
			$this->SetXY($left += 22,$this->getY()-$h*2); $this->Cell(45, $h*2, 'Tanggal', 1, 0, 'C');
			$this->SetXY($left += 45,$this->getY()); $this->Cell(190, $h*2, 'Uraian', 1, 0, 'C');
			$this->SetXY($left += 190,$this->getY()); $this->Cell(100, $h*2, 'Kode Rekening', 1, 0, 'C');
			$this->SetXY($left += 100,$this->getY()); $this->MultiCell(60, $h, 'Penerimaan Rp.', 1, 0, 'C');
			$this->SetXY($left += 60,$this->getY()-$h*2); $this->MultiCell(59, $h, 'Pengeluaran Rp.', 1, 0, 'L');
			$this->SetXY($left += 59,$this->getY()-$h*2); $this->MultiCell(66, $h*2, 'Saldo Rp.', 1, 0, 'L');
	
			$left = $this->GetX();				
			$this->Cell(22,$h,'1',1,0,'C');
			$this->Cell(45,$h,'2',1,0,'C');
			$this->Cell(190,$h,'3',1,0,'C');
			$this->Cell(100,$h,'4',1,0,'C');
			$this->Cell(60,$h,'5',1,0,'C');
			$this->Cell(59,$h,'6',1,0,'C');
			$this->Cell(66,$h,'7',1,0,'C');
			$this->Ln($h);

			$this->Cell(22,$h,'','1',0,'C');
			$this->Cell(45,$h,'','1',0,'C');
			$this->Cell(290,$h,'JUMLAH DIPINDAHKAN',1,0,'C');
			$this->Cell(60,$h,str_replace("Rp ","",rupiah($this->jmlpenerimaan)),'LR',0,'C');
			$this->Cell(59,$h,str_replace("Rp ","",rupiah($this->jmlpengeluaran)),'LR',0,'C');
			$this->Cell(66,$h,str_replace("Rp ","",rupiah($this->saldo['saldo'])),'LR',0,'R');
			$this->Ln($h);

			$this->SetFont('Arial','',7.5);

		}



	}



	function NbLines($w,$txt)

	{

		//Computes the number of lines a MultiCell of width w will take

		$cw=&$this->CurrentFont['cw'];

		if($w==0)

			$w=$this->w-$this->rMargin-$this->x;

		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;

		$s=str_replace("\r",'',$txt);

		$nb=strlen($s);

		if($nb>0 and $s[$nb-1]=="\n")

			$nb--;

		$sep=-1;

		$i=0;

		$j=0;

		$l=0;

		$nl=1;

		while($i<$nb)

		{

			$c=$s[$i];

			if($c=="\n")

			{

				$i++;

				$sep=-1;

				$j=$i;

				$l=0;

				$nl++;

				continue;

			}

			if($c==' ')

				$sep=$i;

			$l+=$cw[$c];

			if($l>$wmax)

			{

				if($sep==-1)

				{

					if($i==$j)

						$i++;

				}

				else

					$i=$sep+1;

				$sep=-1;

				$j=$i;

				$l=0;

				$nl++;

			}

			else

				$i++;

		}

		return $nl;

	}

} //end of class


//pilihan

$options = array(

	'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser

	'destinationfile' => 'I', //I=inline browser (default), F=local file, D=download

	'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal

	'orientation'=>'P' //orientation: P=portrait, L=landscape

);



$tabel = new FPDF_AutoWrapTable($jurnal, $options, $saldo, $jmlpengeluaranlalu, $jmlpenerimaanlalu, $tanggal);

$tabel->printPDF();

?>

