<?php
session_start();
$user_id = ($_SESSION['userid']);
<<<<<<< HEAD
require_once('inc/config.php');
require_once('inc/database.php');
if (isset($_POST['new-gallery'])) {
  $gallery_name = trim($_POST['new-gallery']);
=======

require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['new-gallery'])) {
  $gallery_name = trim($_POST['new-gallery']);

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
	try {
		$check_gallery = $db->prepare('SELECT * FROM image_collection WHERE gallery = ?');
		$check_gallery->bindParam(1,$gallery_name);
		$check_gallery->execute();
	} catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}
<<<<<<< HEAD
	$checked_gallery = $check_gallery->rowCount();
=======

	$checked_gallery = $check_gallery->rowCount();

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
  if ($checked_gallery == 0) {
		$valid = "true";
	} else {
		$valid = "false";
	}
	echo $valid;
}