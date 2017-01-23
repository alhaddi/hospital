<!-- script yg di tambah sm fatur -->
<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label>Cara Bayar</label>
			<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar" data-datatable-filter="true" data-datatable-id='<?=$id_table1?>'>
				<option value="">-- Cara Bayar --</option>
				<?php foreach($cara_bayar as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<label>Poliklinik</label>
			<select class="form-control" data-datatable-id='<?=$id_table1?>' name="id_poliklinik" id="id_poliklinik" data-datatable-filter="true">
				<option value="">-- Poliklinik --</option>
				<?php 
				if(!empty($_GET['igd'])){
					if($_GET['igd'] == 'ya'){
						echo "<option value='20'>IGD</option>";		
						echo "<option value='28'>IGD Phonek</option>";		
					} 
					}
					else{
						 foreach($poliklinik as $f) { ?>
					<option value="<?=$f['id']?>"><?=$f['nama']?></option>
				<?php }
				}
				?>
			</select>
		</div>
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<!--<div class="col-sm-6">
				<button onclick="excel_pasien()" class="btn btn-xs btn-success form-control"><span class="fa fa-file"></span> &nbsp; Excel File </button>
			</div>-->
			<div class="col-sm-6">
				<button onclick="pdf_pasien()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<!-- /> -->
<table id="<?=$id_table1?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list1?>"
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
            <th data-datatable-align="text-center">L/P</th>
            <th data-datatable-align="text-center">Umur</th>
            <th data-datatable-align="text-center">No Kontak</th>
            <th data-datatable-align="text-left">Alamat</th>
            <th data-datatable-align="text-left">Poliklinik</th>
            <th data-datatable-align="text-center">Tgl. Bergabung</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<script>
//script yg di tambah sm fatur
function pdf_pasien(){
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
	window.open('<?=base_url()?>report/showPasien?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik+'&column_order1='+column_order1+'&dir_order1='+dir_order1);
}


function excel_pasien(){
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
	window.open('<?=base_url()?>report/excel/1?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik+'&column_order='+column_order1+'&dir_order='+dir_order1);
}
</script>