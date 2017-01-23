<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal' data-plugin="form-validation" data-redirect="<?=site_url('pasien')?>" id="form_<?=$id_table?>" action="<?=site_url($link_save)?>" method="POST">
		<input type="hidden" name="id">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
				<i class="fa fa-pencil-square-o"></i>Form Pendaftaran Rawat Inap</h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-2">No RM / Nama Pasien <span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select data-pasien-id="true" onchange="changedata();" class="form-control" id="id_pasien" name="id_pasien"  >
									<option value="">-- Pencarian Pasien IGD --</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="col-md-12" id="load_pasien">
					</div>
			</div>
		</div>		
	</form>
</div>

<script>
	
	$(document).ready(function(){
		
		$('#id_pasien').select2();
		
		if($('[data-pasien-id="true"]').length > 0) {
			$('[data-pasien-id="true"]').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					minimumInputLength: 3,
					ajax: {
						url: '<?=site_url('dashboard/select2_pasien')?>',
						dataType: 'json',
						data: function (params) {
							return {
								q: params.term, // search term
								//page: params.page,
							};
						},
						processResults: function (data,params) {
							params.page = params.page || 1;
							return {
								results: data.items,
								//pagination: {
								//	more: (params.page * 30) < data.total_count
								//}
							};
						},
						cache: true
					}
				});
			});
		}
		
	});
	
	function changedata(){
		var pid=$("#id_pasien").val();
		if(pid != ""){
			$.ajax({
			url		:"<?=site_url('rawat_inap/load_pasien')?>",
			data	:{
				id_pasien:pid
			},
			type	:"post",
			success	:function(data){
				$("#load_pasien").html(data);
			}
		});

		}
	}
</script>	

