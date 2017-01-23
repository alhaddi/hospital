
<?php
	$font["judul"] = 12;
	$font["label_header"] = 11.5;
	$font["body_header"] = 10.5;
	$font["table_header"] = 11.5;
	$font["ttd"] = 10.5;
?>
<link rel="stylesheet" type="text/css" href="<?=THEME_HOST?>css/pdf.css" />
<page backtop="35mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <?=$header?>
		<h4 style="text-align:center"><?=strtoupper("Daftar Billing")?></h4>
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
						<th style="text-align:center;  width:175px; border:solid 1px #000;">Nama Lengkap</th>
						<th style="text-align:center; width:50px; border:solid 1px #000;">Cara Bayar</th>
						<th style="text-align:center; width:75px; border:solid 1px #000;">Poliklinik</th>
						<th style="text-align:center; width:100px; border:solid 1px #000;">Tipe Bayar</th>
						<th style="text-align:center; width:50px; border:solid 1px #000;">Tanggal</th>
						<th style="text-align:center; width:50px; border:solid 1px #000;">Nominal</th>
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
						<td style="text-align:left; border:solid 1px #000;"><?=$row["nama_lengkap"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["cara_bayar"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$row["poliklinik"]?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=$komponen?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=convert_tgl($row['add_time'],'d M Y H:i',1)?></td>
						<td style="text-align:left; border:solid 1px #000;"><?=rupiah($row["nominal"])?></td>
				</tr>
		<?php 
				$total+=$row['nominal'];
			} 
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='7' style="text-align:center; font-style:bold; border:solid 1px #000;"><b>Total</b></td>
				<td style="text-align:left; font-style:bold; border:solid 1px #000;"><?=rupiah($total)?></td>
			</tr>
		</tfoot>
	</table>
</page>
