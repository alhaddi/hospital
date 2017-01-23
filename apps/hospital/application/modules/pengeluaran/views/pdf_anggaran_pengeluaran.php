
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 11.5;
	$font["ttd"] = 10.5;

	foreach($query1 as $row){
		
		$tgl_blud = $row['tgl_blud'];
		$no_cek = $row['no_cek'];
		$nama_pph = $row['nama_pph'];
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="40mm" backbottom="0mm" backleft="0mm" backright="0mm">
    <page_header>
        <table style="width: 100%;" align="center">
			<tr>
				<td style="font-size:12px; text-align:center;">
					DOKUMEN PENDUKUNG
				</td>
			</tr>
			<tr>
				<td style="font-size:12px; text-align:center;">
					RENCANA PENGELUARAN
				</td>
			</tr>
			<tr>
				<td style="font-size:12px; text-align:center;">
					BULAN : <?=$tgl_blud?>
				</td>
			</tr>
			<tr>
				<td style="font-size:12px; text-align:center;">
					NO.CEK: <?=$no_cek?>
				</td>
			</tr>
		</table>
		<p>1.02.02.36.01 Peningkatan dan Pendukung Pelayanan Umum Daerah(BLUD)</p>
    </page_header>
    <page_footer>
		<table border="0.1">
			<tr>
				<td></td>
				<td align="center">Garut, <?=$tgl_blud?></td>
			</tr>
			<tr>
				<td>
					<table align="center" style="padding:30px 10px">
						<tr>
							<td style="font-size:12px;">
								Mengetahui/Menyetujui
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">
								Direktur RSU Dr. Slamet
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table align="center" style="padding:30px 10px">
						<tr>
							<td style="font-size:12px;">
								Mengetahui/Menyetujui
							</td>
						</tr>
						<tr rowspan="3">
							<td style="font-size:12px;">
								Direktur RSU Dr. Slamet
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table align="center" style="padding:30px 10px">
						<tr>
							<td style="font-size:12px;">
								Dr. H. Maskut Farid .MM
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">
								NIP. 196706251998031004
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table align="center" style="padding:30px 10px">
						<tr>
							<td style="font-size:12px;">
								Dr. H. Maskut Farid .MM
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">
								NIP. 196706251998031004
							</td>
						</tr>
					</table>
				</td>
			</tr>
        </table>
	</page_footer>
	<table style="width: 100%; font-size:12px;" class="border" border="0.1">
		<thead>
			<tr class="">
				<th style="text-align:center" style="width:20px;padding:5px;">No.</th>
				
						<th style="text-align:center;padding:5px;" colspan="2">Jenis Biaya & Kodrek</th>
						<th style="text-align:center;padding:5px;">Uraian</th>
						<th style="text-align:center;padding:5px;">Jumlah</th>
						<th style="text-align:center;padding:5px;">PPn</th>
						<th style="text-align:center;padding:5px;"><?=$nama_pph?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$query2 = $this->Anggaran_pengeluaran_model->data_pdf2('',$row['tgl_blud']);
			$no = 0; 
			$totaljml = 0;
			$totalppn = 0;
			$totalpph = 0;
			foreach($query2 as $row) { 
		?>
				<tr>
					<td style="text-align:center;padding:5px;"><?=++$no?></td>
				
						<td style="text-align:center;padding:5px;"><?=$row["nama_anggaran"]?></td>
						<td style="text-align:center;padding:5px;"><?=$row["no_rekening"]?></td>
						<td style="text-align:center;padding:5px;"><?=$row["uraian"]?></td>
						<td style="text-align:center;padding:5px;"><?=rupiah($row["jumlah"])?></td>
						<td style="text-align:center;padding:5px;"><?=rupiah($row["ppn"])?></td>
						<td style="text-align:center;padding:5px;"><?=rupiah($row["pph"])?></td>
				</tr>
		<?php 
			$totaljml += $row['jumlah'];
			$totalppn += $row['ppn'];
			$totalpph += $row['pph'];
		} ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:center;padding:5px;"></td>
				<td style="text-align:center;padding:5px;">Total:</td>
				<td style="text-align:center;padding:5px;"><?=rupiah($totaljml)?></td>
				<td style="text-align:center;padding:5px;"><?=rupiah($totalppn)?></td>
				<td style="text-align:center;padding:5px;"><?=rupiah($totalpph)?></td>
			</tr>
			<tr>
				<td style="text-align:center;padding:5px;">Terbilang</td>
				<td style="text-align:center;padding:5px;" colspan="6"><?=strtoupper($this->currency->terbilang_rupiah($totaljml)." RUPIAH")?></td>
			</tr>
		</tfoot>
	</table>
</page>
	<?php } ?>