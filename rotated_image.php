<?php

require_once('inc/config.php');
require_once('inc/database.php');
if(isset($_POST['id'])) {
  $id = $_POST['id']; 
  try {
    $rot = $db->prepare('SELECT image FROM image_collection WHERE id = ?');
    $rot->bindValue(1,$id);
    $rot->execute();
    foreach ($rot as $r) {
      $rotated = $r['image'];
    }
    echo $rotated;
  } catch (Exception $e) {
    echo "Data was not retrieved from the database successfully.";
    exit;
  }
}
?>