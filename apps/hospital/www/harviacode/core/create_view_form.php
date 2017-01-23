<?php 
$string = '
<form data-datatable-action="save" data-datatable-idtable="<?=$id_table?>" id="form_<?=$id_table?>" action="<?=site_url($datatable_save)?>" method="POST">
	<div data-datatable-idtable="<?=$id_table?>" class="modal fade in" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel"><span id="modal_title"></span> <?=$title?></h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<div class="form-vertical">
						<input type="hidden" name="id" id="id">';
				foreach ($non_pk as $row) {
					
					if(!in_array($row['column_name'],$hidden_form))
					{
					$required = ($row['is_null']=="NO")?'data-rule-required="true"':'';
					$maxlength = ($row['maxlength'])?'data-rule-maxlength="'.$row['maxlength'].'"':'';

					if ($row["data_type"] == 'text')
					{
						$string .= "\n\t\t\t\t\t\t";
						$string .= '<div class="form-group">
							<label for="'.$row["column_name"].'" class="control-label">'.label($row["column_name"]).'</label>
							<textarea name="'.$row["column_name"].'" id="'.$row["column_name"].'" class="form-control" '.$required.' '.$maxlength.'></textarea>
						</div>
						';
					} 
					else
					{
						$string .= "\n\t\t\t\t\t\t";
						$string .= '<div class="form-group">
							<label for="'.$row["column_name"].'" class="control-label">'.label($row["column_name"]).'</label>
							<input type="text" name="'.$row["column_name"].'" id="'.$row["column_name"].'" class="form-control" '.$required.' '.$maxlength.'>
						</div>
						';

					}
					
					}
				}
$string .= '		
					</div>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</form>
';

$hasil_view_form = createFile($string, $target."views/" . $v_form_file);

?>