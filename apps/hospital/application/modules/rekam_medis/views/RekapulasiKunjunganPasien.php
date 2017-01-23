<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Poliklinik</label>
			<select class="form-control" name="id_poliklinik"  id="id_poliklinik" data-datatable-filter="true" data-datatable-id='<?=$id_table2?>'>
				<option value="">-- Pilih Poliklinik --</option>
				<?php foreach($poliklinik as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<div class="col-sm-6">
				<button onclick="pdf_rekap()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<table id="<?=$id_table2?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list2?>"
data-datatable-daterange="true"
data-datatable-colvis="true"
data-datatable-scroller="true"
data-datatable-scroll-x="true"
data-datatable-nocolvis=""
>
	<thead>
    <tr>
        <th data-datatable-align="text-center" rowspan="3" style="vertical-align: middle" width="50">No</th>
        <th data-datatable-align="text-center" rowspan="3" style="vertical-align: middle">Status &nbsp Pasien</th>
        <th data-datatable-align="text-center" colspan="2">Kunjungan</th>
        <th data-datatable-align="text-center" colspan="3">Jumlah</th>
        <th data-datatable-align="text-center" colspan="4">Tindakan</th>
		<th data-datatable-align="text-center" rowspan="3" style="vertical-align: middle">Jml</th>
		<th data-datatable-align="text-center" colspan="6">Penunjang</th>
		<th data-datatable-align="text-center" colspan="4">Pendapatan</th>
		<th data-datatable-align="text-center" rowspan="3" style="vertical-align: middle">Jumlah Total</th>
    </tr>
    <tr>
        <th rowspan="2" style="vertical-align: bottom">Baru</th>
        <th rowspan="2" style="vertical-align: bottom">Lama</th>
        <th rowspan="2" style="vertical-align: bottom">Kunj</th>
        <th rowspan="2" style="vertical-align: bottom">Konsul</th>
        <th rowspan="2" style="vertical-align: bottom">Cek Up</th>
        <th>3A</th>
        <th>3B</th>
        <th>3C</th>
        <th>LP</th>
		<th rowspan="2" style="vertical-align: bottom">EKG</th>
		<th rowspan="2" style="vertical-align: bottom">EEG</th>
		<th rowspan="2" style="vertical-align: bottom">USG</th>
		<th rowspan="2" style="vertical-align: bottom">Audio</th>
		<th rowspan="2" style="vertical-align: bottom">Spiro</th>
		<th rowspan="2" style="vertical-align: bottom">Lain2</th>
		<th>Kunjungan</th>
		<th>Tindakan</th>
		<th>Pemeriksaan</th>
		<th>Pem.Konsul</th>
    </tr>
	<tr>
		<th>SDH</th>
		<th>KCL</th>
		<th>SDG</th>
		<th>BSR</th>
		<th>Rp.</th>
		<th>Rp.</th>
		<th>Rp.</th>
		<th>Rp.</th>
	</tr>
    </thead>
	<tbody>
	
	</tbody>
</table>
<script>

//script yg di tambah sm fatur
function pdf_rekap(){
	var d1=$("#<?=$id_table2?>_daterange1").val();
	var d2=$("#<?=$id_table2?>_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var id_poliklinik = $("#id_poliklinik").val();
	
	window.open('<?=base_url()?>rekam_medis/showRekap?tgl1='+t1+'&tgl2='+t2+'&id_poliklinik='+id_poliklinik);
}
</script>