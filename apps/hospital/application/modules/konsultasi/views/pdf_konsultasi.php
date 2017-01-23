
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
		<h1 style="text-align:center"><?=strtoupper("Daftar Konsultasi")?></h1>
    </page_header>
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:15px;" cellspacing="0" class="border" align="center">
		<thead>
			<tr class="">
				<th style="text-align:center" style="width:20px; border:1px solid black;">No.</th>
				
						<th style="width:50px; text-align:center; border:1px solid black;">RM</th>
						<th style="width:150px; text-align:center; border:1px solid black;">Nama Lengkap</th>
						<th style="width:100px; text-align:center; border:1px solid black;">No identitas</th>
						<th style="width:75px; text-align:center; border:1px solid black;">Cara Bayar</th>
						<th style="width:100px; text-align:center; border:1px solid black;">Nama Dokter</th>
						<th style="width:75px; text-align:center; border:1px solid black;">Poliklinik</th>
						<th style="width:100px; text-align:center; border:1px solid black;">Tanggal Daftar</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center; border:1px solid black;"><?=++$no?></td>
				
						<td style="text-align:left; border:1px solid black;"><?=$row["rm"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=$row["tipe_identitas"]." ".$row["no_identitas"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=$row["cara_bayar"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=$row["dokter"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=$row["poliklinik"]?></td>
						<td style="text-align:left; border:1px solid black;"><?=convert_tgl($row["tgl_daftar"],'d M Y H:i',1)?></td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
	<table style="width: 100%;">
		<tr>
			<td style="font-size:12px;">
				- Data ini di cetak oleh <i><?=$this->session->userdata("username")?></i>
				<br>
				- Di cetak pada <i><?=convert_tgl(date("l, d F Y"),"l, d F Y")?></i>
				
			</td>
		</tr>
	</table>
</page>
