<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
		<input type="hidden" name="id">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
				<i class="fa fa-pencil-square-o"></i>Form Pendaftaran BPJS</h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-2">Pencarian Pasien <span class="text-danger">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="keterangan"  name="keterangan"  >
									<option value="peserta_nik" >Cari Berdasarkan KTP</option>
									<option value="peserta_kartu">Cari Berdasarkan No Kartu BPJS</option>
								</select>
							</div>
							<div class="col-sm-7">
								<input type="text" class='form-control' id="key" name="key" placeholder="Masukan nomor dengan lengkap.">
							</div>
						</div>
						<br>
						<br>
						<center><button type="button" class='btn btn-info' id="b1" onclick="caripasien()"><i class="fa fa-search"></i> Cari Pasien..</button><button style="display:none;" type="button" class='btn btn-danger' id="b2" ><i class="fa fa-spin fa-spinner"></i> Silahkan tunggu..</button></center>
					</div>
					<hr>
					<div class="col-md-12" id="load_pasien">
					</div>
			</div>
		</div>		
</div>

<script>
	function caripasien(id_pasien){
		var key=$("#key").val();
		if(key != ""){
		$.ajax({
			url		:"<?=site_url('bpjs/cari')?>",
			data	:{
				key:$("#key").val(),
				ket:$("#keterangan").val()
			},
			type	:"post",
			beforeSend:function(e){
				$("#b1").hide(1);
				$("#b2").show(1);
				$("#load_pasien").html("");
			},
			success	:function(jdata){
				$("#b1").show(1);
				$("#b2").hide(1);
				$("#load_pasien").html(jdata);
			},
			error	:function(f){
				$("#b1").show(1);
				$("#b2").hide(1);
				swal("Gagal","Tidak dapat menghubungkan ke server bpjs, silahkan coba kembali",'error');
			}
		});
		}else{
			swal("Harap isi pencarian..");
		}
	}
</script>	

