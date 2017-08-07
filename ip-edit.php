<?php

require_once('./files/header.php');

$html = '<section id="main-content">';
$html .= '<section class="wrapper">';
$html .= '<div class="row">';
$html .= '<div class="col-sm-12">';
$html .= '<section class="panel">';
$html .= '<header class="panel-heading">';
$html .= 'Edit Individual Prices Panel';
$html .= '<span class="tools pull-right">';
$html .= '<a href="javascript:;" class="fa fa-chevron-down"></a>';
$html .= '<a href="javascript:;" class="fa fa-times"></a>';
$html .= '</span>';
$html .= '</header>';
$html .= '<div class="panel-body">';

echo $html;
$UserLevel = $user->GetData('UserLevel');
if($UserLevel == 'admin') {
	if(isset($_GET['ip-id']) && !empty($_GET['ip-id']) && ctype_digit($_GET['ip-id'])) {
		$IPID = $_GET['ip-id'];
		
		$stmt = $pdo->prepare('SELECT * FROM individualprices WHERE IPID = :IPID');
		$stmt->bindParam(':IPID', $IPID);
		$stmt->execute();
		
		if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$UserName = $user->GetDataID($row['IPUserID'], 'UserName');
			$ProductName = $product->GetData($row['IPProductID'], 'ProductName');
			$Price = $row['IPPrice'];
			?>
				<div class="col-md-10">
					<section class="panel">
						<form method="POST" class="form-horizontal" role="form">
							<input type="hidden" value="<?php echo $IPID; ?>" id="edit-ip-id">
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">User Name</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $UserName; ?>" id="edit-ip-username" placeholder="User Name" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Service</label>
								<div class="col-lg-10">
									<select class="form-control" id="edit-ip-service">
										<option selected="true" value="<?php echo $row['IPProductID']; ?>" style="display:none;"><?php echo $ProductName; ?></option>
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
								<label class="col-lg-2 col-sm-4 control-label">Price</label>
								<div class="col-lg-10">
									<div class="input-group m-bot15">
										<span class="input-group-addon">$</span>
										<input type="number" id="edit-ip-price" class="form-control" value="<?php echo $Price; ?>" placeholder="0.99" autocomplete="off" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="edit-ip" class="btn btn-info">Save</button>
									<button type="submit" id="edit-delete-ip" class="btn btn-danger">Delete</button>
								</div>
							</div>
							<div id="ip-result"></div>
						</form>
					</section>
				</div>
			<?php
		} else {
			$display->ReturnError('Individual price does not exists.');
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