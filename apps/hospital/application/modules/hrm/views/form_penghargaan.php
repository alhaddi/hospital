							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="penghargaan[id]" value="<?=element('id',$row)?>">
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Asal SK</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('asal_sk',$row)?>" name="penghargaan[asal_sk]" id="asal_sk" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama Penghargaan</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('nama',$row)?>" name="penghargaan[nama]" id="nama" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_sk',$row)?>" name="penghargaan[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl SK </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" name="penghargaan[tgl_sk]" id="tgl_sk" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penandatangan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('penandatangan',$row)?>" name="penghargaan[penandatangan]" id="penandatangan" class="form-control" >
											</div>
										</div>
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Keterangan</label>
											<div class="col-sm-8">
												<textarea name="penghargaan[keterangan]" id="keterangan"  class="form-control"><?=element('keterangan',$row)?></textarea>
											</div>
										</div>
									</div>
									
								</div>
							</div>
