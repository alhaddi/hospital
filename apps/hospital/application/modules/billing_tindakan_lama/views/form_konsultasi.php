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
height:62px;
vertical-align:middle !important;
}
.fixheight th{
height:38px;
}
.hidden{
	display:none;
}
</style>
<?php $style=($ket == 'YA')?'display:none;':''; ?>

<input name="id" type="hidden" value="<?=element('id',$konsultasi)?>">
<div class="box">

	<div class="box-content nopadding">
		<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
			<thead>
				<tr class="fixheight">
					<th style="width:3%;" class="text-center">No</th>
					<th style="width:30%;" class="text-left">Nama</th>
					<th style="width:12%;" class="text-center">Jumlah</th>
					<th style="width:20%;" class="text-left">Biaya</th>
					<th style="width:35%;" class="text-left">Keterangan</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no=0;
			$q=$this->db->query("SELECT a.*, b.nama as nama_kategori FROM ms_tindakan a,ms_kategori_tindakan b WHERE a.id_kategori_tindakan=b.id AND a.id_ms_poliklinik='".$konsultasi['id_poliklinik']."'")->result_array();
			foreach($q as $row){ ?>														
				<tr class="fixheight">
					<td style="width:3%;" class="text-center"><?=++$no?>
						<input type="hidden" name="tindakan[id][]" data-tindakan-rowid="<?=$no?>">
					</td>
					<td style="width:30%;" class="text-left">
						<?=$row['nama_kategori']?>
						<input type="hidden" onchange="changebiaya(<?=$no?>);" onchange="changebiaya(<?=$no?>);" value="<?=$row['id']?>" onblur="changebiaya(<?=$no?>);" id="code_tindakan_<?=$no?>" class="code" name="tindakan[id_ms_tindakan][]" data-tindakan-rowid="<?=$no?>" >
					</td>
					<td style="width:12%;" class="text-center">
						<input type="number" onkeyup="changebiaya(<?=$no?>);" onchange="changebiaya(<?=$no?>);"  onblur="changebiaya(<?=$no?>);"  data-rule-number="true" class="form-control" name="tindakan[jumlah][]" id="jum_<?=$no?>" data-tindakan-rowid="<?=$no?>" value="0">
					</td>
					<td style="width:20%;" class="text-left" id="biaya_<?=$no?>"><?=rupiah(0)?></td>
					<td style="width:35%;" class="text-left"><input type="hidden" value='0'  name="tindakan[biaya][]" id="biayavalue_<?=$no?>">
					<input type="text"  class="form-control" name="tindakan[keterangan][]" data-tindakan-rowid="<?=$no?>"></input>
					</td>
				</tr>
														
			<?php } 
			$q = $this->db->where('id IN (3,5,4,15)')->get('ms_penunjang')->result_array();
			foreach($q as $r){ ?>														
				<tr class="fixheight">
					<td style="width:3%;" class="text-center"><?=++$no?>
						<input type="hidden" name="penunjang[id][]" data-penunjang-rowid="<?=$no?>">
					</td>
					<td style="width:30%;" class="text-left">
						<?=$r['nama']?>
						<input type="hidden" value="<?=$r['id']?>" id="code_penunjang_<?=$no?>" class="code" name="penunjang[id_ms_penunjang][]" data-p-rowid="<?=$no?>" >
					</td>
					<td style="width:12%;" class="text-center">
						
					</td>
					<td style="width:20%;">
						<input type="text" name="penunjang[biaya][]" class="form-control" data-plugin="maskmoney" data-penunjang-rowid="<?=$no?>">
					</td>
					<td style="width:35%;" class="text-left">
					<input type="text"  class="form-control" name="penunjang[keterangan][]" data-penunjang-rowid="<?=$no?>"></input>
					</td>
				</tr>
														
			<?php }?>
			</tbody>
			<thead>
				<tr class="fixheight">
				<th style="width:45%;" class="text-center" colspan="3">Total Biaya</th>
				<th style="width:20%;" class="text-right" ><input type="hidden" name="total" id="total"><div class="jsum"></div></th>
				<th style="width:35%;"></th>
				</tr>
				
			</thead>
		</table>
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
	total();
}
});
return false;

}

function total(){
	
	var totalPoints = 0;
		$('[name="tindakan[biaya][]"]').each(function(){
			totalPoints += parseInt($(this).val()); 
		});
		$('[name="penunjang[biaya][]"]').each(function(){
			var str = $(this).val();				
			if(str != ''){
				var res = str.replace('Rp ','');
				var jumlah = res.split('.').join('');
				totalPoints += parseInt(jumlah); 
			}
		});
	var hasil=rupiah(totalPoints);
	$(".jsum").html(hasil);
	$("#total").val(totalPoints);
}
total();
function changebiayapenunjang(id){	
var penunjangid=$("#jumlah"+id).val();	
var jum=$("#tmpbiaya"+id).val();
var jml=penunjangid*jum;

	$("#biaya_penunjang_"+id).html(rupiah(jml));
	$("#hargapenunjang"+id).val(jml);

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

if ($('[data-plugin="maskmoney"]').length > 0) {
	$("[data-plugin='maskmoney']").maskMoney({prefix:'Rp ', allowNegative: false, thousands:'.', decimal:',', affixesStay: true,  precision : 0}).css('text-align','right');
}

$('[name="penunjang[biaya][]"]').change(function(){
	var totalPoints = 0;
		$('[name="tindakan[biaya][]"]').each(function(){
			totalPoints += parseInt($(this).val()); 
		});
		$('[name="penunjang[biaya][]"]').each(function(){
			var str = $(this).val();				
			if(str != ''){
				var res = str.replace('Rp ','');
				var jumlah = res.split('.').join('');
				totalPoints += parseInt(jumlah); 
			}
		});
	var hasil=rupiah(totalPoints);
	$(".jsum").html(hasil);
	$("#total").val(totalPoints);
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

