<?php
	require_once('./files/header.php');
?>
<section id="main-content">
	<section class="wrapper">
		<!-- Deposit Page -->

		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Deposit Funds To User Account
						</header>
					<div class="panel-body">
						<div class="col-md-12">
							<section class="panel">
								<div class="form-group">
									<div class="col-lg-8">
										<div class="input-group m-bot15">
											<span class="input-group-addon"><?php echo $currency; ?></span>
											<input type="number" id="amount" onchange="updateInput(this.value)" class="form-control" min="<?php echo $min_deposit; ?>" value="<?php echo $min_deposit; ?>" placeholder="1.00" autocomplete="off" required>
										</div>
										<?php if($min_deposit != 0){ ?><small>Minimum deposit: <?php echo $currency.$min_deposit; ?></small><?php } ?>
									</div>
								</div>
								<?php
									if(!empty($PaypalEmail)) {
								?>
									<div class="form-group" style="display: inline-block;">
										<form method="POST" action="https://www.paypal.com/cgi-bin/webscr">
											<input type="hidden" name="cmd" value="_xclick">
											<input type="hidden" name="business" value="<?php echo $PaypalEmail; ?>">
											<input type="hidden" name="no_shipping" value="1">
											<input type="hidden" name="quantity" value="1">
											<input type="hidden" name="page_style" value="primary">
											<input type="hidden" name="no_note" value="No Note.">
											<input type="hidden" name="cancel_return" value="<?php echo $settings->url(); ?>/paypal.php">
											<input type="hidden" name="return" value="<?php echo $settings->url(); ?>/paypal.php">
											<input type="hidden" name="notify_url" value="<?php echo $settings->url(); ?>/paypal.php">
											<input type="hidden" name="lc" value="US">
											<input type="hidden" name="currency_code" value="<?php echo $currency_name; ?>">
											<input type="hidden" id="pp_amount" name="amount" value="1">
											<input type="hidden" name="item_name" value="Funds Deposit.">
											<input type="submit" id="paypal" class="btn btn-info" value="Paypal Deposit">
										</form>
									</div>
								<?php
									}

									if(!empty($SkrillEmail) && !empty($SkrillSecret)) {
								?>
									<div class="form-group" style="display: inline-block;">
										<form method="POST" action="https://www.moneybookers.com/app/payment.pl">
											<input type="hidden" name="pay_to_email" value="<?php echo $SkrillEmail; ?>"/>
											<input type="hidden" name="status_url" value="<?php echo $settings->url(); ?>/skrill.php"/>
											<input type="hidden" name="language" value="EN"/>
											<input type="hidden" id="skrill_amount" name="amount" value="1"/>
											<input type="hidden" name="currency" value="<?php echo $currency_name; ?>"/>
											<input type="hidden" name="detail1_description" value="Deposit funds to account."/>
											<input type="hidden" name="detail1_text" value="Skrill Deposit"/>
											<input type="submit" id="skrill" class="btn btn-danger" value="Skrill Deposit">
										</form>
									</div>
								<?php
									}

									if(empty($PaypalEmail) && empty($SkrillEmail) && empty($SkrillSecret)) {
										?>
											<div class="form-group" style="display: inline-block;">
												<form method="POST" action="support.php">
													<input type="hidden" name="custom_title" value="Account Deposit">
													<input type="hidden" name="custom_comment" value="I would like to deposit ___ <?php echo $currency; ?>.">
													<input type="submit" id="support" value="Deposit by Support Centre" class="btn btn-info">
												</form>
											</div>
										<?php
									}
								?>
							</section>
						</div>
						<div id="result"></div>
					</div>
				</section>
			</div>
		</div>
	</section>
	<section class="wrapper">
		<!--mini statistics end-->
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">
						Account Deposits -  History
						
					</header>
					<div class="panel-body">
						<?php
							$UserID = $user->GetData('UserID');

							$stmt = $pdo->prepare('SELECT * FROM deposits WHERE DepositUserID = :DepositUserID');
							$stmt->execute(array(':DepositUserID' => $UserID));

							if($stmt->rowCount() > 0) {
						?>
						<div class="adv-table">
							<section id="unseen">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>Deposit ID</th>
											<th>Deposit Amount (<?php echo $currency_name; ?>)</th>
											<th>Deposit Transaction ID</th>
											<th>Service Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$html = '';

											foreach($stmt->fetchAll() as $row) {
												$deposit = round($row['DepositAmount'], 2);

												$html .= '<tr>';
												$html .= '<td>'.$row['DepositID'].'</td>';
												$html .= '<td>'.$currency.$deposit.'</td>';
												$html .= '<td>'.$row['DepositVerification'].'</td>';
												$html .= '<td>'.date('d.m.Y H:i', $row['DepositDate']).'</td>';
												$html .= '</tr>';
											}

											echo $html;
										?>
									</tbody>
								</table>
							</section>
						</div>
						<?php
							} else {
								$display->ReturnInfo('There are no account balance deposits.');
							}
						?>
					</div>
				</section>
			</div>
		</div>
	</section>
</section>
<?php
	require_once('./files/footer.php');
?>
<script>
function updateInput(ish){
		if(ish >= <?php echo $min_deposit; ?>) {
			if($('#paypal').length == 1) {
				$('#paypal').attr("disabled", false);
				  document.getElementById("pp_amount").value = ish;
			}

			if($('#skrill').length == 1) {
				$('#skrill').attr("disabled", false);
				document.getElementById("skrill_amount").value = ish;
			}

			if($('#support').length == 1) {
				$('#support').attr("disabled", false);
			}
		} else {
			if($('#paypal').length == 1)
			$('#paypal').attr("disabled", true);
			if($('#skrill').length == 1)
			$('#skrill').attr("disabled", true);
			if($('#support').length == 1)
			$('#support').attr("disabled", true);
		}

}
</script>
