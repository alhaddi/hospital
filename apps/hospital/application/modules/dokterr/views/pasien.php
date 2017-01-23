<?php $p = $this->input->get('p');?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Daftar <?=$title?>
					</h3>
					<div class="actions">
						<a href="<?=site_url('pasien/pendaftaran').'?p='.$p?>" class="btn btn-primary btn-mini">
							<i class="fa fa-plus"></i> Tambah
						</a>
						<button data-datatable-action="bulk" data-datatable-idtable="<?=$id_table?>" class="btn btn-primary btn-mini">
							<i class="fa fa-trash"></i> Hapus
						</button>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
								<i class="fa fa-download"></i> Export
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a data-download="excel" data-download-url="pasien/excel"><i class="fa fa-file-excel-o fa-fw"></i> Excel (.xlsx)</a>
								</li>
								<li>
									<a data-download="pdf" data-download-url="pasien/pdf"><i class="fa fa-file-pdf-o fa-fw"></i>Pdf (.pdf)</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="box-content nopadding">
					<div class="table-responsive">
						<table id="<?=$id_table?>" class="table table-hover table-nomargin  table-bordered" 
						data-plugin="datatable-server-side" 
						data-datatable-list="<?=$datatable_list?>"
						data-datatable-delete="<?=$datatable_delete?>"
						data-datatable-multiselect="true"
						data-datatable-colvis="true"
						data-datatable-autorefresh="true"
						data-datatable-nocolvis="-2,-3"
						>
							<thead>
								<tr>
									<th class="with-checkbox" data-datatable-align="text-center">
										<input type="checkbox" name="check_all" data-datatable-checkall="true">
									</th>
									<th data-datatable-align="text-center" style="max-width:50px;">No.</th>
									<th data-datatable-align="text-center" style="max-width:100px">NIP</th>
									<th data-datatable-align="text-left">Nama Lengkap</th>
									<th data-datatable-align="text-center">No Identitas</th>
									<th data-datatable-align="text-center">Jenis Kelamin</th>
									<th data-datatable-align="text-center">Spesialis</th>
									<th data-datatable-align="text-center">No HP</th>
									<th data-datatable-align="text-left">Alamat</th>
									<th data-datatable-align="text-center">Tanggal Lahir</th>
									<th data-datatable-align="text-center">Last Update</th>
									<th data-datatable-align="text-center">Last User</th>
									<th data-datatable-align="text-center" style="max-width:120px;">Action</th>
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
</div>


<form id="form_<?=$id_table?>" action="<?=site_url('pasien/save_poliklinik_pasien')?>" method="POST">
	<div id="modal_<?=$id_table?>" class="modal fade in" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> Form Pendaftaran Poliklinik</h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<input type="hidden" name="id_pasien" id="id_pasien">						
						<input type="hidden" name="id_jenis_appointment" id="id_jenis_appointment" value="<?=$id_jenis_appointment?>">
						<?php $id_komponen = array(
							'1'=>1,
							'2'=>2,
						);
						?>
						<input type="hidden" name="id_komponen" id="id_komponen" value="<?=$id_komponen[$id_jenis_appointment]?>">						
						<div class="form-group">
							<label for="textfield" class="control-label">Poli Tujuan</label>
							<select name="id_poliklinik" class="form-control" id="id_poliklinik" data-rule-required="true" >
								<option value="">-- Pilih Poliklinik --</option>
								<?php foreach($poliklinik as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label">Cara Pembayaran</label>
							<select name="id_cara_bayar" class="form-control" id="id_cara_bayar">
								<?php foreach($cara_bayar as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="form-group hidden" data-showhide="bpjs">
							<label for="textfield" class="control-label">Tipe BPJS</label>
							<select name="id_bpjs_type" class="form-control" id='id_bpjs_type'>
								<?php foreach($bpjs_type as $r){ ?>
									<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="form-group hidden" data-showhide="bpjs" >
							<label for="textfield" class="control-label">ID BPJS</label>
							<input type="text" name="no_bpjs" id="no_bpjs" class="form-control" >
						</div>
						
						<div class="form-group hidden" data-showhide="asuransi_kontraktor">
							<label for="textfield" class="control-label">No Polis</label>
							<input type="text" name="no_polis" id="no_polis" class="form-control" >
						</div>
						
						<div class="form-group hidden" data-showhide="asuransi_kontraktor">
							<label for="textfield" class="control-label">Nama Perusahaan</label>
							<input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" >
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
	function modal_poli(id_pasien){
		$.ajax({
			url		:"<?=site_url('pasien/poliklinik_pasien')?>",
			data	:{
				id:id_pasien
			},
			type	:"post",
			dataType:"json",
			success	:function(jdata){
				var formz = $('#form_<?=$id_table?>');
				formz[0].reset();
				if(jdata){
					$.each(jdata,function(i,v){
						formz.find('[name="'+i+'"]').val(v);
					});
					$('[name="id_cara_bayar"]').trigger('change');
					}
				$('#modal_<?=$id_table?>').modal('show');
				formz.find('select').select2();
			}
		});
	}
	
	$(document).ready(function(){
			
		$('[name="id_cara_bayar"]').on("change",function(){
			var id = $(this).val();
			if(id == 2) {
				$('[data-showhide="bpjs"]').removeClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
				
				$('[name="id_bpjs_type"]').attr('data-rule-required','true').removeAttr('disabled');
				$('[name="no_bpjs"]').attr('data-rule-required','true').removeAttr('disabled');
				
				$('[name="no_polis"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="nama_perusahaan"]').attr('data-rule-required','false').attr('disabled',true);
				
				} else if(id == 3 || id == 4){
				$('[data-showhide="bpjs"]').addClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').removeClass('hidden');
				
				
				$('[name="id_bpjs_type"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="no_bpjs"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="no_polis"]').attr('data-rule-required','true').removeAttr('disabled');
				$('[name="nama_perusahaan"]').attr('data-rule-required','true').removeAttr('disabled');
				} else {
				$('[data-showhide="bpjs"]').addClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
				
				$('[name="id_bpjs_type"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="no_bpjs"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="no_polis"]').attr('data-rule-required','false').attr('disabled',true);
				$('[name="nama_perusahaan"]').attr('data-rule-required','false').attr('disabled',true);
			}
		}).trigger('change');
		
		$('#form_<?=$id_table?>').validate({
			errorElement  : 'span',
			errorClass    : 'help-block has-error',
			errorPlacement: function (error, element) {
				if (element.parents("label").length > 0) {
					element.parents("label").after(error);
					} else {
					element.after(error);
				}
			},
			highlight     : function (label) {
				$(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
			},
			success       : function (label) {
				label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
			},
			onkeyup       : function (element) {
				$(element).valid();
			},
			onfocusout    : function (element) {
				$(element).valid();
			},
			submitHandler: function(form)
			{
				var url = $(form).attr('action');
				var method = $(form).attr('method');
				var success_url = $(form).data('success');
				var datasend = $(form).serialize();
				
				$.ajax({
					url			: url,
					type		: method,
					data		: datasend,
					dataType	: 'json',
					beforeSend	: function(){
						$(form).find('button[type="submit"]').html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Saving...'); //change button text
						$(form).find('button[type="submit"]').attr('disabled',true); //set button disable 
					},
					success	: function(jdata){
						$(form).find('button[type="submit"]').html('<i class="fa fa-save fa-fw"></i> Simpan'); //change button text
						$(form).find('button[type="submit"]').attr('disabled',false); //set button enable 
						if(jdata.status) //if success close modal and reload ajax table
						{
							$('.modal').modal('hide');
							$('#<?=$id_table?>').DataTable().ajax.reload(); 
						}
						else
						{
							alert('terjadi error');
						}
					},
					error : function(jdata){
						$(form).find('button[type="submit"]').html('<i class="fa fa-save fa-fw"></i> Simpan'); //change button text
						$(form).find('button[type="submit"]').attr('disabled',false); //set button enable 
					}
				});
			}
		});
	});
</script>