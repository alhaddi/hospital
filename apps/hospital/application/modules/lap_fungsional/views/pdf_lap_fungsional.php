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



  		'orientation'=>'L'



  	);

	

	private $query3 = array();

	private $jmlpenerimaan = 0;

	private $jmlpengeluaran = 0;

  	function __construct($fpdf_class, $data = array(), $options = array(), $query3 = array()) {

    	$this->data = $data;

   	$this->options = $options;

	$this->query3 = $query3;

	$this->penampung = new penampung;

	$this->fpdf = $fpdf_class;

	

	}


	public function rptDetailData () {



		//



		$this->fpdf->AddPage();



		$this->fpdf->SetAutoPageBreak(true,60);



		$this->fpdf->AliasNbPages();



		$left = 280;


		//header



		$this->fpdf->SetFont("", "B", 8);



		$this->fpdf->MultiCell(0, 3, 'PEMERINTAHAN KABUPATEN GARUT',0,'C');



		$this->fpdf->Ln(7);



		$this->fpdf->MultiCell(0, 3, 'LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN',0,'C');



		$this->fpdf->Ln(7);



		$this->fpdf->MultiCell(0, 3, '(SPJ BELANJA FUNGSIONAL)',0,'C');





		$this->fpdf->Ln(30);


		

		$this->fpdf->SetFont('','B', 7);


		$this->fpdf->SetX($left); 

		$this->fpdf->Cell(0, 3, 'SKPD',0,1,'L');

		$this->fpdf->SetXY($left+100,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': 1.02.02. - PPK - BLUD RSUD dr. SLAMET GARUT',0,1,'L');



		$this->fpdf->Ln(7);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Pengguna Anggaran',0,1,'L');

		$this->fpdf->SetXY($left+100,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': Dr.H. Maskut Farid. MM',0,1,'L');



		$this->fpdf->Ln(7);



		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Bendahara pengeluaran',0,1,'L');

		$this->fpdf->SetXY($left+100,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': Temmy Dewi Utami, SE',0,1,'L');



		$this->fpdf->Ln(7);


		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Tahun Anggaran',0,1,'L');

		$this->fpdf->SetXY($left+100,$this->fpdf->getY()-3);

		$this->fpdf->Cell(0, 3, ': '.convert_tgl(date('Y'),'Y',1),0,1,'L');
		

		$this->fpdf->Ln(7);
		
		
		$this->fpdf->SetX($left); $this->fpdf->Cell(0, 3, 'Bulan',0,1,'L');

		$this->fpdf->SetXY($left+100,$this->fpdf->getY()-3);


		$this->fpdf->Cell(0, 3, ': '.convert_tgl(date('F Y'),'F Y',1),0,1,'L');



		$this->fpdf->Ln(15);




		



		$h = 13;



		$left = 15;



		$top = 12;	



		#tableheader



		$this->fpdf->SetFillColor(255);

		$this->fpdf->SetFont("", "B", 7);



		$left = $this->fpdf->GetX()-5;

		$this->fpdf->Cell(15, $h*2, 'No.',1,0,'C');

		$this->fpdf->SetXY($left += 15,$this->fpdf->getY()); $this->fpdf->Cell(60, $h*2, 'Jenis Biaya', 1, 0, 'C');

		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(140, $h*2, 'Uraian', 1, 0, 'C');

		$this->fpdf->SetXY($left += 140,$this->fpdf->getY()); $this->fpdf->Cell(60, $h*2, 'Anggaran', 1, 0, 'C');

		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(140, $h, 'SPJ-LS-GAJI', 1, 0, 'C');

		$this->fpdf->SetXY($left += 140,$this->fpdf->getY()); $this->fpdf->Cell(140, $h, 'SPJ-LS-Barang & Jasa', 1, 0, 'C');

		$this->fpdf->SetXY($left += 140,$this->fpdf->getY()); $this->fpdf->Cell(140, $h, 'SPJ-LS/UP/GU/TU', 1, 0, 'C');
		
		$this->fpdf->SetXY($left += 140,$this->fpdf->getY()); $this->fpdf->MultiCell(60, $h/2, 'Jumlah SPJ(LP+UP/GU/TU) s.d Bulan ini', 1, 0, 'L');
		
		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()-$h*2); $this->fpdf->MultiCell(60, $h/2, 'Sisa Pagu Anggaran', 1, 0, 'L');

		$this->fpdf->Ln(1);
		
		$left = 15;
		

		$this->fpdf->SetXY($left += 289,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d.Bulan Lalu', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 'Bulan ini', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d. Bulan ini', 1, 0, 'C');
		
		
		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d.Bulan Lalu', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 'Bulan ini', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d. Bulan ini', 1, 0, 'C');
		
		
		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d.Bulan Lalu', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 'Bulan ini', 1, 0, 'C');

		$this->fpdf->SetXY($left += 46.7,$this->fpdf->getY()); $this->fpdf->Cell(46.7, $h, 's.d. Bulan ini', 1, 0, 'C');

		$this->fpdf->Ln(12);
		
		
		$left = 15;
		
		$this->fpdf->Cell(15, $h, '1',1,0,'C');

		$this->fpdf->SetXY($left += 28,$this->fpdf->getY()); $this->fpdf->Cell(60, $h, '2', 1, 0, 'C');

		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(140, $h, '3', 1, 0, 'C');

		$this->fpdf->SetXY($left += 140,$this->fpdf->getY()); $this->fpdf->Cell(60, $h, '4', 1, 0, 'C');

		$this->fpdf->SetXY($left += 60,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '5', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '6', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(32, $h, '7', 1, 0, 'C');
		
		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '8', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '9', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '10', 1, 0, 'C');
		
		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '11', 1, 0, 'C');

		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '12', 1, 0, 'C');
		
		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '13=(6+9+12)', 1, 0, 'C');
		
		$this->fpdf->SetXY($left += 23,$this->fpdf->getY()); $this->fpdf->Cell(23, $h, '14=(3-13)', 1, 0, 'C');

		$this->fpdf->Ln(15);


		$this->fpdf->SetFont('Arial','',7.5);



		$this->SetWidths(array(7,18,50,23,23,23,23,23,23,23,23,23,23,23));



		$this->SetAligns(array('C','C','L','R','R','R','R','R','R','R','R','R','R','R'));

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

				'', 

				'', 

				'',

				'', 

				'', 

				'', 

				''


			));

			$no++;

		}

			$this->fpdf->Cell(89,5,'BELANJA TIDAK LANGSUNG',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);

			

			$this->fpdf->Cell(89,5,'BELANJA BARANG DAN JASA',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			

			$this->fpdf->Cell(89,5,'Pengadaan Alat-alat Kedokteran Rumah Sakit (Pajak Rokok)',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Pengadaan Peningkatan dan Perbaikan Sarana/Prasarana Rumah Sakit (DAK)',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Pembangunan Gedung Rawat Inap Kelas II RSUD dr Slamet (2 Lantai) (Banprop)',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Pengadaan Alat-alat Kedokteran Rumah Sakit (Cukai 2016)',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BIAYA BLUD RSU Dr SLAMET GARUT',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA PEGAWAI',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA BARANG DAN JASA',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');

			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'BELANJA MODAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'JUMLAH TOTAL',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'penerimaan',1,0,'C');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'- SP2D',1,0,'C');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'- Potongan Pajak',1,0,'C');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'a. PPN',1,0,'C');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'b. PPh 21',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'c. PPh 22',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'d. PPh 23',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'e. PPh 4 ayat 2',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'g. Pajak Restoran',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Jumlah Penerimaan:',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Pengeluaran:',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'-SPJ(LS+UP/GU/TU)',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'-Penyetoran',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'a. PPN',1,0,'C');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'b. PPh 21',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'c. PPh 22',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'d. PPh 23',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'e. PPh 4 ayat 2',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'g. Pajak Restoran',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Jumlah Pengeluaran',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');
			
			$this->fpdf->Ln(5);
			
			
			$this->fpdf->Cell(89,5,'Saldo Kas',1,0,'L');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');

			$this->fpdf->Cell(23,5,'',1,0,'R');			

			$this->fpdf->Cell(32,5,'',1,0,'R');			


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



	'orientation'=>'L' //orientation: P=portrait, L=landscape



);

$this->fpdf = new fpdf();

if ($options['paper_size'] == "F4") {

			$a = 8.3 * 72; //1 inch = 72 pt

			$b = 13.0 * 72;

			$this->fpdf->FPDF($options['orientation'], "pt", array($a,$b));

		} else {

			$this->fpdf->FPDF($options['orientation'], "pt", $options['paper_size']);

		}

$tabel = new FPDF_AutoWrapTable($this->fpdf, array(), $options, array());	
$tabel->printPDF();

			    



	    $this->fpdf->Output($options['filename'],$options['destinationfile']);
?>