<div class="wrapper">
		<header class="header header-1" id="header">
			<div class="nav-wrap">
				<div class="container">
					<div class="row">
						<div class="col-sm-1">
							<div class="logo">
								<a href="#"><img src="<?=FILES_HOST?>img/rsu-slamet-logo.jpg" width="80"></a>
							</div>
							<button class="menu visible-xs" id="menu"></button>
						</div>
						<div class="col-sm-5">
							<div class="logodiv">
								<span class="logo-text">RSUD dr.Slamet Garut</span>
								<span class="logo-caption">JL.Rumah Sakit Umum No. 12, Sukakarya, Garut Kota | Telepon : (0262) 232720</span>
							</div>
						</div>
						<div class="col-sm-6 nav-bg">
							<nav class="navigation">
								<ul>
									<li>
										<a href="index.html">-</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="main-banner">
			<div class="rev_slider_wrapper" data-alias="news-gallery34" id="rev_slider_34_1_wrapper">
				<div class="rev_slider fullwidthabanner" data-version="5.0.7" id="rev_slider_34_1">
					<ul>
						<li data-index="rs-129">
							<img alt="" class="rev-slidebg" src="<?= FILES_HOST?>img/banner.jpg">
							<div class="tp-caption Newspaper-Title tp-resizeme" data-fontsize="['50','50','50','30']" data-height="none" data-hoffset="['100','50','50','30']" data-lineheight="['55','55','55','35']" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:0;y:0;s:inherit;e:inherit;" data-responsive_offset="on" data-splitin="none" data-splitout="none" data-start="1000" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" data-voffset="['165','135','105','0']" data-whitespace="normal" data-width="['600','600','600','420']" data-x="['left','left','left','left']" data-y="['top','top','top','center']" id="slide-129-layer-1">
								<div class="banner-text">
									<span>Selamat datang di</span>
									<h2>RSUD DR . Slamet Garut</h2>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever.</p>
								</div>
							</div>
						</li>
					</ul>
					<div class="tp-bannertimer tp-bottom"></div>
				</div>
			</div>
			<div class="appointment">
				<div class="container">
					<form>
						<div class="form-field">
							<div class="col-sm-10">
								<input class="input-sm form-full" id="nama_lengkap" name="nama_lengkap" placeholder="Cari nama pasien disini..." type="text">
							</div>
							<div class="col-sm-2">
							  <a id="patient-search" onclick="patientSearch();" class="btn border-line btn-white-line input-sm form-full">Cari</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

    <!-- Modal Show -->

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Daftar Pasien</h4>
          </div>
          <div class="modal-body">
			<p class="text-center"><b id="list-result">-- Hasil Pencarian Pasien --</b></p>
			<div class="panel-group" id="list-patient" role="tablist" aria-multiselectable="true"></div>
		  </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
	
	<script>
		$('#nama_lengkap').focus();
		
		function patientSearch(){
		var nama_lengkap = $('#nama_lengkap').val();
		var text = "";
		var i;
			
			if(nama_lengkap == ''){
				alert('Silahkan inputkan nama pasien...!');
				location.reload();
			}
		
			$.ajax({
				url : "<?= base_url('login/searchPatient')?>",
				data : {
					nama_lengkap : nama_lengkap
				},
				type: "POST",
				dataType: "JSON",
				success: function(data){
					console.log(data);
					if(typeof data[0] === 'undefined'){
						$('#list-result').text('-- Data pasien tidak ada atau tidak ditemukan --');
					}else{
						$('#list-result').text('-- Hasil Pencarian Pasien --');
						for (i = 0; i < data.length; i++) {
							if(data[i].pulang == '1'){
								var rawat="<font color='red'>Sudah Pulang</font>";
							}else{
								var rawat=data[i].ruang_rawat;
							}
							text += "<div class='panel panel-default'>";
							text += "<div class='panel-heading' role='tab'>";
							text += "<h4 class='panel-title'>";
							text += "<a class='collapsed' role='button' data-toggle='collapse' data-parent'#accordion' href='#"+ data[i].id +"'>";
							text += "<div>" + data[i].nama_lengkap + "</div>";
							text += "<div><small><b>Nomer RM : </b>" + data[i].rm	 + " | <b>Alamat : </b>" + data[i].alamat + " | <b>Ruangan Inap : </b>" + rawat +"</small></div>";
							text += "</a>";
							text += "</h4>";
							text += "</div>";
							text += "</div>";
						}
					
					}
					
					document.getElementById("list-patient").innerHTML = text;
					$('#myModal').modal('show');

				}
			});
		}
	</script>