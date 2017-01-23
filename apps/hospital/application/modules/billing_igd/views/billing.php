<?php $p = $this->input->get('p');?>
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
								<?php if($p == 2){?>
										<option value="20"> IGD </option>
										<option value="28"> IGD Phonek </option>
								<?php }
									else{ ?>
										<?php foreach($poliklinik as $r){ ?>
											<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
										<?php } ?>
								<?php	}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<label>Action</label>
							<br>
							<button onclick="pdf();" class='btn btn-danger' type='button'><i class='fa fa-pdf-o'></i> Cetak ke PDF</button> <a href="<?=site_url('report?igd=ya')?>" class='btn btn-success'>Laporan Billing IGD</a>
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

<script>
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
		var d1=$("#billing_igd_daterange1").val();
		var d2=$("#billing_igd_daterange2").val();
		var tgl1=d1.split("/");
		var tgl2=d2.split("/");
		var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
		var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
		
		var id_cara_bayar=$("#id_cara_bayar").val();
		var id_poliklinik=$("#id_poliklinik").val();
		window.open('<?=base_url()?>billing_igd/pdf/<?=$_GET['p']?>?tgl1='+t1+'&tgl2='+t2+'&cara_bayar='+id_cara_bayar+'&id_poliklinik='+id_poliklinik);
	}		
	
</script>
