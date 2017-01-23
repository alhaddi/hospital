<div class="form-group">
	<input type="hidden" name="PasienID" value="<?=$PasienID?>">
	<label for="textfield" class="control-label">Poli Tujuan</label>
	<select name="Urut" class='form-control' onclick="detpoli($(this).val())">
		<?php 
			$n=1;
			foreach($query as $r){
				echo "<option value='$r->Urut'>Poliklinik $r->Urut</option>";
				$n++;
			}
		?>
		<option value="<?=$n?>">Poliklinik <?=$n?></option>
	</select>
	<input type="hidden" name="PasienID" id="PasienID" value="<?=$PasienID?>">
</div>
<div id="det_poli">
</div>
<script>
	function changebayar(id){
		if(id == 'BPJS'){
			$("#BPJS").show(1);
			$("#ASURANSI").hide(1);
			}else if(id == 'ASURANSI'){
			$("#ASURANSI").show(1);
			$("#BPJS").hide(1);
			}else if(id == 'KONTRAKTOR'){
			$("#ASURANSI").show(1);
			$("#BPJS").hide(1);
			}else{
			$("#ASURANSI").hide(1);
			$("#BPJS").hide(1);
		}
	}
	detpoli(1);
	function detpoli(Urut){
		var PasienID=$("#PasienID").val();
		$("#det_poli").load("<?=base_url()?>pasien/detailpoli/"+PasienID+"/"+Urut);
	}
</script>	