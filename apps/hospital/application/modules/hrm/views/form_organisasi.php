							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="organisasi[id]" value="<?=element('id',$row)?>">
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama Organisasi</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('nama',$row)?>" name="organisasi[nama]" id="nama" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Jabatan</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('jabatan',$row)?>" name="organisasi[jabatan]" id="jabatan" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No Periode</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_periode',$row)?>" name="organisasi[no_periode]" id="no_periode" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Mulai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_awal',$row)));?>" name="organisasi[tgl_awal]" id="tgl_awal" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Selesai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_akhir',$row)));?>" name="organisasi[tgl_akhir]" id="tgl_akhir" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_sk',$row)?>" name="organisasi[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>				
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tanggal SK </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" name="organisasi[tgl_sk]" id="tgl_sk" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penandatangan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('penandatangan',$row)?>" name="organisasi[penandatangan]" id="penandatangan" class="form-control" >
											</div>
										</div>
									</div>
									
								</div>
							</div>
