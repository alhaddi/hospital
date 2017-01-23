<?php 
if(empty($row)){
	$m='';
	$row=array();
	$array=array();
}else{
	$this->db->select('id_menu');
	$this->db->where('username',element('username',$row));
	foreach($this->db->get('sys_akses_menu')->result() as $r){
		$m[]=$r->id_menu;
	}
	$array=implode(',',$m);
}
?>
					<div class="form-vertical">
						<input type="hidden" value="<?=$id_pegawai?>" name="id_pegawai" id="id_pegawai">
						<input type="hidden" value="<?=element('id_user',$row)?>" name="id_user" id="id_user">
						<div class="form-group">
							<label for="nama" class="control-label">Username</label>
							<input type="text" name="username" value="<?=element('username',$row)?>" id="username" class="form-control" data-rule-required="true" >
						</div>
								
						<div class="form-group">
							<label for="nama" class="control-label">Password</label>
							<input type="password" name="password" class="form-control" data-rule-required="true" >
						</div>
														
						<div class="form-group">
							<label for="nama" class="control-label">Poliklinik yg dpt diakses</label>
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
							<label for="nama" class="control-label">Menu yg dpt diakses</label>
							<select name="menu[]" id="menu" class="form-control " multiple data-rule-required="true" >
								<option value=''>-- Pilih Menu --</option>
								<?php
								foreach($menu as $r){ 
								$s=(in_array($r->id,$array))?'selected':'';
								?>
								<option <?=$s?> value='<?=$r->id?>'><?=$r->nama?></option>
								<?php } ?>
							</select>
						</div>
							
																				
						<div class="form-group">
							<label for="nama" class="control-label">Penunjang yg dpt diakses</label>
							<select name="id_penunjang[]" id="id_penunjang" class="form-control " multiple data-rule-required="true" >
								<option value=''>-- Pilih Penunjang --</option>
								<?php
								if(element('id_penunjang',$row)){
									$array=explode(',',element('id_penunjang',$row));
								}else{
									$array=array();
								}
								foreach($penunjang as $r){ 
								$s=(in_array($r->id,$array))?'selected':'';
								?>
								<option <?=$s?> value='<?=$r->id?>'><?=$r->nama?></option>
								<?php } ?>
							</select>
						</div>
								
					</div>
<script>
$('select').select2();
</script>