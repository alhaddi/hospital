<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						MIS Report
					</h3>
					
				</div>
<?php 
$hide = ''; 
$hide2 = '';
$hide3 = '';
$a1='';
$a2='';
$a3='active';
if(!empty($_GET['rajal'])){
	if($_GET['rajal'] == 'ya'){
		$hide="display:none;";
		$a1='active';
		$a3='';
	}
}
if(!empty($_GET['igd'])){
	if($_GET['igd'] == 'ya'){
		$hide2="display:none;";
		$a2='active';
		$a3='';
	}
}
if(!empty($_GET['konsultasi'])){
	if($_GET['konsultasi'] == 'ya'){
		$hide3="display:none;";
	}
}
?>
				<div class="box-content nopadding">
					<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="<?=$a3?>" style='<?=$hide?>'><a href="#Patient" data-toggle="tab" aria-expanded="true">Pasein</a></li>
								
								<li class="" style='<?=$hide.$hide2.$hide3?>'><a href="#TotalPembayaran" data-toggle="tab" aria-expanded="false">Total Pembayaran</a></li>
								
								<li class="<?=$a1?>" style='<?=$hide2.$hide3?>'><a href="#SetoranRegistrasi" data-toggle="tab" aria-expanded="false">Setoran Registrasi</a></li>
								
								<li class="" style='<?=$hide2.$hide3?>'><a href="#SetoranInternalKonsultasi" data-toggle="tab" aria-expanded="false">Setoran Internal Konsultasi</a></li>
								
								<li class="<?=$a2?>" style='<?=$hide2.$hide.$hide3?>'><a href="#SetoranRegistrasiIGD" data-toggle="tab" aria-expanded="false">Setoran Registrasi IGD</a></li>
								
								<li class="" style='<?=$hide2.$hide.$hide3?>'><a href="#SetoranInternalKonsultasiIGD" data-toggle="tab" aria-expanded="false">Setoran Internal Konsultasi IGD</a></li>
								
								<li class="" style='<?=$hide.$hide2.$hide3?>'><a href="#SetoranKonsultasi" data-toggle="tab" aria-expanded="false">Setoran Tindakan</a></li>
								
								<li class="" style='<?=$hide.$hide2.$hide3?>'><a href="#SetoranPenunjang" data-toggle="tab" aria-expanded="false">Setoran Penunjang</a></li>
							</ul>
							<div class="tab-content nopadding">
								<div class="tab-pane <?=$a2?> <?=$a3?>" id="Patient">
									<?=$this->load->view("report/Patient",$data)?>
								</div>
								<div class="tab-pane" id="TotalPembayaran">
									<?=$this->load->view("report/TotalPembayaran",$data)?>
								</div>
								<div class="tab-pane <?=$a1?>" id="SetoranRegistrasi">
									<?=$this->load->view("report/SetoranRegistrasi",$data)?>
								</div>
								<div class="tab-pane" id="SetoranInternalKonsultasi">
									<?=$this->load->view("report/SetoranInternalKonsultasi",$data)?>
								</div>
								<div class="tab-pane " id="SetoranRegistrasiIGD">
									<?=$this->load->view("report/SetoranRegistrasiIgd",$data)?>
								</div>
								<div class="tab-pane" id="SetoranInternalKonsultasiIGD">
									<?=$this->load->view("report/SetoranInternalIgd",$data)?>
								</div>
								<div class="tab-pane" id="SetoranKonsultasi">
									<?=$this->load->view("report/SetoranKonsultasi",$data)?>
								</div>
								<div class="tab-pane" id="SetoranPenunjang">
									<?=$this->load->view("report/SetoranPenunjang",$data)?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
