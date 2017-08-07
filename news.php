<?php
	require_once('./files/header.php');
?>
<section id="main-content">
	<section class="wrapper">
		
		<!--mini statistics end-->

		<div class="row">
			<div class="col-md-12 pull-right">
					<?php
						$stmt = $pdo->prepare('SELECT * FROM news ORDER BY NewsID DESC');
						$stmt->execute();
						
						if($stmt->rowCount() > 0) {
							$html = '<div class="timeline">';
							$html .= '<article class="timeline-item alt">';
							$html .= '<div class="text-right">';
							$html .= '<div class="time-show first">';
							$html .= '<a href="#" class="btn btn-primary">News</a>';
							$html .= '</div>';
							$html .= '</div>';
							$html .= '</article>';
							
							echo $html;
							
							foreach($stmt->fetchAll() as $row){
								
								if($row['NewsID'] & 1) {
									$side = 'timeline-item alt';
								} else {
									$side = 'timeline-item';
								}
								
								$html = '<article class="'.$side.'">';
								$html .= '<div class="timeline-desk">';
								$html .= '<div class="panel">';
								$html .= '<div class="panel-body">';
								$html .= '<span class="arrow-alt"></span>';
								$html .= '<span class="timeline-icon green">';
								$html .= '<i class="fa fa-check"></i>';
								$html .= '</span>';
								$html .= '<span class="timeline-date">'.date('H:I', $row['NewsDate']).'</span>';
								$html .= '<h1 class="blue">'.date('d M, Y', $row['NewsDate']).'</h1>';
								$html .= '<p>'.$row['NewsContent'].'</p>';
								$html .= '<hr>';
								$html .= '<p>Posted by <i>'.ucfirst($user->GetDataID($row['NewsUserID'], 'UserName')).'</i>.</p>';
								$html .= '</div>';
								$html .= '</div>';
								$html .= '</div>';
								$html .= '</article>';
								
								echo $html;
							}
							
							echo '</div>';
						} else {
							$html = '<section class="panel">';
							$html .= '<header class="panel-heading">';
							$html .= 'No news available.';
							$html .= '</header>';
							$html .= '<div class="panel-body" style="overflow: hidden; display: block;">';
							$html .= 'Currently we do not have any news in our database.';
							$html .= '</div>';
							$html .= '</section>';
							
							echo $html;
						}
					?>
			</div>
		</div>
	</section>
</section>
<?php
	require_once('./files/footer.php');
?>