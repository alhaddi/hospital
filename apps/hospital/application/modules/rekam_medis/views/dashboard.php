<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Rekam Medis
					</h3>
					
				</div>
				<div class="box-content nopadding">
					<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#KunjunganPasien" data-toggle="tab" aria-expanded="false">Kunjungan Pasien</a></li>
								<li><a href="#RekapitulasiKunjunganPasien" data-toggle="tab" aria-expanded="false">Rekapitulasi Kunjungan Pasien</a></li>
								<li><a href="#RekapitulasiDiagnosa" data-toggle="tab" aria-expanded="false">Rekapitulasi Diagnosa</a></li>
							</ul>
							<div class="tab-content nopadding">
								<div class="tab-pane active" id="KunjunganPasien">
									<?=$this->load->view("rekam_medis/KunjunganPasien",$data)?>
								</div>
								<div class="tab-pane" id="RekapitulasiKunjunganPasien">
									<?=$this->load->view("rekam_medis/RekapulasiKunjunganPasien",$data)?>
								</div>
								<div class="tab-pane" id="RekapitulasiDiagnosa">
									<?=$this->load->view("rekam_medis/RekapulasiDiagnosa",$data)?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
