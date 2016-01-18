<?php 
require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  $name = $_POST['name'];

  try {
    $edit_name = $db->prepare('UPDATE image_collection SET image_name = ? WHERE id = ?');
    $edit_name->bindValue(1,$name);
    $edit_name->bindValue(2,$id);
    $edit_name->execute();
  } catch (Exception $e) {
    echo "Data was not retrieved from the database successfully.";
    exit;
  }

  try {
  	$grab_name = $db->prepare('SELECT image_name FROM image_collection WHERE id = ?');
  	$grab_name->bindValue(1,$id);
	  $grab_name->execute();
    foreach ($grab_name as $grab) {
    	$edited_name = $grab['image_name'];
		}
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo $edited_name;
}
?>