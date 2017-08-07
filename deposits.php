<?php
	require_once('./files/header.php');
?>
<link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<section id="main-content">
	<section class="wrapper">
		<?php
			$stmt = $pdo->prepare('SELECT * FROM news ORDER BY NewsID DESC LIMIT 1');
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="mini-stat clearfix">
							<span>
								<?php
									foreach($stmt->fetchAll() as $row) {
										echo '<a href="news.php"><strong style="font-size: 14px; color: #1ca59e;">'.$row['NewsTitle'].'</strong></a>';
										echo '<br>';
										echo $row['NewsContent'];
										echo '<hr>';
									}
								?>
							</span>
						</div>
					</div>
				</div>
				<?php
			}
		?>
		<!--mini statistics end-->
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">
						Account Deposits -  History
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span>
					</header>
					<div class="panel-body">
						<?php
							$UserID = $user->GetData('UserID');

							$stmt = $pdo->prepare('SELECT * FROM deposits WHERE DepositUserID = :DepositUserID');
							$stmt->execute(array(':DepositUserID' => $UserID));

							if($stmt->rowCount() > 0) {
						?>
						<div class="adv-table">
							<section id="unseen">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>Deposit ID</th>
											<th>Deposit Amount (<?php echo $currency_name; ?>)</th>
											<th>Deposit Transaction ID</th>
											<th>Service Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$html = '';

											foreach($stmt->fetchAll() as $row) {
												$deposit = round($row['DepositAmount'], 2);

												$html .= '<tr>';
												$html .= '<td>'.$row['DepositID'].'</td>';
												$html .= '<td>'.$currency.$deposit.'</td>';
												$html .= '<td>'.$row['DepositVerification'].'</td>';
												$html .= '<td>'.date('d.m.Y H:i', $row['DepositDate']).'</td>';
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
								$display->ReturnInfo('There are no account balance deposits.');
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
