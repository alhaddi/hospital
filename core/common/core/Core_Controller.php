<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Core Controller
	* @author          Amir Mufid
	* @version         1.1
*/

require_once COMMONPATH."third_party/MX/Controller.php";

class Core_Controller extends MX_Controller {
	
	function bootstarp_table($config)
	{
		@extract($config);
		
		$this->load->library('table');
		$template = array(
				'table_open'            => '<table class="table table-striped table-bordered table-hover">',
				
				'thead_open'            => '<thead>',
				'thead_close'           => '</thead>',

				'heading_row_start'     => '<tr>',
				'heading_row_end'       => '</tr>',
				'heading_cell_start'    => '<th>',
				'heading_cell_end'      => '</th>',

				'tbody_open'            => '<tbody>',
				'tbody_close'           => '</tbody>',

				'row_start'             => '<tr>',
				'row_end'               => '</tr>',
				'cell_start'            => '<td>',
				'cell_end'              => '</td>',

				'row_alt_start'         => '<tr>',
				'row_alt_end'           => '</tr>',
				'cell_alt_start'        => '<td>',
				'cell_alt_end'          => '</td>',

				'table_close'           => '</table>'
		);
		$this->table->set_template($template);
		/* echo '<pre>';
		print_r($thead); */
		$this->table->set_heading(array_push_before($thead,array('No.'),0));
		$no = (isset($no))?$no:1;
		foreach($tbody as $row)
		{
			$fields = array_intersect_key($row,$thead);
			$this->table->add_row(array_push_before($fields,array($no),0));
			$no++;
		}
		return $this->table->generate();
	}
}

