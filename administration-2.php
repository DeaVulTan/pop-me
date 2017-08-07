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
								<a data-toggle="tab" href="#navigation">Navigation</a>
							</li>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content tasi-tab">
							<div id="navigation" class="tab-pane active">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website navigation.
											</header>
											<div class="panel-body">
												<div class="btn-group">
													<a href="#addUser" role="button" data-toggle="modal" class="btn btn-primary">
														Add New <i class="fa fa-plus"></i>
													</a>
													<div id="addUser" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title">Add Navigation</h4>
																</div>
																<div class="modal-body">
																	<form method="POST" class="form-horizontal" role="form">
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">Navigation Text</label>
																			<div class="col-lg-10">
																				<input type="text" class="form-control" id="nav-text" placeholder="Navigation Text" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">Navigation URL</label>
																			<div class="col-lg-10">
																				<input type="text" class="form-control" id="nav-url" placeholder="Navigation URL" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-sm-4 control-label">Navigation Icon</label>
																			<div class="col-lg-10">
																				<input type="text" class="form-control" id="nav-icon" placeholder="fa fa-user (Will display user icon)" autocomplete="off">
																			</div>
																		</div>
																		<div class="form-group">
																			<div class="col-lg-offset-2 col-lg-10">
																				<button type="submit" id="add-nav" class="btn btn-info">Add</button>
																			</div>
																		</div>
																	</form>
																	<div id="nav-result"></div>
																</div>
																<div class="modal-footer">
																	<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="adv-table" id="current-navigation">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM navigation ORDER BY NavigationID');
														$stmt->execute();
														
														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-navigation">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Navigation Text</th>
																			<th>Navigation URl</th>
																			<th>Navigation Icon</th>
																			<th>Navigation Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['NavigationID'].'</th>';
																				$html .= '<th>'.$row['NavigationText'].'</th>';
																				$html .= '<th>'.$row['NavigationURL'].'</th>';
																				$html .= '<th>'.$row['NavigationIcon'].' (<i class="'.$row['NavigationIcon'].'"></i>)</th>';
																				$html .= '<th><a href=nav-edit.php?nav-id='.$row['NavigationID'].' class="btn btn-info">Edit</a></th>';
																				$html .= '</tr>';
																				
																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no navigation links for displaying.');
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