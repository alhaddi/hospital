<?php

require_once COMMONPATH . 'core/Core_Controller.php';

class MY_Controller extends Core_Controller {
	function __construct()
	{
		parent::__construct();
		
		#*********     PATH     ********#
		$full_path['PATH']['FILES'] = '../../../files/hospital/';
		$full_path['PATH']['THEME'] = 'theme/flat/';
		
		#*********     HOST PATH     ********#
		$full_path['HOST']['FILES'] = 'hospital';
		$full_path['HOST']['THEME'] = 'theme/flat';
		
		
		$this->define_path($full_path);
		if(!$this->session->userdata('username') && $this->uri->segment(1) != 'login')
		{
			if($this->uri->segment(1) == 'hims_api'){
			$this->output->delete_cache();
			redirect('hims_api');
			}else{
			$this->output->delete_cache();
			redirect('login');
			}
		}
	}
	
	function define_path($full_path){
		$path = $full_path['PATH'];
		$hostpath = $full_path['HOST'];
		
			foreach($path as $index=>$row){
				
				// $my_path = ($index=="CLIENT")?$row.'/'.$this->session->userdata("web_folder"):$row;
				$my_path = $row;
				if (is_dir($my_path))
				{
					define($index.'_PATH', realpath($my_path));
				}
				else
				{
					exit("Folder ".$index." tidak ditemukan atau tidak berada pada tempat yg seharusnya. Harap buka config di file ini : ".FCPATH."core/MY_Controller.php");
				}
			}
			
			foreach($hostpath as $index=>$row){
				$base_url = $this->config->item('base_url').'/'.$row;
				$files_url = $this->config->item('files_url').'/'.$row;
				$my_path = ($index=="FILES")?$files_url:$base_url;
				define($index.'_HOST', $my_path.'/');
			}
	} 
	
	function display($template,$data=array()){
		//$this->output->cache(1);
		$this->template->display($template,$data);
	}
	
	function clear_cache(){
		if ($handle = opendir(APPPATH.'cache')) {
		//echo "Directory handle: $handle <br /><br/>";
	 
		while (false !== ($entry = readdir($handle))) 
		{               
			//echo $entry."<br />";
			$n = basename($entry);
			//echo "name = ".$n."<br />";  
			//echo "length of name = ".strlen($n)."<br />";
			if( strlen($n) >= 32 ){
				//echo "file name's 32 chars long <br />";
				$p = APPPATH.'cache/'.$entry;
				//echo $p;                  
				unlink($p); 
			}
			//echo "<br />";
		}
		closedir($handle);
	}    
	}
}
