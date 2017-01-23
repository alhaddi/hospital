
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 11.5;
	$font["ttd"] = 10.5;

	if($konsultasi['id_komponen'] != '5'){
		$field = $this->db->select('ms_komponen_registrasi.nama as komponen')
		->where('id',$konsultasi['id_komponen'])->get('ms_komponen_registrasi')->row_array();
	}else{
		$field = $this->db->select('ms_penunjang.nama as komponen')
		->where('id',$konsultasi['id_ms_penunjang'])->get('ms_penunjang')->row_array();
	}
	$komponen = $field['komponen'];
	
	if($konsultasi['kondisi_keluar_pasien'] == '0'){
		$kondisi = 'Sehat';
	}else if($konsultasi['kondisi_keluar_pasien'] == '1'){
		$kondisi = 'Dalam Proses Penyembuhan';
	}else{
		$kondisi = 'Rawat Inap';
	}
	
	if($konsultasi['usia_thn'] != null){
		$usia = $konsultasi['usia_thn'].' Tahun';
	}else if($konsultasi['usia_bln'] != null){
		$usia = $konsultasi['usia_bln'].' Bulan';
	}else{
		$usia = $konsultasi['usia_hari'].' Hari';
	}
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
								<td>: <?=$konsultasi['rm']?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Nama Pasien</b></td>
								<td>: <?=$konsultasi['nama_lengkap']?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Tanggal Lahir</b></td>
								<td>: <?=($konsultasi['tanggal_lahir'] != null)?convert_tgl($konsultasi['tanggal_lahir'],'d F Y',1):''?></td>
							</tr>
						</table>
					</td>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>Kategori Pasien</b></td>
								<td>: <?=$konsultasi['cara_bayar']?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Gol.Darah</b></td>
								<td>: <?=$konsultasi['golongan_darah']?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Alamat</b></td>
								<td>: <?=$konsultasi['alamat']?></td>
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
								<td>: <?=$konsultasi['poliklinik']?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>R. Jalan/Inap</b></td>
								<td>: <?=$komponen?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Diagnosa Utama</b></td>
								<td>: <?=(!empty($konsultasi[0]['deskripsi']))?$konsultasi[0]['deskripsi']:''?></td>
							</tr>
						</table>
					</td>
					<td style="width: 50%;">
						<table style="width: 100%;" cellspacing="0" class="border">
							<tr>
								<td style="width: 100px"><b>Tanggal</b></td>
								<td>: <?=date('Y-m-d')?></td>
							</tr>
							<tr>
								<td style="width: 100px"><b>Umur</b></td>
								<td>: <?=$usia?></td>
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
								<td>: <?=$konsultasi['keluhan_pasien']?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Resep</b></td>
								<td>: <?=($konsultasi['resep'] != null)?$konsultasi['resep']:''?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px; height: 100px;"><b>Kesimpulan</b></td>
								<td>: <?=$konsultasi['kesimpulan']?></td>
							</tr>
							<tr style="vertical-align:top;">
								<td style="width: 100px"><b>Kondisi Keluar</b></td>
								<td>: <?=$kondisi?></td>
							</tr>
						</table>
					</td>
				</tr>
		</tbody>
	</table>
</page>
