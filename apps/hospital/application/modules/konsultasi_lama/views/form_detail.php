<?php
	if($konsultasi['id_komponen'] != '5'){
		$field = $this->db->select('ms_komponen_registrasi.nama as komponen')
		->where('id',$konsultasi['id_komponen'])->get('ms_komponen_registrasi')->row_array();
	}else{
		$field = $this->db->select('ms_penunjang.nama as komponen')
		->where('id',$konsultasi['id_ms_penunjang'])->get('ms_penunjang')->row_array();
	}
	$komponen = $field['komponen'];
	
	if($konsultasi['kondisi_keluar_pasien'] == '0'){
		$kondisi = 'Sehat';
	}else if($konsultasi['kondisi_keluar_pasien'] == '1'){
		$kondisi = 'Dalam Proses Penyembuhan';
	}else{
		$kondisi = 'Rawat Inap';
	}
	
	if($konsultasi['usia_thn'] != null){
		$usia = $konsultasi['usia_thn'].' Tahun';
	}else if($konsultasi['usia_bln'] != null){
		$usia = $konsultasi['usia_bln'].' Bulan';
	}else{
		$usia = $konsultasi['usia_hari'].' Hari';
	}
?>
<style>
	.tabs.tabs-inline.tabs-left {
    width: 200px;
	}
	.tab-content.tab-content-inline {
    margin-left: 200px;
	}
</style>
<form  class='form-horizontal'>

<div class="container-fluid">
		<input type="hidden" name="id" value="<?=$konsultasi['id']?>">
		<div class="box box-bordered box-color">
			<div class="box-title">
				<h3>
				<i class="fa fa-pencil-square-o"></i>Laporan Rekam Medis Pasien</h3>
			</div>
			<div class="box-content padding">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="rm" class="control-label col-sm-4">No RM</label>
							<div class="col-sm-8">
								<input name="rm" id="rm" class="form-control" type="text" value="<?=$konsultasi['rm']?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_lengkap" class="control-label col-sm-4">Nama Pasien</label>
							<div class="col-sm-8">
								<input name="nama_lengkap" id="nama_lengkap" class="form-control" type="text" value="<?=$konsultasi['nama_lengkap']?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-4">Tanggal Lahir</label>
							<div class="col-sm-8">
								<input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?=($konsultasi['tanggal_lahir'] != null)?convert_tgl($konsultasi['tanggal_lahir'],'d F Y',1):''?>" readonly>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div data-poli="true" class="form-group">
							<label for="textfield" class="control-label col-sm-4">Cara Bayar</label>
							<div class="col-sm-8">
								<input name="cara_bayar" id="cara_bayar" class="form-control" type="text" value="<?=$konsultasi['cara_bayar']?>" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label for="nama_lengkap" class="control-label col-sm-4">Golongan Darah</label>
							<div class="col-sm-8">
								<input type="text" name="golongan_darah" id="golongan_darah" class="form-control" value="<?=$konsultasi['golongan_darah']?>" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Alamat</label>
							<div class="col-sm-8">
								<input type="text" name="alamat" id="alamat" class="form-control" value="<?=$konsultasi['alamat']?>" readonly>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<hr/>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Poli</label>
							<div class="col-sm-8">
								<input type="text" name="poliklinik" id="poliklinik" class="form-control" value="<?=$konsultasi['poliklinik']?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Dokter</label>
							<div class="col-sm-8">
								<input type="text" name="dokter" id="dokter" class="form-control" value="<?=$konsultasi['dokter']?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">R.Jalan / Inap</label>
							<div class="col-sm-8">
								<input type="text" name="komponen" id="komponen" class="form-control" value="<?=$komponen?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Diagnosa Utama</label>
							<div class="col-sm-8">
								<input type="text" name="diagnosa" id="diagnosa" class="form-control" value="<?=(!empty($konsultasi[0]['deskripsi']))?$konsultasi[0]['deskripsi']:''?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Keluhan</label>
							<div class="col-sm-8">
								<textarea name="keluhan_pasien" id="keluhan_pasien" class="form-control" readonly><?=$konsultasi['keluhan_pasien']?></textarea>
							</div>
						</div>
						<!--div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Pemeriksaan</label>
							<div class="col-sm-8">
								<textarea name="pemeriksaan" id="pemeriksaan" class="form-control" readonly></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Alergi Obat</label>
							<div class="col-sm-8">
								<textarea name="alergi_obat" id="alergi_obat" class="form-control" readonly></textarea>
							</div>
						</div-->
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Tanggal</label>
							<div class="col-sm-8">
								<input type="text" name="last_update" id="last_update" class="form-control" value="<?=convert_tgl($konsultasi['last_update'],'d F Y H:i:s',1)?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Umur</label>
							<div class="col-sm-8">
								<input type="text" name="usia" id="usia" class="form-control" value="<?=$usia?>" readonly>
							</div>
						</div>

						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Resep</label>
							<div class="col-sm-8">
								<textarea name="resep" id="resep" class="form-control" readonly><?=($konsultasi['resep'] != null)?$konsultasi['resep']:''?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Kesimpulan</label>
							<div class="col-sm-8">
								<textarea name="kesimpulan" id="kesimpulan" class="form-control" readonly><?=$konsultasi['kesimpulan']?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat" class="control-label col-sm-4">Kondisi Keluar</label>
							<div class="col-sm-8">
								<input type="text" name="kondisi_keluar_pasien" id="kondisi_keluar_pasien" class="form-control" value="<?=$kondisi?>" readonly>
							</div>
						</div>						
					</div>
				</div>
				
			</div>
			<div class="form-actions text-left">
				
				<button type="button" onclick="window.open('<?=site_url("konsultasi/pdf_detail_konsultasi/".$konsultasi['id'])?>');" class="btn btn-primary"><i class="fa fa-save"></i> Cetak</button>
				<button type="button" data-action="back" class="btn btn-default"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>
</div>
</form>
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

