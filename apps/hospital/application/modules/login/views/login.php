<?php
	$identitas = $this->db->get('ms_identitas')->row();	
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
		<title><?=$identitas->nama?></title>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="<?=THEME_HOST?>css/bootstrap.min.css">
		<!-- icheck -->
		<link rel="stylesheet" href="<?=THEME_HOST?>plugins/icheck/all.css">
		<!-- SweetAlert 2 -->
		<link rel="stylesheet" href="<?=THEME_HOST?>plugins/sweetalert2/sweetalert2.min.css">
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?=THEME_HOST?>css/style.css">
		<!-- Color CSS -->
		<link rel="stylesheet" href="<?=THEME_HOST?>css/themes.css">
		<!-- Flaticon CSS -->
		<link rel="stylesheet" href="<?=THEME_HOST?>flaticon-hospital/flaticon.css">
		
		
		<!-- jQuery -->
		<script src="<?=THEME_HOST?>js/jquery.min.js"></script>
		
		<!-- Nice Scroll -->
		<script src="<?=THEME_HOST?>plugins/nicescroll/jquery.nicescroll.min.js"></script>
		<!-- Validation -->
		<script src="<?=THEME_HOST?>plugins/validation/jquery.validate.min.js"></script>
		<script src="<?=THEME_HOST?>plugins/validation/additional-methods.min.js"></script>
		<!-- icheck -->
		<script src="<?=THEME_HOST?>plugins/icheck/jquery.icheck.min.js"></script>
		<!-- SweetAlert 2 -->
		<script src="<?=THEME_HOST?>plugins/sweetalert2/sweetalert2.min.js"></script>
		<!-- Bootstrap -->
		<script src="<?=THEME_HOST?>js/bootstrap.min.js"></script>
		<script src="<?=THEME_HOST?>js/eakroko.js"></script>
		<script src="<?=THEME_HOST?>js/main.js"></script>
		
		<!--[if lte IE 9]>
			<script src="<?=THEME_HOST?>plugins/placeholder/jquery.placeholder.min.js"></script>
			<script>
			$(document).ready(function() {
			$('input, textarea').placeholder();
			});
			</script>
		<![endif]-->
		
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?=THEME_HOST?>img/favicon.ico" />
		<!-- Apple devices Homescreen icon -->
		<link rel="apple-touch-icon-precomposed" href="<?=THEME_HOST?>img/apple-touch-icon-precomposed.png" />
	
	</head>
	
	<body class='login'>
		
		<?php if(!empty($identitas->bg)){ 
			echo '
			<style>
				.login {
					background: url('.FILES_HOST.'img/'.$identitas->bg.') no-repeat;
					background-size:100% 100%;
				}
			</style>
			';
		} 		else 		{				}
		?>
		
		<div class="wrapper">
			<div class="login-body">
				<div class="login-padding">
				<center class="login-margin"><img src="<?=FILES_HOST?>img/<?=$identitas->logo?>.png" alt="" class='retina-ready' width="180px"></center>
				<form action="<?=$login_url?>" method='post'  data-plugin="form-validation" id="form_login" class="login-form">
					<div class="form-group login-margin">
						<div class="email controls">
							<input type="text" name='username' placeholder="Username" class='input form-control' data-rule-required="true">
						</div>
					</div>
					<div class="form-group login-margin">
						<div class="pw controls">
							<input type="password" name="password" placeholder="Password" class='input form-control' data-rule-required="true">
						</div>
					</div>
					<div class="submit login-margin">
						<div class="remember">
							<input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="blue" id="remember">
							<label for="remember">Remember me</label>
						</div>
						<button type="submit" class='btn btn-primary pull-right'>Sign me in</button>
					</div>
				</form>
				</div>
			</div>
		</div>
		<div id="footer_login">
			<h4>NEP Indonesia				
				<p>
					<a href="http://nepindo.co.id" target="_blank" style="color:white;text-decoration:none;">http://nepindo.co.id</a>
				</p>
			</h4>
			<p class="right">
				<b>Twitter</b>
				:
				<a href="https://twitter.com/" target="_blank" style="color:white;text-decoration:none;">twitter.com/</a>
			</p>
			<p class="rightbottom">
				<b>Facebook</b>
				: 
				<a href="https://www.facebook.com/" target="_blank" style="color:white;text-decoration:none;">facebook.com</a>
			</p>
		</div>
	</body>
	
</html>
