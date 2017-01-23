<?php foreach($kelompok as $row){ 
			$data=$this->db->query("SELECT id,nama,biaya,kategori FROM ms_kategori_penunjang WHERE id_ms_penunjang='$PenunjangID' AND kelompok='$row->kelompok'")->result();
	echo "<b>".$row->kelompok."</b>";
	echo "<ol>";
	foreach($data as $r){
		$che=(in_array($r->id,$listkategori))?"checked":"";
		echo "<li><input type='checkbox' $che data-kategori-id='$r->id' data-kategori-val='$r->kategori'  data-kategori-harga='$r->biaya' data-checkbox-kategori='true' name='kategori[]' id='label".$r->id."'> <label for='label".$r->id."'>".$r->nama." (".rupiah($r->biaya).")</label></li>";
	}
	echo "</ol>";
?>

	
<?php }?>
<center><button onclick="savekategori();" class='btn btn-success' type='button'><i class="fa fa-check"></i> Simpan</button></center>
<script>
function savekategori(){
	$("#modal_penunjang").modal("hide");
	var id = [];
	var harga = [];
	var kategori_array = [];
	var total_harga = 0;
	$('[name="kategori[]"]:checked').each(function(i,v){
		 id.push($(this).data('kategori-id'));
		 harga.push($(this).data('kategori-harga'));
		 var val_kategori = $(this).data('kategori-harga');
		 if(in_array(val_kategori,kategori_array) == false){
			total_harga += parseFloat($(this).data('kategori-harga')); 
			kategori_array.push(val_kategori);
		 }
	});
	var hasil=id.join();
	
	var jum=$("#jumlah<?=$last_id?>").val();
	var total=total_harga*jum;
	$("#kategoripenunjang<?=$last_id?>").val(hasil);
	$("#biaya_penunjang_<?=$last_id?>").html(rupiah(total));
	$("#hargapenunjang<?=$last_id?>").val(total);
	$("#tmpbiaya<?=$last_id?>").val(total_harga);
	
}
</script>