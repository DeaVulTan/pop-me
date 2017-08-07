<?php
	session_start();
	
	if(isset($_SESSION['auth'])) {
		unset($_SESSION['auth']);
		header('Location: ./');
		exit();
	} else {
		header('Location: ./');
		exit();
	}
?>
