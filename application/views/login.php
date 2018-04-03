<!DOCTYPE html>
<!-- saved from url=(0047)https://colorlib.com/etc/lf/Login_v5/index.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?=$title;?></title>

	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="https://colorlib.com/etc/lf/Login_v5/images/icons/favicon.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/login/files/css/main.css">
<!--===============================================================================================-->
<script type="text/javascript" async="" src="assets/login/files/js/analytics.js"></script>
<!--===============================================================================================-->
<script src="assets/login/files/js/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

<!-- 警告視窗 -->
<link rel="stylesheet" href="assets/css/sweetalert2.min.css">
<script type="text/javascript" src="assets/js/sweetalert2.min.js"></script>
<!-- 警告視窗 -->

</head>
<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/login/files/image/bg-01.jpg');">
			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-53">
						<?=$form_title;?>
					</span>

					<a href="javascript: void(0)" class="btn-face m-b-20">
						<i class="fa fa-facebook-official"></i>
						Facebook
					</a>

					<a href="https://colorlib.com/etc/lf/Login_v5/index.html#" class="btn-google m-b-20">
						<img src="assets/login/files/image/icon-google.png" alt="GOOGLE">
						Google
					</a>
					<?php include($page); ?>
					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn">
							<?=$button;?>
						</button>
					</div>

					<div class="w-full text-center p-t-55">
						<a href="<?=$path;?>" class="txt2 bo1">
						<span class="txt2">
							<?=$path_title;?>
						</a>
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>


<!--===============================================================================================-->
	<script src="assets/login/files/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/login/files/js/popper.js"></script>
	<script src="assets/login/files/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/login/files/js/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/login/files/js/moment.min.js"></script>
	<script src="assets/login/files/js/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/login/files/js/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/login/files/js/main.js"></script>
	<script src="assets/login/files/js/fb-login.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');

	</script>

</body>
</html>
