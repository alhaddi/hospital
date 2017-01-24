<?php 

class Template 
{
	protected $lib;

	function __construct()
	{
		$this->lib = & get_instance();
	}
	
	function display($template,$data=array(),$theme='flat/')
	{	
		$data['head']=$this->lib->load->view(
		'template/'.$theme.'head',$data, true);
		
		$data['libs']=$this->lib->load->view(
		'template/'.$theme.'libs',$data, true);
		
		$data['list_menu']=$this->lib->load->view(
		'template/'.$theme.'list-menu',$data, true);
		
		$data['header']=$this->lib->load->view(
		'template/'.$theme.'header',$data, true);
		
		$data['footer']=$this->lib->load->view(
		'template/'.$theme.'footer',$data, true);
		
		$data['head_title']=$this->lib->load->view(
		'template/'.$theme.'title',$data, true);
		
		$data['content']=$this->lib->load->view(
		$template,$data, true); 
		
		$this->lib->load->view('template/'.$theme.'/template.php',$data);
	}
		
	function display2($template,$data=array(),$theme='incube/')
	{	
		$data['head']=$this->lib->load->view(
		'template/'.$theme.'head',$data, true);
		
		$data['libs']=$this->lib->load->view(
		'template/'.$theme.'libs',$data, true);
		
		$data['list_menu']=$this->lib->load->view(
		'template/'.$theme.'list-menu',$data, true);
		
		$data['header']=$this->lib->load->view(
		'template/'.$theme.'header',$data, true);
		
		$data['footer']=$this->lib->load->view(
		'template/'.$theme.'footer',$data, true);
		
		$data['head_title']=$this->lib->load->view(
		'template/'.$theme.'title',$data, true);
		
		$data['content']=$this->lib->load->view(
		$template,$data, true); 
		
		$this->lib->load->view('template/'.$theme.'/template.php',$data);
	}
}
