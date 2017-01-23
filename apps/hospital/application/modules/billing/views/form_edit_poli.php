					<div class="form-vertical">
						<input type="hidden" name="id_appoinment" value="<?=$cekpoli->id?>" >	
						<div class="form-group">
							<label for="textfield" class="control-label">Cara Bayar</label>
							<select name="id_cara_bayar" class="form-control" id="id_cara_bayar" data-rule-required="true" >
								<?php foreach($cara_bayar as $r){
 									$s=($r['id'] == $cekpoli->id_cara_bayar)?'selected':'';
								?>
									<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="form-group">
							<label for="textfield" class="control-label">Poli Tujuan</label>
							<select name="id_poliklinik" class="form-control" id="id_poliklinik" data-rule-required="true" >
								<option value="">-- Pilih Poliklinik --</option>
								<?php foreach($poliklinik as $r){ 
									$s=($r['id'] == $cekpoli->id_poliklinik)?'selected':'';
								?>
									<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
					</div>
