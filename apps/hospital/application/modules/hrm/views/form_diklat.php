							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="diklat[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Jenis</label>
											<div class="col-sm-8">
												<select name="diklat[jenis]" value="<?=element('jenis',$row)?>" id="jenis_diklat"  class="form-control">
													<?php 
													$a=(element("jenis",$row) == 'diklat')?'checked':'';
													$b=(element("jenis",$row) == 'pelatihan')?'checked':''; ?>
													<option <?=$a?>>diklat</option>
													<option <?=$b?>>pelatihan</option>
												</select>
											</div>
										</div>
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama  </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('nama',$row)?>" name="diklat[nama]" id="nama" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penyelenggara </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('penyelenggara',$row)?>" name="diklat[penyelenggara]" id="penyelenggara" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Jml Jam </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('jml_jam',$row)?>" name="diklat[jml_jam]" id="jml_jam" class="form-control" >
											</div>
										</div>			
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Predikat </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('predikat',$row)?>" name="diklat[predikat]" id="predikat" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Angkatan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('angkatan',$row)?>" name="diklat[angkatan]" id="angkatan" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Mulai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tahun_masuk',$row)));?>" name="diklat[tgl_mulai]" id="tgl_mulai" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tgl Selesai </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_selesai',$row)));?>" name="diklat[tgl_selesai]" id="tgl_selesai" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No Ijazah </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_ijazah',$row)?>" name="diklat[no_ijazah]" id="no_ijazah" class="form-control" >
											</div>
										</div>				
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tanggal Ijazah </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_ijazah',$row)));?>" name="diklat[tgl_ijazah]" id="tgl_ijazah" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penandatangan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('penandatangan',$row)?>" name="diklat[penandatangan]" id="penandatangan" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tempat </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('tempat',$row)?>" name="diklat[tempat]" id="tempat" class="form-control" >
											</div>
										</div>		
									</div>
									
								</div>
							</div>
