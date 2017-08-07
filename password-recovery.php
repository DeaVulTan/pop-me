<?php
	require_once('./files/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Social Panel">
		<link rel="shortcut icon" href="images/favicon.png">
		<title><?php echo($WebsiteName); ?> | Sign In</title>
		<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-reset.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet">
		<link href="css/style-responsive.css" rel="stylesheet" />

		<!--[if lt IE 9]>
			<script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<style>
			canvas {
				width: 100%;
				height: 100%;
				position: absolute;
				top: 0;
			}
			.hs-wrap {
				z-index: 9999;
				position: relative;
				left: 0;
				right: 0;
				background-color: rgba(151, 151, 151, 0.4);
				box-shadow: 0px 0px 50px 0px #000;
			}
		</style>
	</head>
	<body class="login-body">
		<div id="particles-js">
  		<div class="container">
  			<form class="form-signin hs-wrap" method="POST">
  				<h2 class="form-signin-heading">Password Recovery</h2>
  				<div class="login-wrap">
  					<div class="user-login-info">
              <p style="color: #fff;">Enter your user name below.</p>
              <input type="text" id="username" name="username" placeholder="User Name" class="form-control placeholder-no-fix" autocomplete="off" required>
              <p style="color: #fff;">Enter your e-mail address below.</p>
              <input type="text" id="email" name="email" placeholder="E-mail" class="form-control placeholder-no-fix" autocomplete="off" required>
  					</div>
            <button id="reset" class="btn btn-primary" type="button">Reset</button>
            <hr>
            <div id="result"></div>
  					<div class="registration">
  					  Sign in from <a class="" href="login.php">here</a>.
  					</div>
  				</div>
  			</form>
  		</div>
  	</div>
		<script src="js/jquery.js"></script>
		<script src="bs3/js/bootstrap.min.js"></script>
		<script src="js/particles.js"></script>
		<script src="js/app.js"></script>
		<script src="js/sm-requests.js"></script>
	</body>
</html>
