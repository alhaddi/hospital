
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-search"></i>
						Filter
					</h3>
				</div>
				<div class="box-content">
					<div class="row">
						<div class="col-sm-4">
							<label>Cara Bayar</label>
							<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar" data-datatable-filter="true" data-datatable-id='<?=$id_table?>'>
								<option value="">-- Cara Bayar --</option>
								<?php foreach($cara_bayar as $f) { ?>
									<option value="<?=$f['id']?>"><?=$f['nama']?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-4">
							<label>Poliklinik</label>
							<select class="form-control" data-datatable-id='<?=$id_table?>' name="id_poliklinik" id="id_poliklinik" data-datatable-filter="true">
								<option value="">-- Poliklinik --</option>
								<?php foreach($poliklinik as $f) { ?>
									<option value="<?=$f['id']?>"><?=$f['nama']?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<label>Action</label>
							<button onclick="pdf();" class='btn btn-danger form-control' type='button'><i class='fa fa-pdf-o'></i> Cetak ke PDF</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
			<br>
			  <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" ><a href="<?=site_url("billing_konsultasi?p=1")?>">Billing Otomatis</a></li>
				<li role="presentation" class="active"><a>Billing Manual</a></li>
			  </ul>
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Daftar <?=$title?>
					</h3>
					<div class="actions">
						
					</div>
				</div>
				<div class="box-content nopadding">
					
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-delete="<?=$datatable_delete?>"
					data-datatable-colvis="true"
					data-datatable-autorefresh="true"
					data-datatable-daterange="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th data-datatable-align="text-center" style="width:50px;">No.</th>
								<th data-datatable-align="text-center">RM</th>
								<th data-datatable-align="text-left">Nama Pasien</th>
								<th data-datatable-align="text-center">No Identitas</th>
								<th data-datatable-align="text-center">Cara Bayar</th>
								<th data-datatable-align="text-center">Poliklinik</th>
								<th data-datatable-align="text-center">Tipe Bayar</th>
								<th data-datatable-align="text-right">Nominal</th>
								<th data-datatable-align="text-center">Tanggal</th>
								<th data-datatable-align="text-center">Status</th>
								<th data-datatable-align="text-center" style="width:100px;">Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?=$load_form?>

<script>
	table_reload();
	function modal_pembayaran(id_billing){
		$.ajax({
			url		:"<?=site_url('billing_manual/pembayaran')?>",
			data	:{
				id:id_billing
			},
			type	:"post",
			dataType:"json",
			success	:function(jdata){
				var formz = $('#form_<?=$id_table?>');
				formz[0].reset();
				if(jdata){
					$.each(jdata,function(i,v){
						formz.find('[name="'+i+'"]').val(v);
						formz.find('#'+i).html(v);
					});
				}
				$('#modal_<?=$id_table?>').modal('show');
				$('#modal_<?=$id_table?>').on('shown.bs.modal', function() {
					$(this).find('[name="total_bayar"]').focus();
				});
				formz.find('select').select2();
			}
		});
	}
	
	
		
</script>
