
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
		<h1 style="text-align:center"><?=strtoupper("Daftar Pasien")?></h1>
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
				
						<th style="text-align:left;">Rm</th>
						<th style="text-align:left;">Id Agama</th>
						<th style="text-align:left;">Id Pekerjaan</th>
						<th style="text-align:left;">Nama Lengkap</th>
						<th style="text-align:left;">Tipe Identitas</th>
						<th style="text-align:left;">No Identittas</th>
						<th style="text-align:left;">Jk</th>
						<th style="text-align:left;">Tempat Lahir</th>
						<th style="text-align:left;">Tanggal Lahir</th>
						<th style="text-align:left;">Usia</th>
						<th style="text-align:left;">Status Menikah</th>
						<th style="text-align:left;">Nama Orangtua</th>
						<th style="text-align:left;">Asal Pasien</th>
						<th style="text-align:left;">No Rujukan</th>
						<th style="text-align:left;">Rujukan Dari</th>
						<th style="text-align:left;">Hp</th>
						<th style="text-align:left;">Tlp</th>
						<th style="text-align:left;">Email</th>
						<th style="text-align:left;">Alamat</th>
						<th style="text-align:left;">Rt</th>
						<th style="text-align:left;">Rw</th>
						<th style="text-align:left;">Id Wilayah</th>
						<th style="text-align:left;">Kelurahan</th>
						<th style="text-align:left;">Arrived At</th>
						<th style="text-align:left;">Status</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center;"><?=++$no?></td>
				
						<td style="text-align:left;"><?=$row["rm"]?></td>
						<td style="text-align:left;"><?=$row["id_agama"]?></td>
						<td style="text-align:left;"><?=$row["id_pekerjaan"]?></td>
						<td style="text-align:left;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left;"><?=$row["tipe_identitas"]?></td>
						<td style="text-align:left;"><?=$row["no_identitas"]?></td>
						<td style="text-align:left;"><?=$row["jk"]?></td>
						<td style="text-align:left;"><?=$row["tempat_lahir"]?></td>
						<td style="text-align:left;"><?=$row["tanggal_lahir"]?></td>
						<td style="text-align:left;"><?=$row["usia"]?></td>
						<td style="text-align:left;"><?=$row["status_menikah"]?></td>
						<td style="text-align:left;"><?=$row["nama_orangtua"]?></td>
						<td style="text-align:left;"><?=$row["asal_pasien"]?></td>
						<td style="text-align:left;"><?=$row["no_rujukan"]?></td>
						<td style="text-align:left;"><?=$row["rujukan_dari"]?></td>
						<td style="text-align:left;"><?=$row["hp"]?></td>
						<td style="text-align:left;"><?=$row["tlp"]?></td>
						<td style="text-align:left;"><?=$row["email"]?></td>
						<td style="text-align:left;"><?=$row["alamat"]?></td>
						<td style="text-align:left;"><?=$row["rt"]?></td>
						<td style="text-align:left;"><?=$row["rw"]?></td>
						<td style="text-align:left;"><?=$row["id_wilayah"]?></td>
						<td style="text-align:left;"><?=$row["kelurahan"]?></td>
						<td style="text-align:left;"><?=$row["arrived_at"]?></td>
						<td style="text-align:left;"><?=$row["status"]?></td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
</page>
