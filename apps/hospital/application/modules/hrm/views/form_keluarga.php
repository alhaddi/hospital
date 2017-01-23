							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="keluarga[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Hubungan</label>
											<div class="col-sm-8">
												<select name="keluarga[hubungan]" id="hubungan"  class="form-control">
													<?php 
													$a=(element("hubungan",$row) == 'suami')?'checked':'';
													$b=(element("hubungan",$row) == 'istri')?'checked':''; 
													$c=(element("hubungan",$row) == 'anak')?'checked':''; 
													$d=(element("hubungan",$row) == 'orang tua')?'checked':''; 
													$e=(element("hubungan",$row) == 'saudara')?'checked':''; 
													?>
													<option <?=$a?>>suami</option>
													<option <?=$b?>>istri</option>
													<option <?=$c?>>anak</option>
													<option <?=$d?>>orang tua</option>
													<option <?=$e?>>saudara</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('nama_lengkap',$row)?>" name="keluarga[nama_lengkap]" id="nama_lengkap" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir </label>
											
											<div class="col-sm-3">
												<input value="<?=element('tempat_lahir',$row)?>" type="text" name="keluarga[tempat_lahir]" id="tempat_lahir" class="form-control" >
											</div>
											<div class="col-sm-3">
												<input type="text" data-plugin="datepicker" name="keluarga[tgl_lahir]" id="keluarga[tgl_lahir]" value="<?=date("d/m/Y", strtotime(element('tgl_lahir',$row)));?>" class="form-control" >
											</div>
											<div class="col-sm-2">
												<input type="text" name="keluarga[usia]" value="<?=element('usia',$row)?>" id="keluarga[usia]" placeholder="Usia" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Pekerjaan </label>
											<div class="col-sm-8">											
												<select name='keluarga[id_ms_pekerjaan]' class="form-control" id='id_ms_pekerjaan'>
													<?php 
													if(element('id_ms_pekerjaan',$row)){
														$array[]=element(id_ms_pekerjaan);
													}else{
														$array=array();
													}
													foreach($id_ms_pekerjaan as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Pendidikan Terakhir </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('pendidikan_terakhir',$row)?>" name="keluarga[pendidikan_terakhir]" id="pendidikan_terakhir" class="form-control" >
											</div>
										</div>				
		
									</div>
									
								</div>
							</div>
