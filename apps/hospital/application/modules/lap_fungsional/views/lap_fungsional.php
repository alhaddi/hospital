
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
					data-datatable-scroller="true"
					data-datatable-scroll-x="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle" width="50px">No.</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Jenis Biaya</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">No Rekening</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Uraian</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Anggaran</th>
								<th data-datatable-align="text-center" colspan="3">SPJ-LS-Gaji</th>
								<th data-datatable-align="text-center" colspan="3">SPJ-LS-Barang & Jasa</th>
								<th data-datatable-align="text-center" colspan="3">SPJ-LS/UP/GU/TU</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Jumlah SPJ(LP+UP/GU/TU) s.d.Bulan ini</th>
								<th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Sisa Pagu Anggaran</th>
							</tr>
							<tr>
								<th>s.d.Bulan Lalu</th>
								<th>Bulan ini</th>
								<th>s.d Bulan ini</th>
								
								<th>s.d.Bulan Lalu</th>
								<th>Bulan ini</th>
								<th>s.d Bulan ini</th>

								<th>s.d.Bulan Lalu</th>
								<th>Bulan ini</th>
								<th>s.d Bulan ini</th>
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

	window.open('<?=base_url()?>lap_fungsional/pdf_lap_fungsional);
}		
</script>

