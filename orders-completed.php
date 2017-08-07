<?php
	require_once('./files/header.php');
?>

<link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

<section id="main-content">
	<section class="wrapper">
		<!--mini statistics end-->
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">
						Account Order History - Completed Orders
						</header>
					<div class="panel-body">
						<div class="adv-table">
							<div class="space15"></div>
							<?php
								$UserID = $user->GetData('UserID');

								$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderUserID = :OrderUserID AND OrderStatus = "Completed" ORDER BY OrderID DESC');
								$stmt->bindParam(':OrderUserID', $UserID);
								$stmt->execute();

								if($stmt->rowCount() > 0) {
							?>
								<section id="unseen">
									<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed" id="dynamic-orders">
										<thead>
											<tr>
												<th>Date</th>
												<th>Service</th>
												<th>Amount</th>
												<th>Cost</th>
												<th>Link</th>
												<th>Status</th>
												<th>Start Count</th>
												<th>Remains</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$html = '';

												foreach($stmt->fetchAll() as $row) {
													if(empty($row['OrderAPIID'])) {
														$status = $row['OrderStatus'];
														$start_count = 0;
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
															$status = 'Completed';
														if(isset($response->remains))
															$remains = $response->remains;
														else
															$remains = 0;
														if(isset($response->start_count) && empty($row['OrderStartCount']))
															$start_count = $response->start_count;
														else if(!isset($response->start_count) && !empty($row['OrderStartCount']))
															$start_count = $row['OrderStartCount'];
														else if(isset($response->start_count) && !empty($row['OrderStartCount']))
															$start_count = $row['OrderStartCount'];
														else
															$start_count = 0;

														$UserFunds = $user->GetData('UserFunds');

														if($status == 'Completed') {
															$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Completed" WHERE OrderID = :OrderID');
															$stmt->execute(array(':OrderID' => $row['OrderID']));
														} else if($status == 'Canceled' || $status == 'Refunded') {
															if($status == 'Canceled') {
																$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Removed" WHERE OrderID = :OrderID');
																$stmt->execute(array(':OrderID' => $row['OrderID']));
															} else if($status == 'Refunded') {
																$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Refunded" WHERE OrderID = :OrderID');
																$stmt->execute(array(':OrderID' => $row['OrderID']));
															}

															$stmt = $pdo->prepare('UPDATE users SET UserFunds = :UserFunds WHERE UserID = :UserID');
															$stmt->execute(array(':UserFunds' => $row['OrderAmount'] + $UserFunds, ':UserID' => $UserID));
														}
													} else {
														$status = $row['OrderStatus'];
														$start_count = 0;
														$remains = 0;
													}

													if(empty($row['OrderAdditional'])) {
														$additional = 'No comments/hashtags/usernames.';
													} else {
														$additional = $row['OrderAdditional'];
														$additional = str_replace('\r\n',',', $additional);
														$additional = str_replace('\n',',', $additional);
													}

													$html .= '<tr class="">';
													$html .= '<td>'.date('d M, Y', $row['OrderDate']).'</td>';
													$html .= '<td>'.$product->GetData($row['OrderProductID'], 'ProductName').'</td>';
													$html .= '<td>'.$row['OrderQuantity'].'</td>';
													$html .= '<td>'.$currency.round($row['OrderAmount'], 2).'</td>';
													$html .= '<td>'.$row['OrderLink'].'</td>';
													$html .= '<td class="center">'.$status.'.</td>';
													$html .= '<td class="center">'.$start_count.'</td>';
													$html .= '<td class="center">'.$remains.'</td>';
													$html .= '</tr>';
												}

												echo $html;
											?>
										</tbody>
									</table>
								</section>
							<?php
								} else {
									$display->ReturnInfo('Your account does not have any completed orders at this time.');
								}
							?>
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
