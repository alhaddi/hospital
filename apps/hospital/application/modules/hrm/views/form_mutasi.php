							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="mutasi[id]" value="<?=element('id',$row)?>">

										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Jabatan </label>
											<div class="col-sm-8">											
												<select name='mutasi[id_ms_jabatan]' class="form-control" id='id_ms_jabatan'>
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
											<label for="nip" class="control-label col-sm-4">Unit Kerja Asal</label>
											<div class="col-sm-8">											
												<select name='mutasi[id_ms_unit_kerja_asal]' class="form-control" id='id_ms_unit_kerja_asal'>
													<?php 
													if(element('id_ms_unit_kerja_asal',$row)){
														$array[]=element('id_ms_unit_kerja_asal',$row);
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
											<label for="nip" class="control-label col-sm-4">Unit Kerja Tujuan</label>
											<div class="col-sm-8">											
												<select name='mutasi[id_ms_unit_kerja_tujuan]' class="form-control" id='id_ms_unit_kerja_tujuan'>
													<?php 
													if(element('id_ms_unit_kerja_tujuan',$row)){
														$array[]=element('id_ms_unit_kerja_tujuan',$row);
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
												<select name='mutasi[id_ms_sub_unit_kerja]' class="form-control" id='id_ms_sub_unit_kerja'>
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
											<label for="no_ktp" class="control-label col-sm-4">Pangkat</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('pangkat',$row)?>" name="mutasi[pangkat]" id="pangkat" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">TMT</label>
											
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="mutasi[tmt]" id="tmt" value="<?=date("d/m/Y", strtotime(element('tmt',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('no_sk',$row)?>" name="mutasi[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Tgl SK</label>
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="mutasi[tgl_sk]" id="tgl_sk" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Penandatangan</label>
											<div class="col-sm-8">
												<input type="text" name="mutasi[penandatangan]" id="penandatangan" value="<?=element('penandatangan',$row)?>" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Tujuan Mutasi</label>
											<div class="col-sm-8">
												<textarea name="mutasi[tujuan]" id="tujuan" class="form-control" ><?=element('tujuan',$row)?></textarea>
											</div>
										</div>

									</div>
									
								</div>
							</div>
