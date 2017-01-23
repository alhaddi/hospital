<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>ICD</label>
			<select class="form-control" name="type"  id="type" data-datatable-filter="true" data-datatable-id='<?=$id_table3?>'>
				<option value="">-- Pilih ICD --</option>
				<option value="ICD09">ICD 09</option>
				<option value="ICD10">ICD 10</option>
			</select>
		</div>
		<div class="col-sm-3">
			<label>Poliklinik</label>
			<select class="form-control" name="id_poliklinik"  id="id_poliklinik2" data-datatable-filter="true" data-datatable-id='<?=$id_table3?>'>
				<option value="">-- Pilih Poliklinik --</option>
				<?php foreach($poliklinik as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label>Kategori</label>
			<select class="form-control" name="kategori"  id="kategori" data-datatable-filter="true" data-datatable-id='<?=$id_table3?>'>
				<option value="">-- Pilih Kategori --</option>
				<option value="10">-- 10 Besar --</option>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<div class="col-sm-6">
				<button onclick="pdf_diagnosa()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<table id="<?=$id_table3?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list3?>"
data-datatable-daterange="true"
data-datatable-colvis="true"
data-datatable-scroller="true"
data-datatable-scroll-x="true"
data-datatable-nocolvis=""
>
	<thead>
    <tr>
        <th data-datatable-align="text-center" width="10%">Bulan</th>
        <th data-datatable-align="text-center" width="10%">No. Urut</th>
        <th data-datatable-align="text-center" width="10%">Kode ICD</th>
        <th data-datatable-align="text-center" width="10%">Deskripsi</th>
        <th data-datatable-align="text-center" width="10%">Jenis Kelamin LK</th>
        <th data-datatable-align="text-center" width="10%">Jenis Kelamin PR</th>
		<th data-datatable-align="text-center" width="10%">Jumlah Kasus Baru(4+5)</th>
		<th data-datatable-align="text-center" width="10%">Jumlah Kunjungan</th>
    </tr>
    </thead>
	<tbody>
	
	</tbody>
</table>
<script>
//script yg di tambah sm fatur
function pdf_diagnosa(){
	var d1=$("#<?=$id_table3?>_daterange1").val();
	var d2=$("#<?=$id_table3?>_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var id_poliklinik2 = $("#id_poliklinik2").val();
	var type = $("#type").val().replace('ICD','');
	var kategori = $("#kategori").val();
	
	window.open('<?=base_url()?>rekam_medis/showDiagnosa?tgl1='+t1+'&tgl2='+t2+'&id_poliklinik='+id_poliklinik2+'&type='+type+'&kategori='+kategori);
}
</script>