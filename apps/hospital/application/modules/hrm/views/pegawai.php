
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
						<button type='button' onclick='$("#<?=$id_table?>").DataTable().ajax.reload(); ' class="btn btn-mini">
							<i class="fa fa-spinner fa-spin"></i> Refresh
						</button>
						<button type='button' onclick='addmodal(0)' class="btn btn-mini">
							<i class="fa fa-plus"></i> Tambah
						</button>
						<button data-datatable-action="bulk" data-datatable-idtable="<?=$id_table?>" class="btn btn-mini">
							<i class="fa fa-trash"></i> Hapus
						</button>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn--icon">
								<i class="fa fa-download"></i> Export
								<span class="caret"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="box-content nopadding">
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-delete="<?=$datatable_delete?>"
					data-datatable-colvis="true"
					data-datatable-multiselect="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th class="with-checkbox" data-datatable-align="text-center">
									<input type="checkbox" name="check_all" data-datatable-checkall="true">
								</th>
								<th data-datatable-align="text-center" style="max-width:50px;">No.</th>
									<th data-datatable-align="text-center" style="max-width:100px">NIP</th>
									<th data-datatable-align="text-left">Nama Lengkap</th>
									<th data-datatable-align="text-center">No Identitas</th>
									<th data-datatable-align="text-center">Jenis Kelamin</th>
									<th data-datatable-align="text-center">Spesialis</th>
									<th data-datatable-align="text-center">No HP</th>
									<th data-datatable-align="text-left">Alamat</th>
									<th data-datatable-align="text-center">Tanggal Daftar</th>
									<th data-datatable-align="text-center" style="max-width:120px;">Action</th>
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
<!-- Modal -->
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" method="POST">
<div class="modal fade" id="addmodal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Setting Pegawai</h4>
      </div>
      <div class="modal-body" id="body-addmodal">
        <center><i class='fa fa-spinner fa-spin'></i> Memuat data...</center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" onclick="$('#addmodal').modal('hide'); " class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
	function addmodal(id){
		
		$("#form_<?=$id_table?>").removeAttr("action");
		$("#form_<?=$id_table?>").attr("action","<?=site_url('pegawai/ajax_save/'.$id_table)?>");
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>pegawai/adddokter/"+id,
			success: function(data) {
				$("#addmodal").modal('show');
				$("#body-addmodal").html(data);
			}
		});
		return false;
	}
	function addmodaluser(id){
		$("#form_<?=$id_table?>").removeAttr("action");
		$("#form_<?=$id_table?>").attr("action","<?=site_url('pegawai/ajax_save_user/'.$id_table)?>");
		
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>pegawai/adduser/"+id,
			success: function(data) {
				$("#addmodal").modal('show');
				$("#body-addmodal").html(data);
			}
		});
		return false;
	}
		
</script>
