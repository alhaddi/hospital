<?php
$string = "<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        ".$c." Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class " . $c . " extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		\$this->load->model('".$m."');
		\$config['table'] = '".$table_name."';
		\$config['column_order'] = array(null,";
		foreach ($all as $row) {
			$string .= "'".$row['column_name']."',";
		}
$string .="null);
		\$config['column_search'] = array(";
		$x = 1;
		foreach ($all as $row) {
			if($x>1){
			$string .= ",";
			}
			$string .= "'".$row['column_name']."'";
		$x++;
		}
$string .=");
		\$config['column_excel'] = array(";
		$x = 1;
		foreach ($non_pk as $row) {
					
			if(!in_array($row['column_name'],$hidden_form))
			{
				if($x>1){
				$string .= ",";
				}
				$string .= "'".$row['column_name']."'";
		$x++;
			}
		}
$string .=");
		\$config['column_pdf'] = array(";
		$x = 1;
		foreach ($non_pk as $row) {
					
			if(!in_array($row['column_name'],$hidden_form))
			{
				if($x>1){
				$string .= ",";
				}
				$string .= "'".$row['column_name']."'";
		$x++;
			}
		}
$string .=");
		\$config['order'] = array('id' => 'asc');
		\$this->".$m."->initialize(\$config);
    }";

    
$string .= "\n\n    public function index()
    {
		\$data['title'] = '".$c."';
		\$data['id_table'] = '".$c_url."';
		\$data['datatable_list'] = '".$c_url."/ajax_list';
		\$data['datatable_edit'] = '".$c_url."/ajax_edit';
		\$data['datatable_delete'] = '".$c_url."/ajax_delete';
		\$data['datatable_save'] = '".$c_url."/ajax_save';
		\$data['load_form'] = \$this->load_form(\$data);
		\$this->template->display('".$c_url."',\$data);
    }";   
	
$string .= "\n\n    public function load_form(\$data)
	{
		return \$this->load->view('form_".$c_url."',\$data,true);
	}";

    	
$string .= "\n\n    public function ajax_list()
	{	
		\$list = \$this->".$m."->get_datatables();
		\$data = array();
		\$no = \$_POST['start'];
		foreach (\$list as \$row) {
			\$no++;
			\$fields = array();
			\$fields[] = \$row->id;
			\$fields[] = \$no;
			";
			foreach ($non_pk as $row) {
				if(in_array(trim($row['data_type']),array('datetime','timestamp'))){
					$string .= "\n\t\t\t \$fields[] = convert_tgl(\$row->".$row['column_name'].",'d M Y H:i',1);";
				}
				elseif(in_array(trim($row['data_type']),array('date'))){
					$string .= "\n\t\t\t \$fields[] = convert_tgl(\$row->".$row['column_name'].",'d M Y',1);";
				}
				else{
					$string .= "\n\t\t\t \$fields[] = \$row->".$row['column_name'].";";
				}
			}
				
$string .= "
			\$fields[] = \$row->id;
			
			\$data[] = \$fields;
		}

		\$output = array(
			\"draw\" => \$_POST['draw'],
			\"recordsTotal\" => \$this->".$m."->count_all(),
			\"recordsFiltered\" => \$this->".$m."->count_filtered(),
			\"data\" => \$data,
		);

		echo json_encode(\$output);
	}";

    
$string .= "

	public function ajax_edit(\$id=0)
	{
		\$data_object = \$this->".$m."->get_by_id(\$id);
		if(\$data_object)
		{
			\$list_fields = array(";
			
			foreach ($non_pk as $row) {
				$string .= "\n\t\t\t '".$row['column_name']."',";
			}
			
$string .= "
			);
			
			\$fields = \$this->".$m."->list_fields(\$list_fields);
			\$data = (array) \$data_object;
			
			foreach(\$fields as \$meta){
				\$data_new['name'] = \$meta->name;
				\$data_new['value'] = \$data[\$meta->name];
				\$data_array[] = \$data_new;
			}
			
			\$result['status'] = 0;
			\$result['data_array'] = \$data_array;
			\$result['data_object'] = \$data_object;
			\$response['response'] = \$result;
		}
		else
		{
			\$result['status'] = 99;
			\$response['response'] = \$result;
		}
		echo json_encode(\$response);
	}
";

$string .= "
	public function ajax_save()
	{
		\$post = \$this->input->post(NULL,TRUE);
		\$data = array(";
			foreach ($non_pk as $row) {
				if(!in_array($row['column_name'],$hidden_form)){
					$string .= "\n\t\t\t '".$row['column_name']."' => \$post['".$row['column_name']."'],";
				}
			}
$string .= "	
			'last_user'=>\$this->session->userdata('username')
		);
			
		if(empty(\$post['id']))
		{
			\$data['add_time'] = date('Y-m-d H:i:s');
			\$result = \$this->".$m."->insert(\$data);
		}
		else
		{
			\$result = \$this->".$m."->update(array('id' => \$post['id']), \$data);
		}
		
		echo json_encode(array(\"status\" => true));
		
	}
";

$string .= "  

	public function ajax_delete()
	{
		\$post = \$this->input->post(NULL,TRUE);
		\$id = \$post['id'];
		if(!is_array(\$id)){
			\$id[] = \$id;
		}
		\$this->".$m."->delete(\$id);
		echo json_encode(array(\"status\" => TRUE));
	}
";

$string .= "  
	public function excel()
	{
		\$this->load->library(\"Excel\");

		\$query = \$this->".$m."->data_excel(\"".$c_url."\");
		\$this->excel->export(\$query);
	}
	
	public function pdf()
	{
		\$this->load->library(\"Chtml2pdf\");
		\$this->load->library(\"Header_file\");
		
		\$query = \$this->".$m."->data_pdf();
		\$data['header'] = \$this->header_file->pdf('100%');
		\$data['query'] = \$query;
		\$content = \$this->load->view('pdf_".$c_url."',\$data,true);
		\$this->chtml2pdf->cetak(\"P\",\"A4\",\$content,\"".$c."\",\"I\"); 
	}
";
$string .= "}
?>
";

$hasil_controller = createFile($string, $target . "controllers/" . $c_file);

?>