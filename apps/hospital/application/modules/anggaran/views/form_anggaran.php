

<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">

	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog">

		<div class="modal-dialog" style="width: 75%">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>

				</div>

				<!-- /.modal-header -->

				<div class="modal-body">

					<div class="form-horizontal">

						<input type="hidden" name="id" id="id">

						<div class="row">

							<div class="col-sm-12">

								<div class="form-group">

									<label for="nama" class="control-label col-sm-2">Nama</label>

									<div class="col-sm-10">

										<input type="text" name="nama_anggaran" id="nama_anggaran" class="form-control" data-rule-required="true" data-rule-maxlength="50">

									</div>

								</div>

								

								<div class="form-group">

									<label for="no_rekening" class="control-label col-sm-2">No Rekening</label>

									

									<div class="col-sm-1">

									<input type="text" name="no1" id="no1" class="form-control" placeholder="0" data-rule-required="true" data-rule-maxlength="1" maxlength="1">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no2" id="no2" class="form-control" placeholder="0" data-rule-required="true" data-rule-maxlength="1" maxlength="1">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no3" id="no3" class="form-control" placeholder="0" data-rule-required="true" data-rule-maxlength="1" maxlength="1">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no4" id="no4" class="form-control" placeholder="00" data-rule-required="true" data-rule-minlength="2" data-rule-maxlength="2" maxlength="2">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no5" id="no5" class="form-control" placeholder="00" data-rule-required="true" data-rule-minlength="2" data-rule-maxlength="2" maxlength="2">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no6" id="no6" class="form-control" placeholder="000" data-rule-required="true" data-rule-maxlength="3" maxlength="3">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no7" id="no7" class="form-control" placeholder="0" data-rule-required="true" data-rule-maxlength="1" maxlength="1">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no8" id="no8" class="form-control" placeholder="0" data-rule-maxlength="1" maxlength="1">

									</div>

									<div class="col-sm-1">

									<input type="text" name="no9" id="no9" class="form-control" placeholder="0" data-rule-maxlength="1" maxlength="1">

									</div>


								</div>

														

								<div class="form-group">

									<label for="parent_id" class="control-label col-sm-2">Parent</label>

									<div class="col-sm-10">

										<select name='parent_id' data-plugin="select2" class="form-control" id='parent_id'>

											<option value="0">-- Pilih Parent --</option>

											<?php foreach($pr as $r){ ?>
		
												<option value="<?=element('id',$r)?>"><?=element('nama_anggaran',$r)?></option>
		
											<?php } ?>
										</select>

									</div>

								</div>

							</div>

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
