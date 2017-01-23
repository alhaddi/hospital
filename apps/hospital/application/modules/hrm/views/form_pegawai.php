<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal'  onsubmit="savedata(this); return false;" enctype='multipart/form-data'  data-redirect="<?=site_url('hrm/profile/')?>" id="form_<?=$id_table?>" action="<?=site_url('hrm/save')?>" method="POST">
		<input type="hidden" value="<?=element('id',$row)?>" name="id">
		<div class="col-sm-2">
			<div class="box box-color">
				<div class="box-content padding">
					<div class="row">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
								<?=get_img('img/foto/'.element('foto',$row),'no-image')?>
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
							<div>
								<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span>
									<span class="fileinput-exists">Change</span>
									<input id="foto" type="file" name="foto" >
								</span>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						</div>
								<div class="tabs-container">
									<ul class="tabs tabs-inline tabs-left" style="text-align:left; height:115%; direction:rtl;  overflow:auto;">
										<li class="active">
											<a href="#tabBiodata" data-toggle="tab">
												Biodata <i class="fa fa-user"></i></a>
										</li>
										<?php if(!empty(element('id',$row))){ ?>
										<li class=""><a href="#tabDokumen" data-toggle="tab" aria-expanded="false">Dokumen <i class="fa fa-file-text"></i></a></li>
										<li class="">
											<a href="#tabJabatan" data-toggle="tab">
												Jabatan <i class="fa fa-briefcase"></i></a>
										</li>
										<li class="">
											<a href="#tabKepangkatan" data-toggle="tab">
												Kepangkatan <i class="fa fa-star"></i></a>
										</li>
										<li class="">
											<a href="#tabPendidikan" data-toggle="tab">
												Pendidikan <i class="fa fa-mortar-board"></i></a>
										</li>
										<li class="">
											<a href="#tabKeluarga" data-toggle="tab">
												Keluarga <i class="fa fa-home"></i></a>
										</li>
										<li class="">
											<a href="#tabDiklat" data-toggle="tab">
												Diklat & Pelatihan <i class="fa fa-certificate"></i></a>
										</li>
										<li class="">
											<a href="#tabCuti" data-toggle="tab">
												Cuti <i class="fa fa-calendar"></i></a>
										</li>
										<li class="">
											<a href="#tabOrganisasi" data-toggle="tab">
												Organisasi <i class="fa fa-users"></i></a>
										</li>
										<li class="">
											<a href="#tabMutasi" data-toggle="tab">
												Mutasi <i class="fa fa-exchange"></i></a>
										</li>
										<li class="">
											<a href="#tabPenghargaan" data-toggle="tab">
												Penghargaan <i class="fa fa-trophy"></i></a>
										</li>
										<li class="">
											<a href="#tabGaji" data-toggle="tab">
												Kenaikan Gaji <i class="fa fa-money"></i></a>
										</li>
										<?php } ?>
									</ul>
								</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class="box box-bordered box-color">
				<div class="nopadding" style="margin-top: 20px">

					<div class="tab-content nopadding">
						<div class="tab-pane active" id="tabBiodata">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-6">

																							
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Status Pegawai</label>
											<div class="col-sm-5">
							<?php 
							if(element('status_pegawai',$row)){
								$l=(element('status_pegawai',$row) == 'PNS')?'checked':'';
								$p=(element('status_pegawai',$row) == 'TKK')?'checked':'';
							}else{
								$l='checked'; $p='';
							}
							?>
							
							<table>
								<tr>
									<td width="100">
							<input type="radio" name='status_pegawai' value="PNS" <?=$l?> id="pns"> <label for="jkl">PNS</label> </td>
									<td>
							<input type="radio" name='status_pegawai' value="TKK" <?=$p?> id="tkk"> <label for="jkp">TKK</label></td>
								</tr>
							</table>
											
											</div>
										</div>
	
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">NIP </label>
											<div class="col-sm-8">
												<input name="nip" id="nip" value="<?=element('nip',$row)?>" class="form-control" type="text">
												<input name="jenis_pegawai" id="jenis_pegawai" value="<?=element('jenis_pegawai',$row)?>" class="form-control" type="hidden">
											</div>
										</div>
										<div class="form-group">
											<label for="no_registrasi_pegawai" class="control-label col-sm-4">No Registrasi Pegawai </label>
											<div class="col-sm-8">
												<input name="no_registrasi_pegawai" value="<?=element('no_registrasi_pegawai',$row)?>" id="no_registrasi_pegawai"  class="form-control" type="text">
											</div>
										</div>
										<div class="form-group">
											<label for="no_ktp" class="control-label col-sm-4">Nomor KTP</label>
											<div class="col-sm-8">
												<input type="text" value="<?=element('no_identitas',$row)?>" name="no_identitas" id="no_identitas" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="nama_lengkap" class="control-label col-sm-4">Nama Lengkap <span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input name="nama" value="<?=element('nama',$row)?>" id="nama" class="form-control" type="text"  data-rule-required="true">
											</div>
										</div>
										<div class="form-group">
											<label for="nama_lengkap" class="control-label col-sm-4">Gelar<span class="text-danger"></span></label>
											<div class="col-sm-4">
												<input name="gelar_depan" value="<?=element('gelar_depan',$row)?>" id="gelar_depan" class="form-control" type="text"  placeholder="Gelar Depan">
											</div>
											<div class="col-sm-4">
												<input name="gelar_belakang" value="<?=element('gelar_belakang',$row)?>" id="gelar_belakang" class="form-control" type="text" placeholder="Gelar Belakang"  >
											</div>
										</div>
																							
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Jenis Kelamin</label>
											<div class="col-sm-5">
							<?php 
							if(element('jk',$row)){
								$l=(element('jk',$row) == 'L')?'checked':'';
								$p=(element('jk',$row) == 'P')?'checked':'';
							}else{
								$l=''; $p='';
							}
							?>
							<input type="radio" name='jk' value="L" <?=$l?> id="jkl"> <label for="jkl">Laki-laki</label> 
							<input type="radio" name='jk' value="P" <?=$p?> id="jkp"> <label for="jkp">Perempuan</label>
											
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir <span class="text-danger">*</span></label>
											
											<div class="col-sm-3">
												<input data-rule-required="true" value="<?=element('tempat_lahir',$row)?>" type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" >
											</div>
											<div class="col-sm-3">
												<input data-rule-required="true" type="text" data-plugin="datepicker" name="tgl_lahir" id="tanggal_lahir" value="<?=date("d/m/Y", strtotime(element('tgl_lahir',$row)));?>" class="form-control" >
											</div>
											<div class="col-sm-2">
												<input type="text" name="usia" value="<?=element('usia',$row)?>" id="usia" placeholder="Usia" class="form-control" >
											</div>
										</div>

										<div class="form-group">
											<label for="id_agama" class="control-label col-sm-4">Agama</label>
											<div class="col-sm-8">
												<select name='id_agama' class="form-control" id='id_agama'>
													<?php 
													if(element('id_agama',$row)){
														$array[]=element('id_agama',$row);
													}else{
														$array=array();
													}
													foreach($agama as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>

									</div>
									
									
									<div class="col-sm-6">
										
										<div class="form-group">
											<label for="status_sipil" class="control-label col-sm-4">Status Sipil</label>
											<div class="col-sm-8">							
											<?php 
											if(element('status_sipil',$row)){
												$l=(element('status_sipil',$row) == 'MENIKAH')?'selected':'';
												$p=(element('status_sipil',$row) == 'BELUM MENIKAH')?'selected':'';
											}else{
												$l=''; $p='';
											}
											?>
												<select name='status_sipil' class="form-control" id='status_sipil'>
													<option value="">-- Pilih Status --</option>
													<option <?=$l?> value='MENIKAH'>Menikah</option>
													<option <?=$p?> value="BELUM MENIKAH">Belum Menikah</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label for="gol_darah" class="control-label col-sm-4">Golongan Darah </label>
											<div class="col-sm-8">
												<select name='gol_darah' class="form-control" id='gol_darah'>
											<?php 
											if(element('gol_darah',$row)){
												$a=(element('gol_darah',$row) == 'A')?'selected':'';
												$b=(element('gol_darah',$row) == 'AB')?'selected':'';
												$c=(element('gol_darah',$row) == 'B')?'selected':'';
												$d=(element('gol_darah',$row) == 'O')?'selected':'';
											}else{
												$a=''; $b=''; $c=''; $d='';
											}
											?>
													<option <?=$a?> value="A">A</option>
													<option <?=$b?> value="AB">AB</option>
													<option <?=$c?> value="B">B</option>
													<option <?=$d?> value="O">O</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="alamat" class="control-label col-sm-4">Alamat</label>
											<div class="col-sm-8">
												<textarea name="alamat" id="alamat" class="form-control"><?=element('alamat',$row)?></textarea>
											</div>
											
										</div>
										<div class="form-group">
											<label for="alamat" class="control-label col-sm-4">Desa</label>
											<div class="col-sm-8">
												<textarea name="desa" id="desa" class="form-control"><?=element('desa',$row)?></textarea>
											</div>
											
										</div>										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Kecamatan</label>
											<div class="col-sm-8">
												<select data-wilayah="true" class="form-control" id="id_wilayah" name="id_wilayah"  >
												</select>
											</div>
										</div>
										
											
										<div class="form-group">
											<label for="password" class="control-label col-sm-4">Kontak</label>
											<div class="col-sm-4">
												<input data-rule-number="true" value="<?=element('hp',$row)?>" type="text" name="hp" id="hp" placeholder="No HP" class="form-control" >
											</div>
											<div class="col-sm-4">
												<input data-rule-number="true"  value="<?=element('telp',$row)?>" type="text" name="telp" id="telp" placeholder="No Telepon"  class="form-control">
											</div>
										</div>
										
										<div class="form-group">
											<label for="email" class="control-label col-sm-4">E-mail</label>
											<div class="col-sm-8">
												<input name="email" id="email"  value="<?=element('email',$row)?>" class="form-control" type="text" data-rule-email="true">
											</div>
										</div>
										<div class="form-group">
											<label for="id_agama" class="control-label col-sm-4">Akses Poli</label>
											<div class="col-sm-8">
												<select name='id_poliklinik[]' class="form-control" multiple id='id_poliklinik'>
													<?php 
													if(element('id_poliklinik',$row)){
														$array=explode(',',element('id_poliklinik',$row));
													}else{
														$array=array();
													}
													
													foreach($this->db->get('ms_poliklinik')->result_array() as $r){ 
													$s=(in_array($r['id'],$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									
									
								</div>
							</div>
						</div>

						<?php if(!empty(element('id',$row))){ ?>
						<div class="tab-pane" id="tabJabatan">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Riwayat Jabatan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadjabatan')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkop','pegawai_jabatan')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Jabatan Terakhir</th>
															<th style="width:35%;" class="text-left">Nama Jabatan</th>
															<th style="width:20%;" class="text-left">Unit Kerja</th>
															<th style="width:20%;" class="text-left">Sub Unit Kerja</th>
															<th style="width:10%;" class="text-left">Esselon</th>
														</tr>
													</thead>
													<tbody id="tJabatan">
													<?php foreach($pegawai_jabatan as $j){ ?>
														<tr id="checkop<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkop" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=(element('jabtan_terakhir',$j) == '1')?'Ya':'-';?> </td>
															<td style="width:35%;" class="text-left"><?=(element('id_ms_jabatan',$j))?get_field(element('id_ms_jabatan',$j),'ms_jabatan'):''?> <a style="cursor:pointer;" onclick="addData('loadjabatan',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=(element('id_ms_unit_kerja',$j))?get_field(element('id_ms_unit_kerja',$j),'ms_unit_kerja'):''?></td>
															<td style="width:20%;" class="text-left"><?=(element('id_ms_sub_unit_kerja',$j))?get_field(element('id_ms_sub_unit_kerja',$j),'ms_unit_kerja'):''?></td>
															<td style="width:10%;" class="text-left"><?=element('esselon',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabKepangkatan">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Riwayat Kepangkatan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadkepangkatan')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkkepangkatan','pegawai_kepangkatan')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Gol / Ruang</th>
															<th style="width:35%;" class="text-left">Pangkat</th>
															<th style="width:20%;" class="text-left">Esselon</th>
															<th style="width:20%;" class="text-left">TMT</th>
															<th style="width:10%;" class="text-left">No SK</th>
														</tr>
													</thead>
													<tbody id="tKepangkatan">
													<?php foreach($pegawai_kepangkatan as $j){ ?>
														<tr id="checkkepangkatan<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkkepangkatan" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=get_field(element('golongan',$j),'ms_golongan')?> </td>
															<td style="width:35%;" class="text-left"><?=element('pangkat',$j)?> <a style="cursor:pointer;" onclick="addData('loadkepangkatan',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('esselon',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tmt',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabPendidikan">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Pendidikan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadpendidikan')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkpendidikan','pegawai_pendidikan')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Jenjang</th>
															<th style="width:35%;" class="text-left">Nama Sekolah</th>
															<th style="width:20%;" class="text-left">Prodi</th>
															<th style="width:20%;" class="text-left">Jurusan</th>
															<th style="width:10%;" class="text-left">Tahun Lulus</th>
														</tr>
													</thead>
													<tbody id="tPendidikan">
													<?php foreach($pegawai_pendidikan as $j){ ?>
														<tr id="checkpendidikan<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkpendidikan" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=(element('id_ms_jenjang',$j))?get_field(element('id_ms_jenjang',$j),'ms_jenjang'):''?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama_sekolah',$j)?> <a style="cursor:pointer;" onclick="addData('loadpendidikan',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('program_studi',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('jurusan',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('tahun_lulus',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabKeluarga">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Keluarga
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadkeluarga')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkkeluarga','pegawai_keluarga')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Hubungan</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Tempat, Tgl Lahir </th>
															<th style="width:20%;" class="text-left">Usia</th>
															<th style="width:10%;" class="text-left">Pekerjaan</th>
														</tr>
													</thead>
													<tbody id="tKeluarga">
													<?php foreach($pegawai_keluarga as $j){ ?>
														<tr id="checkkeluarga<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkkeluarga" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('hubungan',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama_lengkap',$j)?> <a style="cursor:pointer;" onclick="addData('loadkeluarga',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('tempat_lahir',$j)?>, <?=element('tgl_lahir',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('usia',$j)?></td>
															<td style="width:10%;" class="text-left"><?=(element('id_ms_pekerjaan',$j))?get_field(element('id_ms_pekerjaan',$j),'ms_pekerjaan'):''?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabDiklat">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Diklat & Pelatihan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loaddiklat')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkdiklat','pegawai_diklat_pelatihan')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Jenis</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Penyelenggara </th>
															<th style="width:20%;" class="text-left">Jml jam</th>
															<th style="width:10%;" class="text-left">Predikat</th>
														</tr>
													</thead>
													<tbody id="tDiklat">
													<?php foreach($pegawai_diklat_pelatihan as $j){ ?>
														<tr id="checkdiklat<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkdiklat" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('jenis',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?> <a style="cursor:pointer;" onclick="addData('loaddiklat',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('penyelenggara',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('jml_jam',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('predikat',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabCuti">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Cuti
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadcuti')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkcuti','pegawai_cuti')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Keterangan</th>
															<th style="width:20%;" class="text-left">Tanggal Berlaku </th>
															<th style="width:20%;" class="text-left">Mulai</th>
															<th style="width:10%;" class="text-left">Hingga</th>
														</tr>
													</thead>
													<tbody id="tCuti">
													<?php foreach($pegawai_cuti as $j){ ?>
														<tr id="checkcuti<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkcuti" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('keterangan',$j)?> <a style="cursor:pointer;" onclick="addData('loadcuti',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_berlaku',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_awal',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('tgl_akhir',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabOrganisasi">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Keanggotaan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadorganisasi')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkorganisasi','pegawai_keanggotaan_organisasi')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">No Periode</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Jabatan </th>
															<th style="width:20%;" class="text-left">Tanggal</th>
															<th style="width:10%;" class="text-left">No SK</th>
														</tr>
													</thead>
													<tbody id="tOrganisasi">
													<?php foreach($pegawai_organisasi as $j){ ?>
														<tr id="checkorganisasi<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkorganisasi" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('no_periode',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?> <a style="cursor:pointer;" onclick="addData('loadorganisasi',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('jabatan',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_mulai',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabMutasi">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Mutasi
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadmutasi')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkmutasi','pegawai_mutasi')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">Jabatan</th>
															<th style="width:35%;" class="text-left">Pangkat</th>
															<th style="width:20%;" class="text-left">Unit Kerja Asal </th>
															<th style="width:20%;" class="text-left">Unit Kerja Tujuan</th>
															<th style="width:10%;" class="text-left">No SK</th>
														</tr>
													</thead>
													<tbody id="tMutasi">
													<?php foreach($pegawai_mutasi as $j){ ?>
														<tr id="checkmutasi<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkmutasi" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=get_field(element('id_ms_jabatan',$j),'ms_jabatan')?> </td>
															<td style="width:35%;" class="text-left"><?=element('pangkat',$j)?> <a style="cursor:pointer;" onclick="addData('loadmutasi',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=get_field(element('id_ms_unit_kerja_asal',$j),'ms_unit_kerja')?></td>
															<td style="width:20%;" class="text-left"><?=get_field(element('id_ms_unit_kerja_tujuan',$j),'ms_unit_kerja')?></td>
															<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabPenghargaan">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Penghargaan
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadpenghargaan')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkpenghargaan','pegawai_penghargaan')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Nama Penghargaan</th>
															<th style="width:20%;" class="text-left">Asal SK </th>
															<th style="width:20%;" class="text-left">Tgl SK</th>
															<th style="width:10%;" class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="tPenghargaan">
													<?php foreach($pegawai_penghargaan as $j){ ?>
														<tr id="checkpenghargaan<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkpenghargaan" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?> <a style="cursor:pointer;" onclick="addData('loadpenghargaan',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('asal_sk',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_sk',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('keterangan',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabGaji">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Data Gaji
												</h3>
												<div class="actions">
													<button type="button" class="btn btn-mini" onclick="addData('loadgaji')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="hapus('checkgaji','pegawai_gaji')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center">#</th>
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Gaji</th>
															<th style="width:20%;" class="text-left">TMT </th>
															<th style="width:20%;" class="text-left">Perubahan gaji</th>
															<th style="width:10%;" class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="tGaji">
													<?php foreach($pegawai_gaji as $j){ ?>
														<tr id="checkgaji<?=element('id',$j)?>">
															<td style="width:3%;" class="text-center "><input class="checkgaji" type="checkbox" value="<?=element('id',$j)?>"></td>
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('gaji',$j)?> <a style="cursor:pointer;" onclick="addData('loadgaji',<?=element('id',$j)?>)"><i  class="fa fa-pencil"></i></a></td>
															<td style="width:20%;" class="text-left"><?=element('tmt',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('perubahan_gaji',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('keterangan',$j)?></td>
														</tr>
													<?php }?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>									

								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabDokumen">

						<div class="box-content padding">
								<div class="row">
								<button type="button" class="btn btn-info" onclick="addData('loaddokumen')">
								<i class="fa fa-plus"></i> Masukan Dokumen
								</button>
								<br>
								<br>
									<table class="table table-fixed table-hover table-nomargin table-bordered">
										<thead>
										<tr class="fixheight">
											<th class="text-center">No.</th>
											<th class="text-center">Nama Dokumen</th>
											<th class="text-center">Action</th>
										</tr>
										</thead>
										<tbody>
										<?php 
										$no=1;
										$z="";
										$id=element('id',$row);
										$domain = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
										$domain.="://files.hims.co.id";
											foreach($ms_dokumen_pegawai as $tab){
												$data=$this->db->query("SELECT id,link FROM pegawai_dokumen WHERE id_ms_pegawai='$id' AND id_ms_dokumen_pegawai='".$tab['id']."'")->row_array();
												if(!empty($data['id'])){
													$show="<a href='".$domain."/hospital/img/dokumen/".$data['link']."' target='_blank' class='btn btn-default'>Lihat</a> <a href='".$domain."/hospital/img/dokumen/".$data['link']."' download class='btn btn-default'>Unduh</button>";
													$s=$data['id'];
												}else{
													$show="-- Belum Upload--";
													$s=0;
												}
												
												
											echo "<tr>
													<td>".$no."</td>
													<td>".$tab['nama']."</td>
													<td class='text-center'>".$show."</td>
												</tr>";
												$no++;
											}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
<?php } ?>
					</div>
				</div>
			</div>	
				
			<div class="form-actions text-left">
				
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
				<button type="button" data-action="back" class="btn btn-default"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>		
	</form>

<!-- Modal -->
<form  class='form-horizontal' onsubmit="savetambahan(this); return false;" enctype='multipart/form-data' id="form_<?=$id_table?>" action="<?=site_url('hrm/save_pegawai')?>" method="POST">
<input type="hidden" name="id_ms_pegawai" value="<?=element('id',$row)?>">
<div class="modal fade" id="mdlall"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
      </div>
      <div class="modal-body" id="badd">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="bs">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- Modal -->
</div>

<?php
$kode=element("id_ms_wilayah",$row);
	if(!empty($kode))
	{
		$wilayah = get_wilayah($kode);
	}
	else
	{
		$wilayah['Kode_Kecamatan'] = 21140;
		$wilayah['Kecamatan'] = 'Kec. Tarogong Kidul';
		$wilayah = (object) $wilayah;
	}
?>

<script>

	function savedata(formz){
		var formData = new FormData(formz);	
		$.ajax({
			type:'POST',
			url: $(formz).attr('action'),
			data:formData,
			cache:false,
			contentType: false,
			processData: false,		
			beforeSend:function(e){
				$(".btns").html("<i class='fa fa-spinner fa-spin'></i> Silahkan tunggu...");
				$(".btns").attr('disabled','disabled');
			},
			success:function(data){
			window.location.href = '<?=site_url("hrm/profile/".element('id',$row))?>';
				
				$(".btns").html('<i class="fa fa-save"></i> Simpan Data');
				$(".btns").removeAttr('disabled');
			},
			error: function(data){

			}
		});
	}
function hapus(klas,tabel){
	swal({
	  title: "Apakah anda yakin?",
	  text: "data yang terhapus tidak akan bisa di kembalikan dengan cara apapun!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Hapus data ini !",
	  cancelButtonText: "Batal"
	}).then(
	function(){
	var chkArray = [];
	
	$("."+klas+":checked").each(function() {
		chkArray.push($(this).val());
	});
	var inputElements;
	checkid = chkArray.join(',') ;
	
	if(checkid)
	{
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>index.php/hrm/hapus",
			data: {
				ID: checkid,
				t:tabel
			},
			success: function(data) {
				var mySplitResult = checkid.split(",");
				for (i = 0; i < mySplitResult.length; i++) { 
					$("#"+klas+mySplitResult[i]).remove();
				}
				swal("Sukses!", "Data berhasil di hapus.", "success");
			}
		});
	}
	else
	{
		swal("Belum memilih data!");
	}
	});
}



	function savetambahan(formz){
		var formData = new FormData(formz);	
		$.ajax({
			type:'POST',
			url: $(formz).attr('action'),
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType:'json',
			beforeSend:function(e){
				$("#bs").html("<i class='fa fa-spinner fa-spin'></i> Silahkan tunggu...");
				$("#bs").attr('disabled','disabled');
			},
			success:function(data){
			
			$.when( $("#"+data.tr).remove() ).done(function( x ) {
				$("#"+data.tbody).append(data.isi);
			});
			$("#mdlall").modal("hide");
			$("#bs").html('<i class="fa fa-save"></i> Simpan Data');
			$("#bs").removeAttr('disabled');
			
			},
			error: function(data){

			}
		});
	}

	
	function addData(url,id = null){
			
			$.ajax({
			type:'POST',
			url: "<?=base_url()?>index.php/hrm/"+url,
			data:{
					tid : id,
					id_ms_pegawai : '<?=element('id',$row)?>'
			},
			beforeSend:function(e){
				$("#mdlall").modal("show");
				$("#badd").html("<center><i class fa fa-spin fa-spinner></i> Memuat data...</center>");
			},
			success:function(data){
				$("#badd").html(data);
			},
			error: function(data){

			}
		});	
		
	}

	$(document).ready(function(){
		$('select').select2();
		
		<?php if(!empty($wilayah)) { ?>
			$('[name="id_wilayah"]').select2({
				data: [
				{
					id: '<?=$wilayah->Kode_Kecamatan?>',
					text: '<?=$wilayah->Kecamatan?>'
				},
			]});
		<?php } ?>
		
		$('[name="status_pegawai"]').on("change",function(){
			var id = $(this).val();
			console.log(id);
			if(id == 'PNS'){
				$('[data-showhide="nip"]').removeClass('hidden');
				$('[data-showhide="no_registrasi_pegawai"]').addClass('hidden');
				} else {
				$('[data-showhide="no_registrasi_pegawai"]').removeClass('hidden');
				$('[data-showhide="nip"]').addClass('hidden');
			}
		}).trigger('change');
		
		$('[name="tanggal_lahir"]').on("change",function(){
			var tgl = $(this).val();
			var usia = hitungUsia(tgl);
			if(isNaN(usia) == true){
				usia = null;
			}
			$('[name="usia"]').val(usia);
		});		
		
		if($('[data-wilayah="true"]').length > 0) {
			$('[data-wilayah="true"]').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					minimumInputLength: 3,
					ajax: {
						url: '<?=site_url('dashboard/select2_wilayah')?>',
						dataType: 'json',
						data: function (params) {
							return {
								q: params.term, // search term
								//page: params.page,
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

