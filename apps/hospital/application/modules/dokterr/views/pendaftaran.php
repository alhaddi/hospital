<div class="container-fluid">
	<div class="page-header">
		<div class="pull-left">
			<h1>Baru Rawat Jalan</h1>
		</div>
		<div class="pull-right">
			<ul class="minitiles">
				<li class='grey'>
					<a href="#">
						<i class="fa fa-cogs"></i>
					</a>
				</li>
				<li class='lightgrey'>
					<a href="#">
						<i class="fa fa-globe"></i>
					</a>
				</li>
			</ul>
			<ul class="stats">
				<li class='satgreen'>
					<i class="fa fa-money"></i>
					<div class="details">
						<span class="big">$324,12</span>
						<span>Balance</span>
					</div>
				</li>
				<li class='lightred'>
					<i class="fa fa-calendar"></i>
					<div class="details">
						<span class="big">February 22, 2013</span>
						<span>Wednesday, 13:56</span>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<form  class='form-horizontal form-column form-bordered'  data-plugin="form-validation" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
		<div class="row">
			<div class="col-sm-12">
				<div class="box">
					<ul class="tabs tabs-inline tabs-top">
						<li class="active">
							<a href="#first11" data-toggle="tab">
							<h4><i class="fa fa-list"></i>Data Pasien</h4></a>
						</li>
						<li class="">
							<a href="#second22" data-toggle="tab">
							<h4><i class="fa fa-user"></i>Penanggung Jawab</h4></a>
						</li>
					</ul>
					<div class="tab-content padding tab-content-inline tab-content-bottom">
						<div class="tab-pane active" id="first11">
							<div class="box-content nopadding">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">No RM</label>
											<div class="col-sm-10">
												<input type="text" name="rm" id="rm" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">Tipe Identitas</label>
											<div class="col-sm-3">
												<select name='tipe_identitas' class="form-control" id='tipe_identitas'>
													<option>KTP</option>
													<option>SIM</option>
													<option>KK</option>
													<option>PASPORT</option>
												</select>
											</div>
											<div class="col-sm-7">
												<input type="text" name="no_identitas" id="no_identitas" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Nama Pasien</label>
											<div class="col-sm-10">
												<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Poli Tujuan</label>
											<div class="col-sm-10">
												<select name='poliklinik' class="form-control" id='poliklinik'>
													<?php foreach($this->db->get('ms_poliklinik')->result() as $r){ ?>
														<option value='<?=$r->ID?>'><?=$r->nama?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Jenis Kelamin</label>
											<div class="col-sm-10">
												<label for="jenis_kelaminL"><input checked type="radio" value="LAKI-LAKI" id="jenis_kelaminL" name="jenis_kelamin">Laki - laki</label>
												<label for="jenis_kelaminP"><input type="radio" value="PEREMPUAN" id="jenis_kelaminP" name="jenis_kelamin">Perempuan</label>
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">Kontak</label>
											<div class="col-sm-3">
												<input type="text" name="No_HP" id="No_HP" placeholder="No HP" class="form-control" >
											</div>
											<div class="col-sm-7">
												<input type="text" name="No_Tlp_Rumah" id="No_Tlp_Rumah" placeholder="No Telepon"  class="form-control"  >
											</div>
										</div>
										<div class="form-group">
											<label for="password" class="control-label col-sm-2">Email</label>
											<div class="col-sm-10">
												<input type="text" name="Email" id="Email" placeholder="" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Tanggal Lahir</label>
											<div class="col-sm-7">
												<input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" >
											</div>
											<div class="col-sm-3">
												<input type="text" name="usia" id="usia" placeholder="Usia" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Agama</label>
											<div class="col-sm-10">
												<select name='agama' class="form-control" id='agama'>
													<?php foreach($this->db->get('ms_agama')->result() as $r){ ?>
														<option value='<?=$r->ID?>'><?=$r->nama?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Status Pernikahan</label>
											<div class="col-sm-10">
												<select name='status_perkawinan' class="form-control" id='status_perkawinan'>
													<option value='KAWIN'>Menikah</option>
													<option value="BELUM KAWIN">Belum Menikah</option>
													<option value="DUDA">Duda</option>
													<option value="JANDA">Janda</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Pekerjaan</label>
											<div class="col-sm-10">
												<select name='pekerjaan' class="form-control" id='pekerjaan'>
													<?php foreach($this->db->get('ms_pekerjaan')->result() as $r){ ?>
														<option value='<?=$r->ID?>'><?=$r->nama?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										
									</div>
									<div class="col-sm-6">
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Nama Orang Tua</label>
											<div class="col-sm-10">
												<input type="text" name="nama_orangtua" id="nama_orangtua" class="form-control" >
											</div>
										</div>
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Asal Pasien</label>
											<div class="col-sm-10">
												<select name='asal_pasien' onchange="changeasal($(this).val());" class="form-control" id='asal_pasien'>
													<option >Datang Sendiri</option>
													<option >Rujukan</option>
												</select>
											</div>
										</div>
										<div id="Rujukan" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-2">Asal Rujukan</label>
												<div class="col-sm-3">
													<input type="text" name="no_rujukan" placeholder="No Rujukan" id="no_rujukan" class="form-control" >
												</div>
												<div class="col-sm-7">
													<input type="text" name="rujukan_dari" id="rujukan_dari" placeholder="Asal Rujukan" class="form-control" >
												</div>
											</div>
											
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Cara Pembayaran</label>
											<div class="col-sm-10">
												<select name='cara_pembayaran' onchange="changebayar($(this).val());" class="form-control" id='cara_pembayaran'>
													<option value='UMUM'>UMUM</option>
													<option value="BPJS">BPJS</option>
													<option value="ASURANSI">ASURANSI</option>
													<option value="KONTRAKTOR">KONTRAKTOR</option>
												</select>
											</div>
										</div>
										<div id="BPJS" style="display:none;">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-2">Tipe BPJS</label>
												<div class="col-sm-10">
													<select name='BPJS_type' class="form-control" id='BPJS_type'>
														<?php foreach($this->db->get('ms_bpjs_type')->result() as $r){ ?>
															<option value='<?=$r->ID?>'><?=$r->nama?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-2">ID BPJS</label>
												<div class="col-sm-10">
													<input type="text" name="ID_BPJS" id="ID_BPJS" class="form-control" >
												</div>
											</div>
											
										</div>
										<div id="ASURANSI" style="display:none;">
											
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-2">No Polis</label>
												<div class="col-sm-10">
													<input type="text" name="No_Polis" id="No_Polis" class="form-control" >
												</div>
											</div>
											
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-2">Nama Perusahaan</label>
												<div class="col-sm-10">
													<input type="text" name="Nama_Perusahaan" id="ID_BPJS" class="form-control" >
												</div>
											</div>
											
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Alamat</label>
											<div class="col-sm-10">
												<textarea name='Alamat' class="form-control" id='cara_pembayaran'></textarea>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">RT / RW</label>
											<div class="col-sm-5">
												<input type="text" name="rt" id="RT" placeholder="RT" class="form-control" >
											</div>
											<div class="col-sm-5">
												<input type="text" name="rw" id="RW" placeholder="RW" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Kecamatan</label>
											<div class="col-sm-10">
												<select class="wilayah form-control" id="kecamatan" name="kecamatan"  >
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Kelurahan</label>
											<div class="col-sm-10">
												<input type="text" name="kelurahan" id="kelurahan" placeholder="" class="form-control" >
											</div>
										</div>
										
									</div>
								</div>
							</div>
							
						</div>
						<div class="tab-pane" id="second22">
							<div class="box-content nopadding">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">No RM</label>
											<div class="col-sm-10">
												<input type="text" name="ID_pj" id="ID_pj" class="form-control"  >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Penanggung Jawab 1</label>
											<div class="col-sm-10">
												<input type="text" name="nama_pj1" id="nama_pj1" class="form-control"  >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">Hubungan</label>
											<div class="col-sm-10">
												<select name='hubungan_pj1' class="form-control" id='hubungan_pj1'>
													<option>AYAH</option>
													<option>IBU</option>
													<option>SAUDARA</option>
													<option>PAMAN/BIBI</option>
													<option value="KAKE">KAKEK</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-2">HP / Telepon</label>
											<div class="col-sm-10">
												<input type="text" name="kontak_pj1" id="kontak_pj1" class="form-control"  >
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<a href="<?=site_url('pasien')?>"  class="btn">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
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
	
	function changeasal(id){
		if(id == 'Rujukan'){
			$("#Rujukan").show(1);
			}else{
			$("#Rujukan").hide(1);
		}
	}
	$(document).ready(function(){
		if($('.wilayah').length > 0) {
			$('.wilayah').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					ajax: {
						url: '<?=site_url('pasien/json_wilayah')?>',
						dataType: 'json',
						delay: 250,
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
	
	$( function() {
		$( "#tanggal_lahir" ).datepicker({
			changeMonth: true,  
			yearRange: "1970:<?=date("Y")?>",  
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
	} );
</script>	