<div class="form-group">
	<label for="textfield" class="control-label">Poli Tujuan</label>
	<select name='poliklinik' class="form-control" id='poliklinik'>
		<?php
			$s="";
			foreach($this->db->get('ms_poliklinik')->result() as $r){
				if(element('PoliklinikID',$row)){
					$s=(element('PoliklinikID',$row) == $r->ID)?'selected':'';
				}
			?>
			<option <?=$s?> value='<?=$r->ID?>'><?=$r->nama?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<label for="textfield" class="control-label">Cara Pembayaran</label>
	<select name='cara_pembayaran' onchange="changebayar($(this).val());" class="form-control" id='cara_pembayaran'>
		<option <?=(element('CaraPembayaran',$row) == 'UMUM')?'selected':'';?> value='UMUM'>UMUM</option>
		<option <?=(element('CaraPembayaran',$row) == 'BPJS')?'selected':'';?> value="BPJS">BPJS</option>
		<option <?=(element('CaraPembayaran',$row) == 'ASURANSI')?'selected':'';?> value="ASURANSI">ASURANSI</option>
		<option <?=(element('CaraPembayaran',$row) == 'KONTRAKTOR')?'selected':'';?> value="KONTRAKTOR">KONTRAKTOR</option>
	</select>
</div>
<div id="BPJS" style="display:none;">
	<div class="form-group">
		<label for="textfield" class="control-label">Tipe BPJS</label>
		<select name='BPJS_type' class="form-control" id='BPJS_type'>
			<?php foreach($this->db->get('ms_bpjs_type')->result() as $r){ 		
				$s=(element('TipeBPJS',$row) == $r->ID)?'selected':'';
			?>
			<option <?=$s?> value='<?=$r->ID?>'><?=$r->nama?></option>
			<?php } ?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="textfield" class="control-label">ID BPJS</label>
		<input type="text" value="<?=element('ID_BPJS',$row)?>" name="ID_BPJS" id="ID_BPJS" class="form-control" >
	</div>
	
</div>
<div id="ASURANSI" style="display:none;">
	
	<div class="form-group">
		<label for="textfield" class="control-label">No Polis</label>
		<input type="text" name="No_Polis" value="<?=element('No_Polis',$row)?>" id="No_Polis" class="form-control" >
	</div>
	
	<div class="form-group">
		<label for="textfield" class="control-label">Nama Perusahaan</label>
		<input type="text" name="Nama_Perusahaan" value="<?=element('Nama_Perusahaan',$row)?>" id="ID_BPJS" class="form-control" >
	</div>
	
</div>
