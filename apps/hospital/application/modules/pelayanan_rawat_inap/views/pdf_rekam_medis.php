
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
		<hr>
		<h5 style="text-align:center; margin: 0px;"><?=strtoupper("Laporan Rekam Medis Pasien")?></h5>
		<hr>
    </page_header>
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:-20px;" cellspacing="0" class="border" >
		<tbody>
				<tr>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>No RM</b></td>
								<td>: <?=$rm?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Nama Pasien</b></td>
								<td>: <?=$nama_lengkap?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Tanggal Lahir</b></td>
								<td>: <?=$tanggal_lahir?></td>
							</tr>
						</table>
					</td>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>Kategori Pasien</b></td>
								<td>: <?=$cara_bayar?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Gol.Darah</b></td>
								<td>: <?=$golongan_darah?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Alamat</b></td>
								<td>: <?=($alamat != null)?$alamat:'-'?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>Poli</b></td>
								<td>: <?=$poliklinik?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>R. Jalan/Inap</b></td>
								<td>: <?=$komponen?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Diagnosa Utama</b></td>
								<td>: <?=$diagnosa?></td>
							</tr>
						</table>
					</td>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>Tanggal</b></td>
								<td>: <?=$last_update?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Umur</b></td>
								<td>: <?=$usia?> Thn</td>
							</tr>
							<tr>
								<td colspan="2"><br></td>
							
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Keluhan</b></td>
								<td>: <?=($keluhan_pasien != null)?$keluhan_pasien:'-'?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Pemeriksaan</b></td>
								<td>: <?=($pemeriksaan != null)?$pemeriksaan:'-'?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Alergi Obat</b></td>
								<td>: <?=($alergi_obat != null)?$alergi_obat:'-'?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Resep</b></td>
								<td>: <?=($resep != null)?$resep:'-'?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Kesimpulan</b></td>
								<td>: <?=($kesimpulan != null)?$kesimpulan:'-'?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px"><b>Kondisi Keluar</b></td>
								<td>: <?=($kondisi_keluar_pasien != null)?$kondisi_keluar_pasien:'-'?></td>
							</tr>
						</table>
					</td>
				</tr>
		</tbody>
	</table>
</page>
