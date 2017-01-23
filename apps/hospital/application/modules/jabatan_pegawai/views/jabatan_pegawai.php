<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
					Data Utama Pegawai</h3>
				</div>
				<div class="box-content padding">
					<div class="row">
						
						<div class="col-sm-2">
							<img src="<?=FILES_HOST?>/img/avatar_color.png" alt="" width="185">
							<button class="btn btn-danger form-control"><i class="fa fa-search"></i> Cari Pegawai</button>
						</div>
						<div class="col-sm-6">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Nama Lengkap" readonly>
								</div>
									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="Gol/Ruang" readonly>
										</div>
										<div class="col-sm-5">
											<input type="text" class="form-control" placeholder="Pangkat" readonly>
										</div>
									</div>
								
							</div>
							<div class="col-sm-6">
								<div style="margin-bottom: 15px">
									<input type="text" class="form-control" placeholder="NIP" readonly>
								</div>
								<div style="margin-bottom: 15px">
									<input type="text" class="form-control" placeholder="Kedudukan Hukum" readonly>
								</div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Jabatan" readonly>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Unit Kerja" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered box-color">
				<div class="box-title">
					<h3>
						<i class="fa fa-table"></i>
						Daftar <?=$title?>
					</h3>
					<div class="actions">
						<button data-datatable-action="add" data-datatable-idtable="<?=$id_table?>" class="btn btn-mini">
							<i class="fa fa-plus"></i> Tambah
						</button>
						<button data-datatable-action="bulk" data-datatable-idtable="<?=$id_table?>" class="btn btn-mini">
							<i class="fa fa-trash"></i> Hapus
						</button>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn--icon">
								<i class="fa fa-download"></i> Export
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a data-download="excel" data-download-url="jabatan_pegawai/excel"><i class="fa fa-file-excel-o fa-fw"></i> Excel (.xlsx)</a>
								</li>
								<li>
									<a data-download="pdf" data-download-url="jabatan_pegawai/pdf"><i class="fa fa-file-pdf-o fa-fw"></i>Pdf (.pdf)</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="box-content nopadding">
					<table id="<?=$id_table?>" class="table table-hover table-nomargin table-striped table-bordered" 
					data-plugin="datatable-server-side" 
					data-datatable-list="<?=$datatable_list?>"
					data-datatable-edit="<?=$datatable_edit?>"
					data-datatable-delete="<?=$datatable_delete?>"
					data-datatable-colvis="true"
					data-datatable-multiselect="true"
					data-datatable-nocolvis=""
					>
						<thead>
							<tr>
								<th class="with-checkbox" data-datatable-align="text-center" style="vertical-align: middle"rowspan="2">
									<input type="checkbox" name="check_all" data-datatable-checkall="true">
								</th>
								<th data-datatable-align="text-center" style="width:50px; vertical-align:middle;" rowspan="2">No.</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Nama Jabatan</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Unit Kerja</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Jabatan Terakhir</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Jenis Jabatan</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Esselon</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">THT</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" colspan="4">Surat Keterangan(SK)</th>
								<th data-datatable-align="text-left" style="vertical-align:middle;" rowspan="2">Status</th>
								<th data-datatable-align="text-center" style="width:100px; vertical-align:middle;" rowspan="2">Action</th>
							</tr>
							<tr>
								<th>Nomor</th>
								<th>Tanggal</th>
								<th>Penandatangan</th>
								<th>Lampiran</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $load_form ?>
