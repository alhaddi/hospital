					<div class="form-vertical">
						<input type="hidden" value="<?=element('id',$row)?>" name="id" id="id">
						<div class="form-group">
							<label for="nama" class="control-label">NIP</label>
							<input type="text" name="nip" value="<?=element('nip',$row)?>" id="nip" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Poliklinik</label>
							<select name="id_poliklinik[]" id="id_poliklinik" class="form-control " multiple data-rule-required="true" >
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
							<input type="text" name="spesialis" value="<?=element('spesialis',$row)?>" id="spesialis" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Nama</label>
							<input type="text" name="nama" id="nama" value="<?=element('nama',$row)?>" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">No Identitas</label>
							<input type="text" name="no_identitas" value="<?=element('no_identitas',$row)?>" id="no_identitas" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Tempat Lahir</label>
							<input type="text" name="tempat_lahir" value="<?=element('tempat_lahir',$row)?>" id="tempat_lahir" class="form-control" data-rule-required="true" ">
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Tanggal Lahir</label>
							<input type="text" name="tgl_lahir"  value="<?=element('tgl_lahir',$row)?>" id="tgl_lahir" class="form-control" data-rule-required="true">
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Jenis Kelamin</label><br>
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
								
						<div class="form-group">
							<label for="nama" class="control-label">Alamat</label>
							<textarea name="alamat" class='form-control'><?=element('alamat',$row)?></textarea>
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Telp</label>
							<input type="text" name="telp"  value="<?=element('telp',$row)?>" id="telp" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Handphone</label>
							<input type="text" name="hp" value="<?=element('hp',$row)?>" id="hp" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Email</label>
							<input type="text" name="email" value="<?=element('email',$row)?>" id="email" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Golongan Darah</label>
							<input type="text" name="gol_darah" value="<?=element('gol_darah',$row)?>" id="gol_darah" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Kode Golongan</label>
							<input type="text" name="kode_golongan"  value="<?=element('kode_golongan',$row)?>" id="kode_golongan" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Unit Kerja</label>
							<input type="text" name="unit_kerja"  value="<?=element('unit_kerja',$row)?>" id="unit_kerja" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Status Pegawai</label>
							<?php 
							if(element('status_pegawai',$row)){
								$l=(element('status_pegawai',$row) == 'PNS')?'selected':'';
								$p=(element('status_pegawai',$row) == 'TKK')?'selected':'';
							}else{
								$l=''; $p='';
							}
							?>
							<select name="status_pegawai" class='form-control'>
								<option <?=$l?>>PNS</option>
								<option <?=$p?>>TKK</option>
							</select>
						</div>
								
					</div>
<script>
$('select').select2();
</script>