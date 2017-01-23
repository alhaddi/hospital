<?php
	/**
		* CodeIgniter Core Pagination Helper
		*
		* @package         CodeIgniter 2.0+ - 3.0+
		* @subpackage      Helper
		* @category        Helper for Pagination
		* @author          Amir Mufid
		* @version         1.3
	*/
	
	if(!function_exists('load_pagination')){
		function load_pagination($jml,$limit,$offset,$uri2)
		{
			$ci = &get_instance();
			$ci->load->library('pagination');
			
			$config["base_url"] = site_url($ci->uri->segment(1).'/'.$uri2);
			$config["total_rows"] = $jml;
			$config["per_page"] = $limit;
			
			$config['next_link'] = $ci->lang->line('next').' &raquo;';
			$config['prev_link'] = '&laquo; '.$ci->lang->line('prev');
			$config['last_link'] = $ci->lang->line('last').' &raquo;';
			$config['first_link'] = '&laquo; '.$ci->lang->line('first');
			
			$config['full_tag_open'] = "<div class='pagination pull-right' style='margin:0; padding:0;'><ul>";
			$config['full_tag_close'] = '</ul></div><br><br>';
			
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>'; 
			
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			
			
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>'; 
			
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>'; 
			
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>'; 
			
			$config['cur_tag_open'] = "<li class='active'><a>";
			$config['cur_tag_close'] = '</a></li>';
			
			$ci->pagination->initialize($config);
			$link = $ci->pagination->create_links();
			return $link;
		}
	}
	
	if(!function_exists('ajax_pagination'))
	{
		function ajax_pagination($jml,$limit,$offset,$uri2,$filter,$type='')
		{
			$ci = &get_instance();
			$ci->load->library('ajax_pagination');
			$my_uri = $ci->uri->segment(1).'/'.$uri2;
			$uri = explode('/',$my_uri);
			
			$config['div']        	= 'load_content'; //parent div tag id
			$config["base_url"]		= site_url($ci->uri->segment(1).'/'.$uri2);
			$config['total_rows']  	= $jml; 
			$config['uri_segment']  = count($uri)+1;
			$config['per_page']    	= $limit;
			
			$ci->ajax_pagination->initialize($config);
			$link = $ci->ajax_pagination->create_links();
			
			return $link;
		}
	}
	
	if(!function_exists('total_row'))
	{
		function total_row($jml,$limit,$offset){
			$ci = &get_instance();
			$z=$offset+$limit;
			if($z > $jml)
			$z=$jml;
			$ket = 
			'<span class="pull-left">Showing data '.($offset+1).' - '.$z.' from <b>'.($jml).'</b> results</span>';
			return $ket;	
		}
	}
	
?>
