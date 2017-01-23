<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-title" style="<?=($this->session->userdata("username") == "bendahara")?"background: rgba(255,255,255,0.4)":""?>">
					<h3>
						<i class="fa fa-dashboard"></i>
						<?=$title?>
					</h3>
				</div>
				<div class="box-content" style="<?=($this->session->userdata("username") == "bendahara")?"background: rgba(255,255,255,0.4)":""?>">
					<?php if($this->session->userdata('username') == 'kepegawaian'){ ?>
					<div class="row">
						<div class="col-sm-6">
							<ul class="nomargin tiles">
								<li class="image">
									<a href="#" style="width:95px; height:87px;">
										<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="">
									</a>
								</li>
								<li class="blue long" style="width:194px">
									<a href="#" style="width:194px; height:87px;">
										<span class="nopadding"> 
											<h3>Total Pegawai</h3>
										</span>
										<p>4379 Orang</p>
									</a>
								</li>
							</ul>
							<ul class="nomargin tiles">
								<li class="image">
									<a href="#" style="width:95px; height:87px;">
										<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="">
									</a>
								</li>
								<li class="red long" style="width:194px">
									<a href="#" style="width:194px; height:87px;">
										<span class="nopadding"> 
											<h3>Total PNS</h3>
										</span>
										<p>4281 Orang</p>
									</a>
								</li>
							</ul>
						</div>
						<div class="col-sm-6">
							<ul class="nomargin tiles">
								<li class="image">
									<a href="#" style="width:95px; height:87px;">
										<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="">
									</a>
								</li>
								<li class="green long" style="width:194px">
									<a href="#" style="width:194px; height:87px;">
										<span class="nopadding"> 
											<h3>Total TKK</h3>
										</span>
										<p>98 Orang</p>
									</a>
								</li>
							</ul>
							<ul class="nomargin tiles">
								<li class="image">
									<a href="#" style="width:95px; height:87px;">
										<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="">
									</a>
								</li>
								<li class="orange long" style="width:194px">
									<a href="#" style="width:194px; height:87px;">
										<span class="nopadding"> 
											<h3>Total Pensiun</h3>
										</span>
										<p>0 Orang</p>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="row" style="margin-top:10px">
						<div class="col-sm-6">
							<div class="box box-bordered box-color">
								<div class="box-title">
									<h3>Berdasarkan Golongan dan Jenis Kelamin</h3>
								</div>
								<div class="box-content nopadding">
									<table class="table table-striped table-bordered table-hover" style="text-align:center">
										<thead>
											<tr>
												<td rowspan="2" style="vertical-align:bottom;"><b>No</b></td>
												<td rowspan="2" style="vertical-align:bottom;"><b>Kepangkatan</b></td>
												<td colspan="2"><b>Jenis Kelamin</b></td>
												<td rowspan="2" style="vertical-align:bottom;"><b>Total</b></td>
											</tr>
											<tr>
												<td><b>Laki-laki</b></td>
												<td><b>Perempuan</b></td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>I</td>
												<td>12</td>
												<td>7</td>
												<td>19</td>
											</tr>
											<tr>
												<td>2</td>
												<td>II</td>
												<td>368</td>
												<td>469</td>
												<td>837</td>
											</tr>
											<tr>
												<td>3</td>
												<td>III</td>
												<td>1081</td>
												<td>1617</td>
												<td>2767</td>
											</tr>
											<tr>
												<td>4</td>
												<td>IV</td>
												<td>355</td>
												<td>377</td>
												<td>733</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td><b>#</b></td>
												<td><b>JUMLAH</b></td>
												<td><b>1816</b></td>
												<td><b>2531</b></td>
												<td><b>4356</b></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box box-bordered box-color">
								<div class="box-title">
									<h3>Berdasarkan Eselonering dan Jenis Kelamin</h3>
								</div>
								<div class="box-content nopadding">
									<table class="table table-striped table-bordered table-hover" style="text-align:center">
										<thead>
											<tr>
												<td rowspan="2" style="vertical-align:bottom"><b>No</b></td>
												<td rowspan="2" style="vertical-align:bottom"><b>Esselon</b></td>
												<td colspan="2"><b>Jenis Kelamin</b></td>
												<td rowspan="2" style="vertical-align:bottom"><b>Total</b></td>
											</tr>
											<tr>
												<td><b>Laki-laki</b></td>
												<td><b>Perempuan</b></td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>I</td>
												<td>0</td>
												<td>0</td>
												<td>0</td>
											</tr>
											<tr>
												<td>2</td>
												<td>II</td>
												<td>0</td>
												<td>0</td>
												<td>0</td>
											</tr>
											<tr>
												<td>3</td>
												<td>III</td>
												<td>0</td>
												<td>0</td>
												<td>0</td>
											</tr>
											<tr>
												<td>4</td>
												<td>IV</td>
												<td>0</td>
												<td>0</td>
												<td>0</td>
											</tr>
											<tr>
												<td>5</td>
												<td>V</td>
												<td>0</td>
												<td>0</td>
												<td>0</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td><b>#</b></td>
												<td><b>JUMLAH</b></td>
												<td><b>0</b></td>
												<td><b>0</b></td>
												<td><b>0</b></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
					<ul class="tiles tiles-center nomargin">						
						<?php foreach($menu as $row){ ?>
							<li>
								<a href="<?=site_url($row->link)?>">
									<img src="<?=FILES_HOST?>/img/menu/<?=$row->icon?>.png">
								</a>
								<span><?=$row->nama?></span>
							</li>						
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$a = get_wilayah('100100');
	//var_dump($a->Kota);
?>
<!--select class="wilayah" id="Kota" name="Kota" style="width:83%" >
	
</select>

<script>
$('.wilayah').select2({
		ajax: {
			url: '<?=site_url('dashboard/json_wilayah')?>',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page,
					group: '02',
					kode: '0',
					identitas: 'identitas',
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
</script-->