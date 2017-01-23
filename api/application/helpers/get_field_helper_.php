<?php
//Author : Amir Mufid//

if ( ! function_exists('getIp'))
{
	function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	 
		return $ip;
	}
}

if ( ! function_exists('replace_null_array'))
{
	function array_null_to_string($row) {
		return array_map(function($value) {
		   return $value === NULL ? "" : $value;
		}, $row);
	}
}

if ( ! function_exists('get_ips'))
{
	function get_ips($id,$thn) 
	{
		$ci = &get_instance();
		
		$thn=$thn-1;
		$query="SELECT a.*  
		FROM rencanastudi a
		WHERE a.`MhswID` = '$id' AND a.`TahunID` = '$thn' AND a.approval=2";
		
		/* $query="SELECT a.*  
		FROM rencanastudi a
		WHERE a.`MhswID` = '$id' AND a.`TahunID` = '$thn' AND a.approval=2 
		ORDER BY a.`HariID`,'JamMulai','JamSelesai' ASC"; */
		
		$tot_sks=0;
		$tot_jum=0;
		foreach($ci->db->query($query)->result() as $row){
		
		$det=$ci->db->query("SELECT * FROM detailkurikulum WHERE ID='$row->DetailKurikulumID'")->row();
			$tot_sks+=$det->TotalSKS;
			$bot=$ci->db->query("SELECT * FROM bobot WHERE Nilai='$row->NilaiHuruf'")->row();	
			$jumlah=$det->TotalSKS*$bot->Bobot;
			$tot_jum += $jumlah;
							
			
		}
		$x=$tot_jum/$tot_sks;
		return number_format($x,2,',','.');;
	}
}

if ( ! function_exists('get_ipk'))
{
	function get_ipk($MhswID) 
	{
		$ci = &get_instance();
		$t=$ci->db->query("SELECT * FROM tahun WHERE ProsesBuka='1'")->row();
		$sql= "select * from (select rencanastudi.TahunID as TahunID,rencanastudi.MKKode,MIN(rencanastudi.NilaiHuruf) as NilaiHuruf ,rencanastudi.DetailKurikulumID,rencanastudi.JadwalID,detailkurikulum.Semester as Sem,detailkurikulum.Nama
from rencanastudi,detailkurikulum
where detailkurikulum.ID = rencanastudi.DetailKurikulumID
and detailkurikulum.ProdiID = rencanastudi.ProdiID
and rencanastudi.MhswID='".$MhswID."'
and rencanastudi.approval=2
AND rencanastudi.TahunID !='".$t->ID."'
GROUP BY rencanastudi.MKKode,rencanastudi.TahunID
ORDER BY rencanastudi.TahunID DESC,
detailkurikulum.Semester,rencanastudi.NilaiHuruf ASC,detailkurikulum.TotalSKS DESC
) abc GROUP BY abc.MKKode ORDER BY Sem";
		$tot_sks=0;
		$tot_jum=0;
		foreach($ci->db->query($sql)->result() as $row){
		
		$det=$ci->db->query("SELECT * FROM detailkurikulum WHERE ID='$row->DetailKurikulumID'")->row();
			$tot_sks+=$det->TotalSKS;
			$bot=$ci->db->query("SELECT * FROM bobot WHERE Nilai='$row->NilaiHuruf'")->row();	
			$jumlah=$det->TotalSKS*$bot->Bobot;
			$tot_jum += $jumlah;
							
			
		}
		$x=$tot_jum/$tot_sks;
		return number_format($tot_jum/$tot_sks,2,',','.');
	}
}


if ( ! function_exists('get_path_siak'))
{
	function get_path_siak($lokasi, $dir='') {
		$path  =((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$path .= "://".$_SERVER['HTTP_HOST'];
		//$path .= "://".$_SERVER['HTTP_HOST'];
		return $path.'/'.$dir.'/'.$lokasi;
	}
}


if(!function_exists('get_field')){

function get_field($id, $namatabel, $namafield='Nama')
{
	$ci = &get_instance();
	$ci->db->select($namafield." as field");
	$ci->db->where('ID',$id);
	$Q=$ci->db->get($namatabel)->row();
	return $Q->field;
}

}

if(!function_exists('qrow')){

function qrow($query)
{
	$ci = &get_instance();
	$Q=$ci->db->query($query)->row();
	return $Q;
}

}
if(!function_exists('qresult')){

function qresult($query)
{
	$ci = &get_instance();
	$Q=$ci->db->query($query)->result();
	return $Q;
}

}


if(!function_exists('get_prov')){

function get_prov($namatabel,$sort='ASC',$field='')
{
	$ci = &get_instance();
	if($field)
	$ci->db->order_by($field,$sort);
	$ci->db->where('group',$namatabel);
	$Q=$ci->db->get('m_provincy');
	return $Q->result();
}

}

if(!function_exists('get_prov_field')){

function get_prov_field($code,$group,$namafield="name")
{
	$ci = &get_instance();
	
	$ci->db->select($namafield." as field");
	$ci->db->where('group',$group);
	$ci->db->where('code',$code);
	$Q=$ci->db->get('m_provincy')->row();
	return $Q->field;
}
}

if(!function_exists('get_all')){

function get_all($namatabel,$sort='ASC')
{
	$ci = &get_instance();
	if($namatabel == 'tahunganjilgenap')
	{
		$ci->db->where('RIGHT(TahunID,"1") != "3"');
		$ci->db->order_by('TahunID',$sort);
		$namatabel='tahun';
	}
	elseif($namatabel == 'semuatahun')
	{
		$ci->db->order_by('TahunID',$sort);
		$namatabel='tahun';
	}
	elseif($namatabel == 'tahun')
	{
		//$ci->db->where('ProsesBuka',1);
		$ci->db->order_by('TahunID','desc');
	}
	elseif($namatabel == 'programstudi')
	{
		if($ci->session->userdata('cek_superadmin') < 1)
		{
			$kar 	= get_id($ci->session->userdata('EntityID'),'karyawan');
			//$where	=" ID IN (1) ";
			//$ci->db->where_in("ID",str_replace(",","','",$kar->ProdiID));
			$where="ID IN ('".str_replace(",","','",$kar->ProdiID)."')";
			$ci->db->where($where);
		}
	}
	elseif($namatabel == 'hari')
	{
		$ci->db->order_by('ID',$sort);
	}
	elseif($namatabel == 'kodewaktu')
	{
		$ci->db->order_by('Kode',$sort);
	}
	elseif($namatabel == 'modulgrup')
	{
		$ci->db->order_by('AksesID','ASC');
	}
	elseif($namatabel == 'program')
	{
	}
	elseif($namatabel == 'pmbperiode' OR $namatabel == 'pmbformulir' OR $namatabel == 'pmbsyaratmahasiswa' OR $namatabel == 'pmbruang' OR $namatabel == 'mahasiswanilaipmb' OR $namatabel == 'tempattest' OR $namatabel == 'penghasilan' )
	{
	}
	else
	{
		$ci->db->order_by('Nama',$sort);
	}
	$Q=$ci->db->get($namatabel);
	return $Q->result();
}

}

if(!function_exists('get_id')){

function get_id($id,$namatabel)
{
	$ci = &get_instance();
	$ci->db->where('ID',$id);
	$Q=$ci->db->get($namatabel);
	return $Q->row();
}

}

if(!function_exists('get_where')){

function get_where($where,$namatabel,$field="Nama")
{
	$ci = &get_instance();
	$ci->db->select($field." as field");
	$ci->db->where($where);
	$Q=$ci->db->get($namatabel)->row();
	return $Q->field;
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


if(!function_exists('get_all_epsbed')){

function get_all_epsbed($namatabel,$sort='ASC')
{
	$ci = &get_instance();
	$ci->db->where('Tabel',$namatabel);
	$ci->db->order_by('Label',$sort);
	$Q=$ci->db->get('ref_epsbed');
	return $Q->result();
}

}

if(!function_exists('get_photo')){

function get_photo($foto, $jk, $namatabel, $class='')
{
	if($foto)
	{
		//$path = get_path_siak("assets/".$namatabel."/foto/".$foto);
		$path = "http://ais.stikba.ac.id/assets/".$namatabel."/foto/".$foto;
	}
	elseif($jk == "L")
	{
		// $path = get_path_siak("assets/images/default_".$namatabel.".png");
		$path = "http://ais.stikba.ac.id/assets/images/default_".$namatabel.".png";
	}
		elseif($jk == "P")
	{
		// $path = get_path_siak("assets/images/default_".$namatabel."_2.png");
		$path = "http://ais.stikba.ac.id/assets/images/default_".$namatabel."_2.png";
	}
	else
	{
		$path = "http://ais.stikba.ac.id/assets/images/tanda_tanya.png";
	}
	return $path;
}

}

if(!function_exists('cek_level')){
function cek_level($LevelID,$Url,$Akses)
{
	$ci = &get_instance();
	
	$querymodul = "Select * FROM modul Where Script = '".$Url."'";
	$hasilmodul = $ci->db->query($querymodul)->row();
	
	$querymodul2 = "Select * FROM submodul Where Script = '".$Url."'";
	$hasilmodul2 = $ci->db->query($querymodul2)->row();
	
	if(count($hasilmodul2) > 0)
	{
		$ModulID=$hasilmodul2->ID;
		$type='submodul';
	}
	else
	{
		$ModulID=$hasilmodul->ID;
		$type='modul';
	}
	
	$query = 'Select `'.$Akses.'` as akses FROM levelmodul Where type= "'.$type.'" AND LevelID = "'.$LevelID.'" AND ModulID = "'.$ModulID.'"';
	$hasil = $ci->db->query($query)->row();
	return $hasil->akses;
}
}


if(!function_exists('log_akses')){

function log_akses($aksi,$note)
{
	$ci = &get_instance();
	
	$input["IP"]= getIp();
	$input["aktifitas"]= $aksi;
	$input["note"]= $note;
	$input["url"]= current_url();
	$input["user"]= $ci->session->userdata('username');
	return $ci->db->insert("log",$input);
	
}

}

if(!function_exists('log_note')){

function log_note($input,$input2)
{
	$ci = &get_instance();
	
	$arr=array_diff_assoc($input,$input2);	
	$note = 'Mengubah Data Mahasiswa Dengan';
	
	$arrField = array("ProdiID"=>"programstudi","StatusMhswID"=>"statusmahasiswa");
	$arrField2 = array("ProdiID"=>"Nama","StatusMhswID"=>"Nama");
	
	foreach($arrField as $index=>$val)
	{
		$arrCek[]=$index;
	}
	
	foreach($arr as $index=>$val)
	{
		if(in_array($index,$arrcek))
		{
			$test = get_field($input2[$index],$arrField[$index],$arrField2[$index]);
			$test2 = get_field($input[$index],$arrField[$index],$arrField2[$index]);
		}
		else
		{
			$test = $input2[$index];
			$test2 = $input[$index];
		}
		$note .= ' '.$ci->lang->line($index).' <b>'.$test.'</b> menjadi <b>'.$test2.'</b>, ' ;
	}
	
	return $arrField2[$index];
}

}



if(!function_exists('tgl')){

function tgl($tgl,$type="01")
{
	if(substr($tgl,11,8) == '00:00:00' or substr($tgl,11,8) == '')
	{
		$jam='';
	}
	else
	{
		$jam=substr($tgl,11,8);
	}
	
	if(substr($tgl,0,10) == '0000-00-00' or substr($tgl,0,10) == '')
	{
		return "-";
	}
	else
	{
	$bulan = array ('01'=>'Januari', // array bulan konversi
				'02'=>'Februari',
				'03'=>'Maret',
				'04'=>'April',
				'05'=>'Mei',
				'06'=>'Juni',
				'07'=>'Juli',
				'08'=>'Agustus',
				'09'=>'September',
				'10'=>'Oktober',
				'11'=>'November',
				'12'=>'Desember'
		);

	$hari=array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
	
		$date=date('l-d-m-Y',strtotime($tgl));
		$tanggal=explode('-',$date);
		
		if($type == "01")
		{
			return $hari[$tanggal[0]]." ,".$tanggal[1]." ".$bulan[$tanggal[2]]." ".$tanggal[3]." ".$jam;
		}
		
		if($type == "02")
		{
			return intval($tanggal[1])." ".$bulan[$tanggal[2]]." ".$tanggal[3]." ".$jam;
		}
		
		if($type == "03")
		{
			return $tanggal[1]." ".substr($bulan[$tanggal[2]],0,3)." ".$tanggal[3]." ".$jam;
		}
		
		if($type == "04")
		{
			return $tanggal[1]."/".$tanggal[2]."/".$tanggal[3];
		}
		
		if($type == "05")
		{
			$tanggal=explode('/',$tgl);
			$date=date('Y-m-d',mktime(0,0,0,$tanggal[1],$tanggal[0],$tanggal[2]));
			return $date;
		}
	}
}

}


			
# call_sp digunakan untuk menjalankan STORED PROCEDURE
	
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
	
	if(!function_exists('get_semester2')){
		function get_semester2($mhs,$tahunid=null)
		{
			$procedure_name = 'get_semester2';
			$type = 'proc';
			$params = array(
				$mhs,
				$tahunid
			);
			$return = 'row';
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
		}
	}
	
	if(!function_exists('view_transkrip_sementara')){
		function view_transkrip_sementara($mhs)
		{
			$procedure_name = 'view_transkrip_sementara';
			$type = 'proc';
			$params = array(
				$mhs
			);
			
			$return = 'result';
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
		}
	}
	
	if(!function_exists('view_ipk')){
		function view_ipk($mhs,$tahunid=null)
		{
			$procedure_name = 'view_ipk';
			$type = 'proc';
			$params = array(
				$mhs,
				$tahunid
			);
			$return = 'row';
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
		}
	}
	
	if(!function_exists('get_semester')){
		function get_semester($mhs,$tahunid=null)
		{
			$procedure_name = 'get_semester';
			$type = 'proc';
			$params = array(
				$mhs,
				$tahunid
			);
			$return = 'row';
			
			$nilai = call_sp($procedure_name, $params, $type , $return);
			
			return $nilai;
		}
	}
?>