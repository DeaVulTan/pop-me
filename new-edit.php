<?php

require_once('./files/header.php');

$html = '<section id="main-content">';
$html .= '<section class="wrapper">';
$html .= '<div class="row">';
$html .= '<div class="col-sm-12">';
$html .= '<section class="panel">';
$html .= '<header class="panel-heading">';
$html .= 'Edit New Panel';
$html .= '<span class="tools pull-right">';
$html .= '<a href="javascript:;" class="fa fa-chevron-down"></a>';
$html .= '<a href="javascript:;" class="fa fa-times"></a>';
$html .= '</span>';
$html .= '</header>';
$html .= '<div class="panel-body">';

echo $html;
$UserLevel = $user->GetData('UserLevel');
if($UserLevel == 'admin') {
	if(isset($_GET['new-id']) && !empty($_GET['new-id']) && ctype_digit($_GET['new-id'])) {
		$NewID = $_GET['new-id'];
		
		$stmt = $pdo->prepare('SELECT * FROM news WHERE NewsID = :NewsID');
		$stmt->bindParam(':NewsID', $NewID);
		$stmt->execute();
		
		if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			?>
			
				<div class="col-md-10">
					<section class="panel">
						<form method="POST" class="form-horizontal" role="form">
							<input type="hidden" value="<?php echo $NewID; ?>" id="edit-new-id">
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">New Title</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" value="<?php echo $row['NewsTitle']; ?>" id="edit-new-title" placeholder="New Title" autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">New Content</label>
								<div class="col-lg-10">
									<textarea class="form-control" rows="10" id="edit-new-content" placeholder="New Content" required><?php echo $row['NewsContent']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="edit-new" class="btn btn-info">Save</button>
									<button type="submit" id="edit-delete-new" class="btn btn-danger">Delete</button>
								</div>
							</div>
							<div id="new-result"></div>
						</form>
					</section>
				</div>
			<?php
		} else {
			$display->ReturnError('New does not exists.');
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