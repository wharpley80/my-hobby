<?php
session_start();

$user_id = ($_SESSION['userid']);

require_once('../inc/config.php');
require_once(ROOT_PATH . 'inc/header.php');
require_once(ROOT_PATH . 'inc/database.php');

// Grabs Username of the individual Signed In.
function yourname($user_id) {
  require(ROOT_PATH . 'inc/database.php');
	try {
		$user = $db->prepare('SELECT username FROM user_pass WHERE id = ?');
	  $user->bindParam(1,$user_id);
	  $user->execute();
	  foreach ($user as $usr) {
	    $users = $usr['username'];
	    return $users;
	  }
	} catch (Exception $e) {
		echo "Data could not be retrieved from the database.";
	  exit;
	}
}

$your_name = yourname($user_id);

?>
<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?php echo  htmlspecialchars($your_name); ?></h3>
	  </div>
	  <div class="panel-body">
	  </div>
	</div>
  <form action="index.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="image" id="image">
    <input type="submit" value="Upload" name="sumit">
  </form>
</div>
<?php

if  (isset($_POST['sumit'])) {
	if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
		echo "Please select an image.";
	} else {
		$image = addslashes($_FILES['image']['tmp_name']);
		$image_name = addslashes($_FILES['image']['name']);
		$image = file_get_contents($image);
	  $image = base64_encode($image);

		try {
		  $img = $db->prepare('INSERT INTO image_collection (name,image,name_id) VALUES (?,?,?)');
		  $img->bindParam(1,$image_name);
		  $img->bindParam(2,$image);
		  $img->bindParam(3,$user_id);
		  $img->execute();
		  echo "<br />Image Uploaded.";
		} catch (Exception $e) {
		  echo "<br />Image Not Uploaded.";
		  exit;
		}
	}
}
?>
<div class="container">
	<div class="row">
<?php
try {
  $get_img = $db->prepare('SELECT * FROM image_collection WHERE name_id = ?');
  $get_img->bindValue(1,$user_id);
  $get_img->execute();
  foreach ($get_img as $get) {
    echo '<div class="col-xs-6 col-md-3">' . 
    		 '<a href="#" class="thumbnail">' .
    		 '<img height="300" width="300" src="data:image;base64,'.$get['image'].' ">' .
    		 '</a>' .
    		 '</div>';
  }
} catch (Exception $e) {
  echo "Data was not retrieved from the database successfully.";
  exit;
}

?>
	</div>
</div>
<!--
<div class="container">
	<div class="row">
	  <div class="col-xs-6 col-md-3">
	    <a href="#" class="thumbnail">
	      <img src="../img/DSC_0501 (1).JPG">
	    </a>
	  </div>
	  <div class="col-xs-6 col-md-3">
	    <a href="#" class="thumbnail">
	      <img src="../img/DSC_0075.JPG">
	    </a>
	  </div>
	  <div class="col-xs-6 col-md-3">
	    <a href="#" class="thumbnail">
	      <img src="../img/DSC_0228.JPG">
	    </a>
	  </div>
	  <div class="col-xs-6 col-md-3">
	    <a href="#" class="thumbnail">
	      <img src="../img/DSC_0501.JPG">
	    </a>
	  </div>
	</div>
</div>
-->
<?php
require_once(ROOT_PATH . 'inc/footer.php');
?>