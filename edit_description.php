<?php 
require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  $description = $_POST['description'];

  try {
    $edit_description = $db->prepare('UPDATE image_collection SET description = ? WHERE id = ?');
    $edit_description->bindValue(1,$description);
    $edit_description->bindValue(2,$id);
    $edit_description->execute();
  } catch (Exception $e) {
    echo "Data was not retrieved from the database successfully.";
    exit;
  }

  try {
  	$grab_description = $db->prepare('SELECT description FROM image_collection WHERE id = ?');
  	$grab_description->bindValue(1,$id);
	  $grab_description->execute();
    foreach ($grab_description as $grab) {
    	$edited_description = $grab['description'];
		}
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo $edited_description; 
}
?>