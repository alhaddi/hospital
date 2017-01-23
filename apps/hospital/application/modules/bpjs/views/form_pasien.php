<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal' data-plugin="form-validation" data-redirect="<?=site_url('rawat_inap')?>" id="form_<?=$id_table?>" action="<?=site_url($link_save)?>" method="POST">
		<input type="hidden" name="id">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
				<i class="fa fa-pencil-square-o"></i>Pasien  : <?=element('nama_lengkap',$pasien)?></h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-4">Nomor RM <span class="text-danger">*</span></label>
							<div class="col-sm-5">
								<input name="rm" id="rm" class="form-control" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="nama_lengkap" class="control-label col-sm-4">Nama Lengkap <span class="text-danger">*</span></label>
							<div class="col-sm-8">
								<input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" >								
							</div>
							<div class="col-sm-3">
								<input type="text" data-plugin="datepicker" name="tanggal_lahir" id="tanggal_lahir" class="form-control" >
							</div>
							<div class="col-sm-2">
								<input type="text" name="usia" id="usia" placeholder="Usia" class="form-control" >
							</div>
						</div>

						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Jenis Kelamin</label>
							<div class="col-sm-5">
								<select name='jk' class="form-control" id='jk'>
									<option value="L">Laki - laki</option>
									<option value="P">Perempuan</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Alamat</label>
							<div class="col-sm-8">
								<textarea name="alamat" id="alamat" class="form-control"></textarea>
							</div>
						</div>

					</div>
					
					
					<div class="col-sm-6">
					
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Cara Masuk</label>
							<div class="col-sm-8">
								<select name='cara_masuk' class="form-control" id='cara_masuk'>
									<option value="RJ">Rawat Jalan</option>
									<option value="IGD">IGD</option>
								</select>
							</div>
						</div>
						
						<div class="form-group ">
							<label for="textfield" class="control-label col-md-4">Tanggal Masuk</label>
							<div class="col-sm-8">
								<input type="text" data-plugin="datepicker" name="tgl_masuk" id="tgl_masuk" class="form-control" >
							</div>
						</div>
						
						<div class="form-group ">
							<label for="ruang_rawat" class="control-label col-sm-4">Ruangan Rawat</label>
							<div class="col-sm-8">
								<input name="ruang_rawat" id="ruang_rawat" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group ">
							<label for="cara_keluar" class="control-label col-sm-4">Cara Keluar</label>
							<div class="col-sm-8">
								<select name="cara_keluar" class="form-control" id="cara_keluar">
									<?php foreach($cara_keluar as $r){ ?>
										<option value="<?=$row['id']?>"><?=$row['nama']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group ">
							<label for="tgl_keluar" class="control-label col-md-4">Tanggal Keluar</label>
							<div class="col-sm-8">
								<input type="text" data-plugin="datepicker" name="tgl_keluar" id="tgl_keluar" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label for="keterangan" class="control-label col-sm-4">Keterangan</label>
							<div class="col-sm-8">
								<textarea name="keterangan" id="keterangan" class="form-control"></textarea>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="form-actions text-left">
				
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
				<button type="button" data-action="back" class="btn btn-default"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>		
	</form>
</div>

<script>
	
	$(document).ready(function(){
		var pasien_data = <?=json_encode($pasien)?>;
		$.each(pasien_data,function(i,v){
			$('[name="'+i+'"]').val(v);
		});
		
		$('select').select2();
		
		
		$('[name="tanggal_lahir"]').on("change",function(){
			var tgl = $(this).val();
			var usia = hitungUsia(tgl);
			if(isNaN(usia) == true){
				usia = null;
			}
			$('[name="usia"]').val(usia);
		});		
		

		
		if($('[data-pasien="true"]').length > 0) {
			$('[data-pasien="true"]').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					minimumInputLength: 3,
					ajax: {
						url: '<?=site_url('pasien/select2_pasien')?>',
						dataType: 'json',
						data: function (params) {
							return {
								q: params.term, // search term
								page: params.page,
								group: '03',
								kode: '0',
							};
						},
						processResults: function (data,params) {
							params.page = params.page || 1;
							return {
								results: data.items,
								pagination: {
									more: (params.page * 30) < data.total_count
								}
							};
						},
						cache: true
					}
					}).change(function(result){
					$('#penanggung_jawab1_rm').val();
				});
			});
		}

		$("#usia").change(function() {
            var usia = $("#usia").val();
            //alert(tgl);
            getDateFromAge(usia);
        });
	});
	
	function getDateFromAge(ageInput) {
        var today = new Date();

        var todayYear = today.getFullYear(); // today year
        var todayMonth = today.getMonth(); // today month
        var todayDay = today.getDate(); // today day of month

        var prevyear = parseInt(todayYear)-parseInt(ageInput);
       // alert(nextyear+"="+todayYear+"+"+ageInput);
        //alert(nextyear+"-"+todayMonth+"-"+todayDay);

        $("#tanggal_lahir").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
    }

    function pad(num, size="2") {
        var s = num+"";
        while (s.length < size) s = "0" + s;
        return s;
    }
	

</script>	

