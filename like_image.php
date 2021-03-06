<?php 

require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 

  try {
  	$like = $db->prepare('SELECT likes FROM image_collection WHERE id = ?');
  	$like->bindValue(1,$id);
	  $like->execute();
    foreach ($like as $lk) {
    	$liked = $lk['likes'];
    	$liked++;
      try {
			  $like_img = $db->prepare('UPDATE image_collection SET likes = ? WHERE id = ?');
			  $like_img->bindValue(1,$liked);
			  $like_img->bindValue(2,$id);
			  $like_img->execute();
		  } catch (Exception $e) {
				echo "Data was not retrieved from the database successfully.";
			  exit;
		  }
		}
    
	} catch (Exception $e) {
		echo "Data was not retrieved from the database successfully.";
	  exit;
  }
 echo "success";
}
?>