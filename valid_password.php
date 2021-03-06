<?php
require_once('inc/config.php');
require_once('inc/database.php');
if (isset($_POST['email-SI']) && isset($_POST['password-SI'])) {
	$valid_email = trim($_POST['email-SI']);
	$valid_password = trim($_POST['password-SI']);
	$valid_password = hash("sha256", $valid_password);
	try {
      $validate_pass = $db->prepare('SELECT username FROM user_pass WHERE email = ? AND password = ?');
      $validate_pass->bindParam(1,$valid_email);
			$validate_pass->bindParam(2,$valid_password);
      $validate_pass->execute();
   } catch (Exception $e) {
      echo 'Data could not be retrieved from the database 25.';
      exit;
   }
	
   $pass_valid = $validate_pass->rowCount();
	 if ($pass_valid == 0) {
		$valid_pass = "false";
	 } else {
		$valid_pass = "true";
	 }
	 echo $valid_pass;
}