
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 9.5;
	$font["ttd"] = 10.5;
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="35mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <?=$header?>
		<h4 style="text-align:center"><?=strtoupper("Daftar Pembayaran")?></h4>
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
	<table style="width: 100%; font-size:<?=$font["table_header"]?>;margin-top:15px;" cellspacing="0" class="border" align="center">
		<thead>
			<tr class="">
				<th style="text-align:center; width:20px; border:solid 1px #000;">No.</th>
				
						<th style="text-align:center;  width:50px; border:solid 1px #000;">RM</th>
						<th style="text-align:center;  width:50px; border:solid 1px #000;">Identitas</th>
						<th style="text-align:center;  width:175px; border:solid 1px #000;">Nama Lengkap</th>
						<th style="text-align:center; width:50px; border:solid 1px #000;">Cara Bayar</th>
						<th style="text-align:center; width:125px; border:solid 1px #000;">Tipe Bayar</th>
						<th style="text-align:center; width:150px; border:solid 1px #000;">Nama Dokter</th>
						<th style="text-align:center; width:75px; border:solid 1px #000;">Tanggal Datang</th>
						<th style="text-align:center; width:75px; border:solid 1px #000;">Keterangan</th>
						<th style="text-align:right; width:75px; border:solid 1px #000;">Nominal</th>
						
			</tr>
		</thead>
		<tbody>
		<?php $total = 0; $no = 0; foreach($query as $row) { 
		if($row['id_komponen'] == 5){
			$komponen =  get_field(get_field($row['id_penunjang'],'trs_penunjang','id_ms_penunjang'),'ms_penunjang');
			}else{
			$komponen =  get_field($row['id_komponen'],'ms_komponen_registrasi');
			}
?>
				<tr>
					<td style="text-align:center; border:solid 1px #000;"><?=++$no?></td>
				
						<td style="text-align:center; border:solid 1px #000;"><?=$row["rm"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["no_identitas"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["cara_bayar"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$komponen?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row['dokter']?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=convert_tgl($row['tgl_datang'],'d M Y H:i',1)?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["keterangan"]?></td>
						<td style="text-align:right; border:solid 1px #000;"><?=rupiah($row["nominal"])?></td>
				</tr>
		<?php 
				$total+=$row['nominal'];
			} 
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='9' style="text-align:center; font-style:bold; border:solid 1px #000;"><b>Total</b></td>
				<td style="text-align:right; font-style:bold; border:solid 1px #000;"><?=rupiah($total)?></td>
			</tr>
		</tfoot>
	</table>
</page>
