<div class="box-content padding">
<div class="col-md-12">
<input type="hidden" name="dokumen[cek]" value='1'>
<center><b>Masukan Dokumen</b></center>
<br>
<ul>
<li>- File yang diterima : <b>.pdf | .jpg | .jpeg | .png</b></li>
<li>- Max size file : 1 Mb</b></li>
<li>- Upload secara bertahap untuk koneksi yang lambat</b></li>
</ul>
<br>
<?php 
	$no=1;
	$z="";
		foreach($ms_dokumen_pegawai as $tab){
			$data=$this->db->query("SELECT id,link FROM pegawai_dokumen WHERE id_ms_pegawai='$id' AND id_ms_dokumen_pegawai='".$tab['id']."'")->row_array();
			if(!empty($data['id'])){
				$s=$data['id'];
			}else{
				$s=0;
			}
			
			$z.='<div class="form-group"><label for="'.$tab["nama"].'">'.$tab["nama"].'</label><input type="hidden" name=before'.$tab["id"].'" value="'.$s.'"><input type="file" accept=".jpg, .jpeg, .png, .pdf" class="form-control" name="'.$tab["id"].'" id="'.$tab["nama"].'" placeholder="'.$tab["nama"].'"></div>';
			$no++;
		}
echo $z;
?>

</div>
</div>