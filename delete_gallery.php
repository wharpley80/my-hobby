<?php
include('inc/config.php');
require_once(ROOT_PATH . 'inc/database.php');
<<<<<<< HEAD
=======

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
if(isset($_POST['id']) && ($_POST['gal'])) {
  $id = $_POST['id']; 
  $gal = trim($_POST['gal']); 
  
  $sql = $db->prepare("DELETE FROM image_collection WHERE name_id = ? AND gallery = ?");
  $sql->bindParam(1,$id);    
  $sql->bindParam(2,$gal);           
  $sql->execute();                
} 
?>