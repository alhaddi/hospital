
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-search"></i>
						Filter
					</h3>
				</div>
				<div class="box-content">
					<div class="row">
						<div class="col-sm-4">
							<label>Jenis Pajak</label>
							<select class="form-control" name="id_kategori_pph"  id="id_kategori_pph" data-datatable-filter="true" data-datatable-id='<?=$id_table?>'>
								<option value="0">PPN</option>
								<?php foreach($id_kategori_pph as $f) { 
									if($f['id']!=0){
								?>
									<option value="<?=$f['id']?>"><?=$f['nama_pph']?></option>
								<?php }} ?>
							</select>
						</div>
						<div class="col-sm-2">
							<label>Action</label>
							<button onclick="pdf();" class='btn btn-danger form-control' type='button'><i class='fa fa-pdf-o'></i> Cetak ke PDF</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						<?=$title?>
					</h3>
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
								<th data-datatable-align="text-left">Pemotongan(Rp)</th>
								<th data-datatable-align="text-left">Penyetoran(Rp)</th>
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
<script>
$('select').select2();
function pdf(){
	var d1=$("#pajak_daterange1").val();
	var d2=$("#pajak_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0]+" 00:00:00";
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0]+" 23:59:59";
	var id_anggaran = $("#id_anggaran").val();

	window.open('<?=base_url()?>pajak/_pajak?id_jenis_pajak='+id_jenis_pajak+'&tgl1='+t1+'&tgl2='+t2);
}		
</script>
