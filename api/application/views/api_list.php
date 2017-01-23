<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<h4>API LIST</h4>
		<ul>
			<li><a href="#" onclick="loadkata(1)">Patient API</a></li>
			<li>Consultation API
			<br>
				<ol>
					<li><a href="#" onclick="loadkata(2)">Consultation API</a></li>
					<li><a href="#" onclick="loadkata(3)">Vital Sign API</a></li>
					<li><a href="#" onclick="loadkata(4)">Diagnosis API</a></li>
					<li><a href="#" onclick="loadkata(5)">Procedure API</a></li>
				</ol>
			</li>
			<li><a href="#" onclick="loadkata(6)">Appointment</a></li>
		</ul>
		<div id="a1" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Patient API</b><hr>
			API ini berfungsi untuk menampilkan data pasien.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/patient" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/patient</a><br>
			Parameter = MRN_Number (allow null)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/patient?MRN_Number=00000002" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/patient?MRN_Number=00000002</a></small></blockquote>
		</div>
		<div id="a2" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Consultation API</b><hr>
			API ini berfungsi untuk menunjukan riwayat konsultasi pasien, 1 pasien dapat melakukan beberapa kali konsultasi.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation</a><br>
			Parameter = MRN_Number (Cannot be null)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation?MRN_Number=00000001" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation?MRN_Number=00000001</a></small></blockquote>
		</div>
		<div id="a3" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Vital Sign API</b><hr>
			API ini berfungsi untuk menampilkan data hasil anamesa.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/vitalsign" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/vitalsign</a><br>
			Parameter = ID_Anamesa (cannot be null , ID_Anamesa dapat ditemukan pada Consultation API.)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/vitalsign?ID_Anamesa=56" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/vitalsign?ID_Anamesa=56</a></small></blockquote>
		</div>
		<div id="a4" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Diagnosis API</b><hr>
			API ini berfungsi untuk menampilkan data hasil diagnosa.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/diagnosis" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/diagnosis</a><br>
			Parameter = ID_Consultation (cannot be null , ID_Consultation dapat ditemukan pada Consultation API.)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/diagnosis?ID_Consultation=26" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/diagnosis?ID_Consultation=26</a></small></blockquote>
		</div>
		<div id="a5" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Procedure API</b><hr>
			API ini berfungsi untuk menampilkan data hasil tindakan.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/procedure" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/vitalsign</a><br>
			Parameter = ID_Consultation (cannot be null , ID_Consultation dapat ditemukan pada Consultation API.)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/consultation/procedure?ID_Consultation=26" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/consultation/procedure?ID_Consultation=26</a></small></blockquote>
		</div>
		<div id="a6" style="border:1px solid #000; width:40%; display:none;">
			<blockquote><small><b>Appointment API</b><hr>
			API ini berfungsi untuk menampilkan data appointment.<br><br>
			Link API : <a href="http://<?=$_SERVER['HTTP_HOST']?>/appointment" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/appointment</a><br>
			Parameter 1 = MRN_Number (cannot be null)<br>
			Parameter 2 = Start (cannot be null , date start view)<br>
			Parameter 3 = End (cannot be null , date end view)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/appointment?MRN_Number=00000001&Start=2016-11-09&End=2016-11-10" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/appointment?MRN_Number=00000001&Start=2016-11-09&End=2016-11-10</a><br>
			<br>
			<br>
			INSERT API<hr> 
			METHOD = "POST"<br>
			Parameter 1 = MRN_Number (cannot be null)<br>
			Parameter 2 = Date (cannot be null , date start view)<br>
			Parameter 3 = ID_Clinic (cannot be null , can found in <a href="http://<?=$_SERVER['HTTP_HOST']?>/appointment/clinic" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/appointment/clinic</a>)<br>
			Parameter 4 = ID_Doctor (cannot be null , can found in <a href="http://<?=$_SERVER['HTTP_HOST']?>/appointment/doctor" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/appointment/doctor</a>)<br>
			Example : <a href="http://<?=$_SERVER['HTTP_HOST']?>/appointment" target="_blank">http://<?=$_SERVER['HTTP_HOST']?>/appointment</a><br>

			</small></blockquote>
		</div>
		
<script>
function loadkata(n){
	if(n == '1'){
		$("#a1").show(1);
		$("#a2").hide(1);
		$("#a3").hide(1);
		$("#a4").hide(1);
		$("#a5").hide(1);
		$("#a6").hide(1);
	}else if(n == '2'){
		$("#a2").show(1);
		$("#a1").hide(1);
		$("#a3").hide(1);
		$("#a4").hide(1);
		$("#a5").hide(1);
		$("#a6").hide(1);
	}else if(n == '3'){
		$("#a3").show(1);
		$("#a2").hide(1);
		$("#a1").hide(1);
		$("#a4").hide(1);
		$("#a5").hide(1);
		$("#a6").hide(1);
	}else if(n == '4'){
		$("#a4").show(1);
		$("#a2").hide(1);
		$("#a3").hide(1);
		$("#a1").hide(1);
		$("#a5").hide(1);
		$("#a6").hide(1);
	}else if(n == '5'){
		$("#a5").show(1);
		$("#a2").hide(1);
		$("#a3").hide(1);
		$("#a4").hide(1);
		$("#a1").hide(1);
		$("#a6").hide(1);
	}else if(n == '6'){
		$("#a6").show(1);
		$("#a2").hide(1);
		$("#a3").hide(1);
		$("#a4").hide(1);
		$("#a1").hide(1);
		$("#a5").hide(1);
	}
}
</script>