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
	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter43312414 = new Ya.Metrika({
                    id:43312414,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/43312414" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		<div id="particles-js">
			<div class="container">
				<form class="form-signin hs-wrap" method="POST">
					<h2 class="form-signin-heading">sign in now</h2>
					<div class="login-wrap">
						<div class="user-login-info">
							<input type="text" name="username" class="form-control" placeholder="User Name" autofocus required>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<label class="checkbox">
							<input type="checkbox" value="remember-me"> <font color="#fff">Remember me</font>
							<span class="pull-right">
								<a href="password-recovery.php"> Forgot Password?</a>
							</span>
						</label>
						<input type="submit" name="login" value="Sign In" class="btn btn-lg btn-login btn-block">
						<div class="registration">
							Don't have an account yet?
							<a class="" href="registration.php">Create an account</a>
						</div>
					</div>
				</form>
				<?php
					if(isset($_POST['login'])) {
						if(isset($_POST['username']) && isset($_POST['password']) &&
						is_string($_POST['username']) && is_string($_POST['password']) &&
						!empty($_POST['username']) && !empty($_POST['password'])) {
							$username = stripslashes(strip_tags($_POST['username']));
							$password = md5($_POST['password']);

							$stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName');
							$stmt->bindParam(':UserName', $username);
							$stmt->execute();

							if($stmt->rowCount() > 0) {
								$stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName AND UserPassword = :UserPassword');
								$stmt->execute(array(':UserName' => $username, ':UserPassword' => $password));

								if($stmt->rowCount() > 0) {
									$row = $stmt->fetch();
									$UserLevel = $row['UserLevel'];

									if($UserLevel == 'banned') {
										$display->ReturnError('Your account has been suspended.');
										return false;
									}
									$UserID = $row['UserID'];
									$time = time();
									$IPAddress = $_SERVER['REMOTE_ADDR'];

									$_SESSION['auth'] = $UserID;

									$stmt = $pdo->prepare('INSERT INTO logs (LogUserID, LogDate, LogIPAddress) VALUES (:LogUserID, :LogDate, :LogIPAddress)');
									$stmt->execute(array(':LogUserID' => $UserID, ':LogDate' => $time, ':LogIPAddress' => $IPAddress));

									$settings->forceRedirect('index.php');
								} else {
									$display->ReturnError('Invalid user credentials.');
								}
							} else {
								$display->ReturnError('User with these credentials does not exists.');
							}
						}
					}
				?>
			</div>
		</div>

		<script src="js/jquery.js"></script>
		<script src="bs3/js/bootstrap.min.js"></script>
		<script src="js/particles.js"></script>
		<script src="js/app.js"></script>
		<script src="js/sm-requests.js"></script>
	</body>
</html>
