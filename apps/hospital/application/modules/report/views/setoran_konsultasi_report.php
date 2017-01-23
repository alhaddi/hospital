
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 11.5;
	$font["ttd"] = 10.5;
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="35mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <?=$header?>
		<h4 style="text-align:center"><?=strtoupper("Daftar Setoran Tindakan")?></h4>
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
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:15px;" cellspacing="0" class="border" align="center">
		<thead>
			<tr class="">
				<th style="text-align:center; width:20px; border:solid 1px #000;">No.</th>
				
						<th style="text-align:center;  width:150px; border:solid 1px #000;">Poliklinik</th>
						<th style="text-align:center;  width:150px; border:solid 1px #000;">Reference</th>
						<th style="text-align:center;  width:50px; border:solid 1px #000;">Jml Pasien</th>
						<th style="text-align:center;  width:150px; border:solid 1px #000;">Jasa Rumah Sakit</th>
						<th style="text-align:center; width:100px; border:solid 1px #000;">Jasa Medis</th>
						<th style="text-align:center; width:100px; border:solid 1px #000;">Total</th>
						
			</tr>
		</thead>
		<tbody>
		<?php $total = 0; $pasien = 0; $rmh_sakit = 0; $medis = 0; $no = 0; foreach($query as $row) { 
?>
				<tr>
					<td style="text-align:center; border:solid 1px #000;"><?=++$no?></td>
				
						<td style="text-align:left; border:solid 1px #000;"><?=$row["poliklinik"]?></td>
						<td style="text-align:left; border:solid 1px #000;"></td>
						<td style="text-align:right; border:solid 1px #000;"><?=$row["jml_pasien"]?></td>
						<td style="text-align:right; border:solid 1px #000;"><?=rupiah($row['total']*(60/100))?></td>
						<td style="text-align:right; border:solid 1px #000;"><?=rupiah($row['total']*(40/100))?></td>
						<td style="text-align:right; border:solid 1px #000;"><?=rupiah($row['total'])?></td>
				</tr>
		<?php 
				$pasien+=$row['jml_pasien'];
				$rmh_sakit+=$row['total']*(60/100);
				$medis+=$row['total']*(40/100);
				$total+=$row['total'];
			} 
		?>
		</tbody>
		<tfoot>
			<tr>
				<td style="text-align:left; border:solid 1px #000;"></td>
				<td style="text-align:left; border:solid 1px #000;"></td>
				<td style="text-align:center; font-style:bold; border:solid 1px #000;"><b>Total</b></td>
				<td style="text-align:right; font-style:bold; border:solid 1px #000;"><?=$pasien?></td>
				<td style="text-align:right; font-style:bold; border:solid 1px #000;"><?=rupiah($rmh_sakit)?></td>
				<td style="text-align:right; font-style:bold; border:solid 1px #000;"><?=rupiah($medis)?></td>
				<td style="text-align:right; font-style:bold; border:solid 1px #000;"><?=rupiah($total)?></td>
			</tr>
		</tfoot>
	</table>
</page>
