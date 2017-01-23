
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						<?=$title?>
					</h3>
					<div class="actions">
						<button onclick="pdf()" class="btn btn-mini">
							<i class="fa fa-download"></i> Export PDF
						</button>

					</div>
				</div>
				<div class="box-content nopadding">
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-colvis="true"
					data-datatable-autorefresh="true"
					data-datatable-daterange="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th data-datatable-align="text-center" style="width:50px;">No.</th>
								<th data-datatable-align="text-left">Jenis Biaya</th>
								<th data-datatable-align="text-left">Kodrek</th>
								<th data-datatable-align="text-left">Uraian</th>
								<th data-datatable-align="text-left">Jumlah</th>
								<th data-datatable-align="text-left">PPn</th>
								<th data-datatable-align="text-left">Kategori PPh</th>
								<th data-datatable-align="text-left">PPh</th>
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
function pdf(){
	var d1=$("#pendukung_rencana_pengeluaran_daterange1").val();
	var d2=$("#pendukung_rencana_pengeluaran_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0]+" 00:00:00";
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0]+" 23:59:59";

	window.open('<?=base_url()?>pendukung_rencana_pengeluaran/pdf_pendukung?tgl1='+t1+'&tgl2='+t2);
}		
</script>

