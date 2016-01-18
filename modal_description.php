<?php 
require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  try {
  	$description = $db->prepare('SELECT description FROM image_collection WHERE id = ?');
  	$description->bindValue(1,$id);
	  $description->execute();
    foreach ($description as $desc) {
    	$modal_description = $desc['description'];
		}
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo $modal_description;
}
?>