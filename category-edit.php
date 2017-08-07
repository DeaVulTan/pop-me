<?php

require_once('./files/header.php');

$html = '<section id="main-content">';
$html .= '<section class="wrapper">';
$html .= '<div class="row">';
$html .= '<div class="col-sm-12">';
$html .= '<section class="panel">';
$html .= '<header class="panel-heading">';
$html .= 'Edit Category Panel';
$html .= '<span class="tools pull-right">';
$html .= '<a href="javascript:;" class="fa fa-chevron-down"></a>';
$html .= '<a href="javascript:;" class="fa fa-times"></a>';
$html .= '</span>';
$html .= '</header>';
$html .= '<div class="panel-body">';

echo $html;
$UserLevel = $user->GetData('UserLevel');
if($UserLevel == 'admin') {
	if(isset($_GET['category-id']) && !empty($_GET['category-id']) && ctype_digit($_GET['category-id'])) {
		$CategoryID = strip_tags(stripslashes($_GET['category-id']));
		
		$stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryID = :CategoryID');
		$stmt->bindParam(':CategoryID', $CategoryID);
		$stmt->execute();
		
		if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			?>
			
				<div class="col-md-10">
					<section class="panel">
						<form method="POST" class="form-horizontal" role="form">
							<input type="hidden" value="<?php echo $CategoryID; ?>" id="edit-category-id">
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Category Name</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $row['CategoryName']; ?>" id="edit-category-name" placeholder="Category Name" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Category Description</label>
								<div class="col-lg-10">
									<textarea class="form-control" rows="3" id="edit-category-description" placeholder="Category Description" required><?php echo $row['CategoryDescription'] ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="edit-category" class="btn btn-info">Add</button>
									<button type="submit" id="edit-delete-category" class="btn btn-danger">Delete Category</button>
								</div>
							</div>
							<div id="category-result"></div>
						</form>
					</section>
				</div>
			<?php
		} else {
			$display->ReturnError('Category does not exists.');
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