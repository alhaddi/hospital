<!-- script yg di tambah sm fatur -->
<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Cara Bayar</label>
			<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar2" data-datatable-filter="true" data-datatable-id='<?=$id_table2?>'>
				<option value="">-- Cara Bayar --</option>
				<?php foreach($cara_bayar as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label>Tipe Bayar</label>
			<select class="form-control" data-datatable-id='<?=$id_table2?>' name="id_ms_penunjang" id="id_ms_penunjang" data-datatable-filter="true">
				<option value="">-- Nama Bayar --</option>
				<option value="rajal">Registrasi Rawat Jalan</option>
				<option value="igd">Registrasi IGD</option>
				<option value="tindakan">Konsultasi Tindakan</option>
				<?php foreach($penunjang as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<!--<div class="col-sm-6">
				<button onclick="excel_pembayaran();" class="btn btn-xs btn-success form-control"><span class="fa fa-file"></span> &nbsp; Excel File </button>
			</div>-->
			<div class="col-sm-6">
				<button onclick="pdf_pembayaran()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<!-- /> -->
<table id="<?=$id_table2?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list2?>"
data-datatable-colvis="true"
data-datatable-daterange="true"
data-datatable-nocolvis=""
>
	<thead>
		<tr>
			<th data-datatable-align="text-center">No.Rm</th>
			<th data-datatable-align="text-center">Identitas</th>
			<th data-datatable-align="text-left">Nama</th>
			<th data-datatable-align="text-center">Cara Bayar</th>
			<th data-datatable-align="text-left">Nama Bayar</th>
			<th data-datatable-align="text-left">Dokter</th>
			<th data-datatable-align="text-right">Nominal</th>
			<th data-datatable-align="text-center">Tgl. Bayar</th>
			<th data-datatable-align="text-left">Keterangan</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
	
	<!--tfoot>
		<tr>
			<th colspan="5" style="text-align:right;">Total</th>
			<th><?=rupiah($total_pembayaran)?></th>
			<th colspan="2"></th>
		</tr>
	</tfoot-->
</table>
<script>
//script yg di tambah sm fatur
function pdf_pembayaran(){
	var d1=$("#total_pembayaran_daterange1").val();
	var d2=$("#total_pembayaran_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb2 = ""+$("#<?=$id_table2?>").dataTable().fnSettings().aaSorting;
	var tbl2 = tb2.split(",");
	var column_order2 = tbl2[0];
	var dir_order2 = tbl2[1];
	
	var id_cara_bayar2=$("#id_cara_bayar2").val();
	var id_ms_penunjang=$("#id_ms_penunjang").val();
	window.open('<?=base_url()?>report/showPembayaran?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar2+'&id_ms_penunjang='+id_ms_penunjang+'&column_order2='+column_order2+'&dir_order2='+dir_order2);
}

function excel_pembayaran(){
	var d1=$("#pasien_daterange1").val();
	var d2=$("#pasien_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb1 = ""+$("#<?=$id_table1?>").dataTable().fnSettings().aaSorting;
	var tbl1 = tb1.split(",");
	var column_order1 = tbl1[0];
	var dir_order1 = tbl1[1];
	
	var id_cara_bayar=$("#id_cara_bayar").val();
	var id_poliklinik=$("#id_poliklinik").val();
	var id_ms_penunjang=$("#id_ms_penunjang").val();
	window.open('<?=base_url()?>report/excel/2?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik+'&column_order='+column_order1+'&dir_order='+dir_order1);
}
</script>