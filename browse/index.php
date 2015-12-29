<?php
session_start();
require_once('../inc/config.php');
require_once(ROOT_PATH . 'inc/header.php');
require_once(ROOT_PATH . 'inc/database.php');

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	
	if ($action == 'new-select') {
		$prev = $_REQUEST['new-gallery'];
	
	} elseif ($action == 'old-select') {
		$prev = $_REQUEST['gallery'];
	}
	
} else {
$prev = "Ballparks";	
}
?>

<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h2 class="panel-title">Browse Collections and get Inspired!!!</h2>
		</div>
	  <div class="panel-body">
		  <form class="form-inline" method="POST" enctype="multipart/form-data">
		  	<div>
			  	<label for="gallery">Select Gallery</label>
			    <?php
			    $cols = $db->prepare('SELECT DISTINCT(gallery) FROM image_collection ORDER BY gallery ASC'); 
			    $cols->bindParam(1,$user_id);
			    $cols->execute();?>
			    <select class="form-control" id="return" name="gallery">
			      <option selected disabled>Select</option>
			      <?php foreach ($cols as $col) { ?>
			              <option value="<?php echo htmlspecialchars($col['gallery']); ?>" 
			              <?php if ( $col['gallery'] == "$prev") echo ' selected="selected"'; ?>>
			                <?php echo htmlspecialchars($col['gallery']); ?></option>
			      <?php } ?>
			    </select>
			    <input type="hidden" name="action" value="old-select">
			    <input type="submit" class="btn btn-primary btn-md" name="submit" value="Select">
		  	</div>
		  </form>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
<?php
try {
  $get_img = $db->prepare('SELECT * FROM image_collection WHERE gallery = ?');
  $get_img->bindValue(1,$prev);
  $get_img->execute();
  $i = 0;
  // Displays Images 
  // Loops 4 Images per Row
  foreach ($get_img as $get) {
    echo '<div class="col-xs-6 col-md-3"><span data-id=' . $get['id'] . '>' . 
    		 '<h3>' . htmlspecialchars($get['image_name']) .  '</span>' . '</h3>' .
    		 '<a href="#" class="thumbnail">' .
    		 '<img src="data:image;base64,'.$get['image'].' ">' .
    		 '<p>' . htmlspecialchars($get['description']) . '</p>' ;?>
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