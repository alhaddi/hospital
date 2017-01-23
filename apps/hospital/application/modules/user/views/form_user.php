
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<input type="hidden" name="id" id="id">
						<div class="form-group">
							<label for="kode_user" class="control-label">Kode User</label>
							<input type="text" name="kode_user" id="kode_user" class="form-control" data-rule-required="true" data-rule-maxlength="20">
						</div>
						
						<div class="form-group">
							<label for="nama" class="control-label">Nama</label>
							<input type="text" name="nama" id="nama" class="form-control" data-rule-required="true" data-rule-maxlength="100">
						</div>
						
						<div class="form-group">
							<label for="no_identitas" class="control-label">No Identitas</label>
							<input type="text" name="no_identitas" id="no_identitas" class="form-control" data-rule-required="true" data-rule-maxlength="50">
						</div>
						
						<div class="form-group">
							<label for="jk" class="control-label">Jk</label>
							<input type="text" name="jk" id="jk" class="form-control" data-rule-required="true" data-rule-maxlength="1">
						</div>
						
						<div class="form-group">
							<label for="tempat_lahir" class="control-label">Tempat Lahir</label>
							<input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" data-rule-required="true" data-rule-maxlength="50">
						</div>
						
						<div class="form-group">
							<label for="tgl_lahir" class="control-label">Tgl Lahir</label>
							<input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" data-rule-required="true" >
						</div>
						
						<div class="form-group">
							<label for="alamat" class="control-label">Alamat</label>
							<textarea name="alamat" id="alamat" class="form-control" data-rule-required="true" data-rule-maxlength="65535"></textarea>
						</div>
						
						<div class="form-group">
							<label for="telp" class="control-label">Telp</label>
							<input type="text" name="telp" id="telp" class="form-control"  data-rule-maxlength="15">
						</div>
						
						<div class="form-group">
							<label for="hp" class="control-label">Hp</label>
							<input type="text" name="hp" id="hp" class="form-control" data-rule-required="true" data-rule-maxlength="20">
						</div>
						
						<div class="form-group">
							<label for="email" class="control-label">Email</label>
							<input type="text" name="email" id="email" class="form-control"  data-rule-maxlength="100">
						</div>
						
						<div class="form-group">
							<label for="foto" class="control-label">Foto</label>
							<input type="text" name="foto" id="foto" class="form-control"  data-rule-maxlength="255">
						</div>
								
					</div>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</form>
