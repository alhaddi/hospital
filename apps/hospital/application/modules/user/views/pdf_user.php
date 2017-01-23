
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
		<h1 style="text-align:center"><?=strtoupper("Daftar User")?></h1>
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
				
						<th style="text-align:left;">Kode User</th>
						<th style="text-align:left;">Nama</th>
						<th style="text-align:left;">No Identitas</th>
						<th style="text-align:left;">Jk</th>
						<th style="text-align:left;">Tempat Lahir</th>
						<th style="text-align:left;">Tgl Lahir</th>
						<th style="text-align:left;">Alamat</th>
						<th style="text-align:left;">Telp</th>
						<th style="text-align:left;">Hp</th>
						<th style="text-align:left;">Email</th>
						<th style="text-align:left;">Foto</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center;"><?=++$no?></td>
				
						<td style="text-align:left;"><?=$row["kode_user"]?></td>
						<td style="text-align:left;"><?=$row["nama"]?></td>
						<td style="text-align:left;"><?=$row["no_identitas"]?></td>
						<td style="text-align:left;"><?=$row["jk"]?></td>
						<td style="text-align:left;"><?=$row["tempat_lahir"]?></td>
						<td style="text-align:left;"><?=$row["tgl_lahir"]?></td>
						<td style="text-align:left;"><?=$row["alamat"]?></td>
						<td style="text-align:left;"><?=$row["telp"]?></td>
						<td style="text-align:left;"><?=$row["hp"]?></td>
						<td style="text-align:left;"><?=$row["email"]?></td>
						<td style="text-align:left;"><?=$row["foto"]?></td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
</page>
