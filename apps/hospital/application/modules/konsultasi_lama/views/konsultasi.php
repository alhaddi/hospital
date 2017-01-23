
<div class="container-fluid">

	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Daftar <?=$title?>
					</h3>
					<div class="actions">
						<a href="<?=site_url('report?konsultasi=ya')?>" class="btn btn-primary btn-mini">
							<i class="fa fa-file"></i> Laporan Pasien Poliklinik
						</a>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn--icon">
								<i class="fa fa-download"></i> Export
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<!--<li>
									<a href="#" onclick="excel()"><i class="fa fa-file-excel-o fa-fw"></i> Excel (.xlsx)</a>
								</li>-->
								<li>
									<a href="#" onclick="pdf()"><i class="fa fa-file-pdf-o fa-fw"></i>Pdf (.pdf)</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="box-content nopadding">
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-delete="<?=$datatable_delete?>"
					data-datatable-colvis="true"
					data-datatable-daterange="true"
					data-datatable-autorefresh="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th data-datatable-align="text-center" style="width:50px;">No.</th>
								<th data-datatable-align="text-center">RM</th>
								<th data-datatable-align="text-left">Nama Lengkap</th>
								<th data-datatable-align="text-center">No. Identitas</th>
								<th data-datatable-align="text-center">Cara Bayar</th>
								<th data-datatable-align="text-center">Jenis Daftar</th>
								<th data-datatable-align="text-center">Poliklinik</th>
								<th data-datatable-align="text-center">Dokter</th>
								<th data-datatable-align="text-center">Tanggal</th>
								<th data-datatable-align="text-center">Status</th>
								<th data-datatable-align="text-center" style="width:170px;">Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function excel(){
	var d1=$("#konsultasi_daterange1").val();
	var d2=$("#konsultasi_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb = ""+$("#<?=$id_table?>").dataTable().fnSettings().aaSorting;
	var tbl = tb.split(",");
	var column_order = tbl[0];
	var dir_order = tbl[1];
	
	window.open('<?=base_url()?>konsultasi/excel?tgl1='+t1+' 00:00:00&tgl2='+t2+' 23:59:59&column_order='+column_order+'&dir_order='+dir_order);
}
function pdf(){
	var d1=$("#konsultasi_daterange1").val();
	var d2=$("#konsultasi_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb = ""+$("#<?=$id_table?>").dataTable().fnSettings().aaSorting;
	var tbl = tb.split(",");
	var column_order = tbl[0];
	var dir_order = tbl[1];
	
	window.open('<?=base_url()?>konsultasi/pdf?tgl1='+t1+' 00:00:00&tgl2='+t2+' 23:59:59&column_order='+column_order+'&dir_order='+dir_order);
}
	table_reload();
</script>
