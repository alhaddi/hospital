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
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
								<i class="fa fa-download"></i> Export
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="#" onclick="pdf_ms_rawat_inap(1)"><i class="fa fa-file-pdf-o fa-fw"></i>Pasein Seluruh</a>
								</li>
								<li>
									<a href="#" onclick="pdf_ms_rawat_inap(2)"><i class="fa fa-file-pdf-o fa-fw"></i>Pasien Masuk Hari Ini</a>
								</li>
								<li>
									<a href="#" onclick="pdf_ms_rawat_inap(3)"><i class="fa fa-file-pdf-o fa-fw"></i>Pasien Keluar Hari Ini</a>
								</li>
							</ul>
						</div>
						<a href="<?=site_url('rawat_inap/pendaftaran')?>" class="btn btn-primary btn-mini">
							<i class="fa fa-plus"></i> Tambah
						</a>
						<button data-datatable-action="bulk" data-datatable-idtable="<?=$id_table?>" class="btn btn-primary btn-mini">
							<i class="fa fa-trash"></i> Hapus
						</button>
					</div>
				</div>
				<div class="box-content nopadding">
					<div class="table-responsive">
						<table id="<?=$id_table?>" class="table table-hover table-nomargin  table-bordered" 
						data-plugin="datatable-server-side" 
						data-datatable-list="<?=$datatable_list?>"
						data-datatable-delete="<?=$datatable_delete?>"
						data-datatable-daterange="true"
						data-datatable-multiselect="true"
						data-datatable-colvis="true"
						data-datatable-autorefresh="true"
						>
							<thead>
								<tr>
									<th class="with-checkbox" data-datatable-align="text-center">
										<input type="checkbox" name="check_all" data-datatable-checkall="true">
									</th>
									<th data-datatable-align="text-center" style="max-width:50px;">No.</th>
									<th data-datatable-align="text-left">No RM</th>
									<th data-datatable-align="text-left">Nama Lengkap</th>
									<th data-datatable-align="text-center">Usia</th>
									<th data-datatable-align="text-left">Alamat</th>
									<th data-datatable-align="text-center">Ruang Rawat</th>
									<th data-datatable-align="text-center">Tgl Keluar</th>
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
<?=$load_form?>
<script>
function modal_pulang(id_pasien){
	var formz = $('#form_<?=$id_table?>');
	formz[0].reset();
	formz.find('[name="id"]').val(id_pasien);
	$('#modal_<?=$id_table?>').modal('show');
}
function pdf_ms_rawat_inap(p){
	var d1=$("#<?=$id_table?>_daterange1").val();
	var d2=$("#<?=$id_table?>_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb = ""+$("#<?=$id_table?>").dataTable().fnSettings().aaSorting;
	var tbl = tb.split(",");
	var column_order = tbl[0];
	var dir_order = tbl[1];
	
	window.open('<?=base_url()?>rawat_inap/pdf?tgl1='+t1+'&tgl2='+t2+'&column_order='+column_order+'&dir_order='+dir_order+'&p='+p);
}
	function modal_poli(id_pasien){
		$.ajax({
			url		:"<?=site_url('pasien/poliklinik_pasien')?>",
			data	:{
				id:id_pasien
			},
			type	:"post",
			dataType:"json",
			success	:function(jdata){
				
			}
		});
	}
	
	function checkboxToday(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		
		var yyyy = today.getFullYear();
		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var today = yyyy+'-'+mm+'-'+dd;
		
		var ht = '<div id="pasien_filter_date" class="dataTables_filter" style="width: 10%;vertical-align: center;">';
		ht += '<label style="width: 100%;">';
		ht += '<input data-datatable-id="pasien" data-datatable-filter="true" value="'+today+'" name="datatable_daterange1" id="pasien_daterange1" aria-controls="pasien" style="width: 40%;" type="checkbox">';
		ht += ' Hari ini</label>';
		ht += '</div>'
		var $filter = $('#pasien_filter');
		$filter.after(ht);
		
		$('#pasien').DataTable().ajax.reload();
	}
	
	$(document).ready(function(){
		//checkboxToday();
		
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