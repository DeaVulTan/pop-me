// CLEAR USER INPUTS [CREATE USER (ADMINISTRATION.PHP)] //

function clearResult()
{
	$('#result').html('');
	
	$('#user-name').val('');
	$('#user-first-name').val('');
	$('#user-last-name').val('');
	$('#user-email').val('');
	$('#user-password').val('');
	$('#user-funds').val('0');
	$('#new-title').val('');
	$('#new-content').val('');
}


// EDIT USER //


$(document).ready(function() {
	$('#edit-user').click(function() {
		var user_id = $('#edit-user-id').val();
		var first_name = $('#edit-user-first-name').val();
		var last_name = $('#edit-user-last-name').val();
		var user_name = $('#edit-user-name').val();
		var email = $('#edit-user-email').val();
		var group = $('#edit-user-level').val();
		var funds = $('#edit-user-funds').val();
		
		var dataString = 'action=edit-user&user-id='+user_id+'&user-first-name='+first_name+'&user-last-name='+last_name+'&user-name='+user_name+'&user-email='+email+'&user-level='+group+'&user-funds='+funds;
		
		if($.trim(user_name).length > 0 && $.trim(first_name).length > 0 && $.trim(last_name).length > 0 && $.trim(funds).length > 0 && $.trim(email).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){
					$("#result").val('Updating user row..');
				},
				success: function(data){
					if(data) {
						$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">Your profile was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});


// USER PASSWORD RECOVERY //

$(document).ready(function()  {
	$('#reset').click(function() {
	var username = $("#username").val();
	var email = $("#email").val();
	
	var dataString = 'action=reset'+'&username='+username+'&email='+email;
	
	if($.trim(username).length > 0 && $.trim(email).length > 0) {
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#result').html('<div class="btn btn-danger">'+data+'</div>');
				} else {
					$('#result').html('<div class="btn btn-success">Your password was successfully reset.Check your email for more details.</div>');
				}
			}
		});
	} else {
		$('#result').html('<div class="btn btn-danger">Fill all fields correctly.</div>');
	}
	return false;
	});
});

// BAN USER //


$(document).ready(function() {
	$('#edit-ban-user').click(function() {
		var user_id = $('#edit-user-id').val();
		
		var dataString = 'action=ban-user&user-id='+user_id;
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){
				$("#result").val('Updating user row..');
			},
			success: function(data){
				if(!data) {
					$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">User account has been terminated.</div>');
				} else {
					$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				}
			}
		});
		
		return false;
	});
});

$(document).ready(function() {
	$('#edit-unban-user').click(function() {
		var user_id = $('#edit-user-id').val();
		
		var dataString = 'action=unban-user&user-id='+user_id;
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){
				$("#result").val('Updating user row..');
			},
			success: function(data){
				if(!data) {
					$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">User account has been unterminated.</div>');
				} else {
					$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				}
			}
		});
		
		return false;
	});
});


// DELETE USER //


$(document).ready(function() {
	$('#edit-delete-user').click(function() {
		var user_id = $('#edit-user-id').val();
		
		var dataString = 'action=delete-user&user-id='+user_id;
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){
				$("#result").val('Updating user row..');
			},
			success: function(data){
				if(!data) {
					$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">User account has been deleted.</div>');
				} else {
					$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				}
			}
		});
		
		return false;
	});
});

// DELETE NEW //


$(document).ready(function() {
	$('#edit-delete-new').click(function() {
		var user_id = $('#edit-new-id').val();
		
		var dataString = 'action=delete-new&new-id='+user_id;
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){
				$("#new-result").val('Updating new row..');
			},
			success: function(data){
				if(!data) {
					$('#new-result').html('<div class="btn btn-success" style="margin-top: 5px;">New has been deleted.</div>');
				} else {
					$('#new-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				}
			}
		});
		
		return false;
	});
});

// EDIT NEW //


$(document).ready(function() {
	$('#edit-new').click(function() {
		var new_id = $('#edit-new-id').val();
		var new_title = $('#edit-new-title').val();
		var new_content = $('#edit-new-content').val();
		
		var dataString = 'action=edit-new&new-id='+new_id+'&new-title='+new_title+'&new-content='+new_content;
		
		if($.trim(new_title).length > 0 && $.trim(new_content).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){
					$("#new-result").val('Updating user row..');
				},
				success: function(data){
					if(data) {
						$('#new-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#new-result').html('<div class="btn btn-success" style="margin-top: 5px;">New was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#new-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});


// CREATE USER //


$(document).ready(function() {
	$('#create-user').click(function() {
		var user_name = $('#user-name').val();
		var first_name = $('#user-first-name').val();
		var last_name = $('#user-last-name').val();
		var email = $('#user-email').val();
		var password = $('#user-password').val();
		var level = $('#user-level').val();
		var funds = $('#user-funds').val();
		
		var dataString = 'action=create-user'+'&user-name='+user_name+'&user-first-name='+first_name+'&user-last-name='+last_name+'&user-email='+email+'&user-password='+password+'&user-level='+level+'&user-funds='+funds;
		
		if($.trim(user_name).length > 0 && $.trim(funds).length > 0 && $.trim(first_name).length > 0 && $.trim(last_name).length > 0 && $.trim(email).length > 0 && $.trim(password).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){
					$("#result").val('User is inserting to server database..');
				},
				success: function(data){
					if(data) {
						$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">User successfully created.</div>');
					}
				}
			});
		} else {
			$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields correctly.</div>');
		}
		
		return false;
	});
});

// ADD NEW //

$(document).ready(function() {
	$('#add-new').click(function() {
		var new_title = $('#new-title').val();
		var new_content = $('#new-content').val();
		
		var dataString = 'action=add-new'+'&new-title='+new_title+'&new-content='+new_content;
		
		if($.trim(new_title).length > 0 && $.trim(new_content).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){
					$("#result").val('New is inserting to server database..');
				},
				success: function(data){
					if(data) {
						$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#result').html('<div class="btn btn-success" style="margin-top: 5px;">New successfully have been added.</div>');
					}
				}
			});
		} else {
			$('#result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields correctly.</div>');
		}
		
		return false;
	});
});


// UPLOAD AVATAR //


$(document).ready(function (e) {
	$("#avatar-form").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "responds.php",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				if(data) {
					$("#result").html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$("#result").html('<div class="btn btn-success" style="margin-top: 5px;">Avatar updated successfully.</div>');
				}
			},
			error: function() {
				$("#result").html('<div class="btn btn-danger" style="margin-top: 5px;">There was an error.</div>');
			} 	        
	   });
	}));
});

// UPDATE USER ACCOUNT //

$(document).ready(function() {
	$('#update-information').click(function() {
		var first_name = $('#first-name').val();
		var last_name = $('#last-name').val();
		var email = $('#email').val();
		var password = $('#account-password').val();
		
		var dataString = 'action=profile-update'+'&first-name='+first_name+'&last-name='+last_name+'&email='+email+'&password='+password;
		
		if($.trim(first_name).length > 0 && $.trim(last_name).length > 0 && $.trim(email).length > 0 && $.trim(password).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#account-update-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#account-update-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#account-update-result').html('<div class="btn btn-success" style="margin-top: 5px;">Your profile was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#account-update-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// CREATE CATEGORY //

$(document).ready(function() {
	$('#create-category').click(function() {
		var category_name = $('#category-name').val();
		var category_description = $('#category-description').val();
		
		var dataString = 'action=create-category'+'&category-name='+category_name+'&category-description='+category_description;
		
		if($.trim(category_name).length > 0 && $.trim(category_description).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#category-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#category-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#category-result').html('<div class="btn btn-success" style="margin-top: 5px;">Category was successfully created.</div>');
					}
				}
			});
		} else {
			$('#category-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});


// SERVICE CREATE //

$(document).ready(function() {
	$('#create-service').click(function() {
		var service_name = $('#service-name').val();
		var service_description = $('#service-description').val();
		var service_quantity = $('#service-minimum-quantity').val();
		var service_price = $('#service-price-per-quantity').val();
		var service_category = $('#service-category').val();
		var service_api = $('#service-api-link').val();
		var service_resell = $('#service-resell-price').val();
		
		var dataString = 'action=create-service'+'&service-name='+service_name+'&service-description='+service_description+'&service-quantity='+service_quantity+'&service-price='+service_price+'&service-category='+service_category+'&service-api='+service_api+'&service-reseller-price='+service_resell;
		
		if($.trim(service_name).length > 0 && $.trim(service_description).length > 0 && $.trim(service_quantity).length > 0 && $.trim(service_price).length > 0 && $.trim(service_category).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#service-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#service-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#service-result').html('<div class="btn btn-success" style="margin-top: 5px;">Service was successfully created.</div>');
					}
				}
			});
		} else {
			$('#service-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// SERVICE EDIT //

$(document).ready(function() {
	$('#edit-service').click(function() {
		var service_id = $('#edit-service-id').val();
		var service_name = $('#edit-service-name').val();
		var service_description = $('#edit-service-description').val();
		var service_quantity = $('#edit-service-minimum-quantity').val();
		var service_price = $('#edit-service-price').val();
		var service_category = $('#edit-service-category').val();
		var service_api = encodeURIComponent($('#edit-service-api-link').val());
		var service_resell = $('#edit-service-resell-price').val();
		
		var dataString = 'action=edit-service&service-id='+service_id+'&service-name='+service_name+'&service-description='+service_description+'&service-quantity='+service_quantity+'&service-price='+service_price+'&service-category='+service_category+'&service-api='+service_api+'&service-reseller-price='+service_resell;
		
		if($.trim(service_name).length > 0 && $.trim(service_description).length > 0 && $.trim(service_quantity).length > 0 && $.trim(service_price).length > 0 && $.trim(service_category).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#service-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#service-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#service-result').html('<div class="btn btn-success" style="margin-top: 5px;">Service was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#service-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// DELETE SERVICE //

$(document).ready(function() {
	$('#edit-delete-service').click(function() {
		var service_id = $('#edit-service-id').val();
		
		var dataString = 'action=delete-service&service-id='+service_id;
		
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#service-result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#service-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$('#service-result').html('<div class="btn btn-success" style="margin-top: 5px;">Service was deleted successfully.</div>');
				}
			}
		});
		
		return false;
	});
});

// CATEGORY EDIT //

$(document).ready(function() {
	$('#edit-category').click(function() {
		var category_id = $('#edit-category-id').val();
		var category_name = $('#edit-category-name').val();
		var category_description = $('#edit-category-description').val();
		
		var dataString = 'action=edit-category&category-id='+category_id+'&category-name='+category_name+'&category-description='+category_description;
		
		if($.trim(category_name).length > 0 && $.trim(category_description).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#category-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#category-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#category-result').html('<div class="btn btn-success" style="margin-top: 5px;">Category was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#category-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// DELETE CATEGORY //

$(document).ready(function() {
	$('#edit-delete-category').click(function() {
		var category_id = $('#edit-category-id').val();
		
		var dataString = 'action=delete-category&category-id='+category_id;
		
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#category-result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#category-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$('#category-result').html('<div class="btn btn-success" style="margin-top: 5px;">Category was deleted successfully.</div>');
				}
			}
		});
		
		return false;
	});
});

// ADD INDIVIDUAL PRICE //

$(document).ready(function() {
	$('#add-ip').click(function() {
		var user_name = $('#ip-username').val();
		var service = $('#ip-service').val();
		var price = $('#ip-price').val();
		var dataString = 'action=add-individual-price&ip-username='+user_name+'&ip-service='+service+'&ip-price='+price;
		
		if($.trim(user_name).length > 0 && $.trim(service).length > 0 && $.trim(price).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#ip-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#ip-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#ip-result').html('<div class="btn btn-success" style="margin-top: 5px;">Individual price was successfully added.</div>');
					}
				}
			});
		} else {
			$('#ip-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// EDIT INDIVIDUAL PRICE //

$(document).ready(function() {
	$('#edit-ip').click(function() {
		var id = $('#edit-ip-id').val();
		var user_name = $('#edit-ip-username').val();
		var service = $('#edit-ip-service').val();
		var price = $('#edit-ip-price').val();
		var dataString = 'action=edit-individual-price&ip-username='+user_name+'&ip-service='+service+'&ip-price='+price+'&ip-id='+id;
		
		if($.trim(user_name).length > 0 && $.trim(service).length > 0 && $.trim(price).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#ip-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#ip-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#ip-result').html('<div class="btn btn-success" style="margin-top: 5px;">Individual price was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#ip-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// DELETE INDIVIDUAL PRICE //

$(document).ready(function() {
	$('#edit-delete-ip').click(function() {
		var ip_id = $('#edit-ip-id').val();
		
		var dataString = 'action=delete-ip&ip-id='+ip_id;
		
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#ip-result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#ip-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$('#ip-result').html('<div class="btn btn-success" style="margin-top: 5px;">Individual price was deleted successfully.</div>');
				}
			}
		});
		
		return false;
	});
});

// OPEN TICKET //

$(document).ready(function() {
	$('#open-ticket').click(function() {
		var ticket_title = $('#ticket-title').val();
		var ticket_message = $('#ticket-message').val();
		
		var dataString = 'action=open-ticket&ticket-title='+ticket_title+'&ticket-message='+ticket_message;
		
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#support-result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#support-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$('#support-result').html('<div class="btn btn-success" style="margin-top: 5px;">Ticket was opened successfully.Please wait till your ticket being viewed.</div>');
				}
			}
		});
		
		return false;
	});
});

// UPDATE USER PASSWORD //

$(document).ready(function() {
	$('#update-password').click(function() {
		var current_password = $('#current-password').val();
		var new_password = $('#new-password').val();
		
		var dataString = 'action=password-update'+'&current-password='+current_password+'&new-password='+new_password;
		
		if($.trim(current_password).length > 0 && $.trim(new_password).length > 0) {
			$.ajax({
				type: "POST",
				url: "responds.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#account-password-result").val('Connecting...');},
				success: function(data){
					if(data) {
						$('#account-password-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
					} else {
						$('#account-password-result').html('<div class="btn btn-success" style="margin-top: 5px;">Your account password was successfully updated.</div>');
					}
				}
			});
		} else {
			$('#account-password-result').html('<div class="btn btn-danger" style="margin-top: 5px;">Fill all fields.</div>');
		}
		
		return false;
	});
});

// MERCHANT //

$(document).ready(function() {
	$('#save-merchant').click(function() {
		var website_name = $('#website-name').val();
		var recovery_email = $('#recovery-email').val();
		var paypal_email = $('#merchant-paypal-email').val();
		var skrill_email = $('#merchant-skrill-email').val();
		var skrill_secret = $('#merchant-skrill-secret').val();
		
		var dataString = 'action=save-merchant&website-name='+website_name+'&recovery-email='+recovery_email+'&paypal-email='+paypal_email+'&skrill-email='+skrill_email+'&skrill-secret='+skrill_secret;
		
		$.ajax({
			type: "POST",
			url: "responds.php",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#merchant-result").val('Connecting...');},
			success: function(data){
				if(data) {
					$('#merchant-result').html('<div class="btn btn-danger" style="margin-top: 5px;">'+data+'</div>');
				} else {
					$('#merchant-result').html('<div class="btn btn-success" style="margin-top: 5px;">All changes were successfully saved.</div>');
				}
			}
		});
		
		return false;
	});
});

// ORDER REQUESTS //


function func(selectedValue) {
	var dataString = 'action=get-products'+'&option='+selectedValue;
	
	$('#service').html('');
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString,
		success: function(data) {
			$('#service').append(' <option selected="true" style="display:none;">Click to choose service.</option>');
			$('#service').append(data);
			$('#mininmum-quantity').html();
		}
	});
}

function quantity(selectedValue) {
	var dataString = 'action=product-details&details=ProductMinimumQuantity&product-id='+selectedValue;
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString,
		success: function(data) {
			$('#minimum-quantity').html(data);
			document.getElementById('product-quantity').value=data;
			var GetPrice = 'action=get-amount&quantity='+data+'&service='+selectedValue;
			
			$.ajax({
				url: "responds.php",
				type: "POST",
				data: GetPrice,
				cache: false,
				success: function(data) {
					if(data) {
						if(data == 'Invalid quantity.') {
							$('#order-service-price').val('Not enough quantity.');
							$('#minimum-price').html('0');
						} else {
							$('#order-service-price').val(data);
							$('#minimum-price').html(data);
						}
					}
				}       
		   });
		}
	});
}

function updateOrderStatus(OrderID) {
	var orderStatus = document.getElementById("change-order-status-"+OrderID).value;
	var dataString = 'action=update-order-status&order-status='+orderStatus+'&order-id='+OrderID;
	
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString
	});
}

function replyTicket(TicketID) {
	var ticketReply = document.getElementById("ticket-reply-"+TicketID).value;
	var dataString = 'action=reply-ticket&ticket-id='+TicketID+'&ticket-reply='+ticketReply;
	
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString
	});
	
	alert('Ticket replied.');
}

function deleteTicket(TicketID) {
	var dataString = 'action=delete-ticket&ticket-id='+TicketID;
	
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString
	});
	
	$('#ticket-'+TicketID).remove();   
}
function deleteLogs() {
	var dataString = 'action=delete-logs';
	
	$.ajax({
		url: 'responds.php',
		type: 'POST',
		data: dataString
	});
	
	location.reload();
}

function addAPI() {
	$('#api').remove();
	$('#service-api').html('<label class="col-lg-2 col-sm-4 control-label">Service API</label><div class="col-lg-10"><input type="text" class="form-control" id="service-api-link" placeholder="http://site.com/index.php?quantity=[QUANTITY]&link=[LINK]" autocomplete="off"></div>');
}
function addEditAPI() {
	$('#api').remove();
	$('#service-edit-api').html('<label class="col-lg-2 col-sm-4 control-label">Service API</label><div class="col-lg-10"><input type="text" class="form-control" id="edit-service-api-link" placeholder="http://site.com/index.php?quantity=[QUANTITY]&link=[LINK]" autocomplete="off"></div>');
}

/* Reseller Button */
function addReseller() {
	$('#reseller').remove();
	$('#service-reseller').html('<label class="col-lg-2 col-sm-4 control-label">Service Reseller Price</label><div class="col-lg-10"><div class="input-group m-bot15"><input type="number" class="form-control" id="service-resell-price" placeholder="0.99" value="0.99" autocomplete="off"></div></div>');
}

function addEditReseller() {
	$('#reseller').remove();
	$('#service-edit-reseller-price').html('<label class="col-lg-2 col-sm-4 control-label">Service Reseller Price</label><div class="col-lg-10"><div class="input-group m-bot15"><span class="input-group-addon">$</span><input type="number" class="form-control" id="edit-service-resell-price" placeholder="0.99" value="0.99" autocomplete="off"></div></div>');
}