
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
							<label for="nama" class="control-label">Nama</label>
							<input type="text" name="nama" id="nama" class="form-control" data-rule-required="true" data-rule-maxlength="50">
						</div>
						
						<div class="form-group">
							<label for="link" class="control-label">Link</label>
							<input type="text" name="link" id="link" class="form-control"  data-rule-maxlength="255">
						</div>
						
						<div class="form-group">
							<label for="urut" class="control-label">Urut</label>
							<input type="text" name="urut" id="urut" class="form-control"  >
						</div>
						
						<div class="form-group">
							<label for="icon" class="control-label">Icon</label>
							<input type="text" name="icon" id="icon" class="form-control"  data-rule-maxlength="50">
						</div>
						
						<div class="form-group">
							<label for="parent_id" class="control-label">Parent Id</label>
							<input type="text" name="parent_id" id="parent_id" class="form-control" data-rule-required="true" >
						</div>
						
						<div class="form-group">
							<label for="dashboard" class="control-label">Dashboard</label>
							<input type="text" name="dashboard" id="dashboard" class="form-control"  >
						</div>
						
						<div class="form-group">
							<label for="warna_dashboard" class="control-label">Warna Dashboard</label>
							<input type="text" name="warna_dashboard" id="warna_dashboard" class="form-control"  data-rule-maxlength="9">
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
