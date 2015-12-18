<?php

require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['email-SI'])) {
  $valid_email = trim($_POST['email-SI']);

  try {
    $validate_email = $db->prepare('SELECT email FROM user_pass WHERE email = ?');
    $validate_email->bindValue(1,$valid_email);
    $validate_email->execute();
  } catch (Exception $e) {
    echo "Data was not retrieved from the database successfully.";
    exit;
  }

  $email_valid = $validate_email->rowCount();

  if ($email_valid == 0) {
		$valid_email = "false";
	} else {
		$valid_email = "true";
	}

	echo $valid_email;
}