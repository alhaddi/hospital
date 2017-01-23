
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 12.5;
	$font["ttd"] = 10.5;
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="40mm" backbottom="0mm" backleft="0mm" backright="0mm">
    <page_header>
        <?=$header?>
		<h1 style="text-align:center"><?=strtoupper("Daftar Pasien")?></h1>
    </page_header>
	<table align="center" style="width: 100%; font-size:<?=$font["table_header"]?>; border:1px solid black;" cellspacing="0" class="border">
		<thead>
			<tr class="">
				<th style="text-align:center" style="width:20px; border:1px solid black; padding:1px;">No.</th>
				
						<th style="text-align:center; border:1px solid black; padding:1px;">Rm</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Nama Lengkap</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Tipe Identitas</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">No Identittas</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Jk</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Usia</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Hp</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Alamat</th>
						<th style="text-align:center; border:1px solid black; padding:1px;">Tanggal Datang</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { 
			
		?>
				<tr>
					<td style="text-align:center; border:1px solid black; padding:1px;"><?=++$no?></td>
				
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["rm"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["tipe_identitas"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["no_identitas"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["jk"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["usia"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["hp"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["alamat"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["arrived_at"]?></td>
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
