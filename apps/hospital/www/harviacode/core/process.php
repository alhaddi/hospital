<?php

$hasil = array();

if (isset($_POST['generate']))
{
    // get form data
	$table_name = (isset($_POST['table_name']))?safe($_POST['table_name']):NULL;
    $jenis_tabel = (isset($_POST['jenis_tabel']))?safe($_POST['jenis_tabel']):NULL;
    $export_excel = (isset($_POST['export_excel']))?safe($_POST['export_excel']):NULL;
    $export_word = (isset($_POST['export_word']))?safe($_POST['export_word']):NULL;
    $export_pdf = (isset($_POST['export_pdf']))?safe($_POST['export_pdf']):NULL;
    $controller = (isset($_POST['controller']))?safe($_POST['controller']):NULL;
    $model = (isset($_POST['model']))?safe($_POST['model']):"";

    if ($table_name <> '')
    {
        // set data
        $table_name = $table_name;
        $c = $controller <> '' ? ucfirst($controller) : ucfirst($table_name);
        $m = $model <> '' ? ucfirst($model) : ucfirst($table_name) . '_model';
		
        // url
        $c_url = strtolower($c);
		
        $v_list = $c_url . "";
        $v_read = $c_url . "_read";
        $v_form = "form_".$c_url;
        $v_doc = $c_url . "_doc";
        $v_pdf = "pdf_".$c_url;


        // filename
        $c_file = $c . '.php';
        $m_file = $m . '.php';
        $v_list_file = $v_list . '.php';
        $v_read_file = $v_read . '.php';
        $v_form_file = $v_form . '.php';
        $v_doc_file = $v_doc . '.php';
        $v_pdf_file = $v_pdf . '.php';

        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
		$target = str_replace('[controller_name]',$c_url,$target).'/';
		
		if(!is_dir($target))
		{
            mkdir($target, 0777, true);
		}
		
		$arr_mk_dir = array(
			'controllers',
			'models',
			'views'
		);
		foreach($arr_mk_dir as $arr_dir){
			if (!file_exists($target . "/".$arr_dir."/"))
			{
				mkdir($target . "/".$arr_dir."/", 0777, true);
			}
		}
        
        $pk = $hc->primary_field($table_name);
        $non_pk = $hc->not_primary_field($table_name);
        $all = $hc->all_field($table_name);
		$hidden_form = array('add_time','last_user','last_update');
		
        // generate
        //include 'core/create_config_pagination.php';
        include 'core/create_controller.php';
        include 'core/create_model.php';
        $jenis_tabel == 'reguler_table' ? include 'core/create_view_list.php' : include 'core/create_view_list_datatables.php';
        include 'core/create_view_form.php';
        $export_pdf == 1 ? include 'core/create_view_list_pdf.php' : '';

        //$export_excel == 1 ? include 'core/create_exportexcel_helper.php' : '';
        //$export_word == 1 ? include 'core/create_view_list_doc.php' : '';
        //$export_pdf == 1 ? include 'core/create_pdf_library.php' : '';
		
        $hasil[] = $hasil_controller;
        $hasil[] = $hasil_model;
        $hasil[] = $hasil_view_list;
        $hasil[] = $hasil_view_form;
        $hasil[] = $hasil_view_pdf;
        //$hasil[] = $hasil_view_read;
		//$hasil[] = $hasil_view_doc;
        //$hasil[] = $hasil_config_pagination;
        //$hasil[] = $hasil_exportexcel;
        //$hasil[] = $hasil_pdf;
    } else
    {
        $hasil[] = 'No table selected.';
    }
}

?>