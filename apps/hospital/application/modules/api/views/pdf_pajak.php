<?php  







/**



 * @author Achmad Solichin



 * @website http://achmatim.net



 * @email achmatim@gmail.com



 */


class penampung{

	private $ls = 0;
	private $gu = 0;
	private $tup = 0;

	public function setLs($ls){
		$this->ls = $ls;
	}
	
	public function setGu($gu){
		$this->gu = $gu;
	}

	public function setTup($tup){
		$this->tup = $tup;
	}

	public function getLs(){
		return $this->ls;
	}

	public function getGu(){
		return $this->gu;
	}

	public function getTup(){
		return $this->tup;
	}
} 



class FPDF_AutoWrapTable{



  	private $data = array();



  	private $options = array(



  		'filename' => '',



  		'destinationfile' => '',



  		'paper_size'=>'A4',



  		'orientation'=>'P'



  	);

	

	private $query3 = array();
	
	private $saldo = 0;

	private $jmlpenerimaan = 0;

	private $jmlpengeluaran = 0;

  	function __construct($fpdf_class, $data = array(), $options = array(), $query3 = array(), $saldo) {

    	$this->data = $data;

   	$this->options = $options;

	$this->query3 = $query3;

	$this->saldo = $saldo;

	$this->penampung = new penampung;

	$this->fpdf = $fpdf_class;

	

	}


	public function rptDetailData () {



		//



		$this->fpdf->AddPage();



		$this->fpdf->SetAutoPageBreak(true,60);



		$this->fpdf->AliasNbPages();



		$left = 15;


		//header



		$this->fpdf->SetFont("", "B", 9);

		$this->MultiCell(0, 3, 'PEMERINTAHAN KABUPATEN GARUT',0,'C');

		$this->fpdf->Ln(2);

		$this->MultiCell(0, 3, 'RUMAH SAKIT UMUM dr. SLAMET GARUT',0,'C');

		$this->fpdf->Ln(2);

		$this->SetFont('Arial','',8); 

		$this->MultiCell(0, 3, 'Jalan Rumah Sakit No. 12 Garut Tlp.(0262)232720, Fax No. (0262)541372',0,'C');

		$this->fpdf->Ln(8);
		
		$this->SetFont("", "B", 8);

		$this->SetX($left); $this->Cell(0, 3, 'BUKU KAS UMUM BLUD', 0, 1,'C');

		$this->Ln(5);


		

		$this->fpdf->SetFont('','B', 8);


		$this->fpdf->SetX($left); 

		$this->fpdf->Cell(0, 3, 'SKPD',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': RSU dr SLAMET GARUT',0,1,'L');



		$this->fpdf->Ln(1);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Kode Rekening',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': '.$this->query3[0],0,1,'L');



		$this->fpdf->Ln(1);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Nama Rekening',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': '.$this->query3[1],0,1,'L');



		$this->fpdf->Ln(1);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Jumlah Anggaran',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);


		$this->fpdf->Cell(0, 3, ': '.rupiah($this->query3[2]),0,1,'L');



		$this->fpdf->Ln(1);


		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Tahun Anggaran',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': '.convert_tgl($this->query3[3],'Y',1),0,1,'L');



		$this->fpdf->Ln(5);




		



		$h = 5;



		$left = 15;



		$top = 12;	



		#tableheader



		$this->fpdf->SetFillColor(255);

		$this->fpdf->SetFont("", "B", 8);



		$left = $this->fpdf->GetX();

		$this->fpdf->Cell(7, $h, 'No.',1,0,'C');

		$this->fpdf->SetXY($left += 7,$this->fpdf->getY()); $this->fpdf->Cell(18, $h, 'Tgl', 1, 0, 'C');

		$this->fpdf->SetXY($left += 18,$this->fpdf->getY()); $this->fpdf->Cell(14, $h, 'No. BKU', 1, 0, 'C');

		$this->fpdf->SetXY($left += 14,$this->fpdf->getY()); $this->fpdf->Cell(50, $h, 'Uraian', 1, 0, 'C');

		$this->fpdf->SetXY($left += 50,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja LS', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja GU', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja TUP', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(32, $h, 'Saldo', 1, 0, 'C');

		$this->fpdf->Ln(5);


		$this->fpdf->SetFont('Arial','',7.5);



		$this->SetWidths(array(7,18,14,50,23,23,23,32));



		$this->SetAligns(array('C','C','C','L','R','R','R','R'));

		$this->penampung = new penampung;


		$no = 1;

		$jmlLs = 0;
		$jmlGu = 0;
		$jmlTup = 0;
		$jmlLsLalu = $this->penampung->getLs();
		$jmlGuLalu = $this->penampung->getGu();
		$jmlTupLalu = $this->penampung->getTup();
		$jmlLsTotal = 0;
		$jmlGuTotal = 0;
		$jmlTupTotal = 0;

		foreach ($this->data as $baris) {



			$this->Row(



				array(

				$no, 

				convert_tgl($baris['tgl_blud'],'d-M-y',1), 

				$no, 

				$baris['uraian'],

				($baris['ls']!='0')?rupiah($baris['ls']):'', 

				($baris['gu']!='0')?rupiah($baris['gu']):'', 

				($baris['tup']!='0')?rupiah($baris['tup']):'', 

				rupiah($this->saldo)


			));

			$no++;
			$jmlLs += $baris['ls'];
			$jmlGu += $baris['gu'];
			$jmlTup += $baris['tup'];
			$this->saldo -= $baris['ls']+$baris['gu']+$baris['tup'];

		}

			$jmlLsTotal = $jmlLs + $jmlLsLalu;
			$jmlGuTotal = $jmlGu + $jmlGuLalu;
			$jmlTupTotal = $jmlTup + $jmlTupLalu;



			$this->fpdf->Cell(89,5,'Jumlah Bulan ini '.convert_tgl($this->query3[3],'F Y',1),1,0,'L');

			$this->fpdf->Cell(23,5,($jmlLs!=0)?rupiah($jmlLs):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlGu!=0)?rupiah($jmlGu):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlTup!=0)?rupiah($jmlTup):'-',1,0,'R');			

			$this->fpdf->Cell(32,5,rupiah($this->saldo),1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(89,5,'Jumlah sampai dengan bulan lalu ',1,0,'L');

			$this->fpdf->Cell(23,5,($jmlLsLalu!=0)?rupiah($jmlLsLalu):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlGuLalu!=0)?rupiah($jmlGuLalu):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlTupLalu!=0)?rupiah($jmlTupLalu):'-',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(89,5,'Jumlah sampai dengan bulan ini '.convert_tgl($this->query3[4],'d F Y',1),1,0,'L');

			$this->fpdf->Cell(23,5,($jmlLsTotal!=0)?rupiah($jmlLsTotal):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlGuTotal!=0)?rupiah($jmlGuTotal):'-',1,0,'R');

			$this->fpdf->Cell(23,5,($jmlTupTotal!=0)?rupiah($jmlTupTotal):'-',1,0,'R');			

			$this->fpdf->Cell(32,5,rupiah($this->saldo),1,0,'R');


			$this->fpdf->Ln(5);

			$this->fpdf->Rect($this->fpdf->GetX(),$this->fpdf->GetY(),190,40);

			$this->fpdf->Ln(5);


			

			$left = 25;

			$this->fpdf->SetX($left+5); $this->fpdf->Cell(0, 3, 'Mengetahui',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Garut, '.convert_tgl(date('d F Y'),'d F Y',1),0,1,'L');

			$this->fpdf->Ln(6);

			

			$this->fpdf->SetX($left+1); $this->fpdf->Cell(0, 3, 'Pengguna Anggaran',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Bendahara Pengeluaran',0,1,'L');

			$this->fpdf->Ln(10);

			

			$this->fpdf->SetX($left+1); $this->fpdf->Cell(0, 3, 'dr.H.Maskut Farid.MM',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Temmy Dewi Utami, SE',0,1,'L');

			$this->fpdf->Ln(1);

			

			$this->fpdf->SetX($left-2); $this->fpdf->Cell(0, 3, 'NIP. 196706251998031004',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'NIP. 197405082009022003',0,1,'L');

			$this->fpdf->Ln(6);


	}







	public function printPDF () {


		



	    $this->fpdf->SetAutoPageBreak(false);



	    $this->fpdf->AliasNbPages();



	    $this->fpdf->SetFont("helvetica", "B", 10);


	    //$this->AddPage();



	



	    $this->rptDetailData();




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



		$h=5*$nb;



		//Issue a page break first if needed



		$this->CheckPageBreak($h);



		//Draw the cells of the row



		for($i=0;$i<count($data);$i++)



		{



			$w=$this->widths[$i];



			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';



			//Save the current position



			$x=$this->fpdf->GetX();



			$y=$this->fpdf->GetY();



			//Draw the border



			$this->fpdf->Rect($x,$y,$w,$h);



			//Print the text



			$this->fpdf->MultiCell($w,5,$data[$i],0,$a);



			//Put the position to the right of the cell



			$this->fpdf->SetXY($x+$w,$y);



		}



		//Go to the next line



		$this->fpdf->Ln($h);



	}







	function CheckPageBreak($h2)



	{



		//If the height h would cause an overflow, add a new page immediately



		if($this->fpdf->GetY()+$h2>$this->fpdf->PageBreakTrigger){

		
			$this->fpdf->AddPage($this->fpdf->CurOrientation);


			$h = 6;



			$this->fpdf->SetFillColor(255);

			$this->fpdf->SetFont("", "B", 8);
	


			$left = $this->fpdf->GetX();

			$this->fpdf->Cell(7, $h, 'No.',1,0,'C');

			$this->fpdf->SetXY($left += 7,$this->fpdf->getY()); $this->fpdf->Cell(18, $h, 'Tgl', 1, 0, 'C');

			$this->fpdf->SetXY($left += 18,$this->fpdf->getY()); $this->fpdf->Cell(14, $h, 'No. BKU', 1, 0, 'C');

			$this->fpdf->SetXY($left += 14,$this->fpdf->getY()); $this->fpdf->Cell(50, $h, 'Uraian', 1, 0, 'C');

			$this->fpdf->SetXY($left += 50,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja LS', 1, 0, 'C');

			$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja GU', 1, 0, 'C');

			$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Belanja TUP', 1, 0, 'C');

			$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(32, $h, 'Saldo', 1, 0, 'C');

			$this->fpdf->Ln(5);


			$this->fpdf->SetFont('Arial','',7.5);



		}







	}







	function NbLines($w,$txt)



	{



		//Computes the number of lines a MultiCell of width w will take



		$cw=&$this->fpdf->CurrentFont['cw'];



		if($w==0)



			$w=$this->w-$this->fpdf->rMargin-$this->x;



		$wmax=($w-2*$this->fpdf->cMargin)*1000/$this->fpdf->FontSize;



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

$this->fpdf = new fpdf();

foreach($query1 as $row){	
	$query2 = $this->Rincian_objek_model->data_objek2($row['id_anggaran'],$row['tgl_blud']);

}
$tabel = new FPDF_AutoWrapTable($this->fpdf, $query2, $options, array($row['no_rekening'],$row['nama_anggaran'],$row['pagu'],$row['tgl_blud'],$row['last']),$saldo['saldo']);	
$tabel->printPDF();

			    



	    $this->fpdf->Output($options['filename'],$options['destinationfile']);
?>