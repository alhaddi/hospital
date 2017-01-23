

<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">

	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>

				</div>

				<!-- /.modal-header -->

				<div class="modal-body">

					<div class="form-vertical">

						<input type="hidden" name="id_pagu" id="id_pagu">

						<div class="form-group">

							<label for"anggaran" class="control-label">ID Anggaran</label>

							<select name='id_anggaran' data-plugin="select2" class="form-control" id='id_anggaran'>

								<option value="">-- Pilih Anggaran --</option>

								<?php foreach($anggaran as $r){ ?>

									<option value="<?=element('id',$r)?>"><?=element('no_rekening',$r).' - '.element('nama_anggaran',$r)?></option>

								<?php } ?>

							</select>

						</div>

						

						<div class="form-group">

							<label for="pagu" class="control-label">Pagu</label>

							<input type="text" name="pagu" id="pagu" class="form-control" data-plugin="maskmoney">

						</div>

						

						<div class="form-group">

							<label for="id_periode" class="control-label">ID Periode</label>

							<select name='id_periode' data-plugin="select2" class="form-control" id='id_periode'>

								<option value="">-- Pilih Periode --</option>

								<?php foreach($periode as $r){ ?>

									<option value="<?=element('id',$r)?>"><?=element('nama_periode',$r)." - ".convert_tgl(element('tanggal',$r),'d M Y',1)?></option>

								<?php } ?>

							</select>

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