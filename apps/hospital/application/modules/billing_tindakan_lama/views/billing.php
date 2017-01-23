
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
						<div class="col-md-4">
							<label>Cara Bayar</label>
							<select class="form-control" name="id_cara_bayar"  id="id_cara_bayar" data-datatable-filter="true" data-datatable-id='<?=$id_table?>'>
								<option value="">-- Cara Bayar --</option>
								<?php foreach($cara_bayar as $f) { ?>
									<option value="<?=$f['id']?>"><?=$f['nama']?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-4">
							<label>Poliklinik</label>
							<select class="form-control" data-datatable-id='<?=$id_table?>' name="id_poliklinik" id="id_poliklinik" data-datatable-filter="true">
								<option value="">-- Poliklinik --</option>
								<?php foreach($poliklinik as $f) { ?>
									<option value="<?=$f['id']?>"><?=$f['nama']?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-2">
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
								<th data-datatable-align="text-center">Cara Bayar</th>
								<th data-datatable-align="text-center">Poliklinik</th>
								<th data-datatable-align="text-left">Jenis Bayar</th>
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

<form id="asd<?=$id_table?>" action="<?=site_url('billing/save_poliklinik_pasien')?>" method="POST">
	<div id="poli_<?=$id_table?>" class="modal fade in" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> Form Pindah Poliklinik</h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body" id="body-addmodal">
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan dan cetak</button>
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
	function modal_poli(id){
		
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>billing/addpoli/"+id,
			success: function(data) {
				$("#poli_<?=$id_table?>").modal('show');
				$("#body-addmodal").html(data);
			}
		});
		return false;
	}
	function modal_pembayaran(id_billing){
		$.ajax({
			url		:"<?=site_url('billing/pembayaran')?>",
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
	function modal_pembatalan(id_billing){
		swal({
		  title: 'Apakah anda yakin?',
		  text: "Data yang sudah dibatalkan akan tercatat oleh sistem secara otomatis dan tidak dapat dikembalikan dengan cara apapun!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes!'
		}).then(function () {
			$.ajax({
			url		:"<?=site_url('billing/pembatalan')?>",
			data	:{
				id:id_billing
			},
			type	:"post",
			dataType:"json",
			success	:function(jdata){
				swal("Transaksi berhasil dibatalkan.");
				$('#<?=$id_table?>').DataTable().ajax.reload(); 
			}
			});
		});

	}
	
function pdf(){
	var d1=$("#billing_tbl_daterange1").val();
	var d2=$("#billing_tbl_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	var tb = ""+$("#<?=$id_table?>").dataTable().fnSettings().aaSorting;
	var tbl = tb.split(",");
	var column_order = tbl[0];
	var dir_order = tbl[1];
	
	var id_cara_bayar=$("#id_cara_bayar").val();
	var id_poliklinik=$("#id_poliklinik").val();
	window.open('<?=base_url()?>billing/pdf/<?=$_GET['p']?>?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik+'&column_order='+column_order+'&dir_order='+dir_order);
}	

	$(document).ready(function(){
		$('#asd<?=$id_table?>').validate({
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
							$('#<?=$id_table?>').DataTable().ajax.reload();
							$('.modal').modal('hide');
							window.open("<?=base_url()?>billing/kwitansi/"+jdata.id_pasien+"/"+jdata.id_billing);
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
