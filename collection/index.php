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
  <form class="form-group" action="index.php" method="post" enctype="multipart/form-data">
    <label for="image">Select image to upload:</label>
    <input type="file" name="image" id="image">
    <input type="text" name="image-name" placeholder="Name Image">
    <input type="submit" value="Upload" name="sumit">
  </form>
</div>
<?php

if  (isset($_POST['sumit'])) {
	if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
		echo "Please select an image.";
	} else {
		// addslashes prevents SQL Injection
		$image = addslashes($_FILES['image']['tmp_name']);
		$name = addslashes($_FILES['image']['name']);
		$image = file_get_contents($image);
	  $image = base64_encode($image);
	  $image_name = trim($_POST['image-name']);
    
		try {
		  $img = $db->prepare('INSERT INTO image_collection (name,image,name_id,image_name) VALUES (?,?,?,?)');
		  $img->bindParam(1,$name);
		  $img->bindParam(2,$image);
		  $img->bindParam(3,$user_id);
		  $img->bindParam(4,$image_name);
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
  $i = 0;
  // Displays Images 
  // Loops 4 Images per Row
  foreach ($get_img as $get) {
    echo '<div class="col-xs-6 col-md-3">' . 
    		 '<h3>' . htmlspecialchars($get['image_name']) . '</h3>' .
    		 '<a href="#" class="thumbnail">' .
    		 '<img src="data:image;base64,'.$get['image'].' ">' ;?>
    		 </a>
    		</div>
      <?php
			$i++;
			if ($i%4 == 0) echo '</div><div class="row">';
	} 
} catch (Exception $e) {
  echo "Data was not retrieved from the database successfully.";
  exit;
}
?>
	</div>
</div>
<?php
require_once(ROOT_PATH . 'inc/footer.php');
?>