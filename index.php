<?php
	require_once('./files/header.php');
?>
<section id="main-content">
	<section class="wrapper">
	<!-- Purchase Page -->

		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						New Order
						</header>
					<div class="panel-body">
						<div id="wizard">
							<h2 id="wizard-h-0" tabindex="-1" class="title current">Select Category</h2>
							<section id="wizard-p-0" role="tabpanel" aria-labelledby="wizard-h-0" class="body current" aria-hidden="false" style="display: block;">
								<form class="form-horizontal" id="select-service">
									<div class="form-group">
										<label class="col-lg-2 control-label">Category</label>
										<div class="col-lg-8">
											<select class="form-control" name="category" onchange="func(this.value)">
												<option selected="true" style="display:none;">Select a category.</option>
												<?php
													$stmt = $pdo->prepare('SELECT * FROM categories');
													$stmt->execute();

													$html = '';
													while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
														$html .= '<option value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>';
													}

													echo $html;
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Service</label>
										<div class="col-lg-8">
											<select class="form-control" name="service" id="service" onchange="quantity(this.value)">
												 <option selected="true" style="display:none;">Please select a category.</option>
											</select>
										</div>
									</div>
								</form>
							</section>

							<h2 id="wizard-h-1" tabindex="-1" class="title">Order Options</h2>
							<section id="wizard-p-1" role="tabpanel" aria-labelledby="wizard-h-1" class="body pre-scrollable" style="overflow-x: hidden;" aria-hidden="true" style="display: none;">
								<form class="form-horizontal" id="select-options">
									<div id="order-options">
										<div id="quantity_input" class="form-group">
											<label class="col-lg-2 control-label">Quantity</label>
											<div class="col-lg-8">
												<input type="number" value="1000" id="product-quantity" class="spinner-input form-control" placeholder="Select Amount" autocomplete="off">
												<span class="help-block">
													<?php echo $currency; ?><span id="minimum-price">0</span> / <span id="minimum-quantity">0</span>.
												 </span>
											</div>
										</div>
										<div id="comments_input" class="form-group">
											<div class='form-group'>
												<label class='col-lg-2 control-label'>Comments</label>
												<div class='col-lg-8'>
														<textarea id="product-comments" class='form-control' placeholder='Comments, separated by &#92;r&#92;n or &#92;n'></textarea>
													</div>
											</div>
										</div>
										<div id="mentions_input" class="form-group">
											<label class="col-lg-2 control-label">Username</label>
											<div class="col-lg-8">
												<input type="text" id="product-mentions" class="spinner-input form-control" placeholder="Username" autocomplete="off">
											</div>
										</div>
										<div id="hashtag_input" class="form-group">
											<label class="col-lg-2 control-label">Hashtag</label>
											<div class="col-lg-8">
												<input type="text" id="product-hashtag" class="spinner-input form-control" placeholder="#Hashtag" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Link</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" placeholder="Link" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Price</label>
										<div class="col-lg-8">
											<div class="input-group m-bot15">
												<span class="input-group-addon"><?php echo $currency; ?></span>
												<input type="text" id="order-service-price" value="0" class="form-control" required readonly>
											</div>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-lg-2"></label>
										<div class="col-lg-8">
											<button type="button" class="btn btn-success" id="pre-order">Submit Order.</button>
										</div>
									</div>

									<div id="order-status"></div>
								</form>
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
<script>
	$(document).ready(function() {
		$('#product-quantity').on('input', function() {
			var service = $('#service').val();
			var current_quantity = $(this).val();
			var GetPrice = 'action=get-amount&quantity='+current_quantity+'&service='+service;

			$.ajax({
				url: "responds.php",
				type: "POST",
				data: GetPrice,
				cache: false,
				success: function(data) {
					if(data) {
						if(data == 'Invalid quantity.') {
							$('#order-service-price').val('Not enough quantity.');
						} else {
							$('#order-service-price').val(data);
						}
					} else {
						$('#order-service-price').val('There was an error.');
					}
				}
		   });
		});

		$('#product-comments').on('input', function() {
				var service = $('#service').val();
				var dataString = 'action=product-details&details=ProductType&product-id='+service;

				$.ajax({
					url: 'responds.php',
					type: 'POST',
					data: dataString,
					success: function(order_type) {
						if(order_type) {
							if(order_type == 'comments') {
								var comments = document.getElementById("select-options").elements[1].value;
								var GetOrderPrice = 'action=get-amount&comments='+comments+'&service='+service;

								$.ajax({
									url: 'responds.php',
									type: 'POST',
									data: GetOrderPrice,
									success: function(data) {
										if(data) {
											if(data == 'Invalid quantity.') {
												$('#order-service-price').val('Not enough quantity.');
											} else {
												$('#order-service-price').val(data);
											}
										}
									}
								});
							} else {
								return;
							}
						} else {
							return;
						}
					}
				});
		});

		$('#pre-order').click(function() {
			var service = document.getElementById("select-service").elements[1].value;
			var dataString = 'action=product-details&details=ProductType&product-id='+service;
			var link = document.getElementById("select-options").elements[4].value;
			var price;

			$.ajax({
				url: 'responds.php',
				type: 'POST',
				data: dataString,
				success: function(order_type) {
					if(order_type) {
						if(order_type == 'default') {
						  var quantity = document.getElementById("select-options").elements[0].value;
						  var dataString = 'action=create-order&service='+service+'&quantity='+quantity+'&link='+link;
						  var GetOrderPrice = 'action=get-amount&quantity='+quantity+'&service='+service;
						} else if(order_type == 'comments') {
						  var comments = document.getElementById("select-options").elements[1].value;
						  var dataString = 'action=create-order&service='+service+'&link='+link+'&comments='+comments;
						  var GetOrderPrice = 'action=get-amount&comments='+comments+'&service='+service;
						} else if(order_type == 'hashtag') {
						  var quantity = document.getElementById("select-options").elements[0].value;
						  var hashtag = document.getElementById("select-options").elements[3].value;
						  var dataString = 'action=create-order&service='+service+'&quantity='+quantity+'&link='+link+'&hashtag='+hashtag;
						  var GetOrderPrice = 'action=get-amount&quantity='+quantity+'&service='+service;
						} else if(order_type == 'mentions') {
						  var quantity = document.getElementById("select-options").elements[0].value;
						  var mentions = document.getElementById("select-options").elements[2].value;
						  var dataString = 'action=create-order&service='+service+'&quantity='+quantity+'&link='+link+'&mentions='+mentions;
						  var GetOrderPrice = 'action=get-amount&quantity='+quantity+'&service='+service;
						}

						$.ajax({
						  url: "responds.php",
						  type: "POST",
						  data: GetOrderPrice,
						  cache: false,
						  success: function(data) {
						    if(data) {
						      if(!isNaN(data)) {
						        price = data;

						        $.ajax({
						          url: "responds.php",
						          type: "POST",
						          data: dataString,
						          cache: false,
						          beforeSend: function(){
						            $('#order-status').html('<div class="alert alert-info fade in">Order is preparing to being submitted..</div>');
						          },
						          success: function(data) {
						            if(data) {
						              if(data == 'API: Success') {
						                $('#order-status').html('<div class="alert alert-success fade in">Order is successfully submitted.Your order is being processed.</div>');

														var takeBalance = 'action=get-user-balance';
														$.ajax({
															type: "POST",
															url: "responds.php",
															data: takeBalance,
															cache: false,
															success: function(data){
																if(data) {
																	$("#current-balance").html(data);
																}
															}
														});
						              } else {
						                $('#order-status').html('<div class="alert alert-danger fade in">'+data+'</div>');
						              }
						            } else {
						              $('#order-status').html('<div class="alert alert-success fade in">Order is successfully submitted and it will be reviewed by our website administrators.</div>');

													var takeBalance = 'action=get-user-balance';
													$.ajax({
														type: "POST",
														url: "responds.php",
														data: takeBalance,
														cache: false,
														success: function(data){
															if(data) {
																$("#current-balance").html(data);
															}
														}
													});
						            }
						          }
						         });
						      } else {
						        $('#order-status').html('<div class="alert alert-danger fade in">Order quantity is lower or higher than the required quantity.</div>');
						      }
						    } else {
						      $('#order-status').html('<div class="alert alert-danger fade in">Order quantity is lower or higher than the required quantity.</div>');
						    }
						  }
						});
					}
				}
			});
		});
	});
</script>
