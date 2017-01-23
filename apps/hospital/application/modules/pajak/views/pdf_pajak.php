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
	
	private $jmlPemotongan = 0;
	
	private $jmlPenyetoran = 0;

  	function __construct($fpdf_class, $data = array(), $options = array(), $query3 = array()) {

    	$this->data = $data;

   	$this->options = $options;

	$this->query3 = $query3;

	$this->fpdf = $fpdf_class;
	}


	public function rptDetailData () {



		//



		$this->fpdf->AddPage();



		$this->fpdf->SetAutoPageBreak(true,60);



		$this->fpdf->AliasNbPages();



		$left = 15;


		//header



		$this->fpdf->SetFont("", "B", 13);

		$this->fpdf->MultiCell(0, 3, 'PEMERINTAHAN KABUPATEN GARUT',0,'C');

		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont("", "B", 10);

		$this->fpdf->MultiCell(0, 3, 'RUMAH SAKIT UMUM dr. SLAMET GARUT',0,'C');

		$this->fpdf->Ln(2);

		$this->fpdf->SetFont('Arial','',8); 

		$this->fpdf->MultiCell(0, 3, 'Jalan Rumah Sakit No. 12 Garut Tlp.(0262)232720, Fax No. (0262)541372',0,'C');
		
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(0, 0.5,'','TB',1,'C');

		$this->fpdf->Ln(8);
		
		$this->fpdf->SetFont("", "B", 8);

		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'BUKU PAJAK '.$this->query3[0], 0, 1,'C');
		
		$this->fpdf->Ln(1);
		
		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'BULAN '.convert_tgl($this->query3[1],'F Y',1), 0, 1,'C');

		$this->fpdf->Ln(5);


		

		$this->fpdf->SetFont('','B', 8);


		$this->fpdf->SetX($left); 

		$this->fpdf->Cell(0, 3, 'SKPD',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': RSU dr SLAMET GARUT',0,1,'L');



		$this->fpdf->Ln(1);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Kepala SKPD',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': Dr. H. Maskut Farid .MM',0,1,'L');
		
		$this->fpdf->Ln(1);
		
		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Bendahara Pengeluaran',0,1,'L');

		$this->fpdf->SetXY($left+40,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': Temmy Dewi Utami, SE',0,1,'L');

		$this->fpdf->Ln(5);




		



		$h = 5;



		$left = 15;



		$top = 12;	



		#tableheader



		$this->fpdf->SetFillColor(255);

		$this->fpdf->SetFont("", "B", 8);



		$left = $this->fpdf->GetX();

		$this->fpdf->Cell(7, $h, 'No.',1,0,'C');

		$this->fpdf->SetXY($left += 7,$this->fpdf->getY()); $this->fpdf->Cell(18, $h, 'Tanggal', 1, 0, 'C');

		$this->fpdf->SetXY($left += 18,$this->fpdf->getY()); $this->fpdf->Cell(75, $h, 'Uraian', 1, 0, 'C');

		$this->fpdf->SetXY($left += 75,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, 'Pemotongan(Rp)', 1, 0, 'C');

		$this->fpdf->SetXY($left += 30,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, 'Penyetoran(Rp)', 1, 0, 'C');

		$this->fpdf->SetXY($left += 30,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, 'Saldo Rp', 1, 0, 'C');

		$this->fpdf->Ln(5);


		$this->fpdf->SetFont('Arial','',7.5);



		$this->SetWidths(array(7,18,75,30,30,30));



		$this->SetAligns(array('C','C','L','R','R','R'));

		$this->penampung = new penampung;


		$no = 1;

		$jmlPemotonganLalu = $this->query3[4];
		$jmlPenyetoranLalu = $this->query3[4];
		$jmlPemotonganTotal = 0;
		$jmlPenyetoranTotal = 0;

		foreach ($this->data as $baris) {
			if($this->query3[3]==0){
				
				for($i=1;$i<3;$i++){

					if($i % 2 != 0){
						$this->Row(

						array(

							$no, 

							convert_tgl($baris['tgl_blud'],'d/m/Y',1),  

							'Terima '.$baris['nama_pph'].' atas '.$baris['uraian'],

							rupiah($baris['pph']), 
			
							'', 
						
							''

						));
						
						$this->jmlPemotongan += $baris['pph'];
					}else{
						$this->Row(

						array(

							$no, 

							convert_tgl($baris['tgl_blud'],'d/m/Y',1),  

							'Disetor '.$baris['nama_pph'].' atas '.$baris['uraian'],

							'', 
			
							rupiah($baris['pph']), 
						
							''

						));
						
						$this->jmlPenyetoran += $baris['pph'];
					}
					
					$no++;
					
				}
			}else{
				for($i=1;$i<3;$i++){

					if($i % 2 != 0){
						$this->Row(

						array(

							$no, 

							convert_tgl($baris['tgl_blud'],'d/m/Y',1),  

							'Terima '.$baris['nama_pph'].' atas '.$baris['uraian'],

							'Rp. NIHIL', 
			
							'', 
						
							''

						));
						
						$this->jmlPemotongan += $baris['pph'];
					}else{
						$this->Row(

						array(

							$no, 

							convert_tgl($baris['tgl_blud'],'d/m/Y',1),  

							'Disetor '.$baris['nama_pph'].' atas '.$baris['uraian'],

							'', 
			
							'Rp. NIHIL', 
						
							''

						));
						
						$this->jmlPenyetoran += $baris['pph'];
					}
					
					$no++;
					
				}
			}

		}
			$jmlPemotonganTotal += $this->jmlPemotongan+$jmlPemotonganLalu;
			$jmlPenyetoranTotal += $this->jmlPenyetoran+$jmlPenyetoranLalu;


			$this->fpdf->Cell(7,5,'',1,0,'L');
			
			$this->fpdf->Cell(18,5,'',1,0,'L');
			
			$this->fpdf->Cell(75,5,'Jumlah Bulan ini ',1,0,'C');

			$this->fpdf->Cell(30,5,rupiah($this->jmlPemotongan),1,0,'R');

			$this->fpdf->Cell(30,5,rupiah($this->jmlPenyetoran),1,0,'R');

			$this->fpdf->Cell(30,5,'',1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(7,5,'',1,0,'L');
			
			$this->fpdf->Cell(18,5,'',1,0,'L');
			
			$this->fpdf->Cell(75,5,'Jumlah Sampai Bulan Lalu ',1,0,'C');

			$this->fpdf->Cell(30,5,rupiah($jmlPemotonganLalu),1,0,'R');

			$this->fpdf->Cell(30,5,rupiah($jmlPenyetoranLalu),1,0,'R');

			$this->fpdf->Cell(30,5,'',1,0,'R');			

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(7,5,'',1,0,'L');
			
			$this->fpdf->Cell(18,5,'',1,0,'L');
			
			$this->fpdf->Cell(75,5,'Jumlah sampai dengan bulan ini ',1,0,'C');

			$this->fpdf->Cell(30,5,rupiah($jmlPemotonganTotal),1,0,'R');

			$this->fpdf->Cell(30,5,rupiah($jmlPenyetoranTotal),1,0,'R');

			$this->fpdf->Cell(30,5,'',1,0,'R');	

			$this->fpdf->Ln(10);


			

			$left = 25;

			$this->fpdf->SetX($left+5); $this->fpdf->Cell(0, 3, 'Mengetahui',0,1,'L');

			$this->fpdf->SetXY($left+120,$this->fpdf->GetY()-3); $this->fpdf->Cell(0, 3, 'Garut, '.convert_tgl($this->query3[2],'d F Y',1),0,1,'L');

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



		if($this->fpdf->GetY()+$h2+5>$this->fpdf->PageBreakTrigger){
			
			$this->fpdf->Cell(7,5,'',1,0,'L');
			
			$this->fpdf->Cell(18,5,'',1,0,'L');
			
			$this->fpdf->Cell(75,5,'Jumlah Pindahan',1,0,'C');

			$this->fpdf->Cell(30,5,rupiah($this->jmlPemotongan),1,0,'R');

			$this->fpdf->Cell(30,5,rupiah($this->jmlPenyetoran),1,0,'R');

			$this->fpdf->Cell(30,5,'',1,0,'R');	
		
			$this->fpdf->AddPage($this->fpdf->CurOrientation);


			$h = 6;



			$this->fpdf->SetFillColor(255);

			$this->fpdf->SetFont("", "B", 8);
	


			$left = $this->fpdf->GetX();

			$this->fpdf->Cell(7, $h, '',1,0,'C');

			$this->fpdf->SetXY($left += 7,$this->fpdf->getY()); $this->fpdf->Cell(18, $h, '', 1, 0, 'C');

			$this->fpdf->SetXY($left += 18,$this->fpdf->getY()); $this->fpdf->Cell(75, $h, 'Jumlah Pindahan', 1, 0, 'C');

			$this->fpdf->SetXY($left += 75,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, rupiah($this->jmlPemotongan), 1, 0, 'R');

			$this->fpdf->SetXY($left += 30,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, rupiah($this->jmlPenyetoran), 1, 0, 'R');

			$this->fpdf->SetXY($left += 30,$this->fpdf->getY()); $this->fpdf->Cell(30, $h, '', 1, 0, 'C');

			$this->fpdf->Ln(6);


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
	$query2 = array();
	
		if($row['id_kategori_pph'] != 0){
			if($cek == 0){
				$query2 = $this->db
				->select('
					tgl_blud,
					nama_pph,
					uraian,
					pph
				')
				->join('ms_kategori_pph','ms_kategori_pph.id = trs_blud.id_kategori_pph')
				->where('pph != 0')
				->where('id_kategori_pph',$row['id_kategori_pph'])
				->where('date_format(tgl_blud,"%Y-%m")',convert_tgl($row['tgl_blud'],'Y-m',1))
				->get('trs_blud')->result_array();
			}else{
				$query2 = array(array('tgl_blud'=>$row['tgl_blud'],'nama_pph'=>$row['nama_pph'],'uraian'=>'NIHIL','pph'=>0));
			}
		}else{
			if($cek == 0){
				$query2 = $this->db
				->select('
					tgl_blud,
					"PPN" as nama_pph,
					uraian,
					ppn as pph
				')
				->where('ppn != 0')
				->where('date_format(tgl_blud,"%Y-%m")',convert_tgl($row['tgl_blud'],'Y-m',1))
				->get('trs_blud')->result_array();
			}else{
				$query2 = array(array('tgl_blud'=>$row['tgl_blud'],'nama_pph'=>$row['nama_pph'],'uraian'=>'NIHIL','pph'=>0));
			}
		}
		
	$tabel = new FPDF_AutoWrapTable($this->fpdf, $query2, $options, array($row['nama_pph'],$row['tgl_blud'],$tgl_cetak,$cek,$setoran));	
	$tabel->printPDF();
}    


	    $this->fpdf->Output($options['filename'],$options['destinationfile']);
?>