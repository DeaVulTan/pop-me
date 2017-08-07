<?php
	require_once('./files/header.php');

	if($user->GetData('UserLevel') != 'admin') {
		header('Location: ./index.php');
		exit();
	}
?>

<link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

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
									?>
								</h1>
								<span class="text-muted"><?php echo(ucfirst($user->GetData('UserName'))); ?></span>
								<p>
									Welcome to the administration panel.From here you can manage your social panel easily and change,update and remove data.
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="profile-statistics">
								<h1>
									<?php
										$stmt = $pdo->prepare('SELECT * FROM orders');
										$stmt->execute();

										echo $stmt->rowCount();
									?>
								</h1>
								<p>All sales</p>
								<h1>
									<?php
										$stmt = $pdo->prepare('SELECT * FROM orders');
										$stmt->execute();

										$qty = 0;
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											$qty += $row['OrderAmount'];
										}

										echo '$'.round($qty, 2);
									?>
								</h1>
								<p>All Earnings</p>
								<ul>
									<li>
										<a href="#">
											<i class="fa fa-facebook"></i>
										</a>
									</li>
									<li class="active">
										<a href="#">
											<i class="fa fa-twitter"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-google-plus"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading tab-bg-dark-navy-blue">
						<ul class="nav nav-tabs nav-justified ">
							<li class="active">
								<a data-toggle="tab" href="#logs">Logs</a>
							</li>
							<li>
								<a data-toggle="tab" href="#deposits">Deposits</a>
							</li>
							<li>
								<a data-toggle="tab" href="#news">News</a>
							</li>
							<li>
								<a data-toggle="tab" href="#merchant">Merchant</a>
							</li>
							<li>
								<a data-toggle="tab" href="#ip">Individual Prices</a>
							</li>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content tasi-tab">
							<div id="logs" class="tab-pane active">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage account user logs.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-logs">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM logs ORDER BY LogID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<div class="btn-group">
																<button type="button" onclick="deleteLogs();" class="btn btn-info">Delete User Logs</button>
															</div>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-logs">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Logged User</th>
																			<th>Logged Date</th>
																			<th>Logged IP Address</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$UserName = $user->GetDataID($row['LogUserID'], 'UserName');

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['LogID'].'</th>';
																				$html .= '<th>'.$UserName.'</th>';
																				$html .= '<th>'.date('d.m.Y H:i', $row['LogDate']).'</th>';
																				$html .= '<th>'.$row['LogIPAddress'].'</th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no logs for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="deposits" class="tab-pane">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website deposits.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-deposits">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM deposits ORDER BY DepositID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-deposits">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Deposit User</th>
																			<th>Deposit Date</th>
																			<th>Deposit Amount</th>
																			<th>Deposit Gateway</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$UserName = $user->GetDataID($row['DepositUserID'], 'UserName');

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['DepositID'].'</th>';
																				$html .= '<th>'.$UserName.'</th>';
																				$html .= '<th>'.date('d.m.Y H:i', $row['DepositDate']).'</th>';
																				$html .= '<th>$'.$row['DepositAmount'].'</th>';
																				$html .= '<th>'.$row['DepositGateway'].'</th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no deposits for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="news" class="tab-pane ">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website news.
											</header>
											<div class="panel-body">
												<div class="btn-group">
													<a href="#addUser" onclick="clearResult();" role="button" data-toggle="modal" class="btn btn-primary">
														Add New <i class="fa fa-plus"></i>
													</a>
													<div id="addUser" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title">Add New</h4>
																</div>
																<div class="modal-body">
																	<form method="POST" class="form-horizontal" role="form">
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">New Title</label>
																			<div class="col-lg-10">
																				<input type="text" class="form-control" id="new-title" placeholder="New Title" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">New Content</label>
																			<div class="col-lg-10">
																				<textarea class="form-control" rows="5" id="new-content" placeholder="New Content" autocomplete="off"></textarea>
																			</div>
																		</div>
																		<div class="form-group">
																			<div class="col-lg-offset-2 col-lg-10">
																				<button type="submit" id="add-new" class="btn btn-info">Add</button>
																			</div>
																		</div>
																	</form>
																	<div id="result"></div>
																</div>
																<div class="modal-footer">
																	<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="adv-table" id="current-news">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM news ORDER BY NewsID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-news">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>New Title</th>
																			<th>New Content</th>
																			<th>New Date</th>
																			<th>New Posted By</th>
																			<th>New Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$UserName = $user->GetDataID($row['NewsUserID'], 'UserName');

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['NewsID'].'</th>';
																				$html .= '<th>'.$row['NewsTitle'].'</th>';
																				$html .= '<th>'.$row['NewsContent'].'</th>';
																				$html .= '<th>'.date('d.m.Y', $row['NewsDate']).'</th>';
																				$html .= '<th>'.$UserName.'</th>';
																				$html .= '<th><a href=new-edit.php?new-id='.$row['NewsID'].' class="btn btn-info">Edit</a></th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no news for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="merchant" class="tab-pane">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website merchant settings.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-merchant">
													<form method="POST" class="form-horizontal" role="form">
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Website Name <span class="text-danger">*</span></label>
															<div class="col-lg-10">
																<input type="text" class="form-control" value="<?php echo $WebsiteName; ?>" id="website-name" placeholder="Website Name" autocomplete="off" required>
															</div>
															<small style="float: right;">The website name will be displayed in multiple places such as website title, as logo text and more.</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Recovery E-mail <span class="text-danger">*</span></label>
															<div class="col-lg-10">
																<input type="email" class="form-control" value="<?php echo $RecoveryEmail; ?>" id="recovery-email" placeholder="Recovery E-mail" autocomplete="off" required>
															</div>
															<small style="float: right;">All emails for password recovery will be sent from this E-mail.</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Notification E-mail <span class="text-danger">*</span></label>
															<div class="col-lg-10">
																<input type="email" class="form-control" value="<?php echo $NotificationEmail; ?>" id="notification-email" placeholder="Notification E-mail" autocomplete="off" required>
															</div>
															<small style="float: right;">You'll receive notifications about new users, new orders and more news about your panel.</small>
														</div>
														<hr>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Paypal E-mail</label>
															<div class="col-lg-10">
																<input type="email" class="form-control" value="<?php echo $PaypalEmail; ?>" id="merchant-paypal-email" placeholder="Paypal E-mail" autocomplete="off">
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Skrill E-mail</label>
															<div class="col-lg-10">
																<input type="email" class="form-control" value="<?php echo $SkrillEmail; ?>" id="merchant-skrill-email" placeholder="Skrill E-mail" autocomplete="off">
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Skrill Secret</label>
															<div class="col-lg-10">
																<input type="text" class="form-control" value="<?php echo $SkrillSecret; ?>" id="merchant-skrill-secret" placeholder="Skrill Secret" autocomplete="off">
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Minimum Deposit Amount</label>
															<div class="col-lg-10">
																<input type="text" class="form-control" value="<?php echo $min_deposit; ?>" id="merchant-min-deposit" placeholder="Minimum Deposit" autocomplete="off">
															</div>
															<small style="float: right;">0 - for no minimum deposit.If the deposit is under the required amount the deposit form won't be submitted.</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Currency Symbol</label>
															<div class="col-lg-10">
																<input type="text" class="form-control" value="<?php echo $currency; ?>" id="merchant-currency-symbol" placeholder="Currency Symbol ($)" autocomplete="off">
															</div>
															<small style="float: right;">Currency keyboard symbol.For example: $, €..</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Currency Name</label>
															<div class="col-lg-10">
																<input type="text" class="form-control" value="<?php echo $currency_name; ?>" id="merchant-currency-name" placeholder="Currency Name (USD)" autocomplete="off">
															</div>
															<small style="float: right;">Shorten currency name.For example: USD, EUR, BGN..</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Require Skype</label>
															<div class="col-lg-10">
																<select class="form-control" id="merchant-require-skype">
																	<option value="<?php echo $RequireSkype; ?>"><?php echo $RequireSkype; ?></option>
																	<option disabled>---</option>
																	<option value="Yes">Yes</option>
																	<option value="No">No</option>
																</select>
															</div>
															<small style="float: right;">Require Skype ID at the registration page.</small>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-sm-4 control-label">Save</label>
															<div class="col-lg-10">
																<button type="button" class="btn btn-primary" id="save-merchant">Save Merchant</button>
															</div>
														</div>
													</form>
													<div id="merchant-result"></div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="ip" class="tab-pane">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website individual prices.
											</header>
											<div class="panel-body">
												<div class="btn-group">
													<a href="#addIP" onclick="clearResult();" role="button" data-toggle="modal" class="btn btn-primary">
														Add New <i class="fa fa-plus"></i>
													</a>
													<div id="addIP" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title">Add New</h4>
																</div>
																<div class="modal-body">
																	<form method="POST" class="form-horizontal" role="form">
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">User Name</label>
																			<div class="col-lg-10">
																				<input type="text" class="form-control" id="ip-username" placeholder="User Name" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">Service</label>
																			<div class="col-lg-10">
																				<select class="form-control" id="ip-service">
																					<?php
																						$stmt = $pdo->prepare('SELECT * FROM products ORDER BY ProductID');
																						$stmt->execute();

																						if($stmt->rowCount() > 0) {
																							foreach($stmt->fetchAll() as $row) {
																								echo '<option value="'.$row['ProductID'].'">'.ucfirst($row['ProductName']).'</option>';
																							}
																						} else {
																							echo '<option>There are no products in the database.</option>';
																						}
																					?>
																				</select>
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">Individual Price</label>
																			<div class="col-lg-10">
																				<input type="number" class="form-control" id="ip-price" placeholder="0.99" value="0.99" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<div class="col-lg-offset-2 col-lg-10">
																				<button type="submit" id="add-ip" class="btn btn-info">Add</button>
																			</div>
																		</div>
																	</form>
																	<div id="ip-result"></div>
																</div>
																<div class="modal-footer">
																	<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="adv-table" id="current-ip">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM individualprices ORDER BY IPID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-ip">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>User Name</th>
																			<th>Service Name</th>
																			<th>Individual Price</th>
																			<th>Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$UserName = $user->GetDataID($row['IPUserID'], 'UserName');
																				$ProductName = $product->GetData($row['IPProductID'], 'ProductName');

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['IPID'].'</th>';
																				$html .= '<th>'.$UserName.'</th>';
																				$html .= '<th>'.$ProductName.'</th>';
																				$html .= '<th>$'.$row['IPPrice'].'</th>';
																				$html .= '<th><a href="ip-edit.php?ip-id='.$row['IPID'].'" class="btn btn-primary">Edit</a></th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no individual prices for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" id="page-refresh" class="btn btn-primary pull-right fa fa-refresh"></button>
					</div>
				</section>
			</div>
		</div>
	</section>
</section>
<?php
	require_once('./files/footer.php');
?>
