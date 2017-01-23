
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
		<h1 style="text-align:center"><?=strtoupper("Daftar Anamesa")?></h1>
    </page_header>
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:15px;" cellspacing="0" class="border" align="center">
		<thead>
			<tr class="">
				<th style="text-align:center" style="width:20px; border:1px solid black; padding:1px;">No.</th>
				
						<th style="width:100px; text-align:center; border:1px solid black; padding:1px;">RM</th>
						<th style="width:200px; text-align:center; border:1px solid black; padding:1px;">Nama Lengkap</th>
						<th style="width:100px; text-align:center; border:1px solid black; padding:1px;">Cara Bayar</th>
						<th style="width:125px; text-align:center; border:1px solid black; padding:1px;">Poliklinik</th>
						<th style="width:100px; text-align:center; border:1px solid black; padding:1px;">Tanggal Daftar</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center; border:1px solid black; padding:1px;"><?=++$no?></td>
					
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row['rm']?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row['nama_lengkap']?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row['cara_bayar']?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row['poliklinik']?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=convert_tgl($row['add_time'],'d-m-Y H:i',1)?></td>
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
