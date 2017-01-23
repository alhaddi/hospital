
<form id="form_<?=$id_table?>" method="post">
	<div class="modal fade in" role="dialog" id="modal_<?=$id_table?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<input type="hidden" name="tgl1" id="tgl1">
						<input type="hidden" name="tgl2" id="tgl2">
						<div class="form-group">
							<label for="jumlah" class="control-label">Saldo Bulan Lalu</label>
							<input type="text" name="saldo" id="saldo" class="form-control" data-plugin="maskmoney" data-rule-required="true">
						</div>
						<div class="form-group">
							<label for="tanggal" class="control-label">Jumlah Penerimaan Bulan Lalu</label>
							<input type="text" name="penerimaan" id="penerimaan" class="form-control" data-plugin="maskmoney" data-rule-required="true">
						</div>
						<div class="form-group">
							<label for="uraian" class="control-label">Jumlah Pengeluaran Bulan Lalu</label>
							<input type="text" name="pengeluaran" id="pengeluaran" class="form-control" data-plugin="maskmoney" data-rule-required="true">
						</div>
					</div>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> OK</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</form>
<script>
$(document).ready(function(){
	$('#form_<?=$id_table?>').on('submit',function(){
		var d1=$("#tgl1").val();
		var d2=$("#tgl2").val();
		var tgl1=d1.split("/");
		var tgl2=d2.split("/");
		var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0]+" 00:00:00";
		var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0]+" 23:59:59";
		var saldo = $('#saldo').val();
		var penerimaan = $('#penerimaan').val();
		var pengeluaran = $('#pengeluaran').val();
		window.open('<?=base_url()?>buku_kas_umum/pdf_buku_kas?tgl1='+t1+'&tgl2='+t2+'&saldo='+saldo+'&penerimaan='+penerimaan+'&pengeluaran='+pengeluaran);
	});
});
</script>
