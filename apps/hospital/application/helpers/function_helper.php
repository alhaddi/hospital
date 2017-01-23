<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if ( ! function_exists('load_menu'))
	{
		function load_menu($data, $parent = 0,$class="") {
			static $i = 1;
			$tab = str_repeat("\t\t", $i);
			if (isset($data[$parent])) {
				$html = '';
				
				if($parent != 0){
					$html .= "\n$tab<ul class='".$class."'>";
				}
				
				$i++;
				foreach ($data[$parent] as $v) {
					
					
					if(isset($data[$v->id])){
						$preg_html = '<a href="#" data-toggle="dropdown" class="dropdown-toggle">';
						$class = 'dropdown-menu';
						$class_submenu = ($v->parent_id != 0)?"dropdown-submenu":"";
						$caret = '<i class="fa fa-caret-down"></i>';
					}
					else
					{
						$preg_html = '<a href="'.site_url($v->link).'">';
						$class = '';
						$class_submenu = '';
						$caret = '';
					}
					
					
					$html .= "\n\t$tab<li class='".$class_submenu."'>";
					
					$label = ($v->parent_id == 0)?'<span>'.$v->nama.'</span> '.$caret:$v->nama;
					$icon = (!empty($v->icon))?'<img src="'.FILES_HOST.'img/menu/'.$v->icon.'_menu.png"> ':'';
					$html .= $preg_html.$icon.$label.'</a>';
					
					$child = load_menu($data, $v->id,$class);
					if ($child) {
						$i--;
						$html .= $child;
						$html .= "\n\t$tab";
					}
					$html .= '</li>';
				}
				
				
				if($parent != 0){
					$html .= "\n$tab</ul>";
				}
				return $html;
				} else {
				return false;
			}
		}
	}
