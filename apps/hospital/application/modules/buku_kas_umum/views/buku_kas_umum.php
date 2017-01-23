
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
						<button onclick="modal_buku_kas()" class="btn btn-mini">
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
								<th data-datatable-align="text-left">Tanggal</th>
								<th data-datatable-align="text-left">Uraian</th>
								<th data-datatable-align="text-left">Kode Rekening</th>
								<th data-datatable-align="text-left">Penerimaan Rp</th>
								<th data-datatable-align="text-left">Pengeluaran Rp</th>
								<th data-datatable-align="text-left">Saldo</th>
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
<?=$load_form?>
<script>
function modal_buku_kas(){
	$('#tgl1').val($("#buku_kas_umum_daterange1").val());
	$('#tgl2').val($("#buku_kas_umum_daterange2").val());
	$('#modal_<?=$id_table?>').modal('show');
}
function pdf(){
	var d1=$("#buku_kas_umum_daterange1").val();
	var d2=$("#buku_kas_umum_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0]+" 00:00:00";
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0]+" 23:59:59";
window.open('<?=base_url()?>buku_kas_umum/pdf_buku_kas?tgl1='+t1+'&tgl2='+t2);
}		
</script>
