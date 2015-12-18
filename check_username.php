<?php

require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['username'])) {
  $pre_username = trim($_POST['username']);

	try {
		$check_name = $db->prepare('SELECT username FROM user_pass WHERE username = ?');
		$check_name->bindParam(1,$pre_username);
		$check_name->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}

	$user_check = $check_name->rowCount();

  if ($user_check == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}