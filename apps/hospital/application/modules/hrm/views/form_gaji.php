							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="gaji[id]" value="<?=element('id',$row)?>">
			
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Gaji</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('gaji',$row)?>" name="gaji[gaji]" id="gaji" class="form-control" >
											</div>
										</div>					
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_sk',$row)?>" name="gaji[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>				
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">TMT </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tmt',$row)));?>" name="gaji[tmt]" id="tmt" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Perubahan Gaji </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('perubahan_gaji',$row)?>" name="gaji[perubahan_gaji]" id="perubahan_gaji" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Keterangan</label>
											<div class="col-sm-8">
												<textarea name="gaji[keterangan]" id="keterangan"  class="form-control"><?=element('keterangan',$row)?></textarea>
											</div>
										</div>

									</div>
									
								</div>
							</div>
