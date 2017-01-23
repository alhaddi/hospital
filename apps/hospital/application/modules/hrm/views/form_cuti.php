							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="cuti[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Keterangan</label>
											<div class="col-sm-8">
												<textarea name="cuti[keterangan]" id="keterangan"  class="form-control"><?=element('keterangan',$row)?></textarea>
											</div>
										</div>
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Berlaku </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_berlaku',$row)));?>" name="cuti[tgl_berlaku]" id="tgl_berlaku" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Mulai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_awal',$row)));?>" name="cuti[tgl_awal]" id="tgl_awal" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Selesai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_akhir',$row)));?>" name="cuti[tgl_akhir]" id="tgl_akhir" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_sk',$row)?>" name="cuti[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>				
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tanggal SK </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" name="cuti[tgl_sk]" id="tgl_sk" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penandatangan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('penandatangan',$row)?>" name="cuti[penandatangan]" id="penandatangan" class="form-control" >
											</div>
										</div>
									</div>
									
								</div>
							</div>
