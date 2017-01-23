							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="pendidikan[id]" value="<?=element('id',$row)?>">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Jenis Pendidikan</label>
											<div class="col-sm-8">
												<select name="pendidikan[jenis_pendidikan]" value="<?=element('jenis_pendidikan',$row)?>" id="jenis_pendidikan"  class="form-control">
													<?php 
													$a=(element("jenis_pendidikan",$row) == 'formal')?'checked':'';
													$b=(element("jenis_pendidikan",$row) == 'non formal')?'checked':''; ?>
													<option <?=$a?>>formal</option>
													<option <?=$b?>>non formal</option>
												</select>
											</div>
										</div>
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Jenjang pendidikan </label>
											<div class="col-sm-8">											
												<select name='pendidikan[id_ms_jenjang]' class="form-control" id='id_ms_jenjang'>
													<?php 
													if(element('id_ms_jenjang',$row)){
														$array[]=element('id_ms_jenjang',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_jenjang as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Nama Sekolah </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('nama_sekolah',$row)?>" name="pendidikan[nama_sekolah]" id="nama_sekolah" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Program Studi </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('program_studi',$row)?>" name="pendidikan[program_studi]" id="program_studi" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Jurusan </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('jurusan',$row)?>" name="pendidikan[jurusan]" id="jurusan" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tahun Masuk </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("Y", strtotime(element('tahun_masuk',$row)));?>" name="pendidikan[tahun_masuk]" id="tahun_masuk" class="form-control" >
											</div>
										</div>		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tahun Lulus </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("Y", strtotime(element('tahun_lulus',$row)));?>" name="pendidikan[tahun_lulus]" id="tahun_lulus" class="form-control" >
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Lama Pendidikan </label>
											<div class="col-sm-6">											
												<input type="number" value="<?=element('lama_pendidikan',$row)?>" name="pendidikan[lama_pendidikan]" id="lama_pendidikan" class="form-control" >
											</div>
											<div class='col-sm-2'>
											 <b>Tahun</b>
											</div>
										</div>	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">No Ijazah </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=element('no_ijazah',$row)?>" name="pendidikan[no_ijazah]" id="no_ijazah" class="form-control" >
											</div>
										</div>				
		
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Tanggal Ijazah </label>
											<div class="col-sm-8">											
												<input type="text" value="<?=date("d/m/Y", strtotime(element('tgl_ijazah',$row)));?>" name="pendidikan[tgl_ijazah]" id="tgl_ijazah" class="form-control" >
											</div>
										</div>	
									</div>
									
								</div>
							</div>
