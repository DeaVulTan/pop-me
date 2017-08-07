<?php
	require_once('./files/header.php');

	echo '<section id="main-content">';
	echo '<section class="wrapper">';

	define("DEBUG", 0);
	define("USE_SANDBOX", 0;

	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
		$keyval = explode ('=', $keyval);
		if (count($keyval) == 2)
			$myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	$req = 'cmd=_notify-validate';

	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists = true;
	}

	foreach ($myPost as $key => $value) {
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
			$value = urlencode(stripslashes($value));
		} else {
			$value = urlencode($value);
		}
		$req .= "&$key=$value";
	}
	if(USE_SANDBOX == true) {
		$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	} else {
		$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	}
	$ch = curl_init($paypal_url);

	if ($ch == FALSE) {
		return FALSE;
	}
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

	if(DEBUG == true) {
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
	}

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

	$res = curl_exec($ch);
	if (curl_errno($ch) != 0) {
		curl_close($ch);
		exit;
	} else {
		curl_close($ch);
	}

	$tokens = explode("\r\n\r\n", trim($res));
	$res = trim(end($tokens));

	if (strcmp ($res, "VERIFIED") == 0) {
		$DepositVerification = $_POST['verify_sign'];

		$stmt = $pdo->prepare('SELECT DepositVerification FROM deposits WHERE DepositVerification = :DepositVerification');
		$stmt->bindParam(':DepositVerification', $DepositVerification);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			$display->ReturnError('Transaction already exists in our database.');
		} else {

		$UserID = $user->GetData('UserID');
		$UserFirstName = $user->GetData('UserFirstName');
		$UserLastName = $user->GetData('UserLastName');
		$UserName = $user->GetData('UserName');
		$UserEmail = $user->GetData('UserEmail');
		$DepositedFunds = $_POST['payment_gross'];
		$UserFunds = $user->GetData('UserFunds');
		$TotalFunds = $DepositedFunds + $UserFunds;
		$Date = time();

		$stmt = $pdo->prepare('UPDATE users SET UserFunds = :UserFunds WHERE UserID = :UserID');
		$stmt->execute(array(':UserFunds' => $TotalFunds, ':UserID' => $UserID));

		$stmt = $pdo->prepare('INSERT INTO deposits (DepositUserID, DepositDate, DepositAmount, DepositVerification, DepositGateway) VALUES (:DepositUserID, :DepositDate, :DepositAmount, :DepositVerification, :DepositGateway)');
		$stmt->execute(array(':DepositUserID' => $UserID, ':DepositDate' => $Date, ':DepositAmount' => $DepositedFunds, ':DepositVerification' => $DepositVerification, ':DepositGateway' => 'Paypal'));
?>
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<div class="panel-body invoice">
						<div class="invoice-header">
							<div class="invoice-title col-md-3 col-xs-2">
								<h1>invoice</h1>
								<img class="logo-print" src="images/logo.png" style="margin-top: -73px;" width="170px" height="80px" alt="">
							</div>
							<div class="invoice-info col-md-9 col-xs-10">

								<div class="pull-right">
									<div class="col-md-6 col-sm-6 pull-left">
										<p>
											Last Name : <?php echo(ucfirst($UserLastName)); ?>
											<br>
											First Name : <?php echo(ucfirst($UserFirstName)); ?>
										</p>
									</div>
									<div class="col-md-6 col-sm-6 pull-right">
										<p>
											User Name : <?php echo($UserName); ?>
											<br>
											Email : <?php echo($UserEmail); ?>
										</p>
									</div>
								</div>

							</div>
						</div>
						<div class="row invoice-to">
							<div class="col-md-4 col-sm-4 pull-left">
								<h4>Invoice To:</h4>
								<h2>Envato</h2>
								<p>
									<?php

									?>
									<?php echo(ucfirst($UserLastName)); ?>, <?php echo(ucfirst($UserFirstName)); ?><br>
									Email : <?php echo($UserEmail); ?>
								</p>
							</div>
							<div class="col-md-4 col-sm-5 pull-right">
								<br>
								<div class="row">
									<div class="col-md-4 col-sm-5 inv-label">Date #</div>
									<div class="col-md-8 col-sm-7"><?php echo(date('D M, Y', time())); ?></div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-12 inv-label">
										<h3>NEW USER BALANCE</h3>
									</div>
									<div class="col-md-12">
										<h1 class="amnt-value">$ <?php echo($TotalFunds); ?></h1>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-invoice" >
							<thead>
								<tr>
									<th>#</th>
									<th>Item Description</th>
									<th class="text-center">Unit Cost</th>
									<th class="text-center">Quantity</th>
									<th class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>
										<h4>Deposit</h4>
										<p>You've just deposited funds to your account.</p>
									</td>
									<td class="text-center">1</td>
									<td class="text-center">1</td>
									<td class="text-center">$<?php echo($DepositedFunds); ?></td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-8 col-xs-7 payment-method">
								<h4>Information</h4>
								<p>1. Deposit refund will cause account termination.</p>
								<p>2. You are not allowed to share your account information with others.</p>
								<p>3. We are not responsible for your actions.</p>
								<br>
								<h3 class="inv-label itatic">Thank you for your business</h3>
							</div>
							<div class="col-md-4 col-xs-5 invoice-block pull-right">
								<ul class="unstyled amounts">
									<li class="grand-total">Total Deposit : $<?php echo($DepositedFunds); ?></li>
								</ul>
							</div>
						</div>

						<div class="text-center invoice-btn">
							<a class="btn btn-success btn-lg"><i class="fa fa-check"></i> PAID </a>
						</div>
					</div>
				</section>
			</div>
		</div>

<?php
		}
	} else if (strcmp ($res, "INVALID") == 0) {
		echo('Invalid transaction ID provided.');
	} else {
		echo('Invalid transaction ID provided.');
	}

	echo '</section>';
	echo '</section>';

	require_once('./files/footer.php');
