<?php
	require_once('./files/header.php');
?>
<section id="main-content">
	<section class="wrapper">
	<!-- Support Page -->

		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Send support ticket to our system administrators.
					</header>
					<div class="panel-body">
						<form class="form-horizontal bucket-form" method="POST">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="input-group">
										<span class="input-group-addon"><li class="fa fa-font"></li></span>
										<input type="text" id="ticket-title" placeholder="Ticket Title" value="<?php if(isset($_POST['custom_title'])) echo $_POST['custom_title']; ?>" class="form-control" required autocomplete="off">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="input-group">
										<span class="input-group-addon"><li class="fa fa-list"></li></span>
										<textarea id="ticket-message" class="form-control" rows="3" placeholder="Ticket Message" required><?php if(isset($_POST['custom_comment'])) { echo $_POST['custom_comment']; } ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group pull-right">
								<div class="col-lg-12">
									<button type="submit" id="open-ticket" class="btn btn-success">Open Ticket</button>
								</div>
							</div>
						</form>
						<div id="support-result"></div>
					</div>
				</section>
			</div>

			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Support Tickets
					</header>
					<div class="panel-body">
						<?php
							$UserID = $user->GetData('UserID');

							$stmt = $pdo->prepare('SELECT * FROM support WHERE SupportUserID = :SupportUserID ORDER BY SupportID DESC');
							$stmt->bindParam(':SupportUserID', $UserID);
							$stmt->execute();

							if($stmt->rowCount() > 0) {
						?>
							<section id="unseen">
								<table class="table table-striped table-hover table-bordered" id="editable-sample">
									<thead>
										<tr>
											<th>Ticket Title</th>
											<th>Ticket Message</th>
											<th>Ticket Date</th>
											<th>Ticket Reply</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$html = '';
											foreach($stmt->fetchAll() as $row) {
												if(empty($row['SupportReply'])) {
													$reply = '<i>Waiting for reply..</i>';
												} else {
													$reply = $row['SupportReply'];
												}
												$html .= '<tr class="">';
												$html .= '<td>'.$row['SupportTitle'].'</td>';
												$html .= '<td>'.$row['SupportMessage'].'</td>';
												$html .= '<td>'.date('d M, Y h:I:s', $row['SupportDate']).'</td>';
												$html .= '<td>'.$reply.'</td>';
												$html .= '</tr>';
											}

											echo $html;
										?>
									</tbody>
								</table>
							</section>
						<?php
							} else {
								$display->ReturnInfo('There are no opened tickets for your account.');
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
<script>
$(document).ready(function() {
	$('#bitcoin').click(function() {
		var amount = $('#amount').val();
		var dataString = 'action=bitcoin-deposit&amount='+amount;

		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			success: function(data){
				if(data) {
					$('#result').html(data);
				}
			}
		});

		return false;
	});
});
</script>
