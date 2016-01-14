<?php

require_once('inc/config.php');
require_once('inc/database.php');

if(isset($_POST['id'])) {
  $id = $_POST['id']; 

  $get_img = $db->prepare('SELECT image FROM image_collection WHERE id = ?');
  $get_img->bindValue(1,$id);
  $get_img->execute();

  foreach ($get_img as $img) {
  	$image = $img['image'];
    $image = base64_decode($image);
	  $path = ($image ['tmp_name']);  // This path set to img/rotate.jpeg on GoDaddy
	  $image = file_put_contents($path, $image);
	  $degrees = -90;
    $source = imagecreatefromjpeg($path);
		$rotate = imagerotate($source, $degrees, 0);
		imagejpeg($rotate, $path);
		$image = file_get_contents($path);
	  $image = base64_encode($image);
  }

  $upd_img = $db->prepare('UPDATE image_collection SET image = ? WHERE id = ?');
  $upd_img->bindValue(1,$image);
  $upd_img->bindValue(2,$id);
  $upd_img->execute();

  fopen($path, 'w+');
	echo "success";
}
?>
