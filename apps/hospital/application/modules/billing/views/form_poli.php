					<div class="form-vertical">
						<input type="hidden" name="id_billing" value="<?=$id_billing?>" >	
						<div class="form-group">
							<label for="textfield" class="control-label">Pelayanan Medik</label>
							<select name="id_komponen_registrasi" class="form-control" id="id_komponen_registrasi" data-rule-required="true" >
								<?php foreach($id_komponen_registrasi as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="form-group">
							<label for="textfield" class="control-label">Poli Tujuan</label>
							<select name="id_poliklinik" class="form-control" id="id_poliklinik" data-rule-required="true" >
								<option value="">-- Pilih Poliklinik --</option>
								<?php foreach($poliklinik as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
					</div>
