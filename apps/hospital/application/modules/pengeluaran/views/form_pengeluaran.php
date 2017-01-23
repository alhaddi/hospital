
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog" id="modal_<?=$id_table?>">
		<div class="modal-dialog" style="width: 80%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-horizontal">
						<input type="hidden" name="id_blud" id="id_blud">
						<input type="hidden" name="time_blud" id="time_blud">
						<input type="hidden" name="status" id="status">
						
						<div class="row">
							<div class="col-sm-6">

								<div class="form-group">
									<label for="id_anggaran" class="control-label col-sm-4">Jenis Biaya</label>
									<div class="col-sm-6">
										<select  name='id_anggaran' class="form-control" id='id_anggaran' data-plugin="select2">
										<option value="">-- Pilih Anggaran --</option>
										<?php foreach($anggaran as $r){?>
											<option value="<?=element('id',$r)?>"><?=element('no_rekening',$r).' - '.element('nama_anggaran',$r)?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="no_cek" class="control-label col-sm-4">No.Cek</label>
									<div class="col-sm-6">
										<input type="text" name="no_cek" id="no_cek" class="form-control" data-rule-required="true">
									</div>
								</div>
								
								<div class="form-group">
									<label for="no_cek" class="control-label col-sm-4">Tanggal</label>
									<div class="col-sm-6">
										<input type="text" name="tgl_blud" id="tgl_blud" class="form-control" data-rule-required="true" data-plugin="datepicker">
									</div>
								</div>
								
								<div class="form-group">
									<label for="jumlah" class="control-label col-sm-4">Jumlah</label>
									<div class="col-sm-6">
										<input type="text" name="jumlah" id="jumlah" class="form-control" data-plugin="maskmoney" data-rule-required="true">
									</div>
								</div>
							</div>
							<div class="col-sm-6">		
								<div class="form-group">
									<label for="ppn" class="control-label col-sm-4">PPn</label>
									<div class="col-sm-1">
										<input type="checkbox" id="ppn" name="ppn">
									</div>
									<div class="col-sm-5">
										<input type="text" name="ppn_money" id="ppn_money" class="form-control" data-plugin="maskmoney" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="id_kategori_pph" class="control-label col-sm-4">Kategori PPh</label>
									<div class="col-sm-6">
										<select name='id_kategori_pph' class="form-control" id='id_kategori_pph' data-plugin="select2">
										<option value="">-- Pilih Kategori PPh--</option>
										<?php foreach($kategori_pph as $r){?>
											<option value="<?=element('id',$r)?>"><?=element('nama_pph',$r)?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="pph" class="control-label col-sm-4">PPh</label>
									<div class="col-sm-6">
										<input type="text" name="pph" id="pph" class="form-control" data-plugin="maskmoney">
									</div>
								</div>
								
								<div class="form-group">
									<label for="setoran" class="control-label col-sm-4">Kategori Belanja</label>
									<div class="col-sm-2">
										<input type="radio" name="ls" id="ls" value="LS"> LS
									</div>
									<div class="col-sm-2">
										<input type="radio" name="ls" id="gu" value="GU"> GU 
									</div>
									<div class="col-sm-2"> 
										<input type="radio" name="ls" id="tup" value="TUP"> TUP
									</div>								
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
									<label for="uraian" class="control-label">Uraian</label>
									<textarea name="uraian" id="uraian" class="form-control" data-rule-required="true"></textarea>
							</div>
						</div>
								
					</div>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</form>
<script>
var strppn = 0;
	
$(document).ready(function(){
	setStrpph(0);
		$('[name="ppn"]').on("click",function(){
			strppn = $('[name="ppn_money"]').val();
			var id = $(this).val();
			if($('#ppn').attr('checked') == true || $('#ppn').prop('checked') == true){
				console.log('click');
				var str = $('[name="jumlah"]').val();				
				var res = str.replace('Rp ','');
				var jumlah = res.split('.').join('');
				if(jumlah>1000000){
					jumlah = (jumlah/11).toFixed(0);
					setStrpph(jumlah);
					$('[name="ppn_money"]').val(''+jumlah);
				}else{
					$('[name="ppn_money"]').val('0');
				}
			} else {
				console.log('hilang');
				setStrpph(0);
				$('[name="ppn_money"]').val('');
			}
		}).trigger('change');
		
		$('[name="id_kategori_pph"]').on("change",function(){
			var id = $(this).val();
			if(id == '2'){
				var str = $('[name="jumlah"]').val();
				var res = str.replace('Rp ','');
				var jumlah = res.split('.').join('');
				if(jumlah>2000000){
					console.log(getStrpph());
					var jumlah = (jumlah-getStrpph())*0.015;
					$('[name="pph"]').val(''+jumlah.toFixed(0));
				}else{
					$('[name="pph"]').val('0');
				}
				$('[name="pph"]').attr('readonly',true);
				$('[name="pph"]').prop('readonly',true);
				$('[name="pph"]').attr('readonly',true);
				$('[name="pph"]').prop('readonly',true);
			} else {
				$('[name="pph"]').removeAttr('readonly');
				$('[name="pph"]').removeProp('readonly');
				$('[name="pph"]').removeAttr('readonly');
				$('[name="pph"]').removeProp('readonly');
				$('[name="pph"]').val('');
			}
		}).trigger('change');
		
		
	});
	
	function test(){
		var id = $('[name="id_kategori_pph"]').val();
		if(id == '2'){
			var str = $('[name="jumlah"]').val();
			var res = str.replace('Rp ','');
			var jumlah = res.split('.').join('');
			if(jumlah>2000000){
				console.log(getStrpph());
				var jumlah = (jumlah-getStrpph())*0.015;
				$('[name="pph"]').val(''+jumlah.toFixed(0));
			}else{
				$('[name="pph"]').val('0');
			}
			$('[name="pph"]').attr('readonly',true);
			$('[name="pph"]').prop('readonly',true);
			$('[name="pph"]').attr('readonly',true);
			$('[name="pph"]').prop('readonly',true);
		} else {
			$('[name="pph"]').removeAttr('readonly');
			$('[name="pph"]').removeProp('readonly');
			$('[name="pph"]').removeAttr('readonly');
			$('[name="pph"]').removeProp('readonly');
			$('[name="pph"]').val('');
		}
	}
	
	
	function setStrpph(pph){
		strpph = pph;
	}
	function getStrpph(){
		return strpph;
	}
</script>