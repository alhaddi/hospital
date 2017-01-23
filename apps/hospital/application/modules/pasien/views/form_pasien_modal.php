<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>



<div class="container-fluid">
	<form  class='form-horizontal' data-plugin="form-validation" data-redirect="<?=site_url('pasien')?>" id="form_<?=$id_table?>" action="<?=site_url($link_save)?>" method="POST">
		<input type="hidden" name="id">
		<div class="box box-bordered box-color">
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-4">Nomor RM <span class="text-danger">*</span></label>
							<div class="col-sm-5">
								<input name="rm" id="rm" class="form-control" type="text" data-rule-required="true">
							</div>
							<div class="col-sm-3">
								<div class="checkbox">
									<label>
										<input <?=(!empty($pasien['id']))?"disabled":""?> name="auto_rm" type="checkbox">Auto ?
									</label>
								</div>
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
									<option value="P">Perempuan</option>
								</select>
							</div>
						</div>
						<div data-poli="true" class="form-group">
							<label for="textfield" class="control-label col-sm-4">Poli Tujuan <span class="text-danger">*</span></label>
							<div class="col-sm-8">
							<?php if($p == 2){?>
								<select name="poliklinik[id_poliklinik]" class="form-control" id="id_poliklinik" data-rule-required="true" >
									<option value="20"> IGD </option>
								</select>
							<?php }
								else{ ?>
									
								<select name="poliklinik[id_poliklinik]" class="form-control" id="id_poliklinik" data-rule-required="true" >
									<option value="">-- Pilih Poliklinik --</option>
									<?php foreach($poliklinik as $r){ ?>
										<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
									<?php } ?>
								</select>
							<?php	}
							?>
							</div>
						</div>
						<div data-poli="true" class="form-group">
							<label for="textfield" class="control-label col-sm-4">Cara Pembayaran</label>
							<div class="col-sm-8">
								<select name="poliklinik[id_cara_bayar]" class="form-control" id="id_cara_bayar">
									<?php foreach($cara_bayar as $r){ ?>
										<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div data-poli="true" class="form-group hidden" data-showhide="bpjs">
							<label for="textfield" class="control-label col-sm-4">Tipe BPJS</label>
							<div class="col-sm-8">
								<select name="poliklinik[id_bpjs_type]" class="form-control" id='id_bpjs_type'>
									<?php foreach($bpjs_type as $r){ ?>
										<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div data-poli="true" class="form-group hidden" data-showhide="bpjs" >
							<label for="textfield" class="control-label col-sm-4">ID BPJS</label>
							<div class="col-sm-8">
								<input type="text" name="poliklinik[no_bpjs]" id="no_bpjs" class="form-control" >
							</div>
						</div>
						
						<div data-poli="true" class="form-group hidden" data-showhide="asuransi_kontraktor">
							<label for="textfield" class="control-label col-sm-4">No Polis</label>
							<div class="col-sm-8">
								<input type="text" name="poliklinik[no_polis]" id="no_polis" class="form-control" >
							</div>
						</div>
						
						<div data-poli="true" class="form-group hidden" data-showhide="asuransi_kontraktor">
							<label for="textfield" class="control-label col-sm-4">Nama Perusahaan</label>
							<div class="col-sm-8">
								<input type="text" name="poliklinik[nama_perusahaan]" id="nama_perusahaan" class="form-control" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Tempat & Tgl Lahir</label>
							
							<div class="col-sm-3">
								<select data-tempat_lahir="true" class="form-control" id="tempat_lahir" name="tempat_lahir" >
								</select>
							</div>
							<div class="col-sm-3">
								<input data-rule-required="true" type="text" data-plugin="datepicker" name="tanggal_lahir" id="tanggal_lahir" class="form-control" >
							</div>
							<div class="col-sm-2">
								<input type="text" name="usia" id="usia" placeholder="Usia" class="form-control" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Alamat</label>
							<div class="col-sm-8">
								<textarea name="alamat" id="alamat" class="form-control"></textarea>
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
							<label for="id_agama" class="control-label col-sm-4">Status Menikah</label>
							<div class="col-sm-8">
								<select name='status_menikah' class="form-control" id='status_menikah'>
									<option value="">-- Pilih Status --</option>
									<option value='KAWIN'>Menikah</option>
									<option value="BELUM KAWIN">Belum Menikah</option>
									<option value="DUDA">Duda</option>
									<option value="JANDA">Janda</option>
								</select>
							</div>
						</div>
					</div>
					
					
					<div class="col-sm-6">
					
						<div class="form-group">
							<label for="no_identitas" class="control-label col-sm-4">Nomor Identitas</label>
							<div class="col-sm-3">
								<select name='tipe_identitas' class="form-control" id='tipe_identitas'>
									<option>KTP</option>
									<option>SIM</option>
									<option>KK</option>
									<option>PASPORT</option>
								</select>
							</div>
							<div class="col-sm-5">
								<input type="text" name="no_identitas" id="no_identitas" class="form-control" >
							</div>
						</div>
					
						<div class="form-group hidden">
							<label for="IC_Number" class="control-label col-sm-4">IC Number / No Asuransi <span class="text-danger">*</span></label>
							<div class="col-sm-8">
								<input name="IC_Number" id="IC_Number"  class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Asal Pasien</label>
							<div class="col-sm-8">
								<select name="asal_pasien" class="form-control" id='asal_pasien'>
									<option value="Datang Sendiri">Datang Sendiri</option>
									<option value="Rujukan">Rujukan</option>
								</select>
							</div>
						</div>
						
						<div class="form-group hidden" data-showhide="rujukan">
							<label for="textfield" class="control-label col-sm-4">Asal Rujukan</label>
							<div class="col-sm-2">
								<input type="text" name="no_rujukan" placeholder="No Rujukan" id="no_rujukan" class="form-control" >
							</div>
							<div class="col-sm-6">
								<input type="text" name="rujukan_dari" id="rujukan_dari" placeholder="Asal Rujukan" class="form-control" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="pekerjaan" class="control-label col-sm-4">Pekerjaan</label>
							<div class="col-sm-8">
								<select name='id_pekerjaan' class="form-control" id='id_pekerjaan'>
									<option value="">-- Pilih Pekerjaan --</option>
									<?php foreach($pekerjaan as $r){ ?>
										<option value="<?=element('id',$r)?>"><?=element('nama',$r)?></option>
									<?php } ?>
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
							<label for="nama_lengkap" class="control-label col-sm-4">Golongan Darah</label>
							<div class="col-sm-8">
								<select name='golongan_darah' class="form-control" id='golongan_darah'>
									<option>-</option>
									<option>A</option>
									<option>B</option>
									<option>AB</option>
									<option>O</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">RT / RW</label>
							<div class="col-sm-2">
								<input type="text" name="rt" id="rt" placeholder="RT" class="form-control" >
							</div>
							<div class="col-sm-2">
								<input type="text" name="rw" id="rw" placeholder="RW" class="form-control" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Kelurahan</label>
							<div class="col-sm-8">
								<input type="text" name="kelurahan" id="kelurahan" placeholder="" class="form-control" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="password" class="control-label col-sm-4">Kontak</label>
							<div class="col-sm-4">
								<input data-rule-number="true" type="text" name="hp" id="hp" placeholder="No HP" class="form-control" >
							</div>
							<div class="col-sm-4">
								<input data-rule-number="true" type="text" name="tlp" id="tlp" placeholder="No Telepon"  class="form-control"  >
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="control-label col-sm-4">E-mail</label>
							<div class="col-sm-8">
								<input name="email" id="email" class="form-control" type="text" data-rule-email="true">
							</div>
						</div>
						
						<div class="form-group hidden">
							<label for="textfield" class="control-label col-md-4">Tanggal Pertemuan</label>
							<div class="col-sm-8">
								<input type="datetime" data-plugin="datepicker" name="tgl_pertemuan" id="tgl_pertemuan" class="form-control" >
							</div>
						</div>
						
						<div class="form-group hidden">
							<label for="nama_orangtua" class="control-label col-sm-4">Nama Ibu</label>
							<div class="col-sm-8">
								<input name="nama_orangtua" id="nama_orangtua" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group hidden">
							<label for="nama_orangtua" class="control-label col-sm-4">Nama Ayah</label>
							<div class="col-sm-8">
								<input name="nama_ayah" id="nama_ayah" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group hidden" >
							<label for="password" class="control-label col-sm-4">Emergency Phone</label>
							<div class="col-sm-8">
								<input data-rule-number="true" type="text" name="telp_emergency" id="telp_emergency" placeholder="No Telepon"  class="form-control"  >
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="row">
					<hr/>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12">
								<h4>Penanggung Jawab 1</h4>
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Nama Lengkap</label>
							<div class="col-sm-8">
								<input type="text" name="penanggung_jawab[1][nama]" id="penanggung_jawab1_hubungannama" class="form-control"  >
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Hubungan</label>
							<div class="col-sm-8">
								<select name="penanggung_jawab[1][hubungan]" class="form-control" id='penanggung_jawab1_hubungan'>
									<option>AYAH</option>
									<option>IBU</option>
									<option>SAUDARA</option>
									<option>PAMAN/BIBI</option>
									<option value="KAKE">KAKEK</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="control-label col-sm-4">Kontak</label>
							<div class="col-sm-4">
								<input type="text" name="penanggung_jawab[1][hp]" id="penanggung_jawab1_hubunganhp" placeholder="No HP" class="form-control" >
							</div>
							<div class="col-sm-4">
								<input type="text" name="penanggung_jawab[1][tlp]" id="penanggung_jawab1_hubungantlp" placeholder="No Telepon"  class="form-control"  >
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						
						<div class="form-group">
							<div class="col-sm-12">
								<h4>Penanggung Jawab 2</h4>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="penanggung_jawab[2][id]" >
							<label for="textfield" class="control-label col-sm-4">Nama Lengkap</label>
							<div class="col-sm-8">
								<input type="text" name="penanggung_jawab[2][nama]" id="penanggung_jawab2_hubungannama" class="form-control"  >
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Hubungan</label>
							<div class="col-sm-8">
								<select name="penanggung_jawab[2][hubungan]" class="form-control" id='penanggung_jawab2_hubungan'>
									<option>AYAH</option>
									<option>IBU</option>
									<option>SAUDARA</option>
									<option>PAMAN/BIBI</option>
									<option value="KAKE">KAKEK</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="control-label col-sm-4">Kontak</label>
							<div class="col-sm-4">
								<input type="text" name="penanggung_jawab[2][hp]" id="penanggung_jawab2_hubunganhp" placeholder="No HP" class="form-control" >
							</div>
							<div class="col-sm-4">
								<input type="text" name="penanggung_jawab[2][tlp]" id="penanggung_jawab2_hubungantlp" placeholder="No Telepon"  class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="form-actions text-left">
				
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
				<button type="button" data-action="back" class="btn btn-default"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>		
	</form>
</div>

<?php
	if(!empty($pasien['id_wilayah']))
	{
		$wilayah = get_wilayah($pasien['id_wilayah']);
	}
	else
	{
		$wilayah['Kode_Kecamatan'] = 21140;
		$wilayah['Kecamatan'] = 'Kec. Tarogong Kidul';
		$wilayah = (object) $wilayah;
	}
	
	if(!empty($pasien['tempat_lahir']))
	{
		$sql = "SELECT wilayah.code FROM wilayah WHERE wilayah.name = '".$pasien['tempat_lahir']."'";
		$tmp = $this->db->query($sql)->row_array();
		$tempat_lahir = get_wilayah($tmp['code']);
	}
	else
	{
		$tempat_lahir['Kode_Kota'] = 21100;
		$tempat_lahir['Kota'] = 'Kab. Garut';
		$tempat_lahir = (object) $tempat_lahir;
	}
?>

<script>
	
	$(document).ready(function(){
		var pasien_data = <?=json_encode($pasien)?>;
		$.each(pasien_data,function(i,v){
			$('[name="'+i+'"]').val(v);
		});
		
		var penanggung_jawab_data = <?=json_encode($penanggung_jawab)?>;
		$.each(penanggung_jawab_data,function(iz,vz){
			$.each(vz,function(i,v){
				if(i == 'id' && vz.type==1){
					$('[name="penanggung_jawab['+vz.type+']['+i+']"]').select2({
						data: [
						{
							id: vz.id,
							text: vz.rm+' | '+vz.nama
						},
					]});
					}else{
					$('[name="penanggung_jawab['+vz.type+']['+i+']"]').val(v);
				}
			});
		});
		
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
		
		<?php if(!empty($tempat_lahir)) { ?>
			$('[name="tempat_lahir"]').select2({
				data: [
				{
					id: '<?=$tempat_lahir->Kode_Kota?>',
					text: '<?=$tempat_lahir->Kota?>'
				},
			]});
		<?php } ?>
		
		$('[name="tanggal_lahir"]').on("change",function(){
			var tgl = $(this).val();
			var usia = hitungUsia(tgl);
			if(isNaN(usia) == true){
				usia = null;
			}
			$('[name="usia"]').val(usia);
		});
		
		$('[name="asal_pasien"]').on("change",function(){
			var id = $(this).val();
			if(id == 'Rujukan'){
				$('[name="no_rujukan"]').removeAttr('disabled');
				$('[name="no_rujukan"]').removeProp('disabled');
				$('[name="rujukan_dari"]').removeAttr('disabled');
				$('[name="rujukan_dari"]').removeProp('disabled');
				$('[data-showhide="rujukan"]').removeClass('hidden');
				} else {
				$('[name="no_rujukan"]').attr('disabled',true);
				$('[name="no_rujukan"]').prop('disabled',true);
				$('[name="rujukan_dari"]').attr('disabled',true);
				$('[name="rujukan_dari"]').prop('disabled',true);
				$('[data-showhide="rujukan"]').addClass('hidden');
			}
		}).trigger('change');
		
		$('[name="poliklinik[id_cara_bayar]"]').on("change",function(){
			var id = $(this).val();
			if(id == 2) {
				$('[data-showhide="bpjs"]').removeClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
				
				$('[name="poliklinik[id_bpjs_type]"]').attr('data-rule-required','true');
				$('[name="poliklinik[no_bpjs]"]').attr('data-rule-required','true');
				$('[name="poliklinik[no_polis]"]').attr('data-rule-required','false');
				$('[name="poliklinik[nama_perusahaan]"]').attr('data-rule-required','false');
				
				} else if(id == 3 || id == 4){
				$('[data-showhide="bpjs"]').addClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').removeClass('hidden');
				
				
				$('[name="poliklinik[id_bpjs_type]"]').attr('data-rule-required','false');
				$('[name="poliklinik[no_bpjs]"]').attr('data-rule-required','false');
				$('[name="poliklinik[no_polis]"]').attr('data-rule-required','true');
				$('[name="poliklinik[nama_perusahaan]"]').attr('data-rule-required','true');
				} else {
				$('[data-showhide="bpjs"]').addClass('hidden');
				$('[data-showhide="asuransi_kontraktor"]').addClass('hidden');
				
				$('[name="poliklinik[id_bpjs_type]"]').attr('data-rule-required','false');
				$('[name="poliklinik[no_bpjs]"]').attr('data-rule-required','false');
				$('[name="poliklinik[no_polis]"]').attr('data-rule-required','false');
				$('[name="poliklinik[nama_perusahaan]"]').attr('data-rule-required','false');
			}
		}).trigger('change');
		
		
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
		
		if($('[data-tempat_lahir="true"]').length > 0) {
			$('[data-tempat_lahir="true"]').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					minimumInputLength: 3,
					ajax: {
						url: '<?=site_url('dashboard/select2_wilayah_kota')?>',
						dataType: 'json',
						data: function (params) {
							return {
								q: params.term, // search term
								//page: params.page,
								group: '02',
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
		
		if($('[data-pasien="true"]').length > 0) {
			$('[data-pasien="true"]').each(function(){
				var id = $(this).attr('id');
				$('#'+id).select2({
					minimumInputLength: 3,
					ajax: {
						url: '<?=site_url('pasien/select2_pasien')?>',
						dataType: 'json',
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
								pagination: {
									more: (params.page * 30) < data.total_count
								}
							};
						},
						cache: true
					}
					}).change(function(result){
					$('#penanggung_jawab1_rm').val();
				});
			});
		}
		
		$('[name="auto_rm"]').on("click",function(){
			console.log(this.checked);
			if(this.checked) {
				$('[name="rm"]').prop('readonly',true).val('');
				$('[name="rm"]').attr('readonly',true).val('');
				} else {
				$('[name="rm"]').removeProp('readonly').val('');
				$('[name="rm"]').removeAttr('readonly').val('');
			}
		});
		
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
	
	<?php if(!empty($pasien['id'])){?>
		$('[ data-poli="true"]').remove();
	<?php } ?>	
</script>	

