					<div class="form-vertical">
					
						<input type="hidden" value="<?=element('id',$row)?>" name="id" id="id">
					
						<div class="form-group">
							<label for="nama" class="control-label">Status Pegawai *</label>
							<?php 
							if(element('status_pegawai',$row)){
								$l=(element('status_pegawai',$row) == 'PNS')?'selected':'';
								$p=(element('status_pegawai',$row) == 'TKK')?'selected':'';
							}else{
								$l=''; $p='';
							}
							?>
							<select onchange="changestatus();" id="status_pegawai" name="status_pegawai" class='form-control'>
								<option <?=$l?>>PNS</option>
								<option <?=$p?>>TKK</option>
							</select>
						</div>
																				
						<div class="form-group">
							<label for="nama" class="control-label">Nama *</label>
							<input type="text" name="nama" id="nama" value="<?=element('nama',$row)?>" class="form-control"  data-rule-required="true">
						</div>
						<?php 
						if(empty(element('id',$row))){
							$style="style='display:none;'";
							$style2="";
						?> 
						<div class="form-group">
							<label for="nama" class="control-label">Username *</label>
							<input type="text" name="username" id="username" class="form-control"  data-rule-required="true">
						</div>	
						<div class="form-group">
							<label for="nama" class="control-label">Password *</label>
							<input type="password" name="password" id="Password" class="form-control"  data-rule-required="true">
						</div>				
						<?php }else{
							$style="";
							$style2="style='display:none;'";
						} ?>
						<div class='tkk' >
						
						<div class="form-group">
							<label for="nama" class="control-label">No Registrasi </label>
							<input type="text" name="no_registrasi_pegawai" value="<?=element('no_registrasi_pegawai',$row)?>" id="no_registrasi_pegawai" class="form-control"  >
						</div>
						</div>								
						<div class='pns' >
						<div class="form-group">
							<label for="nama" class="control-label">NIP </label>
							<input type="text" name="nip" value="<?=element('nip',$row)?>" id="nip" class="form-control"  >
						</div>
						<div class="form-group">
							<label for="nama" class="control-label">Kode Golongan</label>
							<select name='id_ms_golongan' class="form-control" id='id_ms_golongan'>
								<?php 
								if(element('id_ms_golongan',$row)){
									$array=element('id_ms_golongan',$row);
								}else{
									$array=array();
								}
								foreach($id_ms_golongan as $r){ 
								$s=(in_array($r->kd,$array))?'selected':'';
								?>
									<option <?=$s?> value="<?=element('kd',$r)?>"><?=element('kd',$r)?> - <?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
					
						<div class="form-group">
							<label for="nama" class="control-label">Nama Jabatan</label>

												<select name='id_ms_jabatan' class="form-control" id='id_ms_jabatan'>
													<?php 
													if(element('id_ms_jabatan',$row)){
														$array=element('id_ms_jabatan',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_jabatan as $r){ 
													$s=(in_array($r->id,$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('kode_jenis_jabatan',$r).' - '.element('nama',$r)?></option>
													<?php } ?>
												</select>
						</div>
						</div>
						<div class="form-group">
							<label for="nama" class="control-label">Kedudukan Hukum </label><br>
							<?php 
							if(element('kedudukan_hukum',$row)){
								$l=(element('kedudukan_hukum',$row) == 'aktif')?'checked':'';
								$p=(element('kedudukan_hukum',$row) == 'tidakaktif')?'checked':'';
							}else{
								$l=''; $p='';
							}
							?>
							<input type="radio" name='kedudukan_hukum' value="Aktif" <?=$l?> id="jl"> <label for="jl">Aktif</label> 
							<input type="radio" name='kedudukan_hukum' value="Tidak Aktif" <?=$p?> id="jp"> <label for="jp">Tidak Aktif</label>
						</div>	
														
						<div class="form-group">
							<label for="nama" class="control-label">Jenis Kelamin </label><br>
							<?php 
							if(element('jk',$row)){
								$l=(element('jk',$row) == 'L')?'checked':'';
								$p=(element('jk',$row) == 'P')?'checked':'';
							}else{
								$l=''; $p='';
							}
							?>
							<input type="radio" name='jk' value="L" <?=$l?> id="jkl"> <label for="jkl">Laki-laki</label> 
							<input type="radio" name='jk' value="P" <?=$p?> id="jkp"> <label for="jkp">Perempuan</label>
						</div>
						<div id="more" <?=$style?>>
						<div class="form-group">
							<label for="nama" class="control-label">Poliklinik</label>
							<select name="id_poliklinik[]" id="id_poliklinik" class="form-control " multiple  >
								<option value=''>-- Pilih Poliklinik --</option>
								<?php
								if(element('id_poliklinik',$row)){
									$array=explode(',',element('id_poliklinik',$row));
								}else{
									$array=array();
								}
								foreach($poli as $r){ 
								$s=(in_array($r->id,$array))?'selected':'';
								?>
								<option <?=$s?> value='<?=$r->id?>'><?=$r->nama?></option>
								<?php } ?>
							</select>
						</div>
										
						<div class="form-group">
							<label for="nama" class="control-label">Spesialis</label>
							<input type="text" name="spesialis" value="<?=element('spesialis',$row)?>" id="spesialis" class="form-control"  >
						</div>

						<div class="form-group">
							<label for="nama" class="control-label">No Identitas</label>
							<input type="text" name="no_identitas" value="<?=element('no_identitas',$row)?>" id="no_identitas" class="form-control"  >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Tempat Lahir</label>
							<input type="text" name="tempat_lahir" value="<?=element('tempat_lahir',$row)?>" id="tempat_lahir" class="form-control"  ">
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Tanggal Lahir</label>
							<input type="text" name="tgl_lahir"  value="<?=element('tgl_lahir',$row)?>" id="tgl_lahir" class="form-control" >
						</div>

								
						<div class="form-group">
							<label for="nama" class="control-label">Alamat</label>
							<textarea name="alamat" class='form-control'><?=element('alamat',$row)?></textarea>
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Telp</label>
							<input type="text" name="telp"  value="<?=element('telp',$row)?>" id="telp" class="form-control"  >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Handphone</label>
							<input type="text" name="hp" value="<?=element('hp',$row)?>" id="hp" class="form-control"  >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Email</label>
							<input type="text" name="email" value="<?=element('email',$row)?>" id="email" class="form-control"  >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Golongan Darah</label>
							<input type="text" name="gol_darah" value="<?=element('gol_darah',$row)?>" id="gol_darah" class="form-control"  >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Unit Kerja</label>
												<select name='id_ms_unit_kerja' class="form-control" id='id_ms_unit_kerja'>
												<?php 
													if(element('id_ms_unit_kerja',$row)){
														$array=element('id_ms_unit_kerja',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_unit_kerja as $r){ 
													$s=(in_array($r->id,$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
						</div>

						</div>		
					
						<div id="m1" <?=$style2?>><center><a style="cursor:pointer;" onclick="showmore(1);">Tampilkan Semua Form</a></center></div>
						<div id="m2" <?=$style?>><center><a style="cursor:pointer;" onclick="showmore(2);">Sembunyikan Beberapa Form</a></center></div>
					</div>
<script>
$('select').select2();

function showmore(id){
	if(id == '1'){
		$('#more').show(1);
		$('#m1').hide(1);
		$('#m2').show(1);
	}else{
		$('#more').hide(1);
		$('#m1').show(1);
		$('#m2').hide(1);
	}
}
changestatus();
function changestatus(){
	var cek=$("#status_pegawai").val();
	if(cek =='PNS'){
		$(".pns").show(1);
		$(".tkk").hide(1);
	}else{
		$(".pns").hide(1);
		$(".tkk").show(1);
	}
}
</script>