<?php
	require_once('./files/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="ThemeBucket">
		<link rel="shortcut icon" href="images/favicon.png">
		<title><?php echo($WebsiteName); ?> | Sign Up</title>
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
				<h2 class="form-signin-heading">sign up</h2>
				<div class="login-wrap">
					<p>Enter your personal details below</p>
					<input type="text" id="first-name" name="first-name" class="form-control" placeholder="First Name" autofocus required>
					<input type="text" id="last-name" name="last-name" class="form-control" placeholder="Last Name" required>
					<input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
					<p> Enter your account details below</p>
					<?php
						if($RequireSkype == 'Yes') {
					?>
							<input type="text" id="skype" name="skype" class="form-control" placeholder="Skype ID" required>
					<?php
						}
					?>
					<input type="text" id="user-name" name="user-name" class="form-control" placeholder="User Name" required>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
					<input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Re-type Password" required>
					<label class="checkbox">
						<input type="checkbox" name="tos" value="tos_agree"> I agree to the Terms of Service and Privacy Policy
					</label>
					<input id="register" type="submit" name="register" class="btn btn-lg btn-login btn-block" value="Sign up">
					<div class="registration">
						Already Registered?
						<a class="" href="login.php">Login</a>
					</div>
				</div>
			</form>
			<?php
			if(isset($_POST['register'])) {
				if(isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['email']) && isset($_POST['user-name']) && isset($_POST['password']) && isset($_POST['confirm-password']) &&
				is_string($_POST['first-name']) && is_string($_POST['last-name']) && is_string($_POST['email']) && is_string($_POST['user-name']) && is_string($_POST['password']) && is_string($_POST['confirm-password']) &&
				!empty($_POST['first-name']) && !empty($_POST['last-name']) && !empty($_POST['email']) && !empty($_POST['user-name']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])) {
					if(isset($_POST['tos'])) {
						if($_POST['password'] == $_POST['confirm-password']) {
							if(strlen($_POST['password']) < 32 && strlen($_POST['password']) > 3) {
								if(strlen($_POST['user-name']) < 16 && strlen($_POST['user-name']) > 3) {
									if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
										$first_name = stripslashes(strip_tags($_POST['first-name']));
										$last_name = stripslashes(strip_tags($_POST['last-name']));
										$email = $_POST['email'];
										$skype = '';


										if($RequireSkype == 'Yes') {
											if(isset($_POST['skype']) && !empty($_POST['skype'])) {
												$skype = stripslashes(strip_tags($_POST['skype']));
											} else {
												$display->ReturnError('Skype length have to be bettwen 2-32 characters.');
												exit();
											}
										}

										$user_name = stripslashes(strip_tags($_POST['user-name']));
										$password = md5($_POST['password']);
										$api = md5($user_name.$password.time().rand(100,10000).time());

										$stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName OR UserEmail = :UserEmail');
										$stmt->execute(array(':UserName' => $user_name, ':UserEmail' => $email));

										if($stmt->rowCount() != 0) {
											$display->ReturnError('User with these credentials already exists.');
										} else {
											$stmt = $pdo->prepare('INSERT INTO users (UserName, UserEmail, UserPassword, UserFirstName, UserLastName, UserRegistrationDate, UserRegistrationAddress, UserAPI, UserSkype)
											VALUES (:UserName, :UserEmail, :UserPassword, :UserFirstName, :UserLastName, :UserRegistrationDate, :UserRegistrationAddress, :UserAPI, :UserSkype)');

											$stmt->execute(array(':UserName' => $user_name, ':UserEmail' => $email, ':UserPassword' => $password, ':UserFirstName' => $first_name, ':UserLastName' => $last_name, ':UserRegistrationDate' => time(), ':UserRegistrationAddress' => $_SERVER['REMOTE_ADDR'], ':UserAPI' => $api,
											':UserSkype' => $skype));

											$stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName');
											$stmt->bindParam(':UserName', $user_name);
											$stmt->execute();

											$row = $stmt->fetch();

											$UserID = $row['UserID'];
											$time = time();
											$IPAddress = $_SERVER['REMOTE_ADDR'];

											$_SESSION['auth'] = $UserID;

											$stmt = $pdo->prepare('INSERT INTO logs (LogUserID, LogDate, LogIPAddress) VALUES (:LogUserID, :LogDate, :LogIPAddress)');
											$stmt->execute(array(':LogUserID' => $UserID, ':LogDate' => $time, ':LogIPAddress' => $IPAddress));

											$settings->forceRedirect('index.php');
										}
									} else {
										$display->ReturnError('The provided e-mail address is invalid.');
									}
								} else {
									$display->ReturnError('User name length have to be between 4-16 characters.');
								}
							} else {
								$display->ReturnError('Password length have to be between 4-32 characters.');
							}
						} else {
							$display->ReturnError('Password do not equals to confirmed password.');
						}
					} else {
						$display->ReturnError('You have to agree with our TOS.');
					}
				} else {
					$display->ReturnError('Fill all fields correctly.');
				}
			}
			?>
		</div>
	</div>
		<script src="js/jquery.js"></script>
		<script src="bs3/js/bootstrap.min.js"></script>
		<script src="js/particles.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>
