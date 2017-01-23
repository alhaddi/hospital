<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal' data-plugin="form-validation" data-redirect="<?=site_url('kepegawaian')?>" id="form_<?=$id_table?>" action="<?=site_url($link_save)?>" method="POST">
		<input type="hidden" name="id">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
				Data Utama Pegawai</h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					
						<div class="col-sm-2">
							<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="" width="185">
							<button class="btn btn-danger form-control"><i class="fa fa-search"></i> Cari Pegawai</button>
						</div>
						<div class="col-sm-6">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Nama Lengkap" readonly>
								</div>
									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="Gol/Ruang" readonly>
										</div>
										<div class="col-sm-5">
											<input type="text" class="form-control" placeholder="Pangkat" readonly>
										</div>
									</div>
								
							</div>
							<div class="col-sm-6">
								<div style="margin-bottom: 15px">
									<input type="text" class="form-control" placeholder="NIP" readonly>
								</div>
								<div style="margin-bottom: 15px">
									<input type="text" class="form-control" placeholder="Kedudukan Hukum" readonly>
								</div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Jabatan" readonly>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Unit Kerja" readonly>
							</div>
						</div>
				</div>
				
				<div class="row" style="margin-top: 10px">
					<div class="col-sm-12">
						<ul class="nav nav-tabs">
								<li class="active"><a href="#data_utama_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Data Utama</a></li>
								
								<li class=""><a href="#lampiran_tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-paperclip"></i> Lampiran</a></li>
								
								<li class=""><a href="#foto_tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-picture-o"></i> Foto</a></li>
							</ul>
						<div class="tab-content padding">
							<div class="tab-pane active" id="data_utama_tab">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Nama Lengkap</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nama Lengkap" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Gelar Depan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Gelar Depan" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">NIP</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="NIP" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Gelar Belakang</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Gelar Belakang" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Tanggal Lahir</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Jenis Kelamin</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Jenis Kelamin" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Tempat Lahir</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Tempat Lahir" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Status Perkawinan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Status Perkawinan" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Agama</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Agama" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Usia</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Usia" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Kontak</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Kontak" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Email" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Alamat</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Alamat" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<hr/>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Kedudukan Hukum</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Kedudukan Hukum" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Status Kepegawaian</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Status Kepegawaian" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Masa kerja</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Masa Kerja" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<hr/>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Masa Kerja Golongan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="MK Golongan" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">THT Golongan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Pangkat Terakhir</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Pangkat Terakhir" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Eselon</label>
											<div class="col-sm-2">
												<input type="text" class="form-control" placeholder="Eselon" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Jenis Jabatan</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" placeholder="Jenis Jabatan" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Nama Jabatan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nama Jabatan" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Unit Kerja</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Unit Kerja" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Masa Kerja Jabatan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nomor SK PNS" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">TMT Jabatan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<hr/>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Pendidikan Terakhir</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Pendidikan Terakhir" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Tahun Lulus</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Tahun Lulus" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Nama Sekolah</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nama Sekolah" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Program Studi</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Program Studi" >
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-label col-sm-2">Jurusan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Jurusan" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">NIK</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="NIK" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">NPWP</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="NPWP" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Jenis Pengadaan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Jenis Pengadaan" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">TMT CPNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">TMT PNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Tanggal SPMT</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Tanggal SK CPNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Tanggal SK PNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="form-label col-sm-4">Nomor SPMT</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nomor SPMT" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Nomor SK CPNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nomor SK CPNS" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Nomor SK PNS</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nomor SK PNS" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<hr/>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Nomor SKCK</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Nomor SKCK" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Ket. Dokter</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Ket. Dokter" >
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Ket. Bebas Narkoba</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="Ket. Bebas Narkoba" >
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label col-sm-4">Tgl SKCK</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Tgl ket. Dokter</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
										<div class="form-group">
											<label class="form-label col-sm-4">Tgl ket. Bebas Narkoba</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" placeholder="dd-mm-yyyy"  data-plugin="datepicker">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="lampiran_tab">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran SK CPNS</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran SPNT</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran SK PNS</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran SKCK</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran Surat Keterangan Dokter</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Lampiran Surat Keterangan Bebas Narkoba</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="foto_tab">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label col-sm-4">Profil</label>
										<div class="col-sm-8">
											<input type="checkbox"> Gunakan photo saya sebagai photo profil.
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-4">Ganti photo anda</label>
										<div class="col-sm-8">
											<input type="file">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions text-right">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Usulkan Perubahan Data</button>
			</div>
		</div>		
	</form>
</div>