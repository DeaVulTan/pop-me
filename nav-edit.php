<?php

require_once('./files/header.php');

$html = '<section id="main-content">';
$html .= '<section class="wrapper">';
$html .= '<div class="row">';
$html .= '<div class="col-sm-12">';
$html .= '<section class="panel">';
$html .= '<header class="panel-heading">';
$html .= 'Edit Navigation Link Panel';
$html .= '<span class="tools pull-right">';
$html .= '<a href="javascript:;" class="fa fa-chevron-down"></a>';
$html .= '<a href="javascript:;" class="fa fa-times"></a>';
$html .= '</span>';
$html .= '</header>';
$html .= '<div class="panel-body">';

echo $html;
$UserLevel = $user->GetData('UserLevel');
if($UserLevel == 'admin') {
	if(isset($_GET['nav-id']) && !empty($_GET['nav-id']) && ctype_digit($_GET['nav-id'])) {
		$NavID = $_GET['nav-id'];
		
		$stmt = $pdo->prepare('SELECT * FROM navigation WHERE NavigationID = :NavigationID');
		$stmt->bindParam(':NavigationID', $NavID);
		$stmt->execute();
		
		if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			?>
			
				<div class="col-md-10">
					<section class="panel">
						<form method="POST" class="form-horizontal" role="form">
							<input type="hidden" value="<?php echo $NavID; ?>" id="nav-id">
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Navigation Text</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="nav-text" value="<?php echo($row['NavigationText']); ?>" placeholder="Navigation Text" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Navigation URL</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="nav-url" value="<?php echo($row['NavigationURL']); ?>" placeholder="Navigation URL" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-4 control-label">Navigation Icon</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="nav-icon" value="<?php echo($row['NavigationIcon']); ?>" placeholder="fa fa-user (Will display user icon)" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" id="edit-nav" class="btn btn-info">Save</button>
									<button type="submit" id="edit-delete-nav" class="btn btn-danger">Delete</button>
								</div>
							</div>
							<div id="nav-result"></div>
						</form>
					</section>
				</div>
			<?php
		} else {
			$display->ReturnError('Navigation link does not exists.');
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