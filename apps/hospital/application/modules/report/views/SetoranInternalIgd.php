<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Cara Bayar</label>
			<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar4" data-datatable-filter="true" data-datatable-id='<?=$id_table8?>'>
				<option value="">-- Cara Bayar --</option>
				<?php foreach($cara_bayar as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<!--<div class="col-sm-6">
				<button onclick="excel_internal()" class="btn btn-xs btn-success form-control"><span class="fa fa-file"></span> &nbsp; Excel File </button>
			</div>-->
			<div class="col-sm-6">
				<button onclick="pdf_internal_igd()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<table id="<?=$id_table8?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list8?>"
data-datatable-colvis="true"
data-datatable-daterange="true"
data-datatable-nocolvis=""
>
	<thead>
    <tr>
        <th data-datatable-align="text-center" width="50">No</th>
        <th data-datatable-align="text-left">Klinik</th>
        <th data-datatable-align="text-left">Referensi</th>
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
			<th><?=$setoran_internal_konsultasi->jml_pasien?></th>
			<th></th>
			<th><?=rupiah($setoran_internal_konsultasi->total)?></th>
			<th><?=rupiah($setoran_internal_konsultasi->total)?></th>
		</tr>
	</tfoot>-->
</table>
<script>
//script yg di tambah sm fatur
function pdf_internal_igd(){
	var d1=$("#<?=$id_table8?>_daterange1").val();
	var d2=$("#<?=$id_table8?>_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb8 = ""+$("#<?=$id_table8?>").dataTable().fnSettings().aaSorting;
	var tbl8 = tb8.split(",");
	var column_order8 = tbl8[0];
	var dir_order8 = tbl8[1];
	var id_cara_bayar8=$("#id_cara_bayar8").val();
	window.open('<?=base_url()?>report/showInternalIGDi?cara_bayar='+id_cara_bayar8+'&tgl1='+t1+'&tgl2='+t2+'&column_order8='+column_order8+'&dir_order8='+dir_order8);
}

function excel_internal(){
	var d1=$("#setoran_internal_konsultasi_daterange1").val();
	var d2=$("#setoran_internal_konsultasi_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb4 = ""+$("#<?=$id_table4?>").dataTable().fnSettings().aaSorting;
	var tbl4 = tb4.split(",");
	var column_order4 = tbl4[0];
	var dir_order4 = tbl4[1];
	var id_cara_bayar4=$("#id_cara_bayar4").val();
	
	window.open('<?=base_url()?>report/excel/4?cara_bayar='+id_cara_bayar4+'&tgl1='+t1+'&tgl2='+t2+'&column_order='+column_order4+'&dir_order='+dir_order4);
}
</script>