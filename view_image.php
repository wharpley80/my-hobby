<?php 
<<<<<<< HEAD
=======

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 
<<<<<<< HEAD
=======

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
  try {
  	$view = $db->prepare('SELECT views FROM image_collection WHERE id = ?');
  	$view->bindValue(1,$id);
	  $view->execute();
    foreach ($view as $vw) {
    	$viewed = $vw['views'];
    	$viewed++;
      try {
			  $like_img = $db->prepare('UPDATE image_collection SET views = ? WHERE id = ?');
			  $like_img->bindValue(1,$viewed);
			  $like_img->bindValue(2,$id);
			  $like_img->execute();
		  } catch (Exception $e) {
				echo "Data was not retrieved from the database successfully.";
			  exit;
		  }
		}
<<<<<<< HEAD
=======

>>>>>>> df4bbfe9a9e6bc2fbb1b3e28815a8efb8f5c0951
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
  echo "success";
}
?>