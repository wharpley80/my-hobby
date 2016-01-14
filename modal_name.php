<?php 
require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  try {
  	$title = $db->prepare('SELECT image_name FROM image_collection WHERE id = ?');
  	$title->bindValue(1,$id);
	  $title->execute();
    foreach ($title as $mt) {
    	$modal_name = $mt['image_name'];
		}
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo $modal_name;
}
?>