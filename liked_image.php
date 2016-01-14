<?php
session_start();
require_once('inc/config.php');
require_once('inc/database.php');
<<<<<<< HEAD
if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  try {
    $like = $db->prepare('SELECT likes FROM image_collection WHERE id = ?');
    $like->bindValue(1,$id);
    $like->execute();
    foreach ($like as $lk) {
      $liked = $lk['likes'];
    }
  } catch (Exception $e) {
    echo "Data was not retrieved from the database successfully.";
    exit;
=======

if(isset($_POST['id'])) {
  $id = $_POST['id']; 

  try {
  	$like = $db->prepare('SELECT likes FROM image_collection WHERE id = ?');
  	$like->bindValue(1,$id);
	  $like->execute();
	  foreach ($like as $lk) {
    	$liked = $lk['likes'];
    }
  } catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
  }
  echo $liked;
}
?>