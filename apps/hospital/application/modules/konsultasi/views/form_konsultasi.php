<style>
.tiles > li:hover:before {
content: '';
position: absolute;
left: 0;
top: 0;
width: 109px;
height: 120px;
background: none;
pointer-events: none;
border: 5px solid rgba(0, 0, 0, 0.5);
z-index: 99;
}
.tiles li.white{
border: 1px solid black;
color: #000;
}
.tiles > li > p {
width: 109px;
height: 110px;
display: block;
color: #000;
text-decoration: none;
position: relative;
text-align: center;
}
.tiles > li > p span {
padding-top: 0px;
font-size: 48px;
display: block;
}
.tiles.tiles-center > li > p .name {
text-align: center;
}
.tiles > li > p .name {
font-size: 13px !important;
display: block;
position: absolute;
bottom: 0;
left: 0;
right: 0;
text-align: left;
padding: 3px 10px;
float: left;
}


.table-fixed thead {
width: 98.7%;
}
.table-fixed tbody {
height: 250px;
overflow-y: scroll;
width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
float: left;
border-bottom-width: 0;
}
.fixheight td{
height:88px;
vertical-align:middle !important;
}
.fixheight th{
height:38px;
}
.hidden{
	display:none;
}
</style>
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" data-plugin="form-validation" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
<input type="hidden" name="id_pasien" id="id_pasien" value="<?=element('id_pasien',$konsultasi)?>">
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
					<i class="fa fa-table"></i>
					Daftar <?=$title?>
				</h3>
				
			</div>
			<div class="box-content">
				<div class="row">
					<div class="col-sm-5">
						<ul class="tiles">
							<li class="image">
								<a href="#">
									<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="">
								</a>
							</li>
							<li class="blue long" style="width: 350px">
								<a href="#" style="width: 350px">
									<span class="nopadding"> 
										<h5><?=$konsultasi['nama_lengkap']?></h5>
										<p>Poliklinik : <?=$konsultasi['poliklinik']?></p>
										<p>No. RM : <?=$konsultasi['rm']?></p>
										<p>Pemeriksa : <?=$konsultasi['dokter']?></p>
									</span>
								</a>
							</li>
						</ul>
					</div>
					<?php $style=($ket == 'YA')?'display:none;':''; ?>
					<div class="col-sm-7 form-vertical">
						<div class="form-group">
							<div class="text-right" >
								<button type="button" onclick="modal_mr(<?=element('id_pasien',$konsultasi)?>,<?=element('id',$konsultasi)?>)" id="btnmr" class="btn btn-primary"><i class="fa fa-history"></i> Medical Record</button>
								<button style="<?=$style?>" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Konsultasi Selesai</button>
								<?php if($bill['pindah_poli'] == 'ya'){ ?>
								<button style="<?=$style?>" type="button" onclick="swal('Gagal!','Pasien telah melakukan pindah poli','error');" class="btn btn-primary"><i class="fa fa-repeat"></i> Pindah Konsultasi (Poli)</button>
								<?php }else{ ?>
									
								<button style="<?=$style?>" type="button" onclick="modal_poli(<?=element('id_pasien',$konsultasi)?>,<?=$bill['id']?>)" class="btn btn-primary"><i class="fa fa-repeat"></i> Pindah Konsultasi (Poli)</button>
								<?php }?>
							</div>
						</div>
						<div class="form-group">
							<input name="id" type="hidden" value="<?=element('id',$konsultasi)?>">
							<textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder=" Patient Remarks "><?=element('catatan',$konsultasi)?></textarea>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-sm-12">
						<ul class="tiles tiles-center">
							<?php foreach($anamesa as $anms){ ?>
								<li class="white">
									<p>
										<span>
											<img src="<?=FILES_HOST?>/<?=$anms['icon']?>">
										</span>
										<a href="javascript.void(0)" class="anamesa_<?=$anms['id_ms_anamesa']?>" id="anamesa_<?=$anms['id_ms_anamesa']?>" data-plugin="xeditable" data-url="<?=site_url('konsultasi/anamesa_edit/'.$anms['id_ms_anamesa'].'/'.$anms['id_anamesa'])?>" data-type="number" data-pk="<?=$anms['id_ms_anamesa']?>" data-original-title="<?=$anms['nama'].' ['.$anms['satuan'].']'?>"><?=$anms['hasil']?></a>
										<span class="name"><?=$anms['nama']?></span>
									</p>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						
					
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_diagnosa" data-toggle="tab" aria-expanded="true"><i class="flaticon-medical-2"></i> Diagnosa</a></li>
							<li class=""><a href="#tab_tindakan" data-toggle="tab" aria-expanded="false"><i class="flaticon-doctor-1"></i> Tindakan</a></li>
							<!--<li class="" style="<?=($poliklinik == null)?'display:none':''?>"><a href="#tab_penunjang" data-toggle="tab" aria-expanded="false"><i class="flaticon-patient-lying-on-stretcher-with-medical-doctor"></i>Penunjang</a></li>
							<li class="" style="display:none"><a href="#tab_penunjang2" data-toggle="tab" aria-expanded="false"><i class="flaticon-patient-lying-on-stretcher-with-medical-doctor"></i>Penunjang</a></li>-->
							<li class=""><a href="#tab_resep" data-toggle="tab" aria-expanded="false"><i class="flaticon-medical"></i>  Resep</a></li>
							<li class="" style="display:none"><a href="#tab_resep2" data-toggle="tab" aria-expanded="false"><i class="flaticon-medical"></i>  Resep</a></li>
							<li class=""><a href="#tab_kondisi_akhir" data-toggle="tab" aria-expanded="false">  Kondisi Akhir</a></li>
						</ul>
						
						
						
						<div class="tab-content nopadding">
							<div class="tab-pane active" id="tab_diagnosa">
								
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
												</h3>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<?php if(strpos($this->session->userdata('id_pol'),'14') !== false){?>
																<th style="width:35%;" class="text-left">Keluhan Pasien</th>
																<th style="width:35%;" class="text-left">Kesimpulan</th>
																<th style="width:10%;" class="text-left">Hamil</th>
																<th style="width:10%;" class="text-left">Hamil Ke</th>
																<th style="width:10%;" class="text-left">Minggu Ke</th>
															<?php }else{ ?>
																<th style="width:50%;" class="text-left">Keluhan Pasien</th>
																<th style="width:50%;" class="text-left">Kesimpulan</th></th>
															<?php } ?>
														</tr>
													</thead>
													<tbody>
														<tr class="fixheight">
															<?php if(strpos($this->session->userdata('id_pol'),'14') !== false){?>
																<td style="width:35%;">
																	<textarea class="form-control" name="keluhan_pasien"><?=$konsultasi['keluhan_pasien']?></textarea>
																</td>
																<td style="width:35%;">
																	<textarea class="form-control" name="kesimpulan"><?=$konsultasi['kesimpulan']?></textarea>
																</td>
																<!--td style="width:20%;">
																	<select name="kondisi_keluar_pasien">
																		<option value="Sehat" < ?= ($konsultasi['kondisi_keluar_pasien'] == 'Sehat')?'selected':''?>>Sehat</option>
																		<option value="Pengobatan Berkala" < ?=($konsultasi['kondisi_keluar_pasien'] == 'Pengobatan Berkala')?'selected':''?>>Dalam Proses Penyembuhan</option>
																		<option value="Rawat Inap" < ?=($konsultasi['kondisi_keluar_pasien'] == 'Rawat Inap')?'selected':''?>>Rawat Inap</option>
																	</select>
																</td-->
																<td style="width:10%;">
																	<input type="radio" name="hamil" value="0" <?=($konsultasi['hamil'] == '0')?'checked':''?>> Ya
																	<input type="radio" name="hamil" value="1" <?=($konsultasi['hamil'] == '1')?'checked':''?>> Tidak
																</td>
																<td style="width:10%;">
																	<input type="number" class="form-control" name="hamil_ke" value="<?=($konsultasi['hamil_ke'] != null)?$konsultasi['hamil_ke']:''?>">
																</td>
																<td style="width:10%;">
																	<input type="number" class="form-control" name="minggu_ke" value="<?=($konsultasi['minggu_ke'] != null)?$konsultasi['minggu_ke']:''?>">
																</td>
															<?php }else{ ?>
																<td style="width:50%;">
																	<textarea class="form-control" name="keluhan_pasien"><?=$konsultasi['keluhan_pasien']?></textarea>
																</td>
																<td style="width:50%;">
																	<textarea class="form-control" name="kesimpulan"><?=$konsultasi['kesimpulan']?></textarea>
																</td>
																<!--td style="width:20%;">
																	<select name="kondisi_keluar_pasien">
																		<option value="Sehat" < ?=($konsultasi['kondisi_keluar_pasien'] == '0')?'selected':''?>>Sehat</option>
																		<option value="Pengobatan Berkala" < ?=($konsultasi['kondisi_keluar_pasien'] == '1')?'selected':''?>>Dalam Proses Penyembuhan</option>
																		<option value="Rawat Inap" < ?=($konsultasi['kondisi_keluar_pasien'] == '2')?'selected':''?>>Rawat Inap</option>
																	</select>
																</td-->
															<?php } ?>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Kode ICD 10
												</h3>
												<div class="actions">
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="addItem('ICD10')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="removeItem('ICD10')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:40%;" class="text-left">Nama </th>
															<th style="width:57%;" class="text-left">Catatan</th>
														</tr>
													</thead>
													<tbody id="diagnosa_ICD10">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-cardiogram"></i>
													Kode ICD 9
												</h3>
												<div class="actions">
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="addItem('ICD09')">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="removeItem('ICD09')">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:40%;" class="text-left">Nama </th>
															<th style="width:57%;" class="text-left">Catatan</th>
														</tr>
													</thead>
													<tbody id="diagnosa_ICD09">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							
							
							
							<div class="tab-pane" id="tab_tindakan">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-first-aid-kit"></i>
													Tindakan Medis
												</h3>
												<div class="actions">
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="addTindakan()">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="removeTindakan()">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:35%;" class="text-left">Nama Tindakan</th>
															<th style="width:7%;" class="text-center">Jumlah</th>
															<th style="width:20%;" class="text-left">Biaya</th>
															<th style="width:35%;" class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="tindakan">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab_penunjang">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-first-aid-kit"></i>
													Penunjang
												</h3>
											</div>
											<div class="box-content nopadding">
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:48.5%; class="text-left">Nama Penunjang</th>
															<th style="width:10%; display:none" class="text-left">Biaya</th>
															<th style="width:48.5%; class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="penunjang">
														<?php foreach($poliklinik2 as $row){ ?>
														<tr class="fixheight">
														<td style="width:3%" class="text-center">
														<input type="hidden" name="penunjang[id][]" value="<?=($penunjang != null)?$penunjang[0]['rowid']:''?>"> 
														<input type="hidden" name="penunjang[id_dokter][]" value="<?=$konsultasi['id_dokter']?>">
														<input type="hidden" name="penunjang[id_pasien][]" value="<?=$konsultasi['id_pasien']?>">
														<input type="hidden" name="penunjang[biaya][]" value="<?=$row['biaya']?>">
														<input type="checkbox" name="penunjang[id_ms_penunjang][]" value="<?=$row['id']?>" <?=($penunjang != null)?'checked':''?>>
														</td>
														<td style="width:48.5%;" class="text-left"><?=$row['nama']?></td>
														<td style="width:48.5%;" class="text-left"><textarea  class="form-control" name="penunjang[keterangan][]"><?=($penunjang != null)?$penunjang[0]['keterangan']:''?></textarea></td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab_penunjang2">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-first-aid-kit"></i>
													Registrasi Penunjang
												</h3>
												
												<div class="actions">
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="addPenunjang()">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" style="<?=$style?>" class="btn btn-mini" onclick="removePenunjang()">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:20%; class="text-left">Nama Penunjang</th>
															<th style="width:19%; class="text-center">Klinis</th>
															<th style="width:10%; class="text-left">Kategori</th>
															<!--th style="width:15%; class="text-left">Kiriman Poliklinik</th-->
															<th style="width:15%; class="text-left">Dokter</th>
															<th style="width:5%; class="text-left">Jumlah</th>
															<th style="width:10%; class="text-left">Biaya</th>
															<th style="width:18%; class="text-left">Keterangan</th>
														</tr>
													</thead>
													<tbody id="penunjang">
														
													</tbody>
												</table>
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab_resep">
								<div class="row">
									<div class="col-sm-12">
										<div class="box">
											<div class="box-title">
												<h3>
													<i class="flaticon-first-aid-kit"></i>
													Resep
												</h3>
											</div>
											<div class="box-content nopadding">
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:100%; class="text-left">Resep</th>
														</tr>
													</thead>
													<tbody id="resep">
														<tr class="fixheight">
															<td style="width:100%;" class="text-left"><textarea class="form-control" name="resep_txt"><?=($konsultasi['resep'] != null)?$konsultasi['resep']:''?></textarea></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_resep2">
								
							</div>
							<div class="tab-pane" id="tab_kondisi_akhir">
								<div style="padding: 10px">
								<div class="row">
									<div class="col-sm-6">
											<label class="control-label col-sm-4">Status</label>
											<div class="col-sm-8 form-group">
												<select name="status_kondisi_akhir" id="status_kondisi_akhir">
													<option value="">--- Pilih Status ---</option>
													<option value="pulang" <?=($konsultasi['status_kondisi_akhir'] == 'pulang')?'selected':''?>>Pulang</option>
													<option value="atas_permintaan_sendiri" <?=($konsultasi['status_kondisi_akhir'] == 'atas_permintaan_sendiri')?'selected':''?>>Atas Permintaan Sendiri</option>
													<option value="dirujuk" <?=($konsultasi['status_kondisi_akhir'] == 'dirujuk')?'selected':''?>>Dirujuk</option>
													<option value="pindah_rawat_inap" <?=($konsultasi['status_kondisi_akhir'] == 'pindah_rawat_inap')?'selected':''?>>Pindah Rawat Inap</option>
													<option value="meninggal" <?=($konsultasi['status_kondisi_akhir'] == 'meninggal')?'selected':''?>>Meninggal</option>
												</select>
											</div>
										<div class="hidden" id="dirujuk-form">
											<label class="control-label col-sm-4">Dirujuk</label>
											<div class="col-sm-8 form-group">
												<select name="dirujuk">
													<option value="">--- Pilih Dirujuk ---</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
									</div>
								</div>
								<div class="row">
										<div class="col-sm-6">
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">Nama Penanggung Jawab</label>
												<div class="col-sm-8 form-group">
													<input type="text" name="nama_penanggung_jawab" class="form-control" value="<?=$konsultasi['nama_penanggung_jawab']?>">
												</div>
											</div>
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">No Hp</label>
												<div class="col-sm-8 form-group">
													<input type="text" name="hp" class="form-control" value="<?=$konsultasi['hp']?>">
												</div>
											</div>
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">Ruang</label>
												<div class="col-sm-8 form-group">
													<select name="id_ruang">
														<option value="">--- Pilih Ruang ---</option>
														<?php foreach($ruang as $r){?>
															<option value="<?=$r['id']?>" <?=($konsultasi['id_ruang'] == $r['id'])?'selected':''?>><?=$r['nama']?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">Kelas</label>
												<div class="col-sm-8 form-group">
													<select name="kelas" id="kelas">
													<option value="">--- Pilih Kelas ---</option>
													<?php foreach($kelas as $r){ ?>
														<option value="<?=$r['kelas']?>" <?=($konsultasi['kelas'] == $r['kelas'])?'selected':''?>><?=$r['kelas']?></option>
													<?php } ?>
													</select>
												</div>
											</div>
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">Kamar</label>
												<div class="col-sm-8 form-group">
													<select name="id_kamar" id="kamar">
														<option value="">--- Pilih Kamar ---</option>
													</select>
												</div>
											</div>
											<div class="hidden" data-rawat="true">
												<label class="control-label col-sm-4">Tarif</label>
												<div class="col-sm-8 form-group">
													<input type="text" name="tarif" id="tarif" class="form-control" value="<?=$konsultasi['tarif']?>">
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
		</div>
	</div>
</div>
</div>
</form>


<form id="pindah_poli" action="<?=site_url('konsultasi/save_poliklinik_pasien')?>" method="POST">
<div id="modal_<?=$id_table?>" class="modal fade in" role="dialog">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> Form Pendaftaran Poliklinik</h4>
		</div>
		<!-- /.modal-header -->
		<div class="modal-body">
			<div class="form-vertical">
				<input type="hidden" name="id_pasien" id="id_pasien" value="<?=element('id_pasien',$konsultasi)?>">					
				<input type="hidden" name="id_komponen" id="id_komponen" value="3">						
				<input type="hidden" name="id_appointment_before" value="<?=$konsultasi['id_appointment']?>">					
				<input type="hidden" name="id_billing_before" value="<?=$bill['id']?>">					
				<div class="form-group">
					<label for="textfield" class="control-label">Pelayanan Medik</label>
					<select name="id_jenis_appointment" class="form-control" id="id_jenis_appointment" data-rule-required="true" >
						<?php foreach($jenis_appointment as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="textfield" class="control-label">Poli Tujuan</label>
					<select name="id_poliklinik" class="form-control" id="id_poliklinik" data-rule-required="true" >
						<option value="">-- Pilih Poliklinik --</option>
						<?php foreach($poliklinik as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
				
				<input type="hidden" name="id_cara_bayar" value="<?=element('id_cara_bayar',$konsultasi)?>">
				<input type="hidden" name="id_bpjs_type" value="<?=element('id_bpjs_type',$konsultasi)?>">
				<input type="hidden" name="no_bpjs" value="<?=element('no_bpjs',$konsultasi)?>">
				<input type="hidden" name="no_polis" value="<?=element('no_polis',$konsultasi)?>">
				<input type="hidden" name="nama_perusahaan" value="<?=element('nama_perusahaan',$konsultasi)?>">
				
			</div>
		</div>
		<!-- /.modal-body -->
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		</div>
		<!-- /.modal-footer -->
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</form>
<div class="modal fade" id="modal_penunjang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:90%" role="document">
    <div class="modal-content"> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">List Data</h4>
      </div>
      <div class="modal-body" id="body_modal_penunjang">
        
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	/*
	$('#pindah_poli').on('submit', function(){
		$('[name="diagnosa[ICD09][rowid][]"]').prop('checked','checked');
		$('[name="diagnosa[ICD10][rowid][]"]').prop('checked','checked');
		$('[name="tindakan[rowid][]"]').prop('checked','checked');
		removeItem('ICD09');
		removeItem('ICD10');
		removeTindakan();
	});
	*/
	$('#status_kondisi_akhir').change(function(){
		var status = $(this).val();
		if(status == 'dirujuk'){
			$('#dirujuk-form').removeClass('hidden');
			$('[data-rawat="true"]').addClass('hidden');
		}else if(status == 'pindah_rawat_inap'){
			$('#dirujuk-form').addClass('hidden');
			$('[data-rawat="true"]').removeClass('hidden');
		}else{
			$('#dirujuk-form').addClass('hidden');
			$('[data-rawat="true"]').addClass('hidden');
		}
	});
	$('#kelas').change(function(){
		var kelas = $(this).val();
		$.ajax({
			url	 :"<?=site_url('konsultasi/get_kamar')?>",
			data :{
				kelas:kelas
			},
			type :"post",
			success : function(jdata){
				$('#kamar').html(jdata);
			}
		});
	});
	$('#kamar').change(function(){
		var id_kamar = $(this).val();
		$.ajax({
			url	 :"<?=site_url('konsultasi/get_tarif_kamar')?>",
			data :{
				id:id_kamar
			},
			type :"post",
			success : function(jdata){
				$('#tarif').val(jdata);
			}
		});
	});
});
function modal_poli(id_pasien,id_bill){

		var formz = $('#form_<?=$id_table?>');
		formz[0].reset();
		$('#modal_<?=$id_table?>').modal('show');
		formz.find('select').select2();

}

function load_mr(id){
	window.open("<?=base_url()?>konsultasi/form_konsultasi/"+id+"/YA");
}
if ($('[data-plugin="xeditable"]').length > 0) {
$('[data-plugin="xeditable"]').each(function () {
	var id = $(this).attr('id');
	$("#" + id).editable();
});
}




var last_id ;

function addItem(myid){

var select_options = {
	ajax: {
		url: '<?=site_url('konsultasi/json_diagnosa')?>',
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				q: params.term, // search term
				page: params.page,
				type: myid
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

if(last_id){
	last_id++;
}
else
{
	last_id = 1;
}
var tampil = '';

tampil +='<tr class="fixheight" data-'+myid+'-rowid="'+last_id+'">';
tampil +='<td style="width:3%" class="text-center">';
tampil +='<input type="checkbox" name="diagnosa['+myid+'][rowid][]" data-'+myid+'-rowid="'+last_id+'">';
tampil +='<input type="hidden" name="diagnosa['+myid+'][id][]" data-'+myid+'-rowid="'+last_id+'">';
tampil +='</td>';
tampil +='<td style="width:40%" class="">';
tampil +='<select id="code_'+myid+'_'+last_id+'" class="code" name="diagnosa['+myid+'][code][]" data-'+myid+'-rowid="'+last_id+'" style="width:100%">';
tampil +='</select>';
tampil +='</td>';
tampil +='<td style="width:57%;" class="text-center">';
tampil +='<textarea  class="form-control" name="diagnosa['+myid+'][catatan][]" data-'+myid+'-rowid="'+last_id+'"></textarea>';
tampil +='</td>';
tampil +='</tr>';

$('#diagnosa_'+myid).append(tampil);

$('#code_'+myid+'_'+last_id).select2(select_options);

$('[name="diagnosa['+myid+'][rowid][]"][data-'+myid+'-rowid="'+last_id+'"]').focus();
}

function removeItem(myid){
$.ajax({
	type: "POST",
	url: '<?=base_url('konsultasi/ajax_delete_diagnosa/')?>'+myid,
	dataType: 'json',
	data: $('[name="diagnosa['+myid+'][rowid][]"]:checked').serialize(),
});

$('[name="diagnosa['+myid+'][rowid][]"]:checked').each(function(){
	var rowid = $(this).data(myid.toLowerCase()+'-rowid');
	$('tr[data-'+myid+'-rowid="'+rowid+'"]').remove();
});
$('.check_all').prop('checked',false);
return false;
}

function addTindakan(){

var select_options = {
	ajax: {
		url: '<?=site_url('konsultasi/json_tindakan/'.$konsultasi['id_poliklinik'])?>',
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				q: params.term, // search term
				page: params.page
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
};

if(last_id){
	last_id++;
}
else
{
	last_id = 1;
}
var tampil = '';


tampil +='<tr class="fixheight" data-tindakan-rowid="'+last_id+'">';
tampil +='<td style="width:3%" class="text-center">';
tampil +='<input type="checkbox" name="tindakan[rowid][]" data-tindakan-rowid="'+last_id+'">';
tampil +='<input type="hidden" name="tindakan[id][]" data-tindakan-rowid="'+last_id+'">';
tampil +='</td>';
tampil +='<td style="width:35%" class="">';
tampil +='<select  onchange="changebiaya('+last_id+');" onchange="changebiaya('+last_id+');"  onblur="changebiaya('+last_id+');" id="code_tindakan_'+last_id+'" class="code" name="tindakan[id_ms_tindakan][]" data-tindakan-rowid="'+last_id+'" style="width:100%">';
tampil +='</select>';
tampil +='</td>';
tampil +='<td style="width:7%;" class="text-center">';
tampil +='<input type="number" onkeyup="changebiaya('+last_id+');" onchange="changebiaya('+last_id+');"  onblur="changebiaya('+last_id+');"  data-rule-number="true" class="form-control" name="tindakan[jumlah][]" id="jum_'+last_id+'" data-tindakan-rowid="'+last_id+'" value="1">';
tampil +='</td>';
tampil +='<td style="width:20%;" class="text-right" id="biaya_'+last_id+'">'+rupiah(0)+'</td>';
tampil +='<td style="width:35%;" class="text-center"><input type="hidden" name="tindakan[biaya][]" id="biayavalue_'+last_id+'">';
tampil +='<textarea  class="form-control" name="tindakan[keterangan][]" data-tindakan-rowid="'+last_id+'"></textarea>';
tampil +='</td>';
tampil +='</tr>';
$('#tindakan').append(tampil);

$('#code_tindakan_'+last_id).select2(select_options).on('change',function(e){
	console.log(e);
});

$('[name="tindakan[rowid][]"][data-tindakan-rowid="'+last_id+'"]').focus();
}

function addPenunjang2(){

var select_options = {
	ajax: {
		url: '<?=site_url('konsultasi/json_ms_penunjang')?>',
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				q: params.term, // search term
				page: params.page
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
};
if(last_id){
	last_id++;
}
else
{
	last_id = 1;
}
var tampil = '';


tampil +='<tr class="fixheight" data-penunjang-rowid="'+last_id+'">';
tampil +='<td style="width:3%" class="text-center">';
tampil +='<input type="checkbox" name="penunjang[rowid][]" data-penunjang-rowid="'+last_id+'">';
tampil +='<input type="hidden" name="penunjang[id][]" data-penunjang-rowid="'+last_id+'">';
tampil +='</td>';
tampil +='<td style="width:20%; class="text-left"><select data-penunjang-rowid="'+last_id+'" name="penunjang[id_ms_penunjang][]" class="code" id="code_penunjang_'+last_id+'"></select></td>';
tampil +='<td style="width:19%; class="text-center"><input data-penunjang-rowid="'+last_id+'" type="hidden" name="penunjang[biaya][]" id="hargapenunjang'+last_id+'"><input data-penunjang-rowid="'+last_id+'" type="text" name="penunjang[klinis][]" id="klinis" class="form-control" ></td>';
tampil +='<td style="width:10%; text-align:center;"><input data-penunjang-rowid="'+last_id+'" type="hidden" name="penunjang[kategori][]" id="kategoripenunjang'+last_id+'"><button id="btnpenunjang'+last_id+'" onclick="modal_penunjang('+last_id+');" type="button" class="btn btn-success">Input Kategori</button></td>';
tampil +='<td style="width:15%; class="text-left"><input type="hidden" id="tmpbiaya'+last_id+'"><input data-penunjang-rowid="'+last_id+'" type="text" name="penunjang[nama_dokter][]" id="nama_dokter" class="form-control" ></td>';
tampil +='<td style="width:5%;" class="text-right"><input data-penunjang-rowid="'+last_id+'" type="text" name="penunjang[jumlah][]" onblur="changebiayapenunjang('+last_id+')" onkeyup="changebiayapenunjang('+last_id+')" value="1" id="jumlah'+last_id+'" class="form-control" ></td>';
tampil +='<td style="width:10%;" class="text-right" id="biaya_penunjang_'+last_id+'">'+rupiah(0)+'</td>';
tampil +='<td style="width:18%; class="text-left"><textarea  class="form-control" name="penunjang[keterangan][]"  data-penunjang-rowid="'+last_id+'"></textarea></td>';
tampil +='</tr>';
$('#penunjang').append(tampil);

$('#code_penunjang_'+last_id).select2(select_options).on('change',function(e){
	console.log(e);
});

$('[name="penunjang[rowid][]"][data-penunjang-rowid="'+last_id+'"]').focus();
}

function changebiaya(id){
var tindakanid=$("#code_tindakan_"+id).val();	
var jum=$("#jum_"+id).val();	
$.ajax({
type: "POST",
url: '<?=site_url('konsultasi/json_getbiaya')?>',
dataType: 'json',
data: {
	IDTindakan : tindakanid,
	jumlah : jum
},
success: function(data) {
	var rp=rupiah(data.hasil);
	$("#biayavalue_"+id).val(data.hasil);
	$("#biaya_"+id).html(rp);
}
});
return false;

}


function changebiayapenunjang(id){	
var penunjangid=$("#jumlah"+id).val();	
var jum=$("#tmpbiaya"+id).val();
var jml=penunjangid*jum;

	$("#biaya_penunjang_"+id).html(rupiah(jml));
	$("#hargapenunjang"+id).val(jml);

}

function removePenunjang(){
$.ajax({
	type: "POST",
	url: '<?=base_url('konsultasi/ajax_delete_penunjang/')?>',
	dataType: 'json',
	data: $('[name="penunjang[rowid][]"]:checked').serialize(),
});
$('[name="penunjang[rowid][]"]:checked').each(function(){
	var rowid = $(this).data('penunjang-rowid');
	$('tr[data-penunjang-rowid="'+rowid+'"]').remove();
});
$('.check_all').prop('checked',false);
return false;

}
function removeTindakan(){
$.ajax({
	type: "POST",
	url: '<?=base_url('konsultasi/ajax_delete_tindakan/')?>',
	dataType: 'json',
	data: $('[name="tindakan[rowid][]"]:checked').serialize(),
});


$('[name="tindakan[rowid][]"]:checked').each(function(){
	var rowid = $(this).data('tindakan-rowid');
	$('tr[data-tindakan-rowid="'+rowid+'"]').remove();
});
$('.check_all').prop('checked',false);
return false;

}

$(document).ready(function(){	
$('select').select2();
$('[name="id_cara_bayar"]').on("change",function(){
	var id = $(this).val();
	if(id == 2) {
		$('[data-showhide="bpjs"]').removeClass('hidden');
		$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
		
		$('[name="id_bpjs_type"]').attr('data-rule-required','true').removeAttr('disabled');
		$('[name="no_bpjs"]').attr('data-rule-required','true').removeAttr('disabled');
		
		$('[name="no_polis"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="nama_perusahaan"]').attr('data-rule-required','false').attr('disabled',true);
		
		} else if(id == 3 || id == 4){
		$('[data-showhide="bpjs"]').addClass('hidden');
		$('[data-showhide="asuransi_kontraktor"]').removeClass('hidden');
		
		
		$('[name="id_bpjs_type"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="no_bpjs"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="no_polis"]').attr('data-rule-required','true').removeAttr('disabled');
		$('[name="nama_perusahaan"]').attr('data-rule-required','true').removeAttr('disabled');
		} else {
		$('[data-showhide="bpjs"]').addClass('hidden');
		$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
		
		$('[name="id_bpjs_type"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="no_bpjs"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="no_polis"]').attr('data-rule-required','false').attr('disabled',true);
		$('[name="nama_perusahaan"]').attr('data-rule-required','false').attr('disabled',true);
	}
}).trigger('change');

$('.check_all').click(function(e){
	var table= $(e.target).closest('table');
	$('td input:checkbox',table).prop('checked',this.checked);
});

var diagnosa_data = <?=json_encode($diagnosa)?>;
console.log(diagnosa_data);
var x=1;
$.each(diagnosa_data,function(iz,vz){
	addItem(vz.type);
	$.each(vz,function(i,v){
		var icd = vz.type.toLowerCase();
		if(i == 'code'){
			var myid = vz.type;
			var last_id = x;
			$('[name="diagnosa['+vz.type+']['+i+'][]"][data-'+icd+'-rowid="'+x+'"]').select2({
				data: [
				{
					id: vz.code,
					text: vz.code+' | '+vz.deskripsi
				}
				]
			});
			
			
			var select_options = {
				ajax: {
					url: '<?=site_url('konsultasi/json_diagnosa')?>',
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page,
							type: myid
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
			};
			
			$('#code_'+myid+'_'+last_id).select2(select_options);
			
		}
		else
		{
			$('[name="diagnosa['+vz.type+']['+i+'][]"][data-'+icd+'-rowid="'+x+'"]').val(v);
		}
	});
	x++;
});

/*
var penunjang_data = <?=json_encode($penunjang)?>;
$.each(penunjang_data,function(iz,vz){
	addPenunjang();
	$.each(vz,function(i,v){
		if(i == 'id_ms_penunjang'){
			var last_id = x;
			$('[name="penunjang['+i+'][]"][data-penunjang-rowid="'+x+'"]').select2({
				data: [
				{
					id: vz.id_ms_penunjang,
					text: vz.namapenunjang
				}
				]
			});
			
			
			var select_options = {
				ajax: {
					url: '<?=site_url('konsultasi/json_ms_penunjang')?>',
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page
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
			};
			
			$('#code_penunjang_'+last_id).select2(select_options);
			
		}
		else if(i == 'biaya')
		{
			$('#biaya_penunjang_'+x).html(rupiah(v));
			$('#tmpbiaya'+x).val(v);
			$('[name="penunjang['+i+'][]"][data-penunjang-rowid="'+x+'"]').val(v);
		}
		else
		{
			$('[name="penunjang['+i+'][]"][data-penunjang-rowid="'+x+'"]').val(v);
		}
	});
	x++;
});
*/

var tindakan_data = <?=json_encode($tindakan)?>;
$.each(tindakan_data,function(iz,vz){
	addTindakan();
	$.each(vz,function(i,v){
		if(i == 'id_ms_tindakan'){
			var last_id = x;
			$('[name="tindakan['+i+'][]"][data-tindakan-rowid="'+x+'"]').select2({
				data: [
				{
					id: vz.id_ms_tindakan,
					text: vz.nama
				}
				]
			});
			
			
			var select_options = {
				ajax: {
					url: '<?=site_url('konsultasi/json_tindakan/'.$konsultasi['id_poliklinik'])?>',
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page
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
			};
			
			$('#code_tindakan_'+last_id).select2(select_options);
			
		}
		else if(i == 'biaya')
		{
			$('#biaya_'+x).html(rupiah(v));
			$('#biayavalue_'+x).val(v);
			$('[name="tindakan['+i+'][]"][data-tindakan-rowid="'+x+'"]').val(v);
		}
		else
		{
			$('[name="tindakan['+i+'][]"][data-tindakan-rowid="'+x+'"]').val(v);
		}
	});
	x++;
});

$('#pindah_poli').validate({
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
					$('.modal').modal('hide');
					table_reload();
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

	function modal_penunjang(id){
		var penunjangid=$("#code_penunjang_"+id).val();	
		var kategori=$("#kategoripenunjang"+id).val();	
		$.ajax({
			url		:"<?=site_url('konsultasi/modal_penunjang')?>",
			data	:{
				IDPenunjang:penunjangid,
				listkategori:kategori,
				last_id:id
			},
			type	:"post",
			beforeSend:function(){
				$("#btnpenunjang"+id).attr("disabled","disabled");
				$("#btnpenunjang"+id).html("<i class='fa fa-spin fa-spinner'></i> silahkan tunggu..");
			},
			success	:function(data){
				$("#btnpenunjang"+id).removeAttr("disabled");
				$("#btnpenunjang"+id).html("input kategori");
				$('#modal_penunjang').modal('show');
				$('#body_modal_penunjang').html(data);
			}
		});
		return false;
	}
	
	
	function modal_mr(pasien,konsul){
		$.ajax({
			url		:"<?=site_url('konsultasi/modal_mr')?>",
			data	:{
				PasienID:pasien,
				KonsultasiID:konsul
			},
			type	:"post",
			beforeSend:function(){
				$("#btnmr").attr("disabled","disabled");
				$("#btnmr").html("<i class='fa fa-spin fa-spinner'></i> silahkan tunggu..");
			},
			success	:function(data){
				$("#btnmr").removeAttr("disabled");
				$("#btnmr").html("<i class='fa fa-history'></i> Medical Record");
				$('#modal_penunjang').modal('show');
				$('#body_modal_penunjang').html(data);
			}
		});
		return false;
	}
	

</script>

