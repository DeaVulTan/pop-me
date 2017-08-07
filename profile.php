<?php
	require_once('./files/header.php');

	$UserAPI = $user->GetData('UserAPI');
?>
<link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />

<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<div class="panel-body profile-information">
						<div class="col-md-3">
							<div class="profile-pic text-center">
								<?php
									$user->GetImage();
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="profile-desk">
								<h1>
									<?php
										echo(ucfirst($user->GetData('UserFirstName').' '));
										echo(ucfirst($user->GetData('UserLastName')));

										$stmt = $pdo->prepare('SELECT * FROM logs WHERE LogUserID = :LogUserID ORDER BY LogID DESC LIMIT 1');
										$stmt->bindParam(':LogUserID', $UserID);
										$stmt->execute();

										$row = $stmt->fetch(PDO::FETCH_ASSOC);
										$login_date = $row['LogDate'];
										$login_ip_address = $row['LogIPAddress'];
									?>
								</h1>
								<span class="text-muted">
									<p>Welcome back, <?php echo($UserName); ?>.</p>
									<br>
									<p>You were logged in at <b><?php echo(date('d M, Y H:i:s', $login_date)) ?></b> (<b><?php echo($login_ip_address); ?></b>).</p>

								</span>
							</div>
						</div>
						<div class="col-md-3">
							<div class="profile-statistics">
								<h1>
									<?php
										$UserID = $user->GetData('UserID');
										$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderUserID = :OrderUserID');
										$stmt->bindParam(':OrderUserID', $UserID);
										$stmt->execute();

										echo $stmt->rowCount();
									?>
								</h1>
								<p>Account product orders.</p>
								<h1>
									<?php
										$UserFunds = $user->GetData('UserFunds');
										echo $currency.round($UserFunds, 2);
									?>
								</h1>
								<p>Available account funds.</p>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12">
				<section class="panel">
					<div class="panel-body">
						<div class="tab-content tasi-tab">
							<div id="settings" class="tab-pane active">
								<div class="position-center">
									

									<div class="prf-contacts sttng">
										<h2>  Account API</h2>
									</div>
									<?php
										$UserAPI = $user->GetData('UserAPI');
									?>
									<form method="POST`" role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-lg-4 control-label">User API</label>
											<div class="col-lg-6">
												<input type="text" value="<?php echo($UserAPI); ?>" class="form-control" disabled>
											</div>
										</div>
									</form>

									<div class="prf-contacts sttng">
										<h2>  Account Information</h2>
									</div>
									<?php
										$UserName = $user->GetData('UserName');
										$UserEmail = $user->GetData('UserEmail');
										$UserFirstName = $user->GetData('UserFirstName');
										$UserLastName = $user->GetData('UserLastName');
										$UserSkypeID = $user->GetData('UserSkype');
									?>
									<form method="POST`" role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-lg-4 control-label">User Name</label>
											<div class="col-lg-6">
												<input type="text" value="<?php echo($UserName); ?>" class="form-control" disabled>
											</div>
										</div>
										<?php
											if($RequireSkype == 'Yes') {
										?>
											<div class="form-group">
												<label class="col-lg-4 control-label">Skype ID</label>
												<div class="col-lg-6">
													<input type="text" value="<?php echo($UserSkypeID); ?>" class="form-control" disabled>
												</div>
											</div>
										<?php
											}
										?>
										<div class="form-group">
											<label class="col-lg-4 control-label">User E-mail</label>
											<div class="col-lg-6">
												<input type="text" id="email" value="<?php echo($UserEmail); ?>" class="form-control" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">User First Name</label>
											<div class="col-lg-6">
												<input type="text" id="first-name" placeholder="Your first name.." value="<?php echo($UserFirstName); ?>" class="form-control" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">User Last Name</label>
											<div class="col-lg-6">
												<input type="text" id="last-name" placeholder="Your last name.." value="<?php echo($UserLastName); ?>" class="form-control" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Account Password</label>
											<div class="col-lg-6">
												<input type="password" id="account-password" placeholder="Account password to confirm." value="" class="form-control" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button id="update-information" class="btn btn-primary" type="submit">Save</button>
												<input type="reset" class="btn btn-default" value="Cancel">
												<div id="account-update-result"></div>
											</div>
										</div>
									</form>

									<div class="prf-contacts sttng">
										<h2>  Account Password</h2>
									</div>
									<form method="POST" role="form" class="form-horizontal">
										<div class="form-group">
											<label class="col-lg-4 control-label">Account Current Password</label>
											<div class="col-lg-6">
												<input type="password" id="current-password" value="" class="form-control" autocomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Account New Password</label>
											<div class="col-lg-6">
												<input type="password" id="new-password" value="" class="form-control" autcomplete="off" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-10">
												<button id="update-password" class="btn btn-primary" type="submit">Save</button>
												<input type="reset" class="btn btn-default" value="Cancel">
												<div id="account-password-result"></div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</section>
<?php
	require_once('./files/footer.php');
?>
