
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
							<label for="nama" class="control-label">Nama *</label>
							<input type="text" name="nama" id="nama" class="form-control" data-rule-required="true" data-rule-maxlength="15">
						</div>
						<div class="form-group">
							<label for="nama" class="control-label">Kelas *</label>
							<input type="text" name="kelas" id="kelas" class="form-control" data-rule-required="true" >
						</div>
						<div class="form-group">
							<label for="nama" class="control-label">Tarif *</label>
							<input type="text" name="tarif" id="tarif" class="form-control" data-rule-required="true" >
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
