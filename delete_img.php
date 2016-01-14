<?php
include('inc/config.php');
require_once(ROOT_PATH . 'inc/database.php');
<<<<<<< HEAD
if(isset($_POST['id'])) {
	$id = $_POST['id']; 
	
	try {
	  $sql = $db->prepare("DELETE FROM image_collection WHERE id = ?");
	  $sql->bindParam(1,$id);
	  $sql->execute();
  } catch (Exception $e) {
		echo 'Data could not be retrieved from the database.';
		exit;
	}
=======

if(isset($_POST['id'])) {
  $id = $_POST['id'];  
  $sql = $db->prepare("DELETE FROM image_collection WHERE id = ?");
  $sql->bindParam(1,$id, PDO::PARAM_INT);
  $sql->execute();
>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
}
?>