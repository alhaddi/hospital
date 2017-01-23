
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						<?=$title?>
					</h3>
					<div class="actions">				
						<button onclick="tambahOnClick()" data-datatable-action="add" data-datatable-idtable="<?=$id_table?>" id="tambah_<?=$id_table?>" class="btn btn-mini">
							<i class="fa fa-plus"></i> Tambah
						</button>
						<button data-datatable-action="bulk" data-datatable-idtable="<?=$id_table?>" class="btn btn-mini">
							<i class="fa fa-trash"></i> Hapus
						</button>
						<button onclick="tutup()" class="btn btn-mini">
							<i class="fa fa-table"></i> Tutup Buku
						</button>
					</div>
				</div>
				<div class="box-content nopadding">
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-delete="<?=$datatable_delete?>"
					data-datatable-colvis="true"
					data-datatable-nocolvis=""
					data-nosort="0,5"
					>
						<thead>
							<tr>
								<th class="with-checkbox">
									<input type="checkbox" name="check_all" id="check_all">
								</th>
								<th data-datatable-align="text-center" style="width:50px;">No.</th>
								<th data-datatable-align="text-left">Tanggal</th>
								<th data-datatable-align="text-left">Uraian</th>
								<th data-datatable-align="text-left">Jumlah</th>
								<th style="width:100px;">Action</th>
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
<?php echo $load_form ?>
<script>
$(document).ready(function(){
	$('#check_all').on("click",function(){
		$('[name="id[]"]').prop("checked",this.checked);
		$('[name="id[]"]').attr("checked",this.checked);
	});
	$('[name="id[]"]').on("click",function(){
		if($(".pilih").length == $(".pilih:checked").length) {
			$('#check_all').prop("checked","checked");
			$('#check_all').attr("checked","checked");		
		}else{
			$("#check_all").removeAttr("checked");
		}
	});
	/*
	$.post( "<?=base_url()?>pengeluaran/ceksaldo", { })
	.done(function( data ) {
		if(data == 1){
			swal({
				title: "Informasi !",
				text: "Tutup buku terlebih dahulu untuk bisa menambahkan kembali data",
				type: 'warning'
			});
			$('#tambah_<?=$id_table?>').attr('disabled', true);
			$('#tambah_<?=$id_table?>').prop('disabled', true);
			setStatusSaldo(1);
		}
	});
	*/
});
function modal_penerimaan(id){
		$.ajax({
			url		:"<?=site_url('penerimaan/ajax_edit')?>",
			data	:{
				id:id
			},
			type	:"post",
			dataType:"json",
			success	:function(jdata){
				var formz = $('#form_<?=$id_table?>');
				formz[0].reset();
				if(jdata){
					$.each(jdata,function(v,i){
						if(formz.find('[name="'+i.name+'"]').attr('type') == 'radio') {
							formz.find('[name="'+i.name+'"][value="' + i.value + '"]').prop("checked","checked");
							formz.find('[name="'+i.name+'"][value="' + i.value + '"]').attr("checked","checked");
						}
						else if(formz.find('[name="'+i.name+'"]').attr('type') == 'checkbox'){
							if(i.value >= 1){
							formz.find('[name="'+i.name+'"]').val(i.value);
							formz.find('[name="'+i.name+'"][value="' + i.value + '"]').prop("checked","checked");
							formz.find('[name="'+i.name+'"][value="' + i.value + '"]').attr("checked","checked");
							}
						}
						else
						{
							formz.find('[name="'+i.name+'"]').val(i.value);
						}
						formz.find('[name="'+i.name+'"]').trigger('change');
					});
					}
				$('#modal_<?=$id_table?>').modal('show');
			}
		});
	}
function tutup(){
	swal({
		title: 'Apa anda yakin ?',
		text: "Ketika Sudah Menutup Buku Data Tidak Akan Bisa Di Ubah Atau Di Hapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'OK',
		confirmButtonColor: '#d33',
		showLoaderOnConfirm: true,
		preConfirm: function(result) {
			return new Promise(function(resolve, reject) {
				if (result) {
					$.post( "<?=base_url()?>pengeluaran/tutup_buku", { status : getStatusSaldo() })
					.done(function( data ) {
						swal({
							title: "Informasi !",
							text: "Tutup Buku Berhasil",
							type: 'success'
						});
						$("#tambah_<?=$id_table?>").removeAttr("disabled");
						$("#tambah_<?=$id_table?>").removeProp("disabled");
					});
				}
				else {
					reject('Terjadi kesalahan server atau aplikasi !');
				}
			});
		}
	});
}
var status = 0;
function setStatusSaldo(stat){
	status = stat;
}
function getStatusSaldo(){
	return status;
}
</script>