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
						All Panel Services
						</header>
					<div class="panel-body">
						<?php
							$stmt = $pdo->prepare('SELECT * FROM products');
							$stmt->execute();

							if($stmt->rowCount() > 0) {
						?>
						<div class="adv-table">
							<section id="unseen">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>Category</th>
											<th>Name</th>
											<th>Min. Quantity</th>
											<th>Max. Quantity</th>
											<th>Price per 1000</th>
											<th>Resell Price</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$html = '';
											
											foreach($stmt->fetchAll() as $row) {
												$UserID = $user->GetData('UserID');
												$UserGroup = $user->GetData('UserLevel');
												$product_quantity = $row['ProductMinimumQuantity'];
												$CategoryID = $row['ProductCategoryID'];
												$CategoryName = $category->GetData($CategoryID, 'CategoryName');


												$stmt = $pdo->prepare('SELECT * FROM individualprices WHERE IPUserID = :IPUserID AND IPProductID = :IPProductID');
												$stmt->execute(array(':IPUserID' => $UserID, ':IPProductID' => $row['ProductID']));

												if($stmt->rowCount() == 1) {
													$IPPrice = $stmt->fetch(PDO::FETCH_ASSOC);
													$price = $product->DeclarePrice($IPPrice['IPPrice'], $product_quantity, $product_quantity);
												} else {
													if($UserGroup == 'reseller') {
														if(!empty($row['ProductResellerPrice']))
															$price = $product->DeclarePrice($row['ProductResellerPrice'], $product_quantity, $product_quantity);
														else
															$price = $product->DeclarePrice($row['ProductPrice'], $product_quantity, $product_quantity);
													} else {
														$price = $product->DeclarePrice($row['ProductPrice'], $product_quantity, $product_quantity);
													}
												}
												

																				

																				if(empty($row['ProductResellerPrice']))
																					$resell = 0;
																				else
																					$resell = $row['ProductResellerPrice'];


												$price = round($price, 2);

												$html .= '<tr>';
												$html .= '<th>'.$CategoryName.'</th>';
												$html .= '<td>'.$row['ProductName'].'</td>';
												$html .= '<td>'.$row['ProductMinimumQuantity'].'</td>';
												$html .= '<th>'.$row['ProductMaxQuantity'].'</th>';
												$html .= '<td>'.$currency.$price.'</td>';
												$html .= '<th>'.$currency.$resell.'</th>';
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
								$display->ReturnInfo('There are no services.');
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
