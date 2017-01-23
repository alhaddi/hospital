<div style="padding: 20px">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-12">Action</label>
			<div class="col-sm-6">
				<button onclick="pdf()" class="btn btn-xs btn-success form-control"><span class="fa fa-print"></span> &nbsp; Pdf File </button>
			</div>
		</div>
	</div>
</div>
<table id="<?=$id_table1?>" class="table table-hover table-nomargin table-striped table-bordered" 
data-plugin="datatable-server-side" 
data-datatable-list="<?=$datatable_list1?>"
data-datatable-daterange="true"
data-datatable-colvis="true"
data-datatable-scroller="true"
data-datatable-scroll-x="true"
data-datatable-nocolvis=""
>
	<thead>
    <tr>
        <th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle" width="50">No</th>
        <th data-datatable-align="text-center" colspan="7">Kategori</th>
        <th data-datatable-align="text-center" colspan="8">Pembayaran</th>
        <th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">TTL Baru</th>
        <th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">TTL Lama</th>
        <th data-datatable-align="text-center" rowspan="2" style="vertical-align: middle">Total</th>
    </tr>
    <tr>
        <th>Klinik</th>
        <th>Umum</th>
        <th>Kontrak</th>
        <th>RSU</th>
        <th>Baru</th>
        <th>Lama</th>
        <th>JML</th>

        <th>Askes</th>
        <th>KIS</th>
        <th>JMSSTK</th>
        <th>TNI</th>
        <th>Mandiri</th>
        <th>Baru</th>
        <th>Lama</th>
        <th>JML</th>
    </tr>
    </thead>
	<tbody>
	
	</tbody>
</table>
<script>
//script yg di tambah sm fatur
function pdf(){
	var d1=$("#kunjungan_pasien_daterange1").val();
	var d2=$("#kunjungan_pasien_daterange2").val();
	var tgl1=d1.split("/");
	var tgl2=d2.split("/");
	var t1=tgl1[2]+"-"+tgl1[1]+"-"+tgl1[0];
	var t2=tgl2[2]+"-"+tgl2[1]+"-"+tgl2[0];
	
	window.open('<?=base_url()?>rekam_medis/showKunjungan?tgl1='+t1+'&tgl2='+t2);
}
</script>