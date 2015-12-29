<?php
session_start();
$user_id = ($_SESSION['userid']);

require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['new-gallery'])) {
  $gallery_name = trim($_POST['new-gallery']);

	try {
		$check_gallery = $db->prepare('SELECT * FROM image_collection WHERE name_id = ? AND gallery = ?');
		$check_gallery->bindParam(1,$user_id);
		$check_gallery->bindParam(2,$gallery_name);
		$check_gallery->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}

	$checked_gallery = $check_gallery->rowCount();

  if ($checked_gallery == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}