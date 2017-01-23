<?php
	/**
		* CodeIgniter Core DB Helper
		*
		* @package         CodeIgniter 2.0+ - 3.0+
		* @subpackage      Helper
		* @category        Helper DB Function
		* @author          Amir Mufid
		* @version         2.0
	*/
	
	/* CodeIgniter 3 */
	if(!function_exists('url_bpjs'))
	{
		function url_bpjs($nama)
		{
			$ci = &get_instance();
			
			$ci->db->where('nama',$nama);
			$data=$ci->db->get('katalog_bpjs');
			if($data->num_rows() > 0){
			return $data->row();
			}else{
			return null;	
			}
		}
	}
	
	if(!function_exists('header_bpjs'))
	{
		function header_bpjs($get="")
		{
			$ci = &get_instance();
			$dataid    = "4208"; //consumerID dari BPJS
			$secretKey = "1xUB4D73E1"; //consumerSecret dari BPJS

			date_default_timezone_set('UTC');
			$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
			$signature = hash_hmac('sha256', $dataid."&".$tStamp, $secretKey, true);
			$encodedSignature = base64_encode($signature);

			if($get=='cons_id'){
			return $dataid;
			}elseif($get=='timestamp'){
			return $tStamp;
			}elseif($get=='signature'){
			return $encodedSignature;
			}
			else{
			$data=array();
			$data[]="X-cons-id: " .$dataid;
			$data[]="X-timestamp:" .$tStamp;
			$data[]="X-signature: " .$encodedSignature;
			return $data;
			}
		}
	}
	
	if(!function_exists('get_field'))
	{
		function get_field($where,$namatabel,$namafield="Nama")
		{
			$ci = &get_instance();
			$ci->db->select($namafield." as field",true);
			if(!is_array($where))
			{
				$fields = $ci->db->field_data($namatabel);
				foreach($fields as $row)
				{
					if($row->primary_key == 1)
					{
						$my_field = $row->name;
					}
				}
				$where = array($my_field => $where);
			}
			$ci->db->where($where);
			$q = $ci->db->get($namatabel)->row();
			if ($ci->db->affected_rows() > 0)
			{
				$return = $q->field;
			}
			else
			{
				$return = '-';
			}
			return $return;
		}
	}
	
	if(!function_exists('get_row'))
	{
		function get_row($where,$table_name,$return='object')
		{
			$ci = &get_instance();
			$ci->db->where($where);
			$q = $ci->db->get($table_name);
			
			if($return == 'array')
			{
				return $q->row_array();
			}
			elseif($return == 'object')
			{
				return $q->row();
			}
			elseif($return == 'json')
			{
				return json_encode($q->row_array());
			}
			else
			{
				exit('error where return the row');
			}
		}
	}
	
	if(!function_exists('get_result'))
	{
		function get_result($where,$namatabel,$sort=array(),$return="object")
		{
			$ci = &get_instance();
			if($sort)
			{
				$ci->db->order_by($sort);
			}
			
			$ci->db->where($where);
			$q = $ci->db->get($namatabel);
			
			if($return == 'array')
			{
				return $q->result_array();
			}
			elseif($return == 'object')
			{
				return $q->result();
			}
			elseif($return == 'json')
			{
				return json_encode($q->result_array());
			}
			else
			{
				exit('error where return the result');
			}
		}
	}
	
	if(!function_exists('get_data_id')){
		
		function get_data_id($id,$namatabel)
		{
			$ci = &get_instance();
			$ci->db->where('ID',$id);
			$Q=$ci->db->get($namatabel);
			return $Q->result();
		}
		
	}
	
	if(!function_exists('get_photo')){
		
		function get_photo($kode,$foto,$jk,$namatabel,$class='')
		{
			if($foto)
			{
				$path = CLIENT_HOST.$namatabel."/".$kode."/foto/".$foto;
			}
			elseif($jk == "L")
			{
				$path = ASSETS_HOST."images/default_".$namatabel.".png";
			}
			elseif($jk == "P")
			{
				$path = ASSETS_HOST."images/default_".$namatabel."_2.png";
			}
			else
			{
				$path = ASSETS_HOST.'images/tanda_tanya.png';
			}
			return '<img class="'.$class.'" src="'.$path.'">';
		}
	}
	
	if(!function_exists('get_img')){
		
		function get_img($img="",$noimage="no-image",$pathonly="",$class="",$css="")
		{
				
				if(is_file(FILES_PATH.'/'.$img))
				{
					$path = FILES_HOST.$img;
				}
				elseif($noimage=='avatar')
				{
					$path = FILES_HOST.'img/avatar.png';
				}
				else
				{
					$path = FILES_HOST.'img/no-image.png';
				}

				
				if(empty($pathonly))
				{
					return '<img style="'.$css.'" class="'.$class.'" src="'.$path.'" alt="">';
				}
				else
				{
					return $path;
				}
		}
		
	}
	
	if(!function_exists('call_sp')){
		function call_sp($procedure_name, $params = array(), $type = "proc",$return="result",$multi=0) 
		{
			$ci =& get_instance();
			$param_list=array();
			$parameter = "";
			$outs = array();
			$counter=0;
			foreach($params as $key=>$p){
				$check=false;
				if(substr($p,0,1)=="@"){
					array_push($outs,$p);
					$check=true;
				}
				if($check==true){
					$parameter.=$p;
					}else{
					if($p===NULL)
					{
						$parameter.='NULL';
						}else{
						if(sizeof($param_list)>0){
							if(in_array(strtolower($param_list[$key]->DATA_TYPE),array("tinyint","int","bigint"))){
								$parameter.=(int)$p;
								}elseif(in_array(strtolower($param_list[$key]->DATA_TYPE),array("char","varchar","text"))){
								$parameter.="'".((string)$p)."'";
								}elseif(in_array(strtolower($param_list[$key]->DATA_TYPE),array("float","decimal"))){
								$parameter.=(float)$p;
								}elseif(in_array(strtolower($param_list[$key]->DATA_TYPE),array("double"))){
								$parameter.=(double)$p;
								}else{
								$parameter.="'".$p."'";
							}            
							}else{
							$parameter.="'".$p."'";
						}
					}
				}
				(($counter + 1) < sizeof($params)) ? $parameter.="," : "";
				$counter++;
			}
			$row=array();
			if($multi==1){      
				$arr  = $this->otherdb->GetMultiResults("CALL $procedure_name($parameter)");
				if($return=="result"){
					return $arr;
					}else{
					return (isset($arr[0]) ? $arr[0] : array());
				}
			}
			else
			{      
				if ($type == "proc") {
					$result = $ci->db->query("call $procedure_name($parameter)");
					} else {
					$result = $ci->db->query("select " . $procedure_name . "(" . $parameter . ") as result_function");
				}
				if(sizeof($outs)>0){
					$parameter="";
					for ($x = 0; $x < sizeof($outs); $x++) {
						$parameter.=(($x + 1) < sizeof($outs)) ? $outs[$x]." as ".substr($outs[$x],1)."," : $outs[$x]." as ".substr($outs[$x],1);
					}
					$result=$ci->db->query("select $parameter");
					$row = $result->row();
					}else{
					if($return=="result"){
						$row = $result->result();
						}elseif($return=="result_array"){
						$row = $result->result_array();
						}elseif($return=="row_array"){
						$row = $result->row_array();
						}elseif($return=="row"){
						$row = $result->row();
						}elseif($return=="json"){
						$row = $result->result();
						$row = json_encode($row);
					}
				}
				$result->next_result();
				$result->free_result();
				return $row;
			} 
		}
	}
	
	if(!function_exists('get_wilayah')){
		function get_wilayah($kode=0,$group=null,$keyword=null)
		{
			$ci =& get_instance();
			if(!$kode)
			{
				$kode = 0;
				if($group == ""){				
					if($keyword == ""){				
					$wil = array();
					}else{
					$wil = $ci->db->query("call p_wilayah(".$kode.",'".$group."','".$keyword."')")->result();
					}
				}else{
				$wil = $ci->db->query("call p_wilayah(".$kode.",'".$group."','".$keyword."')")->result();
				}
			}
			elseif(!$group) 
			{
				$group = 'null';
				$keyword = 'null';
				$wil = $ci->db->query("call p_wilayah(".$kode.",".$group.",".$keyword.")")->row();
			}
			else
			{
				return false;
			}
			$ci->db->close();
			$ci->db->reconnect();
			
			return $wil;
		}
	}
	
?>