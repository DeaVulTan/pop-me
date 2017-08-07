<?php

require_once('./files/header.php');

$html = '<section id="main-content">';
$html .= '<section class="wrapper">';
$html .= '<div class="row">';
$html .= '<div class="col-sm-12">';
$html .= '<section class="panel">';
$html .= '<header class="panel-heading">';
$html .= 'Edit Service Panel';
$html .= '<span class="tools pull-right">';
$html .= '<a href="javascript:;" class="fa fa-chevron-down"></a>';
$html .= '<a href="javascript:;" class="fa fa-times"></a>';
$html .= '</span>';
$html .= '</header>';
$html .= '<div class="panel-body">';

echo $html;
$UserLevel = $user->GetData('UserLevel');
if($UserLevel == 'admin') {
	if(isset($_GET['service-id']) && !empty($_GET['service-id']) && ctype_digit($_GET['service-id'])) {
		$ServiceID = strip_tags(stripslashes($_GET['service-id']));

		$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
		$stmt->bindParam(':ProductID', $ServiceID);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			?>

				<div class="col-md-10">
					<section class="panel">
						<form method="POST" class="form-horizontal" role="form">
							<input type="hidden" value="<?php echo $ServiceID; ?>" id="edit-service-id">
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service Name</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $row['ProductName']; ?>" id="edit-service-name" placeholder="Service Name" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service Minimum Quantity</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $row['ProductMinimumQuantity']; ?>" id="edit-service-minimum-quantity" placeholder="Service Minimum Quantity (Example: At least 100 to purchase)" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service Max Quantity</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $row['ProductMaxQuantity']; ?>" id="edit-service-max-quantity" placeholder="Service Max Quantity (Example: 1000)" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service Price</label>
								<div class="col-lg-10">
									<input type="number" class="form-control" pattern="([0-9]+\.)?[0-9]+" value="<?php echo $row['ProductPrice']; ?>" id="edit-service-price" placeholder="Service Price (Example: $5 for 1000 (Minimum Quantity))" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service Category</label>
								<div class="col-lg-10">
									<select class="form-control" id="edit-service-category">
										<option value="<?php echo($row['ProductCategoryID']); ?>" selected="true" style="display:none;"><?php echo(ucfirst($category->GetData($row['ProductCategoryID'], 'CategoryName'))); ?></option>
										<?php
											$stmt = $pdo->prepare('SELECT * FROM categories');
											$stmt->execute();

											foreach($stmt->fetchAll() as $category) {
												echo '<option value="'.$category['CategoryID'].'">'.$category['CategoryName'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id="service-edit-api">
								<label class="col-lg-2 col-sm-4 control-label">Service API</label>
									<?php
										$service_api = $row['ProductAPI'];
										if(empty($service_api)) {
											?>

												<div id="api">
													<button type="button" onclick="addEditAPI();" class="btn btn-primary pull-right">Add API (If available)</button>
													<input type="hidden" value="" id="edit-service-api-link"/>
												</div>
											<?php
										} else {
											?>
												<div class="col-lg-10">
													<input type="text" class="form-control" id="edit-service-api-link" value="<?php echo($row['ProductAPI']); ?>" placeholder="http://site.com/index.php?quantity=[QUANTITY]&link=[LINK]" autocomplete="off">
												</div>
											<?php
										}
									?>
								</label>
							</div>
							<div class="form-group" id="service-edit-reseller-price">
								<label class="col-lg-2 col-sm-4 control-label">Service Reseller Price</label>
									<?php
										$service_reseller = $row['ProductResellerPrice'];
										if(empty($service_reseller)) {
											?>

												<div id="reseller">
													<button type="button" onclick="addEditReseller();" class="btn btn-primary pull-right">Add Reseller Price</button>
													<input type="hidden" value="" id="edit-service-resell-price"/>
												</div>
											<?php
										} else {
											?>
												<div class="col-lg-10">
													<div class="input-group m-bot15">
														<span class="input-group-addon"><?php echo $currency; ?></span>
														<input type="text" class="form-control" id="edit-service-resell-price" value="<?php echo($row['ProductResellerPrice']); ?>" placeholder="0.99" autocomplete="off">
													</div>
												</div>
											<?php
										}
									?>
								</label>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="edit-service" class="btn btn-info">Save Service</button>
									<button type="submit" id="edit-delete-service" class="btn btn-danger">Delete Service</button>
								</div>
							</div>
							<div id="service-result"></div>
						</form>
					</section>
				</div>
			<?php
		} else {
			$display->ReturnError('Service does not exists.');
		}
	} else {
		$display->ReturnError('Invalid GET parameter provided.');
	}
} else {
	$display->ReturnError('You do not have permissions to access this page.');
}


$html = '</div>';
$html .= '</section>';
$html .= '</div>';
$html .= '</div>';
$html .= '</section>';
$html .= '</section>';

echo $html;

require_once('./files/footer.php');
?>
