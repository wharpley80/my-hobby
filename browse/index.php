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
	
	if ($action == 'old-select') {
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
		  	<label id="gal" for="gallery">Select Gallery:</label>
		    <?php
		    $cols = $db->prepare('SELECT DISTINCT(gallery) FROM image_collection WHERE privacy = "public" ORDER BY gallery ASC'); 
		    $cols->bindParam(1,$user_id);
		    $cols->execute();?>
		    <select class="form-control" id="return" name="gallery">
		      <option selected disabled>Select</option>
		      <?php foreach ($cols as $col) { 
		      				if (trim($col['gallery']) != "") { ?>
		              <option value="<?php echo htmlspecialchars($col['gallery']); ?>" 
		              <?php if ( $col['gallery'] == "$prev") echo ' selected="selected"'; ?>>
		                <?php echo htmlspecialchars($col['gallery']); ?></option>
		      	<?php } 
		    				} ?>
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
  <div class="modal fade modal" id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="title-name"></h3>
				</div>
	      <div class="modal-body" id="my-body">
	      	<img src="" id="imagepreview" class="img-responsive">
	      </div>
	      <div class="modal-body">
	      	<p id="modal-description"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      	</div>
	    </div>
	  </div>
	</div> 
</div>
<?php
 if ($prev !== "Select") {?>
	<div class="container-fluid">
		<?php echo  
					'<div class="container"><span data-gal=' . json_encode($prev) . '>' .
						'<h1 class="gallery-name">' . htmlspecialchars($prev) . '</span>' . ' ' . '</h1>' . 
					'</div>';
		?>
		<div class="row" id="browse-row">
			<?php
			// Grabs selected Gallery to Browse
			try {
			  $get_img = $db->prepare('SELECT * FROM image_collection WHERE gallery = ? 
			  	 AND image_name IS NOT NULL ORDER BY id DESC');
			  $get_img->bindValue(1,$prev);
			  $get_img->execute();
			  $i = 0;
			  // Displays Images 
			  // Loops 4 Images per Row
			  foreach ($get_img as $get) {
			  	$myname = $get['image_name'];
			    echo  
          '<div class="col-xs-6 col-md-3"><span data-id=' . $get['id'] . '>' . 
    		  	'<h3>' . htmlspecialchars($get['image_name']) .  '</span>' . '</h3>' .
	    		  '<a href="#" id="name" class="thumbnail" data-toggle="modal"><span data-id=' . $get['id'] . '></span>' .
		    		  '<img class="show-img" id="imageresource' . $get['id'] . '" src="data:image;base64,' . $get['image'] . '">' . 
    		  		'<p>' . htmlspecialchars($get['description']) . '</p>' .
		    		  '<a href="#" class="like-img pull-left"><span data-id=' . $get['id'] .
		    		  ' class="glyphicon glyphicon-thumbs-up"></span>' . ' Like
		    		  <span id="liked_' . $get['id'] . '_likes">' . $get['likes'] . '</span>
		    		  </a>' .
		          /*
		          '<a href="#" class="view-img pull-right"><span  data-id=' . $get['id'] . 
		          ' class="glyphicon glyphicon-eye-open"></span>' . ' View
		    		  <span id="viewed_' . $get['id'] . '_views">' . $get['views'] . '</span></a>' .
	            */
  		  		'</a>' .	
  				'</div>';
    			$i++;
    			if ($i%2 == 0) echo '<div class="clearfix visible-xs"></div>';
					if ($i%4 == 0) echo '</div><div class="row" id="browse-row">';
				} 
			} catch (Exception $e) {
			  echo "Data was not retrieved from the database successfully.";
			  exit;
			}
			?>
		</div>
	</div>
<?php } ?>
<div class="container">
	<div class="row" id="browse-row">
		<?php
		// Searches for Specific Names
		if (!empty($search)) { ?>
			<div class="container">
				<h1 class="gallery-name">Search Results</h1>
			</div>
			<?php
			try {
			  $get_search = $db->prepare('SELECT * FROM image_collection WHERE privacy = "public" AND image_name LIKE ? OR privacy = "public" AND description LIKE ?');
			  $get_search->bindValue(1, "%" . $search . "%");
			  $get_search->bindValue(2, "%" . $search . "%");
			  $get_search->execute();
			  $j = 0;
			  // Displays Images 
			  // Loops 4 Images per Row
			  foreach ($get_search as $searched) {
			    echo 
			    '<div class="col-xs-6 col-md-3"><span data-id=' . $searched['id'] . '>' . 
	    			'<h3>' . htmlspecialchars($searched['image_name']) .  '</span>' . '</h3>' .
	    		 	'<a href="#" class="thumbnail" data-toggle="modal"><span data-id=' . $searched['id'] . '></span>' .	    		 
	    		  	'<img class="show-img" id="imageresource' . $searched['id'] . '" src="data:image;base64,'.$searched['image'].' ">' .	    		 
	    		    '<p>' . htmlspecialchars($searched['description']) . '</p>' .
	    		 		'<a href="#" class="like-img pull-left"><span data-id=' . $searched['id'] .
	    		  		' class="glyphicon glyphicon-thumbs-up"></span>' . ' Like
	    		  		<span id="liked_' . $searched['id'] . '_likes">' . $searched['likes'] . '</span>
	    		  	 </a>' . 
	    		  '</a>' .
    		  '</div>';
				  $j++;
			    if ($j%2 == 0) echo '<div class="clearfix visible-xs"></div>';
			    if ($j%4 == 0) echo '</div><div class="row" id="browse-row">';			
				} 
			} catch (Exception $e) {
			  echo "Data was not retrieved from the database successfully.";
			  exit;
			}
		}
		?>
	</div>
</div>
<?php require_once(ROOT_PATH . 'inc/footer.php'); ?>