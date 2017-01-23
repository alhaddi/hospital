<?php 

$string = '
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 11.5;
	$font["ttd"] = 10.5;
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="40mm" backbottom="0mm" backleft="0mm" backright="0mm">
    <page_header>
        <?=$header?>
		<h1 style="text-align:center"><?=strtoupper("Daftar '.label($c).'")?></h1>
    </page_header>
    <page_footer>
        <table style="width: 100%;">
			<tr>
				<td style="font-size:12px;">
					- Data ini di cetak oleh <i><?=$this->session->userdata("username")?></i>
					<br>
					- Di cetak pada <i><?=convert_tgl(date("l, d F Y"),"l, d F Y")?></i>
					
				</td>
			</tr>
		</table>
	</page_footer>
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:15px;" cellspacing="0" class="border" >
		<thead>
			<tr class="">
				<th style="text-align:center" style="width:20px;">No.</th>
				';
				foreach ($non_pk as $row) {
					
					if(!in_array($row['column_name'],$hidden_form))
					{
						$string .= "\n\t\t\t\t\t\t";
						$string .= '<th style="text-align:left;">'.label($row["column_name"]).'</th>';
					}
				}
			$string .='
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center;"><?=++$no?></td>
				';
				foreach ($non_pk as $row) {
					
					if(!in_array($row['column_name'],$hidden_form))
					{
						$string .= "\n\t\t\t\t\t\t";
						$string .= '<td style="text-align:left;"><?=$row["'.$row["column_name"].'"]?></td>';
					}
				}
			$string .='
				</tr>
		<?php } ?>
		</tbody>
	</table>
</page>
';


$hasil_view_pdf = createFile($string, $target."views/" . $v_pdf_file);

?>