<?php
	ob_clean();
	class Chtml2pdf{
		function cetak($orientation="P",$paper="A4",$content,$name,$type="I")
		{
			require_once(dirname(__FILE__).'/html2PDF/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF($orientation, $paper, 'en');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->addFont('', 'I', '');
				$html2pdf->Output($name.'.pdf',$type);
			}
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
		}
	}
	ob_end_clean();
