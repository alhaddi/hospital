<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal'  onsubmit="savedata(this); return false;" enctype='multipart/form-data'  data-redirect="<?=site_url('pegawai/loadForm/')?>" id="form_<?=$id_table?>" action="<?=site_url('pegawai/save_pegawai')?>" method="POST">
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
									<input id="foto" type="file" name="ff" <?=(is_file(FILES_PATH.'/img/foto/'.element('foto',$row)))?"":'data-rule-required="true"'?>>
								</span>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-10">
			<div class="box box-bordered box-color">
				<div class="nopadding" style="margin-top: 20px">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tabBiodata" data-toggle="tab" aria-expanded="true">Biodata</a></li>
						<li class=""><a href="#tabKerja" data-toggle="tab" aria-expanded="false">Kerja</a></li>
						<li class=""><a href="#tabPendidikan" data-toggle="tab" aria-expanded="false">Pendidikan</a></li>
						<li class=""><a href="#tabKeluarga" data-toggle="tab" aria-expanded="false">Keluarga</a></li>
						<li class=""><a href="#tabDokumen" data-toggle="tab" aria-expanded="false">Dokumen</a></li>
					</ul>
					<div class="tab-content nopadding">
						<div class="tab-pane active" id="tabBiodata">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group" data-showhide="nip">
											<label for="nip" class="control-label col-sm-4">NIP </label>
											<div class="col-sm-8">
												<input name="nip" id="nip" value="<?=element('nip',$row)?>" class="form-control" type="text">
											</div>
										</div>
										<div class="form-group" data-showhide="no_registrasi_pegawai">
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
											<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir <span class="text-danger">*</span></label>
											
											<div class="col-sm-3">
												<input data-rule-required="true" value="<?=element('tempat_lahir',$row)?>" type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" >
											</div>
											<div class="col-sm-3">
												<input data-rule-required="true" type="text" data-plugin="datepicker" name="tanggal_lahir" id="tanggal_lahir" value="<?=date("d/m/Y", strtotime(element('tgl_lahir',$row)));?>" class="form-control" >
											</div>
											<div class="col-sm-2">
												<input type="text" name="usia" value="<?=element('usia',$row)?>" id="usia" placeholder="Usia" class="form-control" >
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
										
										<!--div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Kecamatan</label>
											<div class="col-sm-8">
												<select data-wilayah="true" class="form-control" id="id_wilayah" name="id_wilayah"  >
												</select>
											</div>
										</div-->
										
											
										<div class="form-group">
											<label for="id_agama" class="control-label col-sm-4">Agama</label>
											<div class="col-sm-8">
												<select name='id_agama' class="form-control" id='id_agama'>
													<?php 
													if(element('id_agama',$row)){
														$array=element('id_agama',$row);
													}else{
														$array=array();
													}
													foreach($agama as $r){ 
													$s=(in_array($r->id,$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
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
											<label for="alamat" class="control-label col-sm-4">Alamat</label>
											<div class="col-sm-8">
												<textarea name="alamat" id="alamat" class="form-control"><?=element('alamat',$row)?></textarea>
											</div>
											
										</div>
									</div>
									
									
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tabKerja">
							<div class="box-content padding">
								<div class="row">
									<div class="col-sm-6">
										<b>Kepangkatan</b><hr>
										<div class="form-group">
											<label for="status_pegawai" class="control-label col-sm-4">Status Pegawai <span class="text-danger">*</span></label>
											<div class="col-sm-8">
											<?php 
											if(element('status_pegawai',$row)){
												$l=(element('status_pegawai',$row) == 'PNS')?'selected':'';
												$p=(element('status_pegawai',$row) == 'TKK')?'selected':'';
											}else{
												$l=''; $p='';
											}
											?>
												<select onchange="changestatus();" readonly id="status_pegawai" name="status_pegawai" class='form-control'>
												<option <?=$l?>>PNS</option>
												<option <?=$p?>>TKK</option>
												</select>
											</div>
										</div>								
										<div class="form-group">
											<label for="status_pegawai" class="control-label col-sm-4">Kedudukan Hukum <span class="text-danger">*</span></label>
											<div class="col-sm-8">
											<?php 
											if(element('kedudukan_hukum',$row)){
												$l=(element('kedudukan_hukum',$row) == 'aktif')?'selected':'';
												$p=(element('kedudukan_hukum',$row) == 'tidakaktif')?'selected':'';
											}else{
												$l=''; $p='';
											}
											?>
											<select name='kedudukan_hukum' readonly class="form-control" id='status_pegawai'>
													<option <?=$l?> value="aktif">Aktif</option>
													<option <?=$p?> value="tidakaktif">Tidak Aktif</option>
												</select>
											</div>
										</div>
										
										<div class="form-group" data-showhide="nip">
											<label for="nip" class="control-label col-sm-4">Pangkat Terakhir </label>
											<div class="col-sm-8">
												<input type="text" name="pangkat_terakhir" value="<?=element('pangkat_terakhir',$row)?>" id="pangkat_terakhir"  class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="masa_kerja_thn" class="control-label col-sm-4">Masa Kerja <span class="text-danger">*</span></label>
											<div class="col-sm-4">
												<input name="masa_kerja_thn" value="<?=element('masa_kerja_thn',$row)?>" id="masa_kerja_thn" placeholder="Tahun" class="form-control" type="text">
											</div>
											<div class="col-sm-4">
												<input name="masa_kerja_bln" value="<?=element('masa_kerja_bln',$row)?>" id="masa_kerja_bln" placeholder="Bulan" class="form-control" type="text">
											</div>
										</div>
										<div class="form-group">
											<label for="kode_golongan" class="control-label col-sm-4">Kode Golongan <span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<select name='kode_golongan' class="form-control" id='kode_golongan'>
													<?php 
													if(element('kode_golongan',$row)){
														$array[]=element('kode_golongan',$row);
													}else{
														$array=array();
													}
													foreach($kode_golongan as $r){ 
													$s=(in_array(element('kd',$r),$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('kd',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">TMT Golongan<span class="text-danger">*</span></label>
											
											<div class="col-sm-8">
												<input data-rule-required="true" type="text" data-plugin="datepicker" name="tgl_mulai_golongan" value="<?=date("d/m/Y",strtotime(element('tgl_mulai_golongan',$r)))?>" id="tgl_mulai_golongan" class="form-control" >
											</div>
										</div>
										
									</div>
									<div class="col-sm-6">
										<b>Jabatan</b><hr>

										<div class="form-group">
											<label for="id_ms_jabatan" class="control-label col-sm-4">Jabatan <span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<select name='id_ms_jabatan' class="form-control" id='id_ms_jabatan'>
													<?php 
													if(element('id_ms_jabatan',$row)){
														$array[]=element('id_ms_jabatan',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_jabatan as $r){ 
													$s=(in_array(element('id',$r),$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('kode_jenis_jabatan',$r).' - '.element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="id_ms_unit_kerja" class="control-label col-sm-4">Unit Kerja <span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<select name='id_ms_unit_kerja' class="form-control" id='id_ms_unit_kerja'>
												<?php 
													if(element('id_ms_unit_kerja',$row)){
														$array[]=element('id_ms_unit_kerja',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_unit_kerja as $r){ 
													$s=(in_array(element('id',$r),$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>										
										<div class="form-group">
											<label for="id_ms_unit_kerja" class="control-label col-sm-4">Sub Unit Kerja <span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<select name='id_sub_ms_unit_kerja' class="form-control" id='id_ms_unit_kerja'>
													<?php 
													if(element('id_sub_ms_unit_kerja',$row)){
														$array[]=element('id_sub_ms_unit_kerja',$row);
													}else{
														$array=array();
													}
													foreach($id_ms_unit_kerja as $r){ 
													$s=(in_array(element('id',$r),$array))?'selected':'';
													?>
														<option <?=$s?> value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Penempatan Unit Kerja </label>
											<div class="col-sm-8">
												<input name="penempatan_unit_kerja" value="<?=element('penempatan_unit_kerja',$row)?>" id="penempatan_unit_kerja"  class="form-control" type="text">
											</div>
										</div>
										<div class="form-group">
											<label for="nip" class="control-label col-sm-4">Eselon Jabatan </label>
											<div class="col-sm-8">
												<input name="eselon_jabatan" value="<?=element('eselon_jabatan',$row)?>" id="eselon_jabatan"  class="form-control" type="text">
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">TMT Jabatan<span class="text-danger"></span></label>
											
											<div class="col-sm-8">
												<input data-rule-required="true" value="<?=date("d/m/Y",strtotime(element('tgl_mulai_tugas_jabatan',$row)))?>" type="text" data-plugin="datepicker" name="tgl_mulai_tugas_jabatan" id="tgl_mulai_tugas_jabatan" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield"  class="control-label col-sm-4">Tanggal & No SK Jabatan<span class="text-danger"></span></label>
											
											<div class="col-sm-3">
												<input  type="text" value="<?=date("d/m/Y",strtotime(element('penandatangan_sk',$row)))?>" data-plugin="datepicker" name="penandatangan_sk" id="penandatangan_sk" class="form-control" >
											</div>											
											<div class="col-sm-5">
												<input  type="text" value="<?=element('no_sk_jabatan',$row)?>"  name="no_sk_jabatan" id="no_sk_jabatan" placeholder="Nomor SK Jabatan" class="form-control" >
											</div>
										</div>
										<div class="form-group">
											<label for="textfield" class="control-label col-sm-4">Penandatangan SK Jabatan<span class="text-danger"></span></label>
											
											<div class="col-sm-8">
												<input type="text" value="<?=element('penandatangan_sk',$row)?>" name="penandatangan_sk" id="penandatangan_sk" class="form-control" >
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
													<button type="button" class="btn btn-mini" onclick="addpendidikan()">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="removePendidikan()">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:17%;" class="text-left">Tingkat</th>
															<th style="width:35%;" class="text-left">Nama Sekolah</th>
															<th style="width:35%;" class="text-left">Jurusan</th>
															<th style="width:20%;" class="text-left">Tahun Lulus</th>
														</tr>
													</thead>
													<tbody id="pendidikan">
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
													<button type="button" class="btn btn-mini" onclick="addKeluarga()">
														<i class="fa fa-plus"></i> Tambah
													</button>
													<button type="button" class="btn btn-mini" onclick="removeKeluarga()">
														<i class="fa fa-trash"></i> Hapus
													</button>
												</div>
											</div>
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-center"><input class="check_all" type="checkbox"></th>
															<th style="width:30%;" class="text-left">Hubungan</th>
															<th style="width:50%;" class="text-left">Nama</th>
															<th style="width:17%;" class="text-left">Jenis Kelamin</th>
														</tr>
													</thead>
													<tbody id="keluarga">
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
								<button type="button" class="btn btn-info" onclick="abc();">
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
											foreach($ms_dokumen_pegawai as $tab){
												$data=$this->db->query("SELECT id,link FROM pegawai_dokumen WHERE id_ms_pegawai='$id' AND id_ms_dokumen_pegawai='".$tab['id']."'")->row_array();
												if(!empty($data['id'])){
													$show="<a href='http://files.hims.co.id/hospital/img/dokumen/".$data['link']."' target='_blank' class='btn btn-default'>Lihat</a> <a href='http://files.hims.co.id/hospital/img/dokumen/".$data['link']."' download class='btn btn-default'>Unduh</button>";
													$s=$data['id'];
												}else{
													$show="-- Belum Upload--";
													$s=0;
												}
												
												$z.='<div class="form-group"><label for="'.$tab["nama"].'">'.$tab["nama"].'</label><input type="hidden" name="before'.$tab["id"].'" value="'.$s.'"><input type="file" class="form-control" name="'.$tab["id"].'" id="'.$tab["nama"].'" placeholder="'.$tab["nama"].'"></div>';
												
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
					</div>
				</div>
			</div>	
				
			<div class="form-actions text-left">
				
				<button type="submit" class="btn btn-primary btns"><i class="fa fa-save"></i> Simpan Data</button>
				<button type="button" data-action="back" class="btn btn-default"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>		
	</form>
</div>
<!-- Modal -->
<form  class='form-horizontal'  onsubmit="savedokumen(this); return false;" enctype='multipart/form-data'  data-redirect="<?=site_url('pegawai/loadForm/')?>" id="form_<?=$id_table?>" action="<?=site_url('pegawai/save_dokumen')?>" method="POST">
<input type="hidden" name="id_ms_pegawai" value="<?=element('id',$row)?>">
<div class="modal fade" id="modaldokumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Dokumen</h4>
      </div>
      <div class="modal-body" id="bdoc">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="bs">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php
	if(!empty($pegawai['id_wilayah']))
	{
		$wilayah = get_wilayah($pegawai['id_wilayah']);
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
			window.location.href = '<?=site_url("pegawai/loadForm/")?>';
				
				$(".btns").html('<i class="fa fa-save"></i> Simpan Data');
				$(".btns").removeAttr('disabled');
			},
			error: function(data){

			}
		});
	}
	function savedokumen(formz){
		var formData = new FormData(formz);	
		$.ajax({
			type:'POST',
			url: $(formz).attr('action'),
			data:formData,
			cache:false,
			contentType: false,
			processData: false,		
			beforeSend:function(e){
				$("#bs").html("<i class='fa fa-spinner fa-spin'></i> Silahkan tunggu...");
				$("#bs").attr('disabled','disabled');
			},
			success:function(data){
			$("#modaldokumen").modal("hide");
			$("#bs").html('<i class="fa fa-save"></i> Simpan Data');
			$("#bs").removeAttr('disabled');
			},
			error: function(data){

			}
		});
	}
	
	function getDateFromAge(ageInput) {
        var today = new Date();

        var todayYear = today.getFullYear(); // today year
        var todayMonth = today.getMonth(); // today month
        var todayDay = today.getDate(); // today day of month

        var prevyear = parseInt(todayYear)-parseInt(ageInput);
       // alert(nextyear+"="+todayYear+"+"+ageInput);
        //alert(nextyear+"-"+todayMonth+"-"+todayDay);

        $("#tanggal_lahir").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
        $("#tanggal_mulai_tugas_golongan").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
        $("#tanggal_mulai_tugas_jabatan").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
        $("#tanggal_sk_jabatan").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
        $("#no_sk_jabatan").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
        $("#penandatangan_sk_jabatan").val(pad(todayDay)+"/"+pad(todayMonth)+"/"+prevyear);
    }

    function pad(num, size="2") {
        var s = num+"";
        while (s.length < size) s = "0" + s;
        return s;
    }
	
	function abc(){
		$("#bdoc").html('<div class="box-content padding"><div class="col-md-12"><center><b>Masukan Dokumen</b></center><br><ul><li>- File yang diterima : <b>.pdf | .jpg | .jpeg | .png</b></li></ul><br><?=$z?></div></div>');
		$("#modaldokumen").modal("show");
	}
	
var last_id ;

function addpendidikan(){

if(last_id){
	last_id++;
}
else
{
	last_id = 1;
}
var tampil = '';

tampil+='<tr data-pendidikan-rowid="'+last_id+'"><td style="width:3%;" class="text-center"><input type="checkbox" name="pendidikan[rowid][]"  data-pendidikan-rowid="'+last_id+'"><input type="hidden" name="pendidikan[id][]" data-pendidikan-rowid="'+last_id+'"></td>';
tampil+='<td style="width:17%;" class="text-left"><input data-pendidikan-rowid="'+last_id+'" class="form-control" type="text" name="pendidikan[jenis_sekolah][]" placeholder="SD/SMP/SMK/dsb.."></td>';
tampil+='<td style="width:35%;" class="text-left"><input data-pendidikan-rowid="'+last_id+'" class="form-control" type="text" name="pendidikan[nama_sekolah][]" placeholder="Nama Sekolah"></td>';
tampil+='<td style="width:35%;" class="text-left"><input data-pendidikan-rowid="'+last_id+'" class="form-control" type="text" name="pendidikan[jurusan][]" placeholder="Jurusan Sekolah..."></td>';
tampil+='<td style="width:20%;" class="text-left"><input data-pendidikan-rowid="'+last_id+'" class="form-control" type="text" name="pendidikan[tahun_lulus][]" placeholder="Tahun Lulus..."></td></tr>';
$('#pendidikan').append(tampil);
}
var x=1;
var pendidikan_data = <?=json_encode($pendidikan)?>;
$.each(pendidikan_data,function(iz,vz){
	addpendidikan();
	$.each(vz,function(i,v){
		if(i == 'id'){
			$('[name="pendidikan[rowid][]"][data-pendidikan-rowid="'+x+'"]').val(v);
		}
			$('[name="pendidikan['+i+'][]"][data-pendidikan-rowid="'+x+'"]').val(v);
		
	});
	x++;
});

function removePendidikan(){
$.ajax({
	type: "POST",
	url: '<?=base_url('pegawai/ajax_delete_pendidikan/')?>',
	dataType: 'json',
	data: $('[name="pendidikan[rowid][]"]:checked').serialize(),
});


$('[name="pendidikan[rowid][]"]:checked').each(function(){
	var rowid = $(this).data('pendidikan-rowid');
	$('tr[data-pendidikan-rowid="'+rowid+'"]').remove();
});
$('.check_all').prop('checked',false);
return false;

}

var last_id2;
function addKeluarga(){

if(last_id2){
	last_id2++;
}
else
{
	last_id2 = 1;
}
var tampil = '';

tampil+='<tr data-keluarga-rowid="'+last_id2+'"><td style="width:3%;" class="text-center"><input type="checkbox" name="keluarga[rowid][]"  data-keluarga-rowid="'+last_id2+'"><input type="hidden" name="keluarga[id][]" data-keluarga-rowid="'+last_id2+'"></td>';
tampil+='<td style="width:30%;" class="text-left"><input data-keluarga-rowid="'+last_id2+'" class="form-control" type="text" name="keluarga[jenis_keluarga][]" placeholder="Ayah/Ibu/Suami/dsb.."></td>';
tampil+='<td style="width:50%;" class="text-left"><input data-keluarga-rowid="'+last_id2+'" class="form-control" type="text" name="keluarga[nama][]" placeholder="Nama Kaluarga"></td>';
tampil+='<td style="width:17%;" class="text-left"><input data-keluarga-rowid="'+last_id2+'" class="form-control" type="text" name="keluarga[jk][]" placeholder="L/P"></td></tr>';
$('#keluarga').append(tampil);
}
var xx=1;
var keluarga_data = <?=json_encode($keluarga)?>;
$.each(keluarga_data,function(iz,vz){
	addKeluarga();
	$.each(vz,function(i,v){
		if(i == 'id'){
			$('[name="keluarga[rowid][]"][data-keluarga-rowid="'+xx+'"]').val(v);
		}
			$('[name="keluarga['+i+'][]"][data-keluarga-rowid="'+xx+'"]').val(v);
		
	});
	xx++;
});

function removeKeluarga(){
$.ajax({
	type: "POST",
	url: '<?=base_url('pegawai/ajax_delete_keluarga/')?>',
	dataType: 'json',
	data: $('[name="keluarga[rowid][]"]:checked').serialize(),
});


$('[name="keluarga[rowid][]"]:checked').each(function(){
	var rowid = $(this).data('keluarga-rowid');
	$('tr[data-keluarga-rowid="'+rowid+'"]').remove();
});
$('.check_all').prop('checked',false);
return false;

}

	
</script>	

