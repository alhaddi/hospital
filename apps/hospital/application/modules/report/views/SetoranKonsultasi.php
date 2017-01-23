<!-- script yg di tambah sm fatur -->
<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Cara Bayar</label>
			<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar5" data-datatable-filter="true" data-datatable-id='<?=$id_table5?>'>
				<option value="">-- Cara Bayar --</option>
				<?php foreach($cara_bayar as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<!--<div class="col-sm-6">
				<button onclick="excel_konsultasi()" class="btn btn-xs btn-success form-control"><span class="fa fa-file"></span> &nbsp; Excel File </button>
			</div>-->
			<div class="col-sm-6">
				<button onclick="pdf_konsultasi()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<!-- /> -->

<table id="<?=$id_table5?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list5?>"
data-datatable-colvis="true"
data-datatable-daterange="true"
data-datatable-nocolvis=""
>
	<thead>
    <tr>
        <th data-datatable-align="text-center" width="50">No</th>
        <th data-datatable-align="text-left">Klinik</th>
        <th data-datatable-align="text-center">Referensi</th>
        <th data-datatable-align="text-center">Jml pasien</th>
        <th data-datatable-align="text-right">jasa rumah sakit</th>
        <th data-datatable-align="text-right">jasa Medis</th>
        <th data-datatable-align="text-right">Total</th>
    </tr>
    </thead>
	<tbody>
	</tbody>
	<!--<tfoot>
		<tr>
			<th colspan="3" style="text-align:right;">Total</th>
			<th><?=$setoran_konsultasi->jml_pasien?></th>
			<th><?=rupiah($setoran_konsultasi->jasa_rs)?></th>
			<th><?=rupiah($setoran_konsultasi->jasa_ms)?></th>
			<th><?=rupiah($setoran_konsultasi->total)?></th>
		</tr>
	</tfoot>-->
</table>
<script>
//script yg di tambah sm fatur
function pdf_konsultasi(){
	var d1=$("#setoran_konsultasi_daterange1").val();
	var d2=$("#setoran_konsultasi_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb5 = ""+$("#<?=$id_table5?>").dataTable().fnSettings().aaSorting;
	var tbl5 = tb5.split(",");
	var column_order5 = tbl5[0];
	var dir_order5 = tbl5[1];
	
	var id_cara_bayar5=$("#id_cara_bayar5").val();
	window.open('<?=base_url()?>report/showKonsultasi?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar5+'&column_order5='+column_order5+'&dir_order5='+dir_order5);
}

function excel_konsultasi(){
	var d1=$("#setoran_konsultasi_daterange1").val();
	var d2=$("#setoran_konsultasi_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb1 = ""+$("#<?=$id_table5?>").dataTable().fnSettings().aaSorting;
	var tbl1 = tb1.split(",");
	var column_order1 = tbl1[0];
	var dir_order1 = tbl1[1];
	
	var id_cara_bayar5=$("#id_cara_bayar5").val();
	window.open('<?=base_url()?>report/excel/5?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik+'&column_order='+column_order1+'&dir_order='+dir_order1);
}
</script>