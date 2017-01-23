							<input name="id" type="hidden" value="<?=element('id',$konsultasi)?>">
							<input name="edit" type="hidden" value="ya">
							<input name="id_billing" type="hidden" value="<?=$id_billing?>">
										<div class="box">
											<div class="box-content nopadding">
												<table id="<?=$id_table?>" class="table table-fixed table-hover table-nomargin table-bordered">
													<thead>
														<tr class="fixheight">
															<th style="width:3%;" class="text-left">No</th>
															<th style="width:35%;" class="text-left">Nama Penunjang</th>
															<th style="width:7%;" class="text-center">Jumlah</th>
															<th style="width:20%;" class="text-left">Biaya</th>
															<th style="width:35%;" class="text-left">Klinis</th>
														</tr>
													</thead>
													<tbody id="penunjang">
													<?php $total=0; $no=0; foreach($penunjang as $row){ ?>
														<tr class="fixheight">
															<td style="width:3%;" class="text-left"><?=++$no?></td>
															<td style="width:35%;" class="text-left"><?=$row['nama']?></td>
															<td style="width:7%;" class="text-center"><?=$row['jumlahp']?></td>
															<td style="width:20%;" class="text-right"><?=rupiah($row['biayap'])?></td>
															<td style="width:35%;" class="text-left"><?=$row['klinis']?></td>
														</tr>
													<?php $total+=$row['biayap']; }?>
													</tbody>
													<thead>
														<tr class="fixheight">
														<th style="width:45%;" class="text-center" colspan="3">Total Biaya</th>
														<th style="width:20%;" class="text-right" ><input type="hidden" name="total" id="total" value="<?=$total?>"><div class="jsum"><?=rupiah($total)?></div></th>
														<th style="width:35%;"></th>
														</tr>
														
													</thead>
												</table>
											</div>
										</div>
