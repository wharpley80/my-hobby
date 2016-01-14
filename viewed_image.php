<?php 

require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 

  try {
  	$view = $db->prepare('SELECT views FROM image_collection WHERE id = ?');
  	$view->bindValue(1,$id);
	  $view->execute();
    foreach ($view as $vw) {
    	$viewed = $vw['views'];
    }
  } catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo $viewed;
}
?>