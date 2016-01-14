<?php
session_start();
$user_id = ($_SESSION['userid']);
<<<<<<< HEAD
require_once('inc/config.php');
require_once('inc/database.php');
if (isset($_POST['image-name'])) {
  $image_name = trim($_POST['image-name']);
=======

require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['image-name'])) {
  $image_name = trim($_POST['image-name']);

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
	try {
		$check_name = $db->prepare('SELECT * FROM image_collection WHERE name_id = ? AND image_name = ?');
		$check_name->bindParam(1,$user_id);
		$check_name->bindParam(2,$image_name);
		$check_name->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}
<<<<<<< HEAD
	$checked_name = $check_name->rowCount();
=======

	$checked_name = $check_name->rowCount();

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
  if ($checked_name == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}