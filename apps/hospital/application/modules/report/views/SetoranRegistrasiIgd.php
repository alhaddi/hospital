<!-- script yg di tambah sm fatur -->
<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Cara Bayar</label>
			<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar7" data-datatable-filter="true" data-datatable-id='<?=$id_table7?>'>
				<option value="">-- Cara Bayar --</option>
				<?php foreach($cara_bayar as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<!--<div class="col-sm-6">
				<button onclick="excel_loket();" class="btn btn-xs btn-success form-control"><span class="fa fa-file"></span> &nbsp; Excel File </button>
			</div>-->
			<div class="col-sm-6">
				<button onclick="pdf_loket_igd()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<!-- /> -->
<table id="<?=$id_table7?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list7?>"
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
			<th><?=$setoran_registrasi->jml_pasien?></th>
			<th><?=rupiah($setoran_registrasi->jasa_rs)?></th>
			<th><?=rupiah($setoran_registrasi->jasa_ms)?></th>
			<th><?=rupiah($setoran_registrasi->total)?></th>
		</tr>
	</tfoot>-->
</table>
<script>
//script yg di tambah sm fatur
function pdf_loket_igd(){
	var d1=$("#<?=$id_table7?>_daterange1").val();
	var d2=$("#<?=$id_table7?>_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb7 = ""+$("#<?=$id_table7?>").dataTable().fnSettings().aaSorting;
	var tbl7 = tb7.split(",");
	var column_order7 = tbl7[0];
	var dir_order7 = tbl7[1];
	
	var id_cara_bayar7=$("#id_cara_bayar7").val();
	window.open('<?=base_url()?>report/showLoketIGD?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar7+'&column_order7='+column_order7+'&dir_order7='+dir_order7);
}

function excel_loket(){
	var d1=$("#pasien_daterange1").val();
	var d2=$("#pasien_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb3 = ""+$("#<?=$id_table3?>").dataTable().fnSettings().aaSorting;
	var tbl3 = tb3.split(",");
	var column_order3 = tbl3[0];
	var dir_order3 = tbl3[1];
	
	var id_cara_bayar3=$("#id_cara_bayar3").val();
	window.open('<?=base_url()?>report/excel/3?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar3+'&column_order='+column_order3+'&dir_order='+dir_order3);
}
</script>