<?php

require_once('./files/functions.php');

$messages = array();

if(isset($_REQUEST['key']) && !empty($_REQUEST['key']) && ctype_alnum($_REQUEST['key']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'order' &&
	(isset($_REQUEST['quantity']) && !empty($_REQUEST['quantity']) && ctype_digit($_REQUEST['quantity'])) || (isset($_REQUEST['comments']) && !empty($_REQUEST['comments']) && is_string($_REQUEST['comments'])) &&
	isset($_REQUEST['service']) && !empty($_REQUEST['service']) && ctype_digit($_REQUEST['service']) &&
	isset($_REQUEST['link']) && !empty($_REQUEST['link']) && is_string($_REQUEST['link'])) {

	$APIKey = stripslashes(strip_tags($_REQUEST['key']));
	$stmt = $pdo->prepare('SELECT * FROM users WHERE UserAPI = :UserAPI');
	$stmt->bindParam(':UserAPI', $APIKey);
	$stmt->execute();

	if($stmt->rowCount() > 0) {
		$service = strip_tags(stripslashes($_REQUEST['service']));

		$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
		$stmt->execute(array(':ProductID' => $service));

		if($stmt->rowCount() == 1) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$additional = '';

			if($row['ProductType'] == 'default' || $row['ProductType'] == 'hashtag' || $row['ProductType'] == 'mentions') {
				if(isset($_REQUEST['quantity']) && ctype_digit($_REQUEST['quantity'])) {
					$quantity = strip_tags(stripslashes($_REQUEST['quantity']));
				} else {
					echo 'Invalid quantity.';
					exit();
				}
				if($row['ProductType'] == 'hashtag') {
					if(isset($_REQUEST['hashtag']) && is_string($_REQUEST['hashtag'])) {
						$hashtag = stripslashes(strip_tags($_REQUEST['hashtag']));
						$additional = $hashtag;
					} else {
						echo 'Hashtag must be provided.';
						exit();
					}
				} else if($row['ProductType'] == 'mentions') {
					if(isset($_REQUEST['mentions']) && is_string($_REQUEST['mentions'])) {
						$mentions = stripslashes(strip_tags($_REQUEST['mentions']));
						$additional = $mentions;
					} else {
						echo 'Mentions username must be provided.';
						exit();
					}
				}
			} else if($row['ProductType'] == 'comments') {
				if(isset($_REQUEST['comments']) && is_string($_REQUEST['comments']) && strpos($_REQUEST['comments'], '\n') !== false) {
					$comments = $_REQUEST['comments'];
					$quantity = substr_count($_REQUEST['comments'], '\n') + 1;
					$additional = $comments;
				} else {
					echo '{"error":"Incorrect comments format."}';
					exit();
				}
			} else {
				echo '{"error":"Invalid product ID."}';
				exit();
			}

			$link = stripslashes(strip_tags($_REQUEST['link']));
			$time = time();
			$UserID = $user->GetData('UserID');
			$UserName = $user->GetData('UserName');
			$UserGroup = $user->GetData('UserLevel');

			$max_quantity = $row['ProductMaxQuantity'];
			$product_quantity = $row['ProductMinimumQuantity'];
			$account_balance = $user->GetData('UserFunds');

			if($quantity >= $product_quantity) {
				if($quantity <= $max_quantity) {
					if(empty($additional)) {
						$query = $pdo->prepare('SELECT * FROM orders WHERE OrderLink = :OrderLink AND OrderProductID = :OrderProductID');
						$query->execute(array(':OrderLink' => $link, ':OrderProductID' => $service));
					} else {
						$query = $pdo->prepare('SELECT * FROM orders WHERE OrderLink = :OrderLink AND OrderAdditional = :OrderAdditional AND OrderProductID = :OrderProductID');
						$query->execute(array(':OrderLink' => $link, ':OrderAdditional' => $additional, ':OrderProductID' => $service));
					}

					if($query->rowCount() > 0) {
						if($query->rowCount() == 1) {
							$query_row = $query->fetch();
							$qu_am = $query_row['OrderQuantity'];
						} else {
							$qu_am = 0;

							foreach($query->fetchAll() as $qu_row) {
								$qu_am += $qu_row['OrderQuantity'];
							}
						}
						$total = $qu_am + $quantity;
						$total_more = $max_quantity - $qu_am;

						if($total_more < 0) {
							$total_more = 0;
						}

						if($total > $max_quantity) {
							echo '{"error":"You can purchase '.$total_more.' more."}';
							exit();
						}
					}

					$stmt = $pdo->prepare('SELECT * FROM individualprices WHERE IPUserID = :IPUserID  AND IPProductID = :IPProductID');
					$stmt->execute(array(':IPUserID' => $UserID, ':IPProductID' => $service));

					if($stmt->rowCount() == 1) {
						$IPPrice = $stmt->fetch(PDO::FETCH_ASSOC);
						$newprice = $product->DeclarePrice($IPPrice['IPPrice'], $row['ProductMinimumQuantity'], $quantity);
					} else {
						if($UserGroup == 'reseller') {
							if(!empty($row['ProductResellerPrice']))
								$newprice = $product->DeclarePrice($row['ProductResellerPrice'], $row['ProductMinimumQuantity'], $quantity);
							else
								$newprice = $product->DeclarePrice($row['ProductPrice'], $row['ProductMinimumQuantity'], $quantity);
						} else {
							$newprice = $product->DeclarePrice($row['ProductPrice'], $row['ProductMinimumQuantity'], $quantity);
						}
					}
					$price = round($newprice, 2);
					if($account_balance >= $price) {
						$api = $row['ProductAPI'];

						if(!empty($api)) {
							if($row['ProductType'] == 'default' || $row['ProductType'] == 'hashtag' || $row['ProductType'] == 'mentions') {
								$api_link = str_replace('[LINK]', $link, $api);
								$api_final = str_replace('[QUANTITY]', $quantity, $api_link);

								if($row['ProductType'] == 'hashtag') {
									$api_final = str_replace('[HASHTAG]', $hashtag, $api_final);
								} else if($row['ProductType'] == 'mentions') {
									$api_final = str_replace('[USERNAME]', $mentions, $api_final);
								}
							} else if($row['ProductType'] == 'comments') {
								$api_link = str_replace('[LINK]', $link, $api);
								$api_final = str_replace('[COMMENTS]', $comments, $api_link);
							}

							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => $api_final,
								CURLOPT_USERAGENT => 'Enigma SMM API Caller'
							));

							$resp = curl_exec($curl);
							curl_close($curl);
							$resp = json_decode($resp);

							if(isset($resp->order)) {
								$order_id = $resp->order;

								$stmt = $pdo->prepare('INSERT INTO orders (OrderUserID, OrderProductID, OrderDate,
								OrderLink, OrderQuantity, OrderAmount, OrderStatus, OrderAPIID, OrderAdditional, OrderType) VALUES (:OrderUserID, :OrderProductID, :OrderDate, :OrderLink, :OrderQuantity, :OrderAmount, :OrderStatus, :OrderAPIID, :OrderAdditional, :OrderType)');

								$stmt->execute(array(':OrderUserID' => $UserID, ':OrderProductID' => $service, ':OrderDate' => $time, ':OrderLink' => $link,
								':OrderQuantity' => $quantity, ':OrderAmount' => $price, ':OrderStatus' => 'In Process', 'OrderAPIID' => $order_id, ':OrderAdditional' => $additional,
								':OrderType' => $row['ProductType']));
							} else {
								$stmt = $pdo->prepare('INSERT INTO orders (OrderUserID, OrderProductID, OrderDate, OrderLink, OrderQuantity, OrderAmount, OrderAdditional, OrderType) VALUES (:OrderUserID, :OrderProductID, :OrderDate, :OrderLink, :OrderQuantity, :OrderAmount, :OrderAdditional, :OrderType)');
								$stmt->execute(array(':OrderUserID' => $UserID, ':OrderProductID' => $service, ':OrderDate' => $time, ':OrderLink' => $link, ':OrderQuantity' => $quantity, ':OrderAmount' => $price, ':OrderAdditional' => $additional, ':OrderType' => $row['ProductType']));
							}
						} else {
							$stmt = $pdo->prepare('INSERT INTO orders (OrderUserID, OrderProductID, OrderDate, OrderLink, OrderQuantity, OrderAmount, OrderAdditional, OrderType) VALUES (:OrderUserID, :OrderProductID, :OrderDate, :OrderLink, :OrderQuantity, :OrderAmount, :OrderAdditional, :OrderType)');
							$stmt->execute(array(':OrderUserID' => $UserID, ':OrderProductID' => $service, ':OrderDate' => $time, ':OrderLink' => $link, ':OrderQuantity' => $quantity, ':OrderAmount' => $price, ':OrderAdditional' => $additional, ':OrderType' => $row['ProductType']));
						}

						$n_order_Id = $pdo->lastInsertId();

						// Take balance from user's account

						$UserFunds = $account_balance - $price;

						$stmt = $pdo->prepare('UPDATE users SET UserFunds = :UserFunds WHERE UserID = :UserID');
						$stmt->execute(array(':UserFunds' => $UserFunds, ':UserID' => $UserID));

						$ProductName = $product->GetData($service, 'ProductName');

						if(!empty($NotificationEmail)) {
							$txt = "";

							$subject = "New Service Order";
							$txt .= "+----------------------------------+\r\n";
							$txt .= "| New Service Order |\r\n";
							$txt .= "+----------------------------------+\r\n";
							$txt .= "| User ID: ".$UserID."\r\n";
							$txt .= "| User Name: ".$UserName."\r\n";
							$txt .= "| Service ID: ".$service."\r\n";
							$txt .= "| Service Name: ".$ProductName."\r\n";
							$txt .= "| Quantity: ".$quantity.".\r\n";
							$txt .= "| Link: ".$link."\r\n";
							$txt .= "| Price: ".$currency.$price."\r\n";
							$txt .= "+----------------------------------+\r\n";
							$headers = "From: purchase@".$_SERVER['SERVER_NAME']."" . "\r\n" .
							"CC: purchase@".$_SERVER['SERVER_NAME']."";

							@mail($NotificationEmail,$subject,$txt,$headers);
						}

						echo '{"order":"'.$n_order_Id.'"}';
					} else {
						echo '{"error":"Insufficient account balance."}';
					}
				} else {
					echo '{"error":"Maximum quantity: '.$max_quantity.'"}';
				}
			} else {
				echo '{"error":"Minimum quantity '.$product_quantity.'."}';
			}
		} else {
			echo '{"error":"Invalid product ID"}.';
		}
	} else {
		echo('{"error":"Unknwon API key"}');
	}
} else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'status' && isset($_REQUEST['order']) && ctype_digit($_REQUEST['order']) &&
	isset($_REQUEST['key']) && !empty($_REQUEST['order'])) {
		$stmt = $pdo->prepare('SELECT * FROM users WHERE UserAPI = :UserAPI');
		$stmt->execute(array(':UserAPI' => $_REQUEST['key']));

		if($stmt->rowCount() == 1) {
			$user_row = $stmt->fetch();
			$UserID = $user_row['UserID'];

			$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID AND OrderUserID = :OrderUserID');
			$stmt->execute(array(':OrderID' => $_REQUEST['order'], ':OrderUserID' => $UserID));

			if($stmt->rowCount() == 1) {
				$order_row = $stmt->fetch();
				if(empty($row['OrderAPIID'])) {
					$status = $row['OrderStatus'];
					$start_count = $row['OrderStartCount'];
					$remains = 0;
				} else if($row['OrderStatus'] == 'In Process') {
					$stmt = $pdo->prepare('SELECT * FROM products WHERE ProductID = :ProductID');
					$stmt->execute(array(':ProductID' => $row['OrderProductID']));
					$service_api = $stmt->fetch();

					$parts = parse_url($service_api['ProductAPI']);
					parse_str($parts['query'], $query);
					$api_key = $query['key'];

					$current_url = explode("?", $service_api['ProductAPI']);
					$url = $current_url[0].'?key='.$api_key.'&action=status&order='.$row['OrderAPIID'];

					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => $url,
						CURLOPT_USERAGENT => 'Enigma SMM API Caller'
					));

					$resp = curl_exec($curl);
					curl_close($curl);

					$response = json_decode($resp);
					if(isset($response->status))
						$status = $response->status;
					else
						$status = $row['OrderStatus'];

					if(isset($response->remains))
						$remains = $response->remains;
					else
						$remains = 0;
					if(empty($row['OrderStartCount']) && $row['OrderStartCount'] == 0) {
						if(isset($response->start_count))
							$start_count = $response->start_count;
						else
							$start_count = 0;
					} else {
							$start_count = $row['OrderStartCount'];
					}

					if(!empty($row['OrderStartCount']) && isset($response->start_count)) {
						$start_count = $row['OrderStartCount'];
					}

					if($status == 'Completed') {
						$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Completed" WHERE OrderID = :OrderID');
						$stmt->execute(array(':OrderID' => $row['OrderID']));
					} else if($status == 'Canceled') {
						$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Removed" WHERE OrderID = :OrderID');
						$stmt->execute(array(':OrderID' => $row['OrderID']));
					}
				} else {
					$status = $row['OrderStatus'];
					$start_count = $row['OrderStartCount'];
					$remains = 0;
				}

				echo('{"charge":"'.$order_row['OrderAmount'].'",
				"status":"'.$status.'",
				"link":"'.$order_row['OrderLink'].'",
				"quantity":"'.$order_row['OrderQuantity'].'",
				"start_count":"'.$start_count.'",
				"remains":"'.$remains.'"');
			} else {
				echo('{"error":"Unknwon order id"}');
			}
		} else {
			echo('{"error":"Unknwon API key"}');
		}
} else {
	echo '{"error":"Incorrect request.Current requests: order &amp; status."}';
}
