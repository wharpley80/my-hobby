<?php
session_start();

require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
	$user_id = ($_SESSION['userid']);
	$angle = 90;

	try {
	  $get_img = $db->prepare('SELECT image FROM image_collection WHERE id = ');
	  $get_img->bindValue(1,$id);
	  $get_img->execute();
    $filename = imagecreatefromstring(base64_decode($get_img[0]["image"])) ;
	  function RotateImg($filename,$angle)	{
    	$rotate = imagerotate($filename, $angle, 0);
    	return $rotate;
    }
	} catch (Exception $e) {
	  echo "Data was not retrieved from the database successfully.";
	  exit;
	}
  
  $image = base64_encode(RotateImg($filename,$angle));
	
	try {
	  $upd_img = $db->prepare('UPDATE image_collection SET image = ? WHERE id = ?');
	  $upd_img->bindValue(1,$image);
	  $upd_img->bindValue(2,$id);
	  $upd_img->execute();
	} catch (Exception $e) {
	  echo "Data was not retrieved from the database successfully.";
	  exit;
	}
}
?>

	