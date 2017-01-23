<div class="box-content padding">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="id_ms_jenis_user" class="control-label col-sm-4">Jenis User <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<select name='id_ms_jenis_user' class="form-control" id='id_ms_jenis_user'>
						<?php foreach($id_ms_jenis_user as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="kd" class="control-label col-sm-4">KD </label>
				<div class="col-sm-8">
					<input name="kd" id="kd"  class="form-control" type="text">
				</div>
			</div>
			<div class="form-group">
				<label for="status_pegawai" class="control-label col-sm-4">Status Pegawai <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<select name='status_pegawai' class="form-control" id='status_pegawai'>
						<option value="PNS">PNS</option>
						<option value="TKK">TKK</option>
					</select>
				</div>
			</div>
			<div class="form-group" data-showhide="nip">
				<label for="nip" class="control-label col-sm-4">NIP </label>
				<div class="col-sm-8">
					<input name="nip" id="nip"  class="form-control" type="text">
				</div>
			</div>
			<div class="form-group" data-showhide="no_registrasi_pegawai">
				<label for="no_registrasi_pegawai" class="control-label col-sm-4">No Registrasi Pegawai </label>
				<div class="col-sm-8">
					<input name="no_registrasi_pegawai" id="no_registrasi_pegawai"  class="form-control" type="text">
				</div>
			</div>
			<div class="form-group">
				<label for="nama_lengkap" class="control-label col-sm-4">Nama Lengkap <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text"  data-rule-required="true">
				</div>
			</div>
			<div class="form-group">
				<label for="textfield" class="control-label col-sm-4">Jenis Kelamin</label>
				<div class="col-sm-5">
					<select name='jk' class="form-control" id='jk'>
						<option value="L">Laki - laki</option>
						<option value="L">Perempuan</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="id_agama" class="control-label col-sm-4">Agama</label>
				<div class="col-sm-8">
					<select name='id_agama' class="form-control" id='id_agama'>
						<?php foreach($agama as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir <span class="text-danger">*</span></label>
				
				<div class="col-sm-3">
					<input data-rule-required="true" type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" >
				</div>
				<div class="col-sm-3">
					<input data-rule-required="true" type="text" data-plugin="datepicker" name="tanggal_lahir" id="tanggal_lahir" class="form-control" >
				</div>
				<div class="col-sm-2">
					<input type="text" name="usia" id="usia" placeholder="Usia" class="form-control" >
				</div>
			</div>
		</div>
		
		
		<div class="col-sm-6">
			<div class="form-group">
				<label for="gol_darah" class="control-label col-sm-4">Golongan Darah </label>
				<div class="col-sm-8">
					<select name='gol_darah' class="form-control" id='gol_darah'>
						<option value="A">A</option>
						<option value="AB">AB</option>
						<option value="B">B</option>
						<option value="O">O</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_agama" class="control-label col-sm-4">Status Sipil</label>
				<div class="col-sm-8">
					<select name='status_sipil' class="form-control" id='status_sipil'>
						<option value="">-- Pilih Status --</option>
						<option value='KAWIN'>Menikah</option>
						<option value="BELUM KAWIN">Belum Menikah</option>
						<option value="DUDA">Duda</option>
						<option value="JANDA">Janda</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="no_ktp" class="control-label col-sm-4">Nomor KTP</label>
				<div class="col-sm-8">
					<input type="text" name="no_ktp" id="no_ktp" class="form-control" >
				</div>
			</div>
			<div class="form-group">
				<label for="kode_golongan" class="control-label col-sm-4">Kode Golongan <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<select name='kode_golongan' class="form-control" id='kode_golongan'>
						<?php foreach($kode_golongan as $r){ ?>
							<option value="<?=element('kd',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_ms_unit_kerja" class="control-label col-sm-4">Unit Kerja <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<select name='id_ms_unit_kerja' class="form-control" id='id_ms_unit_kerja'>
						<?php foreach($id_ms_unit_kerja as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_ms_jabatan" class="control-label col-sm-4">Jabatan <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<select name='id_ms_jabatan' class="form-control" id='id_ms_jabatan'>
						<?php foreach($id_ms_jabatan as $r){ ?>
							<option value="<?=element('id',$r)?>"><?=element('kode_jenis_jabatan',$r).' - '.element('nama',$r)?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="masa_kerja_thn" class="control-label col-sm-4">Masa Kerja Thn <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input name="masa_kerja_thn" id="masa_kerja_thn" class="form-control" type="text">
				</div>
			</div>
			<div class="form-group">
				<label for="masa_kerja_bln" class="control-label col-sm-4">Masa Kerja Bln <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input name="masa_kerja_bln" id="masa_kerja_bln"  class="form-control" type="text">
				</div>
			</div>
		</div>
		
		
	</div>
	
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_alamat" data-toggle="tab">Alamat</a></li>
			</ul>
			<div class="tab-content padding">
				<div class="tab-pane active" id="tab_alamat">
					<div class="row">
						<div class="col-sm-12">
							
							<div class="form-group">
								<label for="alamat" class="control-label col-sm-2">Alamat</label>
								<div class="col-sm-4">
									<textarea name="alamat" id="alamat" class="form-control"></textarea>
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="password" class="control-label col-sm-2">Kontak</label>
								<div class="col-sm-2">
									<input data-rule-number="true" type="text" name="hp" id="hp" placeholder="No HP" class="form-control" >
								</div>
								<div class="col-sm-2">
									<input data-rule-number="true" type="text" name="tlp" id="tlp" placeholder="No Telepon"  class="form-control"  >
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="control-label col-sm-2">E-mail</label>
								<div class="col-sm-4">
									<input name="email" id="email" class="form-control" type="text" data-rule-email="true">
								</div>
							</div>
							
							<div class="form-group">
								<label for="textfield" class="control-label col-sm-2">Kecamatan</label>
								<div class="col-sm-4">
									<select data-wilayah="true" class="form-control" id="id_wilayah" name="id_wilayah"  >
									</select>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	
</div>