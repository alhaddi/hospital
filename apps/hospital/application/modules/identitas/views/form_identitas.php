<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered">
				<div class="box-title">
					<h3>
					<i class="fa fa-th-list"></i><?=$title?></h3>
				</div>
				<div class="box-content nopadding">
					<form id="form_<?=$id_table?>" data-plugin="form-validation" action="<?=site_url($form_save)?>" method="POST">
						<input type="hidden" name="id" id="id"  value="<?=element('id',$row)?>">
						<div class="form-horizontal form-bordered">
							<div class="form-group">
								<label for="nama" class="control-label col-sm-2">Nama</label>
								<div class="col-sm-10">
									<input type="text" name="nama" id="nama"  value="<?=element('nama',$row)?>" class="form-control" data-rule-required="true" data-rule-maxlength="100">
								</div>
							</div>
							<div class="form-group">
								<label for="alamat" class="control-label col-sm-2">Alamat</label>
								<div class="col-sm-10">
									<textarea name="alamat" id="alamat"  class="form-control" data-rule-required="true" data-rule-maxlength="65535"><?=element('alamat',$row)?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="tlp" class="control-label col-sm-2">Tlp</label>
								<div class="col-sm-10">
									<input type="text" name="tlp" id="tlp" value="<?=element('tlp',$row)?>" class="form-control" data-rule-required="true" data-rule-maxlength="15">
								</div>
							</div>
							<div class="form-group">
								<label for="fax" class="control-label col-sm-2">Fax</label>
								<div class="col-sm-10">
									<input type="text" name="fax" id="fax" value="<?=element('fax',$row)?>" class="form-control"  data-rule-maxlength="15">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="control-label col-sm-2">E-mail</label>
								<div class="col-sm-10">
									<input type="text" name="email" id="email" value="<?=element('email',$row)?>" class="form-control" data-rule-email="true" data-rule-maxlength="100">
								</div>
							</div>
							<div class="form-group">
								<label for="website" class="control-label col-sm-2">Website</label>
								<div class="col-sm-10">
									<input type="text" name="website" id="website" value="<?=element('website',$row)?>" class="form-control" data-rule-url="true" data-rule-maxlength="100">
								</div>
							</div>
							<div class="form-group">
								<label for="logo" class="control-label col-sm-2">Logo</label>
								<div class="col-sm-10">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											<?=get_img('img/'.element('logo',$row),'no-image')?>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
										<div>
											<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input id="logo" type="file" name="logo" <?=(is_file(FILES_PATH.'/img/'.element('logo',$row)))?"":'data-rule-required="true"'?>>
											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
