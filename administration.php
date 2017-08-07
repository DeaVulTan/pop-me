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

										echo $currency.round($qty, 2);
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
								<a data-toggle="tab" href="#users">Users</a>
							</li>
							<li>
								<a data-toggle="tab" href="#categories">Categories</a>
							</li>
							<li>
								<a data-toggle="tab" href="#services">Services</a>
							</li>
							<li>
								<a data-toggle="tab" href="#orders">User Orders</a>
							</li>
							<li>
								<a data-toggle="tab" href="#tickets">Tickets</a>
							</li>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content tasi-tab">
							<div id="users" class="tab-pane active">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website users.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-users">
													<div class="btn-group">
														<a href="#addUser" onclick="clearResult();" role="button" data-toggle="modal" class="btn btn-primary">
															Add New <i class="fa fa-plus"></i>
														</a>
														<div id="addUser" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="modal-title">Add New User</h4>
																	</div>
																	<div class="modal-body">
																		<form method="POST" class="form-horizontal" role="form">
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">First Name</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" id="user-first-name" placeholder="Account First Name" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Last Name</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" id="user-last-name" placeholder="Account Last Name" autocomplete="off">
																				</div>
																			</div>
																			<?php
																				if($RequireSkype == 'Yes') {
																					?>
																					<div class="form-group">
																						<label class="col-lg-2 col-sm-4 control-label">Skype ID</label>
																						<div class="col-lg-10">
																							<input type="text" class="form-control" id="user-skype" placeholder="Account Skype" autocomplete="off">
																						</div>
																					</div>
																					<?php
																				}
																			?>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">User Name</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" id="user-name" placeholder="Account User Name" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">User E-mail</label>
																				<div class="col-lg-10">
																					<input type="email" class="form-control" id="user-email" placeholder="Account E-mail" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">User Password</label>
																				<div class="col-lg-10">
																					<input type="password" class="form-control" id="user-password" placeholder="Account Password">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">User Group</label>
																				<div class="col-lg-10">
																					<select class="form-control" id="user-level">
																						<optgroup label="User Group">
																							<option value="default">Default User</option>
																							<option value="banned">Banned User</option>
																							<option value="admin">Admin User</option>
																							<option value="reseller">Reseller User</option>
																						</optgroup>
																					</select>
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">User Funds</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" value="0" id="user-funds" placeholder="Account Funds">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="col-lg-offset-2 col-lg-10">
																					<button type="submit" id="create-user" class="btn btn-info">Create</button>
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
													<?php
														$stmt = $pdo->prepare('SELECT * FROM users ORDER BY UserID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>User Name</th>
																			<th>First Name</th>
																			<th>Last Name</th>
																			<th>User Email</th>
																			<th>User Funds</th>
																			<th>User Group</th>
																			<?php
																				if($RequireSkype == 'Yes') {
																			?>
																					<th>User Skype</th>
																			<?php
																				}
																			?>
																			<th>Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['UserID'].'</th>';
																				$html .= '<th>'.$row['UserName'].'</th>';
																				$html .= '<th>'.$row['UserFirstName'].'</th>';
																				$html .= '<th>'.$row['UserLastName'].'</th>';
																				$html .= '<th>'.$row['UserEmail'].'</th>';
																				$html .= '<th>'.$currency.round($row['UserFunds'], 2).'</th>';
																				$html .= '<th>'.ucfirst($row['UserLevel']).'</th>';
																				if($RequireSkype == 'Yes') {
																					$html .= '<th>'.$row['UserSkype'].'</th>';
																				}
																				$html .= '<th><a href=user-edit.php?user-id='.$row['UserID'].' class="btn btn-info">Edit</a></th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no users for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="categories" class="tab-pane">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website categories.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-users">
													<div class="btn-group">
														<a href="#createCategory" onclick="clearResult();" role="button" data-toggle="modal" class="btn btn-primary">
															New Category <i class="fa fa-plus"></i>
														</a>
														<div id="createCategory" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="modal-title">Add New Category</h4>
																	</div>
																	<div class="modal-body">
																		<form method="POST" class="form-horizontal" role="form">
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Category Name</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" id="category-name" placeholder="Category Name" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Category Description</label>
																				<div class="col-lg-10">
																					<textarea class="form-control" rows="10" id="category-description" placeholder="Category Description" autocomplete="off"></textarea>
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="col-lg-offset-2 col-lg-10">
																					<button type="submit" id="create-category" class="btn btn-info">Create</button>
																				</div>
																			</div>
																		</form>
																		<div id="category-result"></div>
																	</div>
																	<div class="modal-footer">
																		<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<?php
														$stmt = $pdo->prepare('SELECT * FROM categories');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table-categories">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Category Name</th>
																			<th>Category Create Date</th>
																			<th>Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {

																				$html = '<tr>';
																				$html .= '<th class="numeric">'.$row['CategoryID'].'</th>';
																				$html .= '<th>'.ucfirst($row['CategoryName']).'</th>';
																				
																				$html .= '<th>'.date('d M, Y', $row['CategoryCreatedDate']).'</th>';
																				$html .= '<th><a href=category-edit.php?category-id='.$row['CategoryID'].' class="btn btn-info">Edit</a></th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no categories for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="services" class="tab-pane ">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website services.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-users">
													<div class="btn-group">
														<a href="#createService" role="button" data-toggle="modal" class="btn btn-warning">
															New Service <i class="fa fa-plus"></i>
														</a>
														<div id="createService" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="modal-title">Add New Service</h4>
																	</div>
																	<div class="modal-body">
																		<form method="POST" class="form-horizontal" role="form">
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Name</label>
																				<div class="col-lg-10">
																					<input type="text" class="form-control" id="service-name" placeholder="Service Name" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Description</label>
																				<div class="col-lg-10">
																					<textarea class="form-control" rows="3" id="service-description" placeholder="Service Description" autocomplete="off"></textarea>
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Type</label>
																				<div class="col-lg-10">
																					<select class="form-control" id="service-type">
																						<option value="default">Default</option>
																						<option value="comments">Comments</option>
																						<option value="hashtag">Hashtag</option>
																						<option value="mentions">Mentions</option>
																					</select>
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Min. Quantity</label>
																				<div class="col-lg-10">
																					<input type="number" class="form-control" id="service-minimum-quantity" placeholder="Service Minimum Quantity Required Per Purchase (Example: 1000)" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Max Quantity</label>
																				<div class="col-lg-10">
																					<input type="number" class="form-control" id="service-max-quantity" placeholder="Service Max Quantity (Example: 1000)" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Price</label>
																				<div class="col-lg-10">
																					<input type="number" class="form-control" id="service-price-per-quantity" placeholder="Service Price per Minimum Quantity (Example: 1000x = $5)" autocomplete="off">
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-sm-4 control-label">Service Category</label>
																				<div class="col-lg-10">
																					<select class="form-control" id="service-category">
																						<optgroup label="Example: Likes for category Facebook.">
																							<option value="selected="true" style="display:none;">Assign this service to category.</option>
																							<?php
																								$stmt = $pdo->prepare('SELECT * FROM categories ORDER BY CategoryID');
																								$stmt->execute();

																								if($stmt->rowCount() > 0) {
																									foreach($stmt->fetchAll() as $row) {
																										echo '<option value="'.$row['CategoryID'].'">'.ucfirst($row['CategoryName']).'</option>';
																									}
																								} else {
																									echo '<option>There are no categories in the database.</option>';
																								}
																							?>
																						</optgroup>
																					</select>
																				</div>
																			</div>
																			<div class="form-group" id="service-api">
																				<div id="api">
																					<button type="button" onclick="addAPI();" class="btn btn-primary pull-right">Add API (If available)</button>
																					<input type="hidden" value="" id="service-api-link"/>
																				</div>
																			</div>
																			<div class="form-group" id="service-reseller">
																				<div id="reseller">
																					<button type="button" onclick="addReseller();" class="btn btn-primary pull-right">Add Reseller Price</button>
																					<input type="hidden" value="" id="service-resell-price"/>
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="col-lg-offset-2 col-lg-10">
																					<button type="submit" id="create-service" class="btn btn-info">Create</button>
																				</div>
																			</div>
																		</form>
																		<div id="service-result"></div>
																	</div>
																	<div class="modal-footer">
																		<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<?php
														$stmt = $pdo->prepare('SELECT * FROM products');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table-services">
																	<thead>
																		<tr>
																			
																			<th>Name</th>
																			<th>Category</th>
																			<th>Min Quantity</th>
																			<th>Max Quantity</th>
																			<th>Price per Quantity</th>
																			<th>Create Date</th>
																			<th>API</th>
																			<th>Resell Price</th>
																			<th>Edit</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$CategoryID = $row['ProductCategoryID'];
																				$CategoryName = $category->GetData($CategoryID, 'CategoryName');


																				if(empty($row['ProductAPI'])) {
																					$api = 'No API.';
																				} else {
																					$api = $row['ProductAPI'];
																				}

																				if(empty($row['ProductResellerPrice']))
																					$resell = 0;
																				else
																					$resell = $row['ProductResellerPrice'];

																				$html = '<tr>';
																				$html .= '<th>'.ucfirst($row['ProductName']).'</th>';
																				$html .= '<th>'.ucfirst($CategoryName).'</th>';
																				$html .= '<th>'.ucfirst($row['ProductMinimumQuantity']).'</th>';
																				$html .= '<th>'.ucfirst($row['ProductMaxQuantity']).'</th>';
																				$html .= '<th>'.$currency.ucfirst($row['ProductPrice']).'</th>';
																				$html .= '<th>'.date('d M, Y', $row['ProductCreatedDate']).'</th>';
																				$html .= '<th>'.$api.'</th>';
																				$html .= '<th>'.$currency.$resell.'</th>';
																				$html .= '<th><a href=service-edit.php?service-id='.$row['ProductID'].' class="btn btn-info">Edit</a></th>';
																				$html .= '</tr>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no services for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="orders" class="tab-pane ">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage website orders.
											</header>
											<div class="panel-body">
												<div class="btn-group">
													<div class="form-group">
														<p class="text-dark col-lg-12">Group orders by: </p>
														<div class="col-lg-6">
															<select class="form-control" onChange="selectOrderStatus(this.value);">
																<optgroup label="You are vieweing:
																<?php
																	if(isset($_GET['order_status'])) {
																		echo stripslashes(strip_tags($_GET['order_status']));
																	} else {
																		echo 'All';
																	}
																?>

																">
																	<option disabled selected>---</option>
																	<option value="All">Display all orders</option>
																	<option value="Unprocessed">Unprocessed</option>
																	<option value="Completed">Completed</option>
																	<option value="In Process">In Process</option>
																	<option value="On Hold">On Hold</option>
																	<option value="Refunded">Refunded</option>
																</optgroup>
															</select>
														</div>
														<div class="col-lg-6">
															<select class="form-control" onChange="selectOrderProduct(this.value);">
																<optgroup label="You are vieweing:
																<?php
																	if(isset($_GET['service'])) {
																		$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
																		$stmt->execute(array(':ProductID' => $_GET['service']));

																		if($stmt->rowCount() == 1) {
																			$row = $stmt->fetch();
																			echo $row['ProductName'].'.';
																		} else {
																			echo 'All.';
																		}
																	} else {
																		echo 'All';
																	}

																?>

																">
																	<option disabled selected>---</option>
																	<option value="All">All</option>
																	<?php
																		$stmt = $pdo->prepare('SELECT * FROM products');
																		$stmt->execute();

																		foreach($stmt->fetchAll() as $products) {
																			echo '<option value="'.$products['ProductID'].'">'.$products['ProductName'].'</option>';
																		}
																	?>
																</optgroup>
															</select>
														</div>
													</div>

													<div class="form-group">
														<p class="text-dark col-lg-12">Group orders by (2 filters): </p>
														<div class="col-lg-6">
															<select class="form-control" id="group_order_status" name="order_status">
																<optgroup label="You are vieweing:
																<?php
																	if(isset($_GET['order_status'])) {
																		echo stripslashes(strip_tags($_GET['order_status']));
																	} else {
																		echo 'All';
																	}
																?>

																">
																	<option disabled selected>---</option>
																	<option value="All">Display all orders</option>
																	<option value="Unprocessed">Unprocessed</option>
																	<option value="Completed">Completed</option>
																	<option value="In Process">In Process</option>
																	<option value="On Hold">On Hold</option>
																	<option value="Refunded">Refunded</option>
																</optgroup>
															</select>
														</div>
														<div class="col-lg-6">
															<select class="form-control" id="group_order_service" name="service">
																<optgroup label="You are vieweing:
																<?php
																	if(isset($_GET['service'])) {
																		$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
																		$stmt->execute(array(':ProductID' => $_GET['service']));

																		if($stmt->rowCount() == 1) {
																			$row = $stmt->fetch();
																			echo $row['ProductName'].'.';
																		} else {
																			echo 'All.';
																		}
																	} else {
																		echo 'All';
																	}

																?>

																">
																	<option disabled selected>---</option>
																	<option value="All">All</option>
																	<?php
																		$stmt = $pdo->prepare('SELECT * FROM products');
																		$stmt->execute();

																		foreach($stmt->fetchAll() as $products) {
																			echo '<option value="'.$products['ProductID'].'">'.$products['ProductName'].'</option>';
																		}
																	?>
																</optgroup>
															</select>
														</div>
														<div class="col-lg-6" style="margin-top: 12px;">
															<button type="button" onClick="filterOrders(document.getElementById('group_order_status').value, document.getElementById('group_order_service').value);" class="btn btn-success">Filter</button>
															<a href="administration.php?order_status=All" class="btn btn-success">Clear Filters</a>
														</div>
													</div>
												</div>
												<hr>
												<div class="adv-table" id="current-users">
													<?php
														if(!isset($_GET['order_status']) && !isset($_GET['service']) ||
														(isset($_GET['order_status']) && $_GET['order_status'] == 'All' && !isset($_GET['service'])) ||
														(isset($_GET['service']) && $_GET['service'] == 'All') && !isset($_GET['order_status'])) {
															$stmt = $pdo->prepare('SELECT * FROM orders ORDER BY OrderID DESC');
															$stmt->execute();
														} else if(isset($_GET['order_status']) && $_GET['order_status'] != 'All' && !isset($_GET['service'])) {
															$order_status = stripslashes(strip_tags($_GET['order_status']));
															$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderStatus = :OrderStatus ORDER BY OrderID DESC');
															$stmt->execute(array(':OrderStatus' => $order_status));
														} else if(isset($_GET['service']) && $_GET['service'] != 'All' && !isset($_GET['order_status'])) {
															$service = $_GET['service'];
															$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderProductID = :OrderProductID ORDER BY OrderID DESC');
															$stmt->execute(array(':OrderProductID' => $service));
														} else if(isset($_GET['service']) && isset($_GET['order_status']) && $_GET['service'] != 'All' && $_GET['order_status'] != 'All') {
															$service = $_GET['service'];
															$order_status = $_GET['order_status'];

															$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderProductID = :OrderProductID AND OrderStatus = :OrderStatus ORDER BY OrderID DESC');
															$stmt->execute(array(':OrderProductID' => $service, ':OrderStatus' => $order_status));
														}

														if($stmt->rowCount() > 0) {
													?>
														<section id="unseen">
															<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-table-user-orders">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Order User Name</th>
																		<th>Order Product</th>
																		<th>Order Link</th>
																		<th>Order Amount</th>
																		<th>Order Quantity</th>
																		<th>Order Status</th>
																		<th>Order Remains</th>
																		<th>Order Start Count</th>
																		<th>Order Type</th>
																		<th>Order Ad. Content</th>
																		<th>Order Date</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																		foreach($stmt->fetchAll() as $row) {
																			if(empty($row['OrderAPIID'])) {
																				$status = $row['OrderStatus'];
																				$start_count = $row['OrderStartCount'];
																				$remains = 0;
																			} else if($row['OrderStatus'] == 'In Process') {
																				$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
																				$stmt->execute(array(':ProductID' => $row['OrderProductID']));
																				$service_api = $stmt->fetch();

																				$parts = parse_url($service_api['ProductAPI']);
																				parse_str($parts['query'], $query);
																				$api_key = $query['key'];

																				$current_url = explode("?", $service_api['ProductAPI']);
																				$url = $current_url[0].'?key='.$api_key.'&action=status&order='.$row['OrderAPIID'];

																				$curl = curl_init();
																				curl_setopt_array($curl, array(
																					CURLOPT_RETURNTRANSFER => 1,
																					CURLOPT_URL => $url,
																					CURLOPT_USERAGENT => 'Enigma SMM API Caller'
																				));

																				$resp = curl_exec($curl);
																				curl_close($curl);

																				$response = json_decode($resp);
																				if(isset($response->status))
																					$status = $response->status;
																				else
																					$status = $row['OrderStatus'];

																				if(isset($response->remains))
																					$remains = $response->remains;
																				else
																					$remains = 0;
																				if(empty($row['OrderStartCount']) && $row['OrderStartCount'] == 0) {
																					if(isset($response->start_count))
																						$start_count = $response->start_count;
																					else
																						$start_count = 0;
																				} else {
																						$start_count = $row['OrderStartCount'];
																				}

																				if(!empty($row['OrderStartCount']) && isset($response->start_count)) {
																					$start_count = $row['OrderStartCount'];
																				}

																				if($status == 'Completed') {
																					$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Completed" WHERE OrderID = :OrderID');
																					$stmt->execute(array(':OrderID' => $row['OrderID']));
																				} else if($status == 'Canceled') {
																					$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Removed" WHERE OrderID = :OrderID');
																					$stmt->execute(array(':OrderID' => $row['OrderID']));
																				}
																			} else {
																				$status = $row['OrderStatus'];
																				$start_count = $row['OrderStartCount'];
																				$remains = 0;
																			}

																			if(empty($row['OrderAdditional'])) {
																				$additional = 'None';
																			} else {
																				$additional = $row['OrderAdditional'];
																			}

																			$ProductID = $row['OrderProductID'];
																			$ProductName = $product->GetData($ProductID, 'ProductName');
																			$UserName = $user->GetDataID($row['OrderUserID'], 'UserName');
																			$OrderStatus = $row['OrderStatus'];

																			$html = '<tr>';
																			$html .= '<th>'.$row['OrderID'].'</th>';
																			$html .= '<th>'.$UserName.'</th>';
																			$html .= '<th>'.ucfirst($ProductName).'</th>';
																			$html .= '<th>'.$row['OrderLink'].'</th>';
																			$html .= '<th>'.$currency.round($row['OrderAmount'], 2).'</th>';
																			$html .= '<th>'.$row['OrderQuantity'].'</th>';
																			$html .= '<th>';
																			$html .= '<select class="form-control" id="change-order-status-'.$row['OrderID'].'" onchange="updateOrderStatus('.$row['OrderID'].')">';
																			$html .= '<optgroup label="Update order status.">';
																			$html .= '<option value="'.$OrderStatus.'" selected="true" disabled>'.$status.'</option>';
																			$html .= '<option value="Unprocessed">Unprocessed</option>';
																			$html .= '<option value="Completed">Completed</option>';
																			$html .= '<option value="In Process">In Process</option>';
																			$html .= '<option value="On Hold">On Hold</option>';
																			$html .= '<option value="Refunded">Refunded</option>';
																			$html .= '<option value="Removed">Removed</option>';
																			$html .= '</optgroup>';
																			$html .= '<optgroup label="Delete order from database.">';
																			$html .= '<option value="Delete Order">Delete Order</option>';
																			$html .= '</optgroup>';
																			$html .= '</select>';
																			$html .= '</th>';
																			$html .= '<th>'.$remains.'</th>';
																			$html .= '<th><input type="number" id="change-order-start-count-'.$row['OrderID'].'" onchange="updateOrderStartCount('.$row['OrderID'].')" value="'.$start_count.'"></th>';
																			$html .= '<th>'.ucfirst($row['OrderType']).'</th>';
																			$html .= '<th>'.$additional.'</th>';
																			$html .= '<th>'.date('d-m-Y', $row['OrderDate']).'</th>';
																			$html .= '</tr>';

																			echo $html;
																		}
																	?>
																</tbody>
															</table>
														</section>
													<?php
														} else {
															$display->ReturnInfo('There are no orders for displaying.');
														}
													?>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div id="tickets" class="tab-pane ">
								<div class="row">
									<div class="col-sm-12">
										<section class="panel">
											<header class="panel-heading">
												Manage user tickets.
											</header>
											<div class="panel-body">
												<div class="adv-table" id="current-users">
													<?php
														$stmt = $pdo->prepare('SELECT * FROM support ORDER BY SupportID DESC');
														$stmt->execute();

														if($stmt->rowCount() > 0) {
													?>
															<section id="unseen">
																<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="dynamic-table-tickets">
																	<thead>
																		<tr>
																			<th>#</th>
																			<th>Ticket User</th>
																			<th>Ticket Title</th>
																			<th>Ticket Message</th>
																			<th>Ticket Date</th>
																			<th>Ticket Reply</th>
																			<th>Ticket Save</th>
																			<th>Ticket Delete</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($stmt->fetchAll() as $row) {
																				$UserName = $user->GetDataID($row['SupportUserID'], 'UserName');

																				$html = '<form method="POST">';
																				$html .= '<tr id="ticket-'.$row['SupportID'].'">';
																				$html .= '<th>'.$row['SupportID'].'</th>';
																				$html .= '<th>'.$UserName.'</th>';
																				$html .= '<th>'.$row['SupportTitle'].'</th>';
																				$html .= '<th>'.$row['SupportMessage'].'</th>';
																				$html .= '<th>'.date('d-m-Y', $row['SupportDate']).'</th>';
																				$html .= '<th><div class="form-group"><textarea id="ticket-reply-'.$row['SupportID'].'" class="form-control" placeholder="Ticket Reply">'.($row['SupportReply']).'</textarea></div></th>';
																				$html .= '<th><button type="button" onclick="replyTicket('.$row['SupportID'].');" class="btn btn-success">Save</button></th>';
																				$html .= '<th><button type="button" onclick="deleteTicket('.$row['SupportID'].');" class="btn btn-danger">Delete</button></th>';
																				$html .= '</tr>';
																				$html .= '</form>';

																				echo $html;
																			}
																		?>
																	</tbody>
																</table>
															</section>
													<?php
														} else {
															$display->ReturnInfo('There are no tickets for displaying.');
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
	<script src="js/scriped.js"></script>
	<script src="js/table2download.js"></script>
	<?php
	if(isset($_GET['order_status']) || isset($_GET['service'])) {
?>
		<script>
			$(document).ready(function(){
			  activaTab('orders');
			});

			function activaTab(tab){
			  $('.nav-tabs a[href="#' + tab + '"]').tab('show');
			};
		</script>
	<?php
}
?>
