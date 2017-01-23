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
					return $tanggal[1]." ".$bulan[$tanggal[2]]." ".$tanggal[3]." ".$jam;
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
if(!function_exists('batassks')){

function batassks($ips)
{
	$ci = &get_instance();
	
	$x=$ci->db->query("SELECT SKS FROM `rangesks` WHERE  '$ips' BETWEEN IPK_Awal AND IPK_Akhir")->row();
	return $x->SKS;
	
}

}


	if ( ! function_exists('assets'))
	{
		function assets() {
			$ci = &get_instance();
			$ci->web_db = $ci->load->database('web', TRUE);
			// $query = $ci->web_db->query("SELECT KodePT FROM pendaftar WHERE Domain ='".$_SERVER['HTTP_HOST']."'")->row();


			$path  =((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			$path .= "://".$_SERVER['HTTP_HOST'];
			return $path.'/client/'.$query->KodePT."/";
		}
	}
	

if ( ! function_exists('hasilstudi'))
{
function hasilstudi($MhswID,$TahunID,$tipe)
	{		
		$ci = &get_instance();
		//tipe 1 = melihat semester berapa mahasiswa sekarang
		//tipe 2 = melihat total sks yang diperoleh mahasiswa sekarang
		//tipe 3 = melihat total sks yang diambil mahasiswa sekarang
		$a=$ci->db->query("SELECT COUNT(ID) as jum FROM hasilstudi WHERE MhswID='$MhswID'")->row();
		if($tipe==1){
			if($a->jum > 0){	
			$b=$a->jum+1;
			return $b;
			}else{
				return '1';
			}
		}elseif($tipe=='2'){
			if($a->jum > 0){	
			$t=$ci->db->query("SELECT MAX(TahunID) as t FROM hasilstudi WHERE MhswID='$MhswID'")->row();
			$ips=$ci->db->query("SELECT IPS FROM hasilstudi WHERE MhswID='$MhswID' AND TahunID='$t->t'")->row();
				$b=$ci->db->query("SELECT SKS FROM rangesks WHERE (IPK_Awal <= $ips->IPS AND IPK_Akhir >= $ips->IPS) ORDER BY SKS DESC LIMIT 1")->row();
			return $b->SKS;
			}else{
				return '24';
			}			
		}elseif($tipe=='3'){	
			$b=$ci->db->query("SELECT SUM(b.TotalSKS) as SKS FROM rencanastudi a,detailkurikulum b WHERE a.DetailKurikulumID=b.ID AND a.MhswID='$MhswID' AND a.TahunID='$TahunID'")->row();
			return $b->SKS;			
		}
	}
}

if ( ! function_exists('semester'))
{
function semester($thn_masuk,$thn_aktif)
	{
		$tahunaktif = substr($thn_aktif,0,4);
		$semakhir = substr($thn_aktif,4,1);
		
		if( $semakhir=="1")
		$sem = ($tahunaktif-$thn_masuk)*2+1;
		else
		$sem =   ($tahunaktif-$thn_masuk)*2+2;
		
		return $sem;
	}
}
if ( ! function_exists('loop_ip'))
{
	function loop_ip($id,$thn,$type='ips') 
	{
		$ci = &get_instance();
		
		$where=($type=="ips")?"AND a.`TahunID` = '$thn'":"";

		$query="
		select * from (
						
			SELECT
				b.MKKode,
				b.Nama,
				a.NilaiHuruf,
				b.TotalSKS as SKS,
				c.Bobot as NilaiBobot,
				(b.TotalSKS*c.Bobot) as Bobot,
				c.Bobot as bob,
				c.Lulus
			FROM
				rencanastudi a,
				detailkurikulum b,
				bobot c,
				mahasiswa d
			WHERE
			a.MhswID = d.ID
			AND	a.NilaiHuruf = c.Nilai 
			AND FIND_IN_SET(d.TahunMasuk,c.Angkatan) != 0 
			AND FIND_IN_SET(d.ProdiID,c.ProdiID) != 0 
			AND	a.DetailKurikulumID = b.ID
			AND	a.`MhswID` = '$id'	
			and a.approval=2
			$where
			ORDER BY
				b.Semester,b.MKKode
			

		) as abc GROUP BY abc.MKKode";
              
		return $ci->db->query($query)->result();
		
	}
}

if ( ! function_exists('get_ips'))
{
	function get_ips($id,$thn,$type='ips') 
	{
		$ci = &get_instance();
		
		
		$query="SELECT * FROM hasilstudi WHERE MhswID='$MhswID' AND TahunID='$thn'";
		
		$ips=$ci->db->query($query)->row();
		
		if($type=='ips')
		{
			return number_format($ips->IPS,2,'.',',');
		}
		if($type=='bobot')
		{
			return $ips->Bobot;
		}
		if($type=='sks')
		{
			return $ips->SKSIPS;
		}
		if($type=='data')
		{
			return $ips;
		}
		
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

if ( ! function_exists('get_bobot_semester'))
{
	function get_bobot_semester($id,$thn) 
	{
		$ci = &get_instance();
		
		$gt=$ci->db->query("SELECT TahunID FROM rencanastudi WHERE TahunID < $thn GROUP BY TahunID ORDER BY TahunID DESC LIMIT 1")->row();
		$thn=$gt->TahunID;
		$query="SELECT a.*  
		FROM rencanastudi a
		WHERE a.`MhswID` = '$id' AND a.`TahunID` = '$thn' AND a.approval=2 
		ORDER BY a.`HariID`,'JamMulai','JamSelesai' ASC";
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
		return $tot_jum;
	}
}

if ( ! function_exists('get_sks_semester'))
{
	function get_sks_semester($id,$thn) 
	{
		$ci = &get_instance();
		
		$gt=$ci->db->query("SELECT TahunID FROM rencanastudi WHERE TahunID < $thn GROUP BY TahunID ORDER BY TahunID DESC LIMIT 1")->row();
		$thn=$gt->TahunID;
		$query="SELECT a.*  
		FROM rencanastudi a
		WHERE a.`MhswID` = '$id' AND a.`TahunID` = '$thn' AND a.approval=2 
		ORDER BY a.`HariID`,'JamMulai','JamSelesai' ASC";
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
		return $tot_sks;
	}
}

if ( ! function_exists('get_path'))
{
	function get_path($dir,$theme="theme_1") {
		$path = base_url().'assets/'.$theme.'/'.$dir.'/';
		return $path;
	}
}
if ( ! function_exists('get_path_siak'))
{
	function get_path_siak($lokasi,$subdomain="no",$dir='') {
		$path  =((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$arrUrl = explode(".",$_SERVER['HTTP_HOST']);
		if($subdomain=="yes") 
		{
			$arrUrl[0] = $dir;
			$path .= "://".implode(".",$arrUrl);
		} else 
		{
			$path .= "://".implode(".",$arrUrl);
		}
		//return $path.'://'.$arrUrl.'/'.$dir.'/'.$lokasi;
		return $path.'/'.$lokasi;
	}
}

if ( ! function_exists('get_path_library'))
{
	/*function get_path_library($lokasi,$subdomain="yes",$dir='library') {
		
		//return "http://library.stikesindonesia.ac.id/";
        
		$path  =((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		$arrUrl = explode(".",$_SERVER['HTTP_HOST']);
		if($subdomain=="yes") {
			$arrUrl[0] = $dir;
			//$last  = array_slice($arrUrl, 1);
			//$path .= "://".implode(".",$last)."/".$dir;
			$path .= "://".implode(".",$arrUrl);
		} else {
			$path .= "://".implode(".",$arrUrl)."/".$dir;
		}
		//return $path.'://'.$arrUrl.'/'.$dir.'/'.$lokasi;
		return $path.'/'.$lokasi;
        
	}*/
	
	function get_path_library() { 
		
		return "http://103.30.85.201:3180/core/library/";
	}
}



if(!function_exists('get_field')){

function get_field($id,$namatabel,$namafield='Nama')
{
	$ci = &get_instance();
	
	$ci->db->select($namafield." as field");
	$ci->db->where('ID',$id);
	$Q=$ci->db->get($namatabel)->row();
	return $Q->field;
}

}

if(!function_exists('get_field_mkkode')){

function get_field_mkkode($id,$namatabel,$namafield='MKKode')
{
	$ci = &get_instance();
	
	$ci->db->select($namafield." as field");
	$ci->db->where('ID',$id);
	$Q=$ci->db->get($namatabel)->row();
	return $Q->field;
}

}

if(!function_exists('get_all')){

function get_all($namatabel,$sort='ASC')
{
	$ci = &get_instance();
	if($namatabel == 'tahun')
	{
		$ci->db->where('ProsesBuka',1);
		$ci->db->order_by('TahunID',$sort);
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

if(!function_exists('log_akses')){

function log_akses($aksi)
{
	$ci = &get_instance();
	
	$input["IP"]= getIp();
	$input["aktifitas"]= $aksi;
	$input["note"]= get_field($ci->session->userdata('UserID'),'mahasiswa','NPM')." ".get_field($ci->session->userdata('UserID'),'mahasiswa');
	$input["url"]= current_url();
	$input["user"]= $ci->session->userdata('UserID');
	return $ci->db->insert("log_student",$input);
	
}

}
function get_tahun_id($param,$angka,$operand)
	{
		$thn = substr($param,0,4);
		$sem = substr($param,4,1);
		
		$jumlah = $sem + $angka;
		
		$x = $sem;
		$thn_baru = $thn;
		for($i = $sem ;$i < $jumlah;$i++)
		{
			if($operand == '+')
			{
				++$x;
				if($x > 2)
				{
					$x = 1;
					++$thn_baru;
				}
			}
			
			if($operand == '-')
			{
				--$x;
				if($x < 1)
				{
					$x = 2;
					--$thn_baru;
				}
			}
			 $sembaru = $x;
			
		}
		return $thn_baru.$sembaru;
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
	
	function chmod_r($path) {
		$dir = new DirectoryIterator($path);
		foreach ($dir as $item) {
			chmod($item->getPathname(), 0777);
			if ($item->isDir() && !$item->isDot()) {
				chmod_r($item->getPathname());
			}
		}
	}
	
	
	function create_dir($path){     
		$exp = explode("/",$path);
		$way = '';
		foreach($exp as $n){
			$way .= $n.'/';
			if(!is_dir($way)){
				@mkdir($way,0777);
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
				$wil = $ci->db->query("call p_wilayah(".$kode.",'".$group."','".$keyword."')")->result();
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
	
	if(!function_exists('view_khs')){
		function view_khs($mhs,$tahunid)
		{
			$procedure_name = 'view_khs';
			$type = 'proc';
			$params = array(
				$mhs,
				$tahunid
			);
			$return = 'result';
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
		}
	}
	
	if(!function_exists('view_ips')){
		function view_ips($mhs,$tahunid)
		{
			$procedure_name = 'view_ips';
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
	
	if(!function_exists('view_krs')){
		function view_krs($mhs,$tahunid=null)
		{
			$procedure_name = 'view_krs';
			$type = 'proc';
			$params = array(
				$mhs,
				$tahunid
			);
			$return = 'result';
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
		}
	}
	
	if(!function_exists('view_transkrip')){
		function view_transkrip($mhs)
		{
			$procedure_name = 'view_transkrip';
			$type = 'proc';
			$params = array(
				$mhs
			);
			
			$return = 'result';
			
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
			
			$nilai = call_sp($procedure_name, $params, $type ,$return);
			
			return $nilai;
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
	
if ( ! function_exists('replace_null_array'))
{
	function array_null_to_string($row) {
		return array_map(function($value) {
		   return $value === NULL ? "" : $value;
		}, $row);
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