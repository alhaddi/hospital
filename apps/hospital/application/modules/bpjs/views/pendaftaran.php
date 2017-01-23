
	<form  class='form-horizontal form-column form-bordered'  data-plugin="form-validation" id="form_" action="<?=site_url('bpjs/save')?>" method="POST">
		<div class="row">
			<div class="col-sm-12">
				<div class="box">
					<ul class="tabs tabs-inline tabs-top">
						<li class="active">
							<a href="#first11" data-toggle="tab">
							<h4><i class="fa fa-list"></i>Data Pasien</h4></a>
						</li>
					</ul>
					<div class="tab-content padding tab-content-inline tab-content-bottom">
						<div class="tab-pane active" id="first11">
							<div class="box-content nopadding">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">No Kartu</label>
											<div class="col-sm-10">
												<input type="text" name="no_kartu" id="no_kartu" class="form-control" readonly value="<?=$json->response->peserta->noKartu?>" >
											</div>
										</div>
										<div class="form-group">
											<label for="password" readonly class="control-label col-sm-2">Tipe Identitas</label>
											<div class="col-sm-3">
												<input type="text" class='form-control' disabled value="KTP">
											</div>
											<div class="col-sm-7">
												<input type="text" readonly name="no_identitas" id="no_identitas" class="form-control" value="<?=$json->response->peserta->nik?>" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Nama Pasien</label>
											<div class="col-sm-10">
												<input type="text" readonly name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?=$json->response->peserta->nama?>" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Tanggal Lahir</label>
											<div class="col-sm-10">
												<input type="hidden" readonly name="tanggal_lahir"  value="<?=$json->response->peserta->tglLahir?>" >
												<input type="text" readonly class="form-control" value="<?=convert_tgl($json->response->peserta->tglLahir,'d F Y',1)?>" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Jenis Kelamin</label>
												<div class="col-sm-10">
												<input type="hidden" readonly name="jk" id="jk" class="form-control" value="<?=$json->response->peserta->sex?>" >
												<input type="text" readonly  class="form-control" value="<?=($json->response->peserta->sex == "L")?'Laki - laki':'Perempuan'?>" >
												</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">No Rujukan</label>
											<div class="col-sm-10">
												<input type="text" name="noRujukan" id="noRujukan" placeholder="No Rujukan Pasien" value="<?=(empty($rujukan->response->item->noKunjungan))?'':$rujukan->response->item->noKunjungan;?>" class="form-control"  >
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">Tanggal Rujukan</label>
											<div class="col-sm-10">
												<input type="datetime" name="tglRujukan" id="tglRujukan"  class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">PPK Rujukan</label>
											<div class="col-sm-10">
												<input type="text" value="<?=(empty($rujukan->response->item->noKunjungan))?'':substr($rujukan->response->item->noKunjungan,0,8);?>" name="ppkRujukan" id="ppkRujukan" placeholder="" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">PPK Pelayanan</label>
											<div class="col-sm-10">
												<input type="text" name="ppkPelayanan"  value="<?=(empty($rujukan->response->item->noKunjungan))?'':substr($rujukan->response->item->noKunjungan,12,8);?>" id="ppkPelayanan" placeholder="" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Catatan</label>
											<div class="col-sm-10">
												<textarea name='Catatan' class="form-control" id='pekerjaan'></textarea>
											</div>
										</div>
										
									</div>
									<div class="col-sm-6">
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Jenis Pelayanan</label>
											<div class="col-sm-10">
												<select name='jnsPelayanan' onchange="cekjns();" class="form-control" id='jnsPelayanan'>
													<option value="2">Rawat Jalan</option>
													<option value='1'>Rawat Inap</option>
												</select>
											</div>
										</div>
										<div id="pelayanan" style="display:none;">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Kamar</label>
											<div class="col-sm-10">
												<select name='id_kamar' onchange="cekjns();" class="form-control" id='id_kamar'>
												<?php foreach($this->db->get("ms_kamar")->result() as $r){ ?>
													<option value="<?=$r->id?>"><?=$r->nama?> (<?=rupiah($r->tarif)?>)</option>
												<?php }?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Ruang</label>
											<div class="col-sm-10">
												<select name='id_ruang' onchange="cekjns();" class="form-control" id='id_ruang'>
												<?php foreach($this->db->get("ms_ruang")->result() as $r){ ?>
													<option value="<?=$r->id?>"><?=$r->nama?></option>
												<?php }?>
												</select>
											</div>
										</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Diagnosa Awal (ICD10)</label>
											<div class="col-sm-10">
												<select id='diagnosa' name="diagAwal"  class="form-control" >
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Poli Tujuan</label>
											<div class="col-sm-10">
												<select name='poliTujuan' class="form-control" id='poliTujuan'>
													<?php foreach($poli as $r){ ?>
														<option value='<?=$r['id']?>'>(<?=$r['code']?>) <?=$r['nama']?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Kelas Rawat</label>
											<div class="col-sm-10">
												<select name='klsRawat' class="form-control" id='klsRawat'>
													<option value="1">Kelas 1</option>
													<option value="2">Kelas 2</option>
													<option value="3">Kelas 3</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Laka Lantas</label>
											<div class="col-sm-10">
												<select name='lakaLantas' onchange="ceklaka();" class="form-control" id='lakaLantas'>
													<option value="2">Bukan Kasus Kecelakaan</option>
													<option value="1">Kasus Kecelakaan</option>
												</select>
											</div>
										</div>
										<div class="form-group" id="laka" style="display:none;">
											<label for="textfield" class="control-label col-sm-2">Lokasi Kecelakaan</label>
											<div class="col-sm-10">
												<input type="text" name="lokasiLaka" id="lokasiLaka" class="form-control">
											</div>
										</div>
										<div class="col-sm-12">
										<div class="form-actions"><center>
											<button type="submit" id='save_button'  onclick="save_data()" class="btn btn-primary"><i class='fa fa-save'></i> Simpan Data</button>
										</div>
									</div>
									</div>
								</div>
							


							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

<script>
	function changebayar(id){
		if(id == 'BPJS'){
			$("#BPJS").show(1);
			$("#ASURANSI").hide(1);
			}else if(id == 'ASURANSI'){
			$("#ASURANSI").show(1);
			$("#BPJS").hide(1);
			}else if(id == 'KONTRAKTOR'){
			$("#ASURANSI").show(1);
			$("#BPJS").hide(1);
			}else{
			$("#ASURANSI").hide(1);
			$("#BPJS").hide(1);
		}
	}
	
	function ceklaka(){
		var a=$("#lakaLantas").val();
		if(a == "1"){
			$("#laka").show(1);
		}else{
			$("#laka").hide(1);
			$("#lokasiLaka").val("");
		}
	}
	function cekjns(){
		var a=$("#jnsPelayanan").val();
		if(a == "1"){
			$("#pelayanan").show(1);
		}else{
			$("#pelayanan").hide(1);
		}
	}
	$(document).ready(function(){
		var select_options = {
			ajax: {
				url: '<?=site_url('konsultasi/json_diagnosa')?>',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term, // search term
						page: params.page,
						type: "ICD10"
					};
				},
				processResults: function (data,params) {
					console.log(data);
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
		};
		$('#diagnosa').select2(select_options);
		$('#poliTujuan').select2();
		
			$("#tglRujukan").datetimepicker({
			format:'d/m/Y H:i',
			mask:'39/19/2999 29:59',
			required :true
			});
	});

		
	function save_data(){
		$.ajax({
			url	 :"<?=site_url('bpjs/save')?>",
			data :$('#form_').serialize(),
			type :"post",
			dataType	: 'json',
			beforeSend	: function() {
				$('#save_button').attr('disabled',true);
				$('#save_button').prop('disabled',true);
				$('#save_button').html('<i class="fa fa-spinner fa-spin"></i> Silahkan Tunggu',true);
			},
			success : function(jdata){
				console.log(jdata['status']);
				if(jdata.status == true)
				{
					swal({
						title: "Success !",
						text: jdata.message,
						type: "success"
						}).then(function() {
							window.location.reload(); 
					});
				}
				else if(jdata.status == false)
				{
					swal('Gagal !',jdata.message,'error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
				}
				else
				{
					swal('Gagal !','unkwon error','error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
				}
			},
			error : function(er){
					swal('Gagal !','Kesalahan jaringan, silahkan coba kembali','error');
					$('#save_button').attr('disabled',false);
					$('#save_button').prop('disabled',false);
					$('#save_button').html('<i class="fa fa-save"></i> Save Data',true);
			}
		});
	}
	
</script>	