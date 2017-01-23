<?php 
	$k=array();
	if($id != 0){
		$d = $this->db->select('
			trs_anamesa_detail.id_ms_anamesa,
			trs_anamesa_detail.hasil
		')
		->where('trs_anamesa_detail.id_anamesa',$id)
		->get('trs_anamesa_detail')->result();
	
			foreach($d as $r){
				$k[$r->id_ms_anamesa]=$r->hasil;
			}
		
		if(count($d) == 0){
		if(!empty($dokter_pengirim['id'])){
		$d = $this->db->select('
			trs_anamesa_detail.id_ms_anamesa,
			trs_anamesa_detail.hasil
		')
		->where('trs_anamesa_detail.id_anamesa',$dokter_pengirim['id'])
		->get('trs_anamesa_detail')->result();
	
			foreach($d as $r){
				$k[$r->id_ms_anamesa]=$r->hasil;
			}
		}
		else{
			$k=array();
			$dokter_pengirim=array();
		}
		}
			
	}
	else{
		if(!empty($dokter_pengirim['id'])){
		$d = $this->db->select('
			trs_anamesa_detail.id_ms_anamesa,
			trs_anamesa_detail.hasil
		')
		->where('trs_anamesa_detail.id_anamesa',$dokter_pengirim['id'])
		->get('trs_anamesa_detail')->result();
	
			foreach($d as $r){
				$k[$r->id_ms_anamesa]=$r->hasil;
			}
		}
		else{
			$k=array();
			$dokter_pengirim=array();
		}
	}
	
	if(!empty($row['keterangan'])){
		$keterangan=$row['keterangan'];
	}else{
		$keterangan=(!empty($dokter_pengirim['keterangan']))?$dokter_pengirim['keterangan']:'';
	}
?>
					<div class="form-horizontal">
						<input type="hidden" value="<?=element('id',$row)?>" name="id" id="id">
						<div class="row">
							<div class="col-sm-12">
							
								<?php if($konsultasi_pengirim['komponen'] == 3){ ?>
									<div class="form-group">
										<label for="keterangan" class="control-label col-sm-2">Dokter Pengirim</small></label>
										<div class="col-sm-8">
										<input type="text" value="<?= element('nama',$dokter_pengirim) ?>" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="keterangan" class="control-label col-sm-2">Poliklinik Pengirim</small></label>
										<div class="col-sm-8">
										<input type="text" value="<?= element('nama_poli',$dokter_pengirim) ?>" class="form-control" readonly>
										</div>
									</div>
									
									<hr>
								<?php } ?>
								<div class="form-group">
									<label for="keterangan" class="control-label col-sm-2">Dokter</small></label>
									<div class="col-sm-8">
									<select name="id_dokter" id="id_dokter" class="form-control" data-plugin="select2">
										<?php
										foreach($id_dokter as $r){ 
										$s=($r->id == element('id_dokter',$row))?'selected':'';
										?>
										<option <?=$s?> value='<?=$r->id?>'><?=$r->nama?></option>
										<?php } ?>
									</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<?php 
									$split = ceil(count($komponen_anamesa)/2);
									$x=0;
									foreach($komponen_anamesa as $komponen) { ?>
									
									
									<?php if($x==$split) { echo '</div><div class="col-sm-6">';  }?>
									<div class="form-group">
										<label for="komponen_<?=element('id',$komponen)?>" class="control-label col-sm-4"><?=element('nama',$komponen)?></label>
										<div class="col-sm-4">
										<?php 
										if(!empty($k[element('id',$komponen)])){
											$tampil=$k[element('id',$komponen)];
										}else{
											$tampil='';
										}?>
											<div class="input-group">
												<input type="text" value="<?=$tampil?>" name="komponen[<?=element('id',$komponen)?>]" id="komponen_<?=element('id',$komponen)?>" class="form-control" data-rule-number="true" >
												<span class="input-group-addon">
													<?=element('satuan',$komponen)?>
												</span>
											</div>
											
										</div>
									</div>
								<?php $x++;} ?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="keterangan" class="control-label col-sm-2">Keterangan</small></label>
									<div class="col-sm-8">
										<textarea name="keterangan" id="keterangan" class="form-control"><?=$keterangan?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
<script>
$('[data-plugin="select2"]').select2({
	placeholder: '-- Pilih Dokter --'
});
</script>