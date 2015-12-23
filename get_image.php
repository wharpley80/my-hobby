<?php
/*
session_start();

$user_id = ($_SESSION['userid']);

require_once('inc/config.php');
require_once('inc/database.php');

function show_img($user_id) {
  require(ROOT_PATH . 'inc/database.php');
	
	try {
	  $get_img = $db->prepare('SELECT * FROM image_collection WHERE name_id = ?');
	  $get_img->bindValue(1,$user_id);
	  $get_img->execute();
	  foreach ($get_img as $get) {
	    $show_img = $get['image'];
	    return $show_img;
	  }
	} catch (Exception $e) {
	  echo "Data was not retrieved from the database successfully.";
	  exit;
	}
}

header("Content-type: image/jpg");

echo show_img($user_id);
*/

require_once('inc/config.php');
require_once('inc/database.php');

$id = addslashes($_REQUEST['id']);

$get_img = $db->prepare('SELECT * FROM image_collection WHERE id = ?');
$get_img->bindValue(1,$id);
$get_img->execute();

$get_img = mysql_fetch_assoc($get_img);
$get_img = $get_img['image'];

header("Content-type: image/jpeg");

echo $get_img;
?>