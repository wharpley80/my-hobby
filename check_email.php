<?php
require_once('inc/config.php');
require_once('inc/database.php');
if (isset($_POST['email'])) {
  $pre_email = trim($_POST['email']);
	try {
		$check_email = $db->prepare('SELECT email FROM user_pass WHERE email = ?');
		$check_email->bindParam(1,$pre_email);
		$check_email->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}
	$email_check = $check_email->rowCount();
  if ($email_check == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}