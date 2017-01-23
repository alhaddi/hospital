<?php
	/**
		* CodeIgniter Core Function Helper
		*
		* @package         CodeIgniter 2.0+ - 3.0+
		* @subpackage      Helper
		* @category        Helper Function
		* @author          Amir Mufid
		* @version         2.0
	*/
	
	
	function file_icon($filename='') {
		
		$extension =end(explode(".",$filename));
		
		$ext = array('jpg','png','gif','jpeg');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-image-o';
		}
		
		$ext = array('flv','mkv','mp4','avi','3gp');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-video-o';
		}
		
		$ext = array('pdf');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-pdf-o';
		}
		
		$ext = array('doc','docx');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-word-o';
		}
		
		$ext = array('xls','xlsx');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-excel-o';
		}
		
		$ext = array('ppt','pptx');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-powerpoint-o';
		}
		
		$ext = array('zip','rar');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-archive-o';
		}
		
		$ext = array('mp3');
		foreach ($ext as $ex) {
			$icon[$ex] = 'file-audio-o';
		}
		$icon['other'] = 'file-o';
		
		$result = ($icon[$extension])?$icon[$extension]:$icon['other'];
		return '<i class="fa fa-'.$result.'"></i> '.$filename;
	} 
	
	if ( ! function_exists('get_ip'))
	{
		function get_ip() 
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} 
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
			{
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			
			return $ip;
		}
	}
	
	if(!function_exists('rupiah_to_number'))
	{	
		function rupiah_to_number($angka) 
		{
			$replace = array('Rp',' ','.',',');
			$hasil = (double)  str_replace($replace,'',$angka);
			return $hasil;
		}
	}
	
	if(!function_exists('rupiah'))
	{	
		function rupiah($angka) 
		{
			$hasil = 'Rp '.number_format($angka,0, ",",".");
			return $hasil;
		}
	}
	
	/*
		Day 	--- 	---
		d 	Day of the month, 2 digits with leading zeros 	01 to 31
		D 	A textual representation of a day, three letters 	Mon through Sun
		j 	Day of the month without leading zeros 	1 to 31
		l (lowercase 'L') 	A full textual representation of the day of the week 	Sunday through Saturday
		N 	ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0) 	1 (for Monday) through 7 (for Sunday)
		S 	English ordinal suffix for the day of the month, 2 characters 	st, nd, rd or th. Works well with j
		w 	Numeric representation of the day of the week 	0 (for Sunday) through 6 (for Saturday)
		z 	The day of the year (starting from 0) 	0 through 365
		
		Week 	--- 	---
		W 	ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0) 	Example: 42 (the 42nd week in the year)
		
		Month 	--- 	---
		F 	A full textual representation of a month, such as January or March 	January through December
		m 	Numeric representation of a month, with leading zeros 	01 through 12
		M 	A short textual representation of a month, three letters 	Jan through Dec
		n 	Numeric representation of a month, without leading zeros 	1 through 12
		t 	Number of days in the given month 	28 through 31
		
		Year 	--- 	---
		L 	Whether it's a leap year 	1 if it is a leap year, 0 otherwise.
		o 	ISO-8601 week-numbering year. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead. (added in PHP 5.1.0) 	Examples: 1999 or 2003
		Y 	A full numeric representation of a year, 4 digits 	Examples: 1999 or 2003
		y 	A two digit representation of a year 	Examples: 99 or 03
		
		Time 	--- 	---
		a 	Lowercase Ante meridiem and Post meridiem 	am or pm
		A 	Uppercase Ante meridiem and Post meridiem 	AM or PM
		B 	Swatch Internet time 	000 through 999
		g 	12-hour format of an hour without leading zeros 	1 through 12
		G 	24-hour format of an hour without leading zeros 	0 through 23
		h 	12-hour format of an hour with leading zeros 	01 through 12
		H 	24-hour format of an hour with leading zeros 	00 through 23
		i 	Minutes with leading zeros 	00 to 59
		s 	Seconds, with leading zeros 	00 through 59
		u 	Microseconds (added in PHP 5.2.2). Note that date() will always generate 000000 since it takes an integer parameter, whereas DateTime::format() does support microseconds if DateTime was created with microseconds. 	Example: 654321
		
		Timezone 	--- 	---
		e 	Timezone identifier (added in PHP 5.1.0) 	Examples: UTC, GMT, Atlantic/Azores
		I (capital i) 	Whether or not the date is in daylight saving time 	1 if Daylight Saving Time, 0 otherwise.
		O 	Difference to Greenwich time (GMT) in hours 	Example: +0200
		P 	Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3) 	Example: +02:00
		T 	Timezone abbreviation 	Examples: EST, MDT ...
		Z 	Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive. 	-43200 through 50400
		
		Full Date/Time 	--- 	---
		c 	ISO 8601 date (added in PHP 5) 	2004-02-12T15:19:21+00:00
		r 	» RFC 2822 formatted date 	Example: Thu, 21 Dec 2000 16:01:07 +0200
		U 	Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT) 	See also time()
	*/
	
	if(!function_exists('convert_tgl'))
	{
		function convert_tgl($tgl,$format="d-m-Y",$convert=1)
		{
			$bulan = array (
			'January'=>'Januari', // array bulan konversi
			'February'=>'Februari',
			'March'=>'Maret',
			'April'=>'April',
			'May'=>'Mei',
			'June'=>'Juni',
			'July'=>'Juli',
			'August'=>'Agustus',
			'September'=>'September',
			'October'=>'Oktober',
			'November'=>'November',
			'December'=>'Desember'
			);
			
			$hari=array(
			'Sunday'=>'Minggu',
			'Monday'=>'Senin',
			'Tuesday'=>'Selasa',
			'Wednesday'=>'Rabu',
			'Thursday'=>'Kamis',
			'Friday'=>'Jumat',
			'Saturday'=>'Sabtu'
			);
			
			foreach($bulan as $en=>$id){
				$en_lang[] = $en;
				$id_lang[] = $id;
			}
			
			foreach($hari as $en=>$id){
				$en_lang[] = $en;
				$id_lang[] = $id;
			}
			$tgl = str_replace('/','-',$tgl);
			$date = date($format,strtotime($tgl));
			
			if($convert == 1){
				$date = str_replace($en_lang, $id_lang, $date);
			}
			return $date;
			
		}
	}
	
	if(!function_exists('age'))
	{
		function age( $birthday )
		{
			// Convert Ke Date Time
			$biday = new DateTime($birthday);
			$today = new DateTime();
			
			$diff = $today->diff($biday);
			
			// Display
			return $diff->y;
		}
	}
	
	
	if(!function_exists('sanitize_utf8'))
	{
		function sanitize_utf8( $string )
		{
			$string2 = preg_replace('/[^(\x20-\x7F)]*/','', $string);
			return $string2;
		}
	}
	
	if ( ! function_exists('array_push_before'))
	{
		function array_push_before($src,$in,$pos){
			if(is_int($pos)) $R=array_merge(array_slice($src,0,$pos), $in, array_slice($src,$pos));
			else{
				foreach($src as $k=>$v){
					if($k==$pos)$R=array_merge($R,$in);
					$R[$k]=$v;
				}
			}return $R;
		}
	}
		
	if ( ! function_exists('array_string_to_null'))
	{
		function array_string_to_null($row) {
			return array_map(function($value) {
				return $value === "" ? NULL : $value;
			}, $row);
		}
	}
	
	if ( ! function_exists('array_null_to_string'))
	{
		function array_null_to_string($row) {
			return array_map(function($value) {
				return $value === NULL ? "" : $value;
			}, $row);
		}
	}
	
	if ( ! function_exists('create_dir'))
	{
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
	}
	
	

	if ( ! function_exists('QRcode'))
	{
		function QRcode($text,$path) {
			$ci = &get_instance();
			$ci->load->library('ciqrcode');

			$params['data'] = $text;
			$params['level'] = 'H';
			$params['size'] = 10;
		echo	$params['savename'] = $path.'/'.$text.'.png';
			$ci->ciqrcode->generate($params);
		}
	}
	
?>