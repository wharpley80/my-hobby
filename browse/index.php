<?php
session_start();

$thisPage = "browse";
require_once('../inc/config.php');
require_once(ROOT_PATH . 'inc/header.php');
require_once(ROOT_PATH . 'inc/database.php');

if (isset($_POST['search'])) {
	$search = trim($_POST['search']);
}

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	
	if ($action == 'new-select') {
		$prev = $_REQUEST['new-gallery'];
	
	} elseif ($action == 'old-select') {
		$prev = $_REQUEST['gallery'];
	}
	
} else {
$prev = "Select";	
}
?>

<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading" id="head">
	    <h2 class="panel-title" id="name">Browse Collections or Search and Get Inspired!!!</h2>
		</div>
	  <div class="panel-body">
		  <form class="form-inline" method="POST">
		  	<label for="gallery">Select Gallery:</label>
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
		  </form>
		  <form class="form-inline" method="POST">
		  	<label for="search">Search for Specifics:</label>
        <input type="text" name="search" class="search" placeholder="Search">
		    <input type="submit" class="btn btn-primary btn-md" name="submit" value="Search">
		  </form>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
<?php
// Grabs selected Gallery to Browse
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
<div class="container">
	<div class="row">
<?php

if (!empty($search)) {
	// Searches for Specific Names
	try {
	  $get_search = $db->prepare('SELECT * FROM image_collection WHERE image_name LIKE ? OR description LIKE ?');
	  $get_search->bindValue(1, "%" . $search . "%");
	  $get_search->bindValue(2, "%" . $search . "%");
	  $get_search->execute();
	  $j = 0;
	  // Displays Images 
	  // Loops 4 Images per Row
	  foreach ($get_search as $searched) {
	    echo '<div class="col-xs-6 col-md-3"><span data-id=' . $searched['id'] . '>' . 
	    		 '<h3>' . htmlspecialchars($searched['image_name']) .  '</span>' . '</h3>' .
	    		 '<a href="#" class="thumbnail">' .
	    		 '<img src="data:image;base64,'.$searched['image'].' ">' .
	    		 '<p>' . htmlspecialchars($searched['description']) . '</p>' ;?>
	    		 </a>
	    		 
	    		</div>
	      <?php
				$j++;
				if ($j%4 == 0) echo '</div><div class="row">';
		} 
	} catch (Exception $e) {
	  echo "Data was not retrieved from the database successfully.";
	  exit;
	}
}
?>
	</div>
</div>
<?php
require_once(ROOT_PATH . 'inc/footer.php');
?>