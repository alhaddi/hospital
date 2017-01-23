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
				<i class="fa fa-pencil-square-o"></i>Form Data Pasien</h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-4">Nomor Register </label>
							<div class="col-sm-5"> : <?=element('no_register',$pasien)?>
							</div>
						</div>
						<div class="form-group">
							<label for="rm" class="control-label col-sm-4">Nomor RM </label>
							<div class="col-sm-5"> : <?=element('rm',$pasien)?>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_lengkap" class="control-label col-sm-4">Nama Lengkap </label>
							<div class="col-sm-8"> : <?=element('nama_lengkap',$pasien)?>
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Jenis Kelamin</label>
							<div class="col-sm-5"> : <?=element('jk',$pasien)?>
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Cara Pembayaran</label>
							<div class="col-sm-8"> : <?=element('cara_bayar',$pasien)?>
							</div>
						</div>		
						
						
						<div class="form-group hidden">
							<label for="textfield" class="control-label col-sm-4">Cara Masuk</label>
							<div class="col-sm-8"> : <?=element('cara_masuk',$pasien)?>
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir</label>
							
							<div class="col-sm-8"> : 
							<?=element('tempat_lahir',$pasien)?>, <?=convert_tgl(element('tanggal_masuk',$pasien),'d/m/Y')?>
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Usia</label>
							
							<div class="col-sm-8"> : 
							<?=element('usia',$pasien)?> tahun
							</div>
						</div>
						
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Alamat</label>
							<div class="col-sm-8"> : <?=element('alamat',$pasien)?>
							</div>
						</div>

					</div>
					
					
					<div class="col-sm-6">
						
						<div class="form-group ">
							<label for="textfield" class="control-label col-md-4">Tanggal Masuk</label>
							<div class="col-sm-8">
								<?=convert_tgl(element('tgl_masuk',$pasien),'d/m/Y')?>
							</div>
						</div>
						
						<div class="form-group ">
							<label for="ruang_rawat" class="control-label col-sm-4">Ruangan Rawat</label>
							<div class="col-sm-8"> : <?=element('ruang_rawat',$pasien)?>
							</div>
						</div>
						
						<div class="form-group ">
							<label for="tgl_keluar" class="control-label col-md-4">Tanggal Keluar</label>
							<div class="col-sm-8">
								: <?=convert_tgl(element('tgl_keluar',$pasien),'d/m/Y');?>
							</div>
						</div>
																
						<div class="form-group ">
							<label for="cara_keluar" class="control-label col-sm-4">Cara Keluar</label>
							<div class="col-sm-8">
								: <?=element("cara_keluar",$pasien);?>
							</div>
						</div>
						<div class="form-group">
							<label for="keterangan" class="control-label col-sm-4">Keterangan</label>
							<div class="col-sm-8">
								: <?=element("keterangan",$pasien);?>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>		
	</form>
</div>
