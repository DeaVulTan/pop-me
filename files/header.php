<?php
	require_once('./files/functions.php');
	if(isset($user)) {
		$user->IsLogged();
		$user->IsBanned();
	} else {
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Social Panel">
		<meta name="author" content="Social Panel">
		<link rel="shortcut icon" href="images/favicon.png">
		<title><?php echo($WebsiteName); ?></title>
		<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
		<link href="js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
		<link href="css/bootstrap-reset.css" rel="stylesheet">
		<link href="css/table-responsive.css" rel="stylesheet" />
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
		<link href="css/clndr.css" rel="stylesheet">
		<link href="js/css3clock/css/style.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/loader.css" rel="stylesheet"/>
		<link href="css/style-responsive.css" rel="stylesheet"/>
		<link rel="stylesheet" href="css/jquery.steps.css?1">

		<!--[if lt IE 9]>
			<script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
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

		<section id="container">
			<header class="header fixed-top clearfix">
				<div class="brand">
					<a href="index.php" class="logo" style="color; #FFF;">
						<?php
							echo $WebsiteName;
						?>
					</a>
					<div class="sidebar-toggle-box">
						<div class="fa fa-bars"></div>
					</div>
				</div>
				<div class="nav notify-row" id="top_menu">
					<ul class="nav top-menu">
						<li id="header_notification_bar" class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<i class="fa fa-bell-o"></i>
							<span class="badge bg-warning">
								<?php
									$stmt = $pdo->prepare('SELECT * FROM news ORDER BY NewsID DESC LIMIT 3');
									$stmt->execute();

									echo $stmt->rowCount();
								?>
							</span>
							</a>
							<ul class="dropdown-menu extended notification">
								<li>
									<p>Latest News</p>
								</li>

								<?php
									if($stmt->rowCount() > 0) {
										foreach($stmt->fetchAll() as $row) {
											$Content = $settings->shortener($row['NewsContent']);
											$html = '<li>';
											$html .= '<div class="alert alert-info clearfix">';
											$html .= '<span class="alert-icon"><i class="fa fa-flag"></i></span>';
											$html .= '<div class="noti-info">';
											$html .= '<a href="news.php"><strong>'.$row['NewsTitle'].'</strong></a><br>';
											$html .= '<font size="1px;">'.$Content.'</font>';
											$html .= '</div>';
											$html .= '</div>';
											$html .= '</li>';

											echo $html;
										}
									} else {
										$html = '<li>';
										$html .= '<div class="alert alert-danger clearfix">';
										$html .= '<span class="alert-icon"><i class="fa fa-flag"></i></span>';
										$html .= '<div class="noti-info">';
										$html .= '<a href="news.php"> There are no available news.</a>';
										$html .= '</div>';
										$html .= '</div>';
										$html .= '</li>';

										echo $html;
									}
								?>
							</ul>
						</li>
					</ul>
				</div>
				<div class="top-nav clearfix">
					<ul class="nav pull-right top-menu">
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<?php
								$user->GetImage(false, 33, 33);
							?>
							<span class="username"><?php $UserFunds = $user->GetData('UserFunds'); echo(ucfirst($user->GetData('UserName'))); ?></span>
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu extended logout">
								<li><a href="profile.php"><i class=" fa fa-suitcase"></i>Profile</a></li>
								<li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
							</ul>
						</li>
						<li class="btn btn-default" id="current-balance" style="background-color: #F6F6F6; border: none; color: #555; border-radius: 100px; height: 33px !important;">
							Funds: <?php echo $currency.round($UserFunds, 2); ?>
						</li>
					</ul>
				</div>
			</header>
			<aside>
				<div id="sidebar" class="nav-collapse">
					<div class="leftside-navigation">
						<ul class="sidebar-menu" id="nav-accordion">
							<li>
								<a href="index.php">
								<i class="fa fa-dashboard"></i>
								<span>Dashboard</span>
								</a>
							</li>
							<li>
								<a href="profile.php">
								<i class="fa fa-user"></i>
								<span>Profile</span>
								</a>
							</li>
							<li class="sub-menu">
								<a href="javascript:;">
									<i class="fa fa-shopping-cart"></i>
								<span>Order History</span>
								</a>
								<ul class="sub">
									<li>
									<a href="orders.php">
										<span class="badge bg-info">
											<?php
												$stmt = $pdo->prepare('SELECT * FROM orders');
												$stmt->execute();

												echo $stmt->rowCount();
											?>
										</span>
										All Orders
									</a></li>
									<li><a href="orders-completed.php">
										<span class="badge bg-success">
											<?php
												$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderStatus = "Completed"');
												$stmt->execute();

												echo $stmt->rowCount();
											?>
										</span>
										Completed Orders
									</a></li>
									<li><a href="orders-process.php">
										<span class="badge bg-warning">
											<?php
												$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderStatus != "Completed" AND OrderStatus != "Canceled" AND OrderStatus != "Refunded"');
												$stmt->execute();

												echo $stmt->rowCount();
											?>
										</span>
										In Process Orders
									</a></li>
								</ul>
								</li>
							<li>
								<a href="services.php">
								<i class="fa fa-ellipsis-h"></i>
								<span>Our Services</span>
								</a>
							</li>
							<li>
								<a href="documentation.php">
								<i class="fa fa-list"></i>
								<span>API Documentation</span>
								</a>
							</li>
							<li>
								<a href="deposit.php">
								<i class="fa fa-usd"></i>
								<span>Deposit Funds</span>
								</a>
							</li>
							<li>
								<a href="support.php">
								<i class="fa fa-comment"></i>
								<span>Support Centre</span>
								</a>
							</li>
							<?php
								$stmt = $pdo->prepare('SELECT * FROM navigation');
								$stmt->execute();

								foreach($stmt->fetchAll() as $row) {
									$html = '<li>';
									$html .= '<a href="'.$row['NavigationURL'].'">';
									$html .= '<i class="'.$row['NavigationIcon'].'"></i>';
									$html .= '<span>'.$row['NavigationText'].'</span>';
									$html .= '</a>';
									$html .= '</li>';

									echo $html;
								}

								echo $copyright;
							?>
						</ul>
					</div>
				</div>
			</aside>
