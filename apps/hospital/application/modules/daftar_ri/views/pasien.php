<?php $p = $this->input->get('p');
	$cr = $this->input->get('cr');
?>
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
						<!--a href="#myModal" data-toggle="modal" onclick="loadmby(); " class="btn btn-primary btn-mini">
							<i class="fa fa-plus"></i> Tambah 1
						</a-->
					</div>
				</div>
				<div class="box-content nopadding">
					<div class="table-responsive">
						<table id="<?=$id_table?>" class="table table-hover table-nomargin  table-bordered" 
						data-plugin="datatable-server-side" 
						data-datatable-list="<?=$datatable_list?>"
						data-datatable-delete="<?=$datatable_delete?>"
						data-datatable-multiselect="true"
						data-datatable-colvis="true"
						data-datatable-autorefresh="true"
						data-datatable-nocolvis="-2,-3"
						>
							<thead>
								<tr>
									<th class="with-checkbox" data-datatable-align="text-center">
										<input type="checkbox" name="check_all" data-datatable-checkall="true">
									</th>
									<th data-datatable-align="text-center" style="max-width:50px;">No.</th>
									<th data-datatable-align="text-center" style="max-width:100px">Rm</th>
									<th data-datatable-align="text-left">Nama Lengkap</th>
									<th data-datatable-align="text-center">No Identitas</th>
									<th data-datatable-align="text-center">Jenis Kelamin</th>
									<th data-datatable-align="text-center">Tarif</th>
									<th data-datatable-align="text-center">Ruang</th>
									<th data-datatable-align="text-left">Kamar</th>
									<th data-datatable-align="text-center">Tanggal Daftar</th>
									<th data-datatable-align="text-center">Last Update</th>
									<th data-datatable-align="text-center">Last User</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Kepulangan</h4>
      </div>
      <div class="modal-body" id="mby">
	  	<form  class='form-horizontal' data-plugin="form-validation" id="form_" action="<?=site_url('daftar_ri/save_pulang')?>" method="POST">
        <div class="">
		<input type="hidden" name="id_rawat_inap" id="id_trs_rawat_inap" >
		<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">Tanggal Pulang</label>
			<div class="col-sm-8">
				<input type="datetime"  name="tpulang" id="tpulang" class="form-control">
			</div>
		</div>		
		<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">Cara Keluar</label>
			<div class="col-sm-8">
				<select name="cara_keluar" class="form-control">
					<option value="PL">Pulang</option>
					<option value="PP">Pulang Paksa</option>
					<option value="RJK">Rujukan</option>
					<option value="Mati1">Meninggal kurang dr 48jam</option>
					<option value="Mati2">Meninggal lebih dr 48jam</option>
				</select>
			</div>
		</div>		
		<div class="form-group">
			<label for="textfield" class="control-label col-sm-4">Keterangan</label>
			<div class="col-sm-8">
				<textarea name="keterangan" class="form-control"></textarea>
			</div>
		</div>
		<center><button class='btn btn-info' onclick="save_data()" id="save_button"><i class='fa fa-save'></i> Simpan</button></center>		
		</div>
		</form>
	  </div>
    </div>
  </div>
</div>
<script>
		
	function save_data(){
		$.ajax({
			url	 :"<?=site_url('daftar_ri/save_pulang')?>",
			data :$('#form_').serialize(),
			type :"post",
			dataType	: 'json',
			beforeSend	: function() {
				$('#save_button').attr('disabled',true);
				$('#save_button').prop('disabled',true);
				$('#save_button').html('<i class="fa fa-spinner fa-spin"></i> Silahkan Tunggu',true);
			},
			success : function(jdata){
				console.log(jdata['status']);
				if(jdata.status == true)
				{
					swal({
						title: "Success !",
						text: jdata.message,
						type: "success"
						}).then(function() {
							window.location.reload(); 
					});
							$('#<?=$id_table?>').DataTable().ajax.reload();
							$("#myModal").modal('hide');
				}
				else if(jdata.status == false)
				{
					swal('Gagal !',jdata.message,'error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
				}
				else
				{
					swal('Gagal !','unkwon error','error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
				}
			},
			error : function(er){
					swal('Gagal !','Kesalahan jaringan, silahkan coba kembali','error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
			}
		});
	}
	


	
	$(document).ready(function(){
			$("#tpulang").datetimepicker({
			format:'d/m/Y H:i',
			mask:'39/19/2999 29:59',
			required :true
			});
	});
</script>