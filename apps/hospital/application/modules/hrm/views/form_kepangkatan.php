							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="kepangkatan[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Gol / Ruang</label>
											<div class="col-sm-8">
											<select name='kepangkatan[golongan]' class="form-control" id='golongan'>
													<?php 
													if(element('golongan',$row)){
														$array[]=element('golongan',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_golongan as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('kd',$r)?>"><?=element('kd',$r)?> - <?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Pangkat </label>
											<div class="col-sm-8">
												<input name="kepangkatan[pangkat]" value="<?=element('pangkat',$row)?>" id="jenis_kepangkatan"  class="form-control" type="text">
											</div>
										</div>	
										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">esselon</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('esselon',$row)?>" name="kepangkatan[esselon]" id="esselon" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">TMT</label>
											
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="kepangkatan[tmt]" id="tmt" value="<?=date("d/m/Y", strtotime(element('tmt',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">No SK</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('no_sk',$row)?>" name="kepangkatan[no_sk]" id="no_sk" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Tgl SK</label>
											<div class="col-sm-8">
												<input type="text" data-plugin="datepicker" name="kepangkatan[tgl_sk]" id="tgl_sk" value="<?=date("d/m/Y", strtotime(element('tgl_sk',$row)));?>" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Penandatangan</label>
											<div class="col-sm-8">
												<input type="text" name="kepangkatan[penandatangan]" id="penandatangan" value="<?=element('penandatangan',$row)?>" class="form-control" >
											</div>
										</div>

									</div>
									
								</div>
							</div>
