
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
		<h4 style="text-align:center"><?=strtoupper($title)?></h4>
    </page_header>
	<table align="center" style="width: 100%; font-size:<?=$font["table_header"]?>; border:1px solid black;" cellspacing="0" class="border">
		<thead>
			<tr class="">
				<th style="text-align:center; width:70px; border:1px solid black; padding:1px;" rowspan="2">Nomor Registrasi</th>
				<th style="text-align:center; width:90px; border:1px solid black; padding:1px;" rowspan="2">Nomor Rekam Medis</th>
				<th style="text-align:center; width:120px; border:1px solid black; padding:1px;" rowspan="2">Nama</th>
				<th style="text-align:center; width:120px; border:1px solid black; padding:1px;" rowspan="2">Alamat</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" colspan="2">Usia</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" rowspan="2">Cara Bayar</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" colspan="3">Cara Masuk</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" rowspan="2">Tanggal Masuk</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" rowspan="2">Ruangan Rawat</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" rowspan="2">Tanggal Keluar</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" colspan="5">Cara Keluar</th>
				<th style="text-align:center; border:1px solid black; padding:1px;" rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th style="text-align:center; border:1px solid black; padding:1px;">Pria</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">Wanita</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">IGD</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">RJ</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">RI</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">PL</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">PP</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">PLK</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">-</th>
				<th style="text-align:center; border:1px solid black; padding:1px;">-</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($query as $row) { 
			
		?>
				<tr>
					<td style="text-align:center; border:1px solid black; padding:1px;"><?=$row['id']?></td>
				
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["rm"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left; border:1px solid black; padding:1px;"><?=$row["alamat"]?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=($row['jk'] == 'L')?$row['usia']:''?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=($row['jk'] == 'P')?$row['usia']:''?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=get_field($row['cara_bayar'],'ms_cara_bayar')?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=($row['cara_masuk'] == 'IGD')?'O':''?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=($row['cara_masuk'] == 'RJ')?'O':''?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=($row['cara_masuk'] == 'RI')?'O':''?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=convert_tgl($row["tgl_masuk"],'d/m/Y',1)?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=$row["ruang_rawat"]?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=convert_tgl($row["tgl_keluar"],'d/m/Y',1)?></td>
						<td style="text-align:center; border:1px solid black; padding:1px;">-</td>
						<td style="text-align:center; border:1px solid black; padding:1px;">-</td>
						<td style="text-align:center; border:1px solid black; padding:1px;">-</td>
						<td style="text-align:center; border:1px solid black; padding:1px;">-</td>
						<td style="text-align:center; border:1px solid black; padding:1px;">-</td>
						<td style="text-align:center; border:1px solid black; padding:1px;"><?=$row["keterangan"]?></td>
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
