<?php

	ob_clean();

	

	if (!defined('BASEPATH')) exit('No direct script access allowed');  

	

	require_once "PHPExcel.php";

	

	class Excel	 extends PHPExcel{

		public function __construct() {

			parent::__construct();

		}

		

		function read_file($file=null)

		{

			if($file)

			{

				$objPHPExcel = PHPExcel_IOFactory::load($file);

				

				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

				//extract to a PHP readable array format

				foreach ($cell_collection as $cell) {

					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();

					$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

					//header will/should be in row 1 only. of course this can be modified to suit your need.

					if ($row == 1) {

						$header[$row][$column] = $data_value;

						} elseif($row > 2) {

						$arr_data[$row][$column] = $data_value;

					}

				}

				//send the data in an array format

				$data['header'] = $header;

				$data['values'] = $arr_data;

				

				return $data;

			}

			else

			{

				die('masukan file excel');

			}

		}

		

		function export($query)

		{

			$objPHPExcel = new PHPExcel();

			$objPHPExcel->getActiveSheet()->setTitle('Daftar Suplier');

			$worksheet = $objPHPExcel->getActiveSheet();

			

			$exceldata = array();

			$x=1;

			foreach ($query as $row){
					
				if($x==1){
					$exceldata[] = array_merge(array('No'),array_keys($row));
				}

				$exceldata[] = array_merge(array($x),array_null_to_string($row));

				$x++;

			} 

			$bgcell = array(

			'type' => PHPExcel_Style_Fill::FILL_SOLID,

			'startcolor' => array(

			'rgb' => '368ee0'

			)

			);

			

			$font_color = array(

			'font' => array(

			'bold' => false,

			'color' => array('rgb' => 'ffffff')

			)

			);

			

			$border_color = array(

			'borders' => array(

			'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN,

			'color' => array('rgb' => '000000')

			)

			)

			);

			

			$alphas = range('A', 'Z');

			$objPHPExcel->getActiveSheet()->getStyle($alphas[0].'1:'.$alphas[count($exceldata[0])-1].'1')->getFill()->applyFromArray($bgcell);

			$objPHPExcel->getActiveSheet()->getStyle($alphas[0].'1:'.$alphas[count($exceldata[0])-1].'1')->applyFromArray($font_color);

			$objPHPExcel->getActiveSheet()->getStyle($alphas[0].'1:'.$alphas[count($exceldata[0])-1].count($exceldata))->applyFromArray($border_color);

			

			for ($col = 'A'; $col != 'P'; $col++) {

				$worksheet->getColumnDimension($col)->setAutoSize(true);

			}

			$worksheet->fromArray($exceldata, null, 'A1'); 

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

			/* echo '<pre>';

				var_dump($exceldata);

			exit(); */

			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

			header("Cache-Control: no-store, no-cache, must-revalidate");

			header("Cache-Control: post-check=0, pre-check=0", false);

			header("Pragma: no-cache");

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			

			header('Content-Disposition: attachment;filename="hasilExcel.xlsx"');

			

			$objWriter->save("php://output");

		}

	}

	

ob_end_clean();