
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
		<h1 style="text-align:center"><?=strtoupper("Daftar Agama")?></h1>
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
				
									<th data-datatable-align="text-center" style="max-width:100px">NIP</th>
									<th data-datatable-align="text-center" style="max-width:100px">No Registrasi</th>
									<th data-datatable-align="text-left">Nama Lengkap</th>
									<th data-datatable-align="text-center">No Identitas</th>
									<th data-datatable-align="text-center">Jenis Kelamin</th>
									<th data-datatable-align="text-center">Jenis Pegawai</th>
									<th data-datatable-align="text-center">No HP</th>
									<th data-datatable-align="text-left">Alamat</th>
									<th data-datatable-align="text-center">Tanggal Daftar</th>
			</tr>
		</thead>
		<tbody>
		<?php $no = 0; foreach($query as $row) { ?>
				<tr>
					<td style="text-align:center;"><?=++$no?></td>
				
						<td style="text-align:left;"><?=$row["nip"]?></td>
						<td style="text-align:left;"><?=$row["no_registrasi_pegawai"]?></td>
						<td style="text-align:left;"><?=$row["nama"]?></td>
						<td style="text-align:left;"><?=$row["no_identitas"]?></td>
						<td style="text-align:left;"><?=$row["jk"]?></td>
						<td style="text-align:left;"><?=$row["jenis_pegawai"]?></td>
						<td style="text-align:left;"><?=$row["hp"]?></td>
						<td style="text-align:left;"><?=$row["alamat"]?></td>
						<td style="text-align:left;"><?=$row["add_time"]?></td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
</page>
