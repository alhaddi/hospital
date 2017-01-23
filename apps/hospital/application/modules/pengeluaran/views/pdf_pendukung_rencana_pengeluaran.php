<?php  







/**



 * @author Achmad Solichin



 * @website http://achmatim.net



 * @email achmatim@gmail.com



 */

class FPDF_AutoWrapTable{



  	private $data = array();



  	private $options = array(



  		'filename' => '',



  		'destinationfile' => '',



  		'paper_size'=>'A4',



  		'orientation'=>'P'



  	);

	

	private $query3 = array();
	
	private $jmlpenerimaan = 0;

	private $jmlpengeluaran = 0;

  	function __construct($fpdf_class, $data = array(), $options = array(), $query3 = array()) {

    	$this->data = $data;

   	$this->options = $options;

	$this->query3 = $query3;

	$this->c = new currency;

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



		$this->fpdf->MultiCell(0, 3, 'DOKUMEN PENDUKUNG',0,'C');



		$this->fpdf->Ln(2);



		$this->fpdf->MultiCell(0, 3, 'RENCANA PENGELUARAN',0,'C');



		$this->fpdf->Ln(2);



		$this->fpdf->MultiCell(0, 3, 'BULAN : '.convert_tgl($this->query3[0],'d F Y',1),0,'C');
		
		$this->fpdf->Ln(2);

		$this->fpdf->MultiCell(0, 3, 'NO. CEK : '.$this->query3[1],0,'C');



		$this->fpdf->Ln(8);


		

		$this->fpdf->SetFont("", "B", 8);


		$this->fpdf->SetX($left); 
		$this->fpdf->Cell(0, 3, '1.02.02.36.01',0,1,'L');
		$this->fpdf->SetXY($left+23,$this->fpdf->getY()-3);
		$this->fpdf->Cell(0, 3, 'Peningkatan dan Pendukung Pelayanan Umum Daerah (BLUD)',0,1,'L');


		$this->fpdf->Ln(2);




		



		$h = 5;



		$left = 15;



		$top = 12;	



		#tableheader



		$this->fpdf->SetFillColor(255);

		$this->fpdf->SetFont("", "B", 8);



		$left = $this->fpdf->GetX();

		$this->fpdf->Cell(13, $h, 'No.',1,0,'C');

		$this->fpdf->SetXY($left += 13,$this->fpdf->getY()); $this->fpdf->Cell(47, $h, 'Jenis Biaya & Kodrek', 1, 0, 'C');

		$this->fpdf->SetXY($left += 47,$this->fpdf->getY()); $this->fpdf->Cell(60, $h, 'Uraian', 1, 0, 'C');

		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Jumlah', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'PPn', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, $this->query3[2], 1, 0, 'C');

		$this->fpdf->Ln(5);


		$this->fpdf->SetFont('Arial','',7.5);



		$this->SetWidths(array(13,15,32,60,23,23,23));



		$this->SetAligns(array('C','C','C','L','R','R','R'));


		$no = 1;

		$totaljml = 0;

		$totalppn = 0;

		$totalpph = 0;		

		foreach ($this->data as $baris) {



			$this->Row(



				array(

				$no, 
				$baris['jenis_biaya'], 
				$baris['no_rekening'], 
				$baris['nama_anggaran'].' '.$baris['uraian'],
				rupiah($baris['jumlah']), 
				rupiah($baris['ppn']), 
				rupiah($baris['pph'])


			));

			$no++;
			$totaljml += $baris['jumlah'];
			$totalppn += $baris['ppn'];
			$totalpph += $baris['pph'];			

		}


			$this->fpdf->Cell(120,5,'',1,0,'L');

			$this->fpdf->Cell(23,5,rupiah($totaljml),1,0,'R');

			$this->fpdf->Cell(23,5,rupiah($totalppn),1,0,'R');

			$this->fpdf->Cell(23,5,rupiah($totalpph),1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(13,5,'Terbilang',1,0,'L');

			$this->fpdf->Cell(176,5,strtoupper($this->c->terbilang_rupiah($totaljml)).' RUPIAH',1,0,'C');

			$this->fpdf->Ln(10);


			

			$left = 25;

			$this->fpdf->SetX($left+5); $this->fpdf->Cell(0, 3, 'Mengetahui',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Garut, '.convert_tgl(date('d F Y'),'d F Y',1),0,1,'L');

			$this->fpdf->Ln(6);

			

			$this->fpdf->SetX($left+1); $this->fpdf->Cell(0, 3, 'Pengguna Anggaran',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Wadir Keuangan',0,1,'L');

			$this->fpdf->Ln(10);

			

			$this->fpdf->SetX($left+1); $this->fpdf->Cell(0, 3, 'dr.H.Maskut Farid.MM',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Dra. Anne Hayati, M.Si',0,1,'L');

			$this->fpdf->Ln(1);

			

			$this->fpdf->SetX($left-2); $this->fpdf->Cell(0, 3, 'NIP. 196706251998031004',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'NIP.196601141988012002',0,1,'L');

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

			$this->fpdf->Cell(13, $h, 'No.',1,0,'C');

			$this->fpdf->SetXY($left += 13,$this->fpdf->getY()); $this->fpdf->Cell(47, $h, 'Jenis Biaya & Kodrek', 1, 0, 'C');

			$this->fpdf->SetXY($left += 47,$this->fpdf->getY()); $this->fpdf->Cell(60, $h, 'Uraian', 1, 0, 'C');

			$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'Jumlah', 1, 0, 'C');

			$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, 'PPn', 1, 0, 'C');

			$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, $this->query3[2], 1, 0, 'C');

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

$query2 = $this->Pengeluaran_model->data_pdf2('',$row['tgl_blud']);
$data = array();

foreach($query2 as $r){
	$result = $this->db->select('nama_anggaran as jenis_biaya')
		->where('id',$r['parent_id'])
		->get('anggaran')->row_array();

	$field = array();
	$field['nama_anggaran'] = $r['nama_anggaran']; 
	$field['jenis_biaya'] = $result['jenis_biaya'];
	$field['no_rekening'] = $r['no_rekening']; 
	$field['no_cek'] = $r['no_cek']; 
	$field['tgl_blud'] = $r['tgl_blud']; 
	$field['uraian'] = $r['uraian']; 
	$field['jumlah'] = $r['jumlah']; 
	$field['ppn'] = $r['ppn']; 
	$field['id_kategori_pph'] = $r['id_kategori_pph']; 
	$field['pph'] = $r['pph']; 
	
	$data[] = $field;

		
$tabel = new FPDF_AutoWrapTable($this->fpdf, $data, $options, array($row['tgl_blud'],$row['no_cek'],$row['nama_pph']));
$tabel->printPDF();

}


}
			    



	    $this->fpdf->Output($options['filename'],$options['destinationfile']);
?>