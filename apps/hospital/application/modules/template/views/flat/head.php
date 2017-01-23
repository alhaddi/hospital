<?php
	$identitas = $this->db->get('ms_identitas')->row_array();	
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<!-- Apple devices fullscreen -->
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

<title><?=$identitas['nama']?></title>

<!-- Bootstrap -->
<link rel="stylesheet" href="<?=THEME_HOST?>css/bootstrap.min.css">
<!-- jQuery UI -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/jquery-ui/jquery-ui.min.css">
<!-- PageGuide -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/pageguide/pageguide.css">
<!-- Fullcalendar -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/fullcalendar/fullcalendar.css">
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/fullcalendar/fullcalendar.print.css" media="print">
<!-- chosen -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/chosen/chosen.css">
<!-- select2 -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/select2/select2.css">
<!-- icheck -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/icheck/all.css">
<!-- Theme CSS -->
<link rel="stylesheet" href="<?=THEME_HOST?>css/style.css">
<!-- Color CSS -->
<link rel="stylesheet" href="<?=THEME_HOST?>css/themes.css">
<!-- dataTables -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/datatables/css/TableTools.css">
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/datatables/css/dataTables.bootstrap.css">
<!-- SweetAlert 2 -->
<link rel="stylesheet" href="<?=THEME_HOST?>plugins/sweetalert2/sweetalert2.min.css">
<!-- Flaticon CSS -->
<link rel="stylesheet" href="<?=THEME_HOST?>flaticon-hospital/flaticon.css">
<!-- Datetimepicker -->
<link href="<?=THEME_HOST?>plugins/datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
		
<link rel="stylesheet" href="<?=THEME_HOST?>font-awesome/css/font-awesome.min.css">
<!--[if lte IE 9]>
	<script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
	<script>
		$(document).ready(function() {
			$('input, textarea').placeholder();
		});
	</script>
	<![endif]-->

<!-- Favicon -->
<link rel="shortcut icon" href="<?=FILES_HOST?>img/<?=element('logo',$identitas).'_icon.png'?>" />
<!-- Apple devices Homescreen icon -->
<link rel="apple-touch-icon-precomposed" href="<?=THEME_HOST?>img/apple-touch-icon-precomposed.png" />
<!-- jQuery -->
<script src="<?=THEME_HOST?>js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?=THEME_HOST?>js/bootstrap.min.js"></script>
<!-- Function framework -->
<script src="<?=THEME_HOST?>js/main_function.js"></script>
<!-- XEditable -->
	<link rel="stylesheet" href="<?=THEME_HOST?>plugins/xeditable/bootstrap-editable.css">