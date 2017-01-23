<?php
	/**
		* CodeIgniter Currency Libraries Function
		*
		* @package         CodeIgniter 2.0+ - 3.0+
		* @subpackage      Currency Libraries
		* @category        Libraries
		* @author          Amir Mufid
		* @version         3.0
	*/
	error_reporting(0);
	
	class Currency {
		private $angka = 0;
		protected $curr = "rupiah";
		private $nol = "nol";
		private $arraySat = array("satu", "dua", "tiga", "empat", "lima","enam", "tujuh", "delapan", "sembilan");
		private $arrayRat = array("ratus", "puluh", "belas");
		private $arrayRib = array("ribu", "juta", "milyar", "triliyun");
		
		function __construct($angka = 0)
		{
			$this->angka = $angka;
		}
		
		function rupiah($angka) 
		{
			$this->angka = $angka;
			return 'Rp '.number_format($this->angka,2, ".",".");
		}
		
		public function toString()
		{
			return $this->__($this->angka);
		}
		
		public function terbilang_norupiah($angka)
		{
			$word = '';
			$indexRib = 0;
			foreach($this->getArrayOfAngka($angka) as $angka) {
				if(!$this->checkThisNol($angka))
				{
					$word = $this->getRatOfAngka($angka) 
					.$this->arrayRib[$indexRib-1]. $word;
				}
				$indexRib++;
			};
			//$word .= " $this->curr";
			return $word;
		}
		
		private function __($angka)
		{
			if(!is_int($angka)) die("You only can input the integer value");
			return ($angka >0) ? $this->count($angka) : $this->not_count($angka);	
		}
		
		private function not_count($angka)
		{
			if($this->checkThisNol($angka)) 
			{
				return $this->nol." ".$this->curr;
			}
			else
			{
				return "cann't input the minus value" ;
			}
		}
		
		private function count($angka)
		{
			$word = '';
			$indexRib = 0;
			foreach($this->getArrayOfAngka($angka) as $angka) {
				if(!$this->checkThisNol($angka))
				{
					$word = $this->getRatOfAngka($angka) 
					.$this->arrayRib[$indexRib-1]. $word;
				}
				$indexRib++;
			};
			$word .= " $this->curr";
			return $word;
		}
		
		private function getArrayOfAngka($angka)
		{
			$angka = strrev($angka);
			$angka = str_split($angka, 3);
			foreach($angka as &$angkas)
			{
				$angkas = strrev($angkas);
				$angkas = (int) $angkas;
			}
			unset ($angkas);
			return $angka;
		}
		
		private function getRatOfAngka($angka)
		{
			$word = '';
			$angka = strrev($angka);
			$angka = str_split($angka);
			foreach($angka as &$angkas)
			{
				$angkas = strrev($angkas);
				$angkas = (int) $angkas;
			}
			unset ($angkas);
			$word .= ' ';
			$word .= ($this->checkThisNol($angka[2])) ? '' :
			( ($angka[2] == 1) ? 'se' : 
			$this->arraySat[$angka[2]-1]." ").$this->arrayRat[0] ;
			$word .= ' ';
			if(!$this->checkThisNol($angka[1]))
			{
				if($angka[1] == 1) 
				{
					if($this->checkThisNol($angka[0]) )
					{
						$word .= 'se'.$this->arrayRat[1];
					}
					else if($angka[0] == 1)
					{
						$word .= 'se'.$this->arrayRat[2];
					}
					else
					{
						$word .= $this->arraySat[$angka[2]-1]." ".$this->arrayRat[2];
					}
				}
				else
				{
					$word .= $this->arraySat[$angka[1]-1].' '.$this->arrayRat[1];
					$word .= ' ';
					$word .= $this->checkThisNol($angka[0]) ? '' : 
					$this->arraySat[$angka[1]-1];
				}
			}
			else 
			{
				$word .= $this->checkThisNol($angka[0]) ? '' : 
				$this->arraySat[$angka[0]-1];
			}
			$word .= ' ';
			return $word;
		}
		
		private function checkThisNol($angka)
		{
			return ($angka == 0) ? true : false;
		}
		
		function kekata($x) {
			
			$x = abs($x);
			
			$angka = array("", "satu", "dua", "tiga", "empat", "lima",
			
			"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			
			$temp = "";
			
			if ($x <12) {
				
				$temp = " ". $angka[$x];
				
				} else if ($x <20) {
				
				$temp = $this->kekata($x - 10). " belas";
				
				} else if ($x <100) {
				
				$temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
				
				} else if ($x <200) {
				
				$temp = " seratus" . $this->kekata($x - 100);
				
				} else if ($x <1000) {
				
				$temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
				
				} else if ($x <2000) {
				
				$temp = " seribu" . $this->kekata($x - 1000);
				
				} else if ($x <1000000) {
				
				$temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
				
				} else if ($x <1000000000) {
				
				$temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
				
				} else if ($x <1000000000000) {
				
				$temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
				
				} else if ($x <1000000000000000) {
				
				$temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
				
			}
			
			return $temp;
			
		}
		
		function terbilang_rupiah($x, $style=4) {
			
			if($x<0) {
				
				$hasil = "minus ". trim($this->kekata($x));
				
				} else {
				
				$hasil = trim($this->kekata($x));
				
			}
			
			switch ($style) {
				
				case 1:
				
				$hasil = strtoupper($hasil);
				
				break;
				
				case 2:
				
				$hasil = strtolower($hasil);
				
				break;
				
				case 3:
				
				$hasil = ucwords($hasil);
				
				break;
				
				default:
				
				$hasil = ucfirst($hasil);
				
				break;
				
			}
			
			return $hasil;
			
		}
	}
?>