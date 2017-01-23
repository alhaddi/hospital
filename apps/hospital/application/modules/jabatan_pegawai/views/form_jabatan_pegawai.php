
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog">
		<div class="modal-dialog" style="width:60%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<div class="row">
							<input type="hidden" name="id" id="id">
							<div class="col-sm-12 form-group">
									<label for="nama" class="control-label col-sm-2">Jenis Jabatan</label>
									<div class="col-sm-8">
										<select name="kode_jenis_jabatan" id="kode_jenis_jabatan" data-plugin="select2">
										<?php foreach($kode_jenis_jabatan as $r){ ?>
											<option value="<?=$r['kd']?>"><?=$r['nama']?></option>
										<?php } ?>
										</select>
									</div>
							</div>
							<div class="col-sm-12 form-group">
								
									<label for="nama" class="control-label col-sm-2">Nama Jabatan</label>
									<div class="col-sm-8">
										<input type="text" name="nama" id="nama" class="form-control" data-rule-required="true">
									</div>
							</div>
							<div class="col-sm-12 form-group">
								
									<label for="nama" class="control-label col-sm-2">Unit Kerja</label>
									<div class="col-sm-8">
										<select name="unit_kerja" id="unit_kerja" data-plugin="select2">
										<?php foreach($unit_kerja as $r){ ?>
											<option value="<?=$r['id']?>"><?=$r['nama']?></option>
										<?php } ?>
										</select>
									</div>
							</div>
							<div class="col-sm-6">
								<label for="nama" class="control-label col-sm-4 form-group">Esselon</label>
								<div class="col-sm-8 form-group">
									<select name="esselon" id="esselon" data-plugin="select2">
									<?php foreach($esselon as $r){ ?>
										<option value="<?=$r['kd']?>"><?=$r['nama']?></option>
									<?php } ?>
									</select>
								</div>
									
								<div class="col-sm-4 form-group">
								</div>
								<div class="col-sm-8 form-group">
									<input type="checkbox" name="jabatan_terakhir" value="0"> Jabatan Terakhir
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="nama" class="control-label col-sm-4">TMT Jabatan</label>
									<div class="col-sm-8">
										<input type="text" name="tmt_jabatan" id="tmt_jabatan" class="form-control" data-rule-required="true" data-plugin="datepicker">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
									<label class="control-label col-sm-4 form-group">Tanggal SK</label>
									<div class="col-sm-8 form-group">
										<input type="text" class="form-control" name="tanggal_sk" data-plugin="datepicker">
									</div>
									<label class="control-label col-sm-4 form-group">Nomor SK</label>
									<div class="col-sm-8 form-group">
										<input type="text" class="form-control" name="nomor_sk">
									</div>
									<label class="control-label col-sm-4 form-group">Penandatangan</label>
									<div class="col-sm-8 form-group">
										<input type="text" class="form-control" name="penandatangan">
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
