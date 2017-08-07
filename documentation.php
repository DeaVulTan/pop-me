<?php
	require_once('./files/header.php');

	$url = $settings->url();
	$key = $user->GetData('UserAPI');
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
						Create Order
						</header>
					<div class="panel-body">
						<div class="adv-table">
							<section id="unseen">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>HTTP Method</th>
											<th>API URL</th>
											<th>Response format</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>POST &amp; GET</td>
											<td><?php echo $url; ?>/api.php</td>
											<td>JSON</td>
										</tr>
									</tbody>
								</table>
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>action</th>
											<th>key</th>
											<th>order</th>
											<th>quantity</th>
											<th>link</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>order</td>
											<td>Your API Key.</br>You can find it on your profile page.</td>
											<td>Service ID.<br>You can find it on services page.</td>
											<td>Needed quantity.</td>
											<td>Link to page.</td>
										</tr>
									</tbody>
								</table>
							</section>
							<section id="unseen">
									<h4>Comments</h4>
											Deliver comments.All comments should be separated by "\r\n" or "\n".<br>
											Hashtag could be inserted in this way: <br>
											<b>api.php?key=<?php echo $key ?>...&amp;comments=Nice pic!\nGreat!\nWow!</b>
									<hr>
									<h4>Hashtag</h4>
											Hashtag could be inserted in this way: <br>
											<b>api.php?key=<?php echo $key ?>...&amp;hashtag=LikeForLike</b>
									<hr>
									<h4>Mentions</h4>
											Mentions(username) could be inserted in this way: <br>
											<b>api.php?key=<?php echo $key ?>...&amp;mentions=ArianaGrande</b>
									<hr>
							</section>
							<h2>Example Response: </h2>
							<code>
								{"order":"162"}
							</code>
							<h2>Sample GET Request: </h2>
							<code>
								<?php echo $url; ?>/api.php?key=<?php echo $key; ?>&amp;service=5&amp;quantity=1200&amp;link=MyInstagram&amp;hashtag=like4like
							</code>
						</div>
					</div>

					<header class="panel-heading">
						Check Order
						</header>
					<div class="panel-body">
						<div class="adv-table">
							<section id="unseen">
								<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>action</th>
											<th>key</th>
											<th>order</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>status</td>
											<td>Your API Key.</br>You can find it on your profile page.</td>
											<td>Order ID.<br>It will be printed on API order or could be found on orders page.</td>
										</tr>
									</tbody>
								</table>
								<h2>Example Response: </h2>
								<code>
									{"charge":"0.015","status":"In Process", "link":"http://youtube.com/some_user", "quantity":"1000"}
								</code>
							</section>
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
