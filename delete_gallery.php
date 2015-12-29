<?php
include('inc/config.php');
require_once(ROOT_PATH . 'inc/database.php');

if(isset($_POST['id']) && ($_POST['gal'])) {
  $id = $_POST['id']; 
  $gal = trim($_POST['gal']); 
  
  $sql = $db->prepare("DELETE FROM image_collection WHERE name_id = ? AND gallery = ?");
  $sql->bindParam(1,$id);    
  $sql->bindParam(2,$gal);           
  $sql->execute();                
} 
?>