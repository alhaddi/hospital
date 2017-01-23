				<input name="id" type="hidden" value="<?=element('id',$konsultasi)?>">
				<div class="form-vertical">
						<div class="form-group">
							<label for="textfield" class="control-label">Jenis Penunjang</label>
							<select name="penunjang[id_ms_penunjang]" onchange="load_kategori();" class="form-control" id="id_ms_penunjang" data-rule-required="true" >
								<option value="">-- Pilih Penunjang --</option>
								<?php foreach($this->db->get("ms_penunjang")->result_array() as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
												
						
						<div class="form-group">
							<label for="textfield" class="control-label">Dokter Pengirim</label>

							<select name="penunjang[id_dokter]" class="form-control" id="id_dokter" data-rule-required="true" >
								<option value="">-- Pilih Dokter --</option>
								<?php foreach($this->db->query("SELECT id,nama FROM ms_pegawai WHERE jenis_pegawai='dokter'")->result_array() as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
							</div>

						<div class="form-group">
							<label for="textfield" class="control-label">Klinis</label>
							<input name="penunjang[klinis]" class="form-control" id="nama_dokter" >
						</div>

						<div class="form-group">
							<label for="textfield" class="control-label">Total Bayar</label>
							<input name="penunjang[biaya]" class="form-control" id="biaya" data-rule-required="true" data-plugin="maskmoney">
						</div>

						
					</div>
<script>
$("#id_ms_penunjang").select2();
$("#id_dokter").select2();
</script>