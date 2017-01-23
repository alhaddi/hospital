<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>

<?php
if(element('status_pegawai',$row) == "PNS"){
	$vara= 'NIP';
	$varb= " : ".element('nip',$row);
}else{
	$vara= 'No Registrasi';
	$varb= " : ".element('no_registrasi_pegawai',$row);
}?>

<div class="container-fluid">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="box box-bordered box-color">

					<div class="tab-content nopadding">
						<div class="tab-pane active" id="tabBiodata">
							<div class="box-content padding">
								<div class="row">
								<table class='table'>
									<tr>
										<td width="10%">
										<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="card">
											<?=get_img('img/foto/'.element('foto',$row),'no-image','','card-img-top img-fluid')?>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
										</div>
										</td>
										<td>
										
										<table class="table">
											<tr>
												<td width="30%"><h5>Status Pegawai</h5></td>
												<td><h5> : <b><?=element('status_pegawai',$row)?></b></h5></td>
											</tr>
											<tr>
												<td><h5>Nama</h5></td>
												<td><h5> : <b><?=element('gelar_depan',$row)?> <?=element('nama',$row)?> <?=element('gelar_belakang',$row)?></b></h5></td>
											</tr>
											<tr>
												<td><h5><?=$vara?></h5></td>
												<td><b><?=$varb?></b></td>
											</tr>
										</table>
										</td>
										<td width="10%"><button type="button" class="btn btn-danger"><i class='fa fa-print'></i></button> <button type="button" onclick="window.open('<?=site_url('hrm/profile/'.element("id",$row))?>','_self');" class="btn btn-info"><i class='fa fa-pencil'></i></button></td>
									</tr>
								</table>
								<table class="table">
									<tr>
										<td width="100%" bgcolor="#368ee0"><h4><font color="white">Biodata</font></h4></td>
									</tr>
								</table>
								
								
								<div class="row">
								
									<div class="col-sm-6">
									<table class="table">
										<tr>
											<td width="30%">Nomor KTP</td>
											<td>
												: <?=element('no_identitas',$row)?>
											</td>
										</tr>										
										<tr>
											<td>Jenis Kelamin</td>
											<td> : 
							<?php 
							if(element('jk',$row)){
								$l=(element('jk',$row) == 'L')?'Laki-laki':'Perempuan';
								echo $l;
							}
							?>
											</td>
										</tr>
										<tr>
											<td>Tempat & Tgl Lahir </td>
											<td> : <?=element('tempat_lahir',$row)?>, <?=date("d/m/Y", strtotime(element('tgl_lahir',$row)));?> 
											</td>
										</tr>

										<tr>
											<td>Usia </td>
											<td> : <?=element('usia',$row)?> Tahun
											</td>
										</tr>

										<tr>
											<td>Agama</td>
											<td>
													<?php 
													if(element('id_agama',$row)){
														echo get_field(element('id_agama',$row),'ms_agama');
													}else{ echo " : -";} ?>
											</td>
										</tr>

										<tr>
											<td>Status Sipil</td>
											<td>							
											<?php 
											if(element('status_sipil',$row)){
												$l=(element('status_sipil',$row) == 'MENIKAH')?'Menikah':'Belum menikah';
												echo " : $l";
											}
											?>
											</td>
										</tr>

										<tr>
											<td>Golongan Darah </td>
											<td> : <?=element('gol_darah',$row)?>
											</td>
										</tr>
										<tr>
											<td>HP</td>
											<td> : <?=element('hp',$row)?>
											</td>
										</tr>
										<tr>
											<td>Telepon</td>
											<td> : <?=element('telp',$row)?>
											</td>
										</tr>
										
										<tr>
											<td>E-mail</td>
											<td> : <?=element('email',$row)?> 
											</td>
										</tr>
										</table>
									</div>
									
									
									<div class="col-sm-6">
										
										<table class="table">
										<tr>
											<td>Negara</td>
											<td> : <?php if(!empty(element('id_ms_wilayah',$row)))
													{
														$kode=element('id_ms_wilayah',$row);
														$wilayah= get_wilayah($kode);
														echo $wilayah->Negara;
													}?>
											</td>
										</tr>
										<tr>
											<td>Propinsi</td>
											<td> : <?php if(!empty(element('id_ms_wilayah',$row)))
													{
														$kode=element('id_ms_wilayah',$row);
														$wilayah= get_wilayah($kode);
														echo $wilayah->Propinsi;
													}?>
											</td>
										</tr>
										<tr>
											<td>Kota</td>
											<td> : <?php if(!empty(element('id_ms_wilayah',$row)))
													{
														$kode=element('id_ms_wilayah',$row);
														$wilayah= get_wilayah($kode);
														echo $wilayah->Kota;
													}?>
											</td>
										</tr>
										<tr>
											<td>Kecamatan</td>
											<td> : <?php if(!empty(element('id_ms_wilayah',$row)))
													{
														$kode=element('id_ms_wilayah',$row);
														$wilayah= get_wilayah($kode);
														echo $wilayah->Kecamatan;
													}?>
											</td>
										</tr>
										<tr>
											<td width="30%">Alamat</td>
											<td> : <?=element('alamat',$row)?>
											</td>
										</tr>
										<tr>
											<td>Desa</td>
											<td> : <?=element('desa',$row)?>
											</td>
										</tr>
											
										</table>
									</div>
									
								</div>
								<div class="box">
											<div class="box-title">
												<h3>
													Jabatan
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:10%;" class="text-left">Jenis</th>
															<th style="width:35%;" class="text-left">Nama Jabatan</th>
															<th style="width:20%;" class="text-left">Unit Kerja</th>
															<th style="width:20%;" class="text-left">Sub Unit Kerja</th>
															<th style="width:10%;" class="text-left">Esselon</th>
															<th style="width:5%;" class="text-left">Jabatan Terakhir</th>
														</tr>
													</thead>
													<tbody id="tJabatan">
													<?php if(count($pegawai_jabatan) > 0){ foreach($pegawai_jabatan as $j){ ?>
														<tr id="checkop<?=element('id',$j)?>">
															<td style="width:10%;" class="text-left"><?=element('jenis_jabatan',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=(element('id_ms_jabatan',$j))?get_field(element('id_ms_jabatan',$j),'ms_jabatan'):''?></td>
															<td style="width:20%;" class="text-left"><?=(element('id_ms_unit_kerja',$j))?get_field(element('id_ms_unit_kerja',$j),'ms_unit_kerja'):''?></td>
															<td style="width:20%;" class="text-left"><?=(element('id_ms_sub_unit_kerja',$j))?get_field(element('id_ms_sub_unit_kerja',$j),'ms_unit_kerja'):''?></td>
															<td style="width:10%;" class="text-left"><?=element('esselon',$j)?></td>
															<td style="width:5%;" class="text-center"><?=(element('jabatan_terakhir',$j) == '1')?'&#10004;':''?></td>
														</tr>
													<?php } 
													}else{
														echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}	?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>
									<div class="box">
										<div class="box-title">
											<h3>
												Kepangkatan
											</h3>
										</div>
										<div class="box-content nopadding">
											<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
												<thead>
													<tr class="fixheight">
														<th style="width:12%;" class="text-left">Gol / Ruang</th>
														<th style="width:35%;" class="text-left">Pangkat</th>
														<th style="width:20%;" class="text-left">Esselon</th>
														<th style="width:20%;" class="text-left">TMT</th>
														<th style="width:10%;" class="text-left">No SK</th>
													</tr>
												</thead>
												<tbody id="tKepangkatan">
												<?php if(count($pegawai_kepangkatan) > 0){
													foreach($pegawai_kepangkatan as $j){ ?>
													<tr id="checkkepangkatan<?=element('id',$j)?>">
														<td style="width:12%;" class="text-left"><?=element('golongan',$j)?> </td>
														<td style="width:35%;" class="text-left"><?=element('pangkat',$j)?></td>
														<td style="width:20%;" class="text-left"><?=element('esselon',$j)?></td>
														<td style="width:20%;" class="text-left"><?=element('tmt',$j)?></td>
														<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
													</tr>
												<?php }
												}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
												}?>
												</tbody>
											</table>
										</div>
									</div>

										<div class="box">
											<div class="box-title">
												<h3>Pendidikan
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">Jenjang</th>
															<th style="width:35%;" class="text-left">Nama Sekolah</th>
															<th style="width:20%;" class="text-left">Prodi</th>
															<th style="width:20%;" class="text-left">Jurusan</th>
															<th style="width:10%;" class="text-left">Tahun Lulus</th>
														</tr>
													</thead>
													<tbody id="tPendidikan">
													<?php if(count($pegawai_pendidikan) > 0){ foreach($pegawai_pendidikan as $j){ ?>
														<tr id="checkpendidikan<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=(element('id_ms_jenjang',$j))?get_field(element('id_ms_jenjang',$j),'ms_jenjang'):''?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama_sekolah',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('program_studi',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('jurusan',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('tahun_lulus',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
														<tr></tr>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Keluarga
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">Hubungan</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Tempat, Tgl Lahir </th>
															<th style="width:20%;" class="text-left">Usia</th>
															<th style="width:10%;" class="text-left">Pekerjaan</th>
														</tr>
													</thead>
													<tbody id="tKeluarga">
													<?php if(count($pegawai_keluarga) > 0){ foreach($pegawai_keluarga as $j){ ?>
														<tr id="checkkeluarga<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('hubungan',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama_lengkap',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tempat_lahir',$j)?>, <?=element('tgl_lahir',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('usia',$j)?></td>
															<td style="width:10%;" class="text-left"><?=(element('id_ms_pekerjaan',$j))?get_field(element('id_ms_pekerjaan',$j),'ms_pekerjaan'):''?></td>
														</tr>
													<?php } 
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
												}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Diklat & Pelatihan
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">Jenis</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Penyelenggara </th>
															<th style="width:20%;" class="text-left">Jml jam</th>
															<th style="width:10%;" class="text-left">Predikat</th>
														</tr>
													</thead>
													<tbody id="tDiklat">
													<?php  if(count($pegawai_diklat_pelatihan) > 0){ foreach($pegawai_diklat_pelatihan as $j){ ?>
														<tr id="checkdiklat<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('jenis',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('penyelenggara',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('jml_jam',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('predikat',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Cuti
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Keterangan</th>
															<th style="width:20%;" class="text-left">Tanggal Berlaku </th>
															<th style="width:20%;" class="text-left">Mulai</th>
															<th style="width:10%;" class="text-left">Hingga</th>
														</tr>
													</thead>
													<tbody id="tCuti">
													<?php  if(count($pegawai_cuti) > 0){ foreach($pegawai_cuti as $j){ ?>
														<tr id="checkcuti<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('keterangan',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_berlaku',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_awal',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('tgl_akhir',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Keanggotaan
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">No Periode</th>
															<th style="width:35%;" class="text-left">Nama</th>
															<th style="width:20%;" class="text-left">Jabatan </th>
															<th style="width:20%;" class="text-left">Tanggal</th>
															<th style="width:10%;" class="text-left">No SK</th>
														</tr>
													</thead>
													<tbody id="tOrganisasi">
													<?php  if(count($pegawai_organisasi) > 0){ foreach($pegawai_organisasi as $j){ ?>
														<tr id="checkorganisasi<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('no_periode',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('jabatan',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_mulai',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
														</tr>
													<?php } 
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Mutasi
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">Jabatan</th>
															<th style="width:35%;" class="text-left">Pangkat</th>
															<th style="width:20%;" class="text-left">Unit Kerja Asal </th>
															<th style="width:20%;" class="text-left">Unit Kerja Tujuan</th>
															<th style="width:10%;" class="text-left">No SK</th>
														</tr>
													</thead>
													<tbody id="tMutasi">
													<?php  if(count($pegawai_mutasi) > 0){ foreach($pegawai_mutasi as $j){ ?>
														<tr id="checkmutasi<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=get_field(element('id_ms_jabatan',$j),'ms_jabatan')?> </td>
															<td style="width:35%;" class="text-left"><?=element('pangkat',$j)?></td>
															<td style="width:20%;" class="text-left"><?=get_field(element('id_ms_unit_kerja_asal',$j),'ms_unit_kerja')?></td>
															<td style="width:20%;" class="text-left"><?=get_field(element('id_ms_unit_kerja_tujuan',$j),'ms_unit_kerja')?></td>
															<td style="width:10%;" class="text-left"><?=element('no_sk',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Penghargaan
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Nama Penghargaan</th>
															<th style="width:20%;" class="text-left">Asal SK </th>
															<th style="width:20%;" class="text-left">Tgl SK</th>
															<th style="width:10%;" class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="tPenghargaan">
													<?php  if(count($pegawai_penghargaan) > 0){ foreach($pegawai_penghargaan as $j){ ?>
														<tr id="checkpenghargaan<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('nama',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('asal_sk',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('tgl_sk',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('keterangan',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>

										<div class="box">
											<div class="box-title">
												<h3>Gaji
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:12%;" class="text-left">No SK</th>
															<th style="width:35%;" class="text-left">Gaji</th>
															<th style="width:20%;" class="text-left">TMT </th>
															<th style="width:20%;" class="text-left">Perubahan gaji</th>
															<th style="width:10%;" class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="tGaji">
													<?php  if(count($pegawai_keluarga) > 0){
														foreach($pegawai_gaji as $j){ ?>
														<tr id="checkgaji<?=element('id',$j)?>">
															<td style="width:12%;" class="text-left"><?=element('no_sk',$j)?> </td>
															<td style="width:35%;" class="text-left"><?=element('gaji',$j)?> </td>
															<td style="width:20%;" class="text-left"><?=element('tmt',$j)?></td>
															<td style="width:20%;" class="text-left"><?=element('perubahan_gaji',$j)?></td>
															<td style="width:10%;" class="text-left"><?=element('keterangan',$j)?></td>
														</tr>
													<?php }
													}else{
													echo "<tr><td colspan='5'><center>-- Belum mengisi --</center></td></tr>";
													}?>
													</tbody>
												</table>
											</div>
										</div>



		</div>		
							</div>		
						</div>		
					</div>		
			</div>		
		</div>		
</div>		
