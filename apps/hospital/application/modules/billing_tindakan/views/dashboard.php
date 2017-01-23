<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Billing Konsultasi
					</h3>
					
				</div>
				<div class="box-content nopadding">
					<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#Patient" data-toggle="tab" aria-expanded="true">Billing Tindakan</a></li>
								
								<li class=""><a href="#TotalPembayaran" data-toggle="tab" aria-expanded="false">Billing Penunjang</a></li>
								
							</ul>
							<div class="tab-content nopadding">
								<div class="tab-pane active" id="Patient">
									<?=$this->load->view("billing_tindakan/billing_tindakan",$data)?>
								</div>
								<div class="tab-pane" id="TotalPembayaran">
									<?=$this->load->view("billing_tindakan/billing_penunjang",$data)?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
