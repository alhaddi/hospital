
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog" id="modal_<?=$id_table?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<input type="hidden" name="id" id="id">
						<input type="hidden" name="time_jurnal" id="time_jurnal">
						<div class="form-group">
							<label for="jumlah" class="control-label">Jumlah</label>
							<input type="text" name="jumlah_jurnal" id="jumlah" class="form-control" data-plugin="maskmoney" data-rule-required="true">
						</div>
						<div class="form-group">
							<label for="tanggal" class="control-label">Tanggal</label>
							<input type="text" name="tanggal_jurnal" id="tanggal_jurnal" class="form-control" data-rule-required="true" data-plugin="datepicker">
						</div>
						<div class="form-group">
							<label for="uraian" class="control-label">Uraian</label>
							<textarea name="uraian" id="uraian" class="form-control" data-rule-required="true"></textarea>
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
<script>
	$('select').select2();
</script>
