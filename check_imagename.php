<?php
session_start();
$user_id = ($_SESSION['userid']);
require_once('inc/config.php');
require_once('inc/database.php');
if (isset($_POST['image-name'])) {
  $image_name = trim($_POST['image-name']);
	try {
		$check_name = $db->prepare('SELECT * FROM image_collection WHERE name_id = ? AND image_name = ?');
		$check_name->bindParam(1,$user_id);
		$check_name->bindParam(2,$image_name);
		$check_name->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}
	$checked_name = $check_name->rowCount();
  if ($checked_name == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}