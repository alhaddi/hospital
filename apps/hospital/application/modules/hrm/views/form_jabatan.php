							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="jabatan[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Status Jabatan</label>
											<div class="col-sm-8">
												<input style='display:none;' name="jabatan[jenis_jabatan]" value="<?=element('jenis_jabatan',$row)?>" id="jenis_jabatan"  class="form-control" type="text"><br>
												Jabatan terakhir ? <input <?=(element('jabatan_terakhir',$row) == '1')?'checked':''?> name="jabatan[jabatan_terakhir]" value="1" id="jabatan_terakhir"   type="checkbox">
											</div>
										</div>
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama Jabatan </label>
											<div class="col-sm-8">											
												<select name='jabatan[id_ms_jabatan]' class="form-control" id='id_ms_jabatan'>
													<?php 
													if(element('id_ms_jabatan',$row)){
														$array[]=element('id_ms_jabatan',$row);
													}else{
														$array=array();
													}
													foreach($ms_jabatan as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Unit Kerja </label>
											<div class="col-sm-8">											
												<select name='jabatan[id_ms_unit_kerja]' class="form-control" id='id_ms_unit_kerja'>
													<?php 
													if(element('id_ms_unit_kerja',$row)){
														$array[]=element('id_ms_unit_kerja',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_unit_kerja as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Sub Unit Kerja </label>
											<div class="col-sm-8">											
												<select name='jabatan[id_ms_sub_unit_kerja]' class="form-control" id='id_ms_sub_unit_kerja'>
													<?php 
													if(element('id_ms_sub_unit_kerja',$row)){
														$array[]=element('id_ms_sub_unit_kerja',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_unit_kerja as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">esselon</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('esselon',$row)?>" name="jabatan[esselon]" id="esselon" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">TMT</label>
											
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="jabatan[tmt]" id="tmt" value="<?=date("d/m/Y", strtotime(element('tmt',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('no_sk',$row)?>" name="jabatan[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Tgl SK</label>
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="jabatan[tgl_sk]" id="tgl_sk" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Penandatangan</label>
											<div class="col-sm-8">
												<input type="text" name="jabatan[penandatangan]" id="penandatangan" value="<?=element('penandatangan',$row)?>" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Status</label>
											<div class="col-sm-8">
												<textarea name="jabatan[status]" id="status" class="form-control" ><?=element('status',$row)?></textarea>
											</div>
										</div>

									</div>
									
								</div>
							</div>
