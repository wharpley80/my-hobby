<?php
session_start();

$user_id = ($_SESSION['userid']);
$thisPage = "collection";
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

// Adds a New Gallery
if (isset($_POST['new-submit'])) {
  $new_gallery = trim($_POST['new-gallery']);
  $gallery_type = $_POST['gallery-type'];
  $privacy = $_POST['optionsRadios'];
  
  if (!empty($new_gallery)) { 
    try {
      $list = $db->prepare('INSERT INTO image_collection (name_id,gallery,gallery_type,privacy) VALUES(?,?,?,?)');
      $list->bindParam(1,$user_id);
      $list->bindParam(2,$new_gallery);
      $list->bindParam(3,$gallery_type);
      $list->bindParam(4,$privacy);
      $list->execute();
    } catch (Exception $e) {
      echo 'Data was not submitted to the database successfully.';
      exit;
    }
  } 
}
// Sets Gallery Name to variable
if (isset($_POST['gallery'])) { 
	$gallery_name = $_POST['gallery'];
}
// Renames a Gallery
if (isset($_POST['rename'])) {
  $rename = trim($_POST['rename']);
  
  if (!empty($rename)) { 
		try {
			$change = $db->prepare('UPDATE image_collection SET gallery = ? WHERE name_id = ?');
			$change->bindParam(1,$rename);
			$change->bindParam(2,$user_id);
			$change->execute();
		} catch (Exception $e) {
			echo 'Data was not submitted to the database successfully.';
			exit;
		}
  } 
}
// Uploads Images to Database
if  (isset($_POST['sumit']) && isset($_FILES['image'])) {
    $file_temp = $_FILES['image']['tmp_name'];

	if (getimagesize($file_temp) == FALSE) {
		echo "Please select an image.";
	
	} else {
		// addslashes prevents SQL Injection
		// Sets a tmp Path for the file
    //move_uploaded_file($_FILES['upload']['tmp_name'], "img/");
    $image = addslashes($_FILES['image']['tmp_name']);	
		$image = file_get_contents($image);
	  $image = base64_encode($image);
	  $image_name = trim($_POST['image-name']);
	  $description = trim($_POST['description']);

	  try {
	  	$priv = $db->prepare('SELECT DISTINCT(privacy) FROM image_collection WHERE gallery = ?');
	  	$priv->bindParam(1,$gallery_name);
	  	$priv->execute();  	
	  	foreach ($priv as $prv) {
	  		$privac = $prv['privacy'];
		  }
		} catch (Exception $e) {
      echo "Error accessing privacy from database.";
		  exit;
	  }

		try {
		  $img = $db->prepare('INSERT INTO image_collection (name,image,name_id,image_name,gallery,description,privacy) 
		  	VALUES (?,?,?,?,?,?,?)');
		  $img->bindParam(1,$name);
		  $img->bindParam(2,$image);
		  $img->bindParam(3,$user_id);
		  $img->bindParam(4,$image_name);
		  $img->bindParam(5,$gallery_name);
		  $img->bindParam(6,$description);
		  $img->bindParam(7,$privac);
		  $img->execute();
		  echo '<p class="alert alert-success" role="alert">Image Uploaded Successfully!</p>';
		} catch (Exception $e) {
      echo '<p class="alert alert-danger" role="alert">Image Not Uploaded!</p>';
		  exit;
		}
	}
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
	  	<?php echo  
	  				'<div><span data-id=' . $user_id . '>' . 
	  					'<h2 class="panel-title" id="name">' . htmlspecialchars($your_name) . '</span>' . ' ' . '</h2>' .
				    	'<a class="btn btn-danger btn-sm pull-right" id="logout" href="' . BASE_URL . 'index.php">Log Out &amp Save</a>' .
            '</div>'; 
      ?>
		</div>
	  <div class="panel-body">
	  	<form class="form-inline" id="gallery-form" method="POST">
	  		<div class="form-group">
		  		<label for="new-gallery">Start New Hobby or Collection Gallery:</label>
		  		<input type="hidden" name="action" value="new-select">
		  		<input type="text" name="new-gallery" class="new-gallery" placeholder="Gallery Name">
		  		<label for="gallery-type">Select Type of Gallery:</label>
		  		<select class="form-control" name="gallery-type" class="gallery-type">
		  			<option selected disabled>Choose</option>
					  <option>Antiques</option>
					  <option>Arts</option>
					  <option>Automotive</option>
					  <option>Cards</option>
					  <option>Coins</option>
					  <option>Comics</option>
					  <option>Crafts</option>
					  <option>Destinations</option>
					  <option>Dolls</option>
					  <option>Figurines</option>
					  <option>Guns/Knives</option>
					  <option>Jewelry</option>
					  <option>Legos</option>
					  <option>Metalry</option>
					  <option>Needlecraft</option>
					  <option>Photography</option>
					  <option>Sports</option>
					  <option>Toys</option>
					  <option>Wood Work</option>
					  <option>Other</option>
        	</select>
        	<div class="radio">
	        	<label>
	      			<input type="radio" name="optionsRadios" class="optionsRadios" value="public"> Public
	    			</label>
    			</div>
    			<div class="radio">
	    			<label>
	      			<input type="radio" name="optionsRadios" class="optionsRadios" value="private"> Private
	    			</label>
    			</div>
	  		</div>
	  		<input type="submit" class="btn btn-primary btn-md" name="new-submit" value="Add">
	  	</form>
	  </div>
	</div>
	<?php echo  
				'<div class="container"><span data-gal=' . json_encode($prev) . '>' .
					'<h1 class="gallery-name">' . htmlspecialchars($prev) . '</span>' . ' ' . '</h1>' . 
				'</div>';
	?>
  <form class="form-inline" id="upload-form" method="POST" enctype="multipart/form-data">
  	<div>
	  	<label for="gallery">Select Gallery</label>
	    <?php
	    $cols = $db->prepare('SELECT DISTINCT(gallery) FROM image_collection 
	    	WHERE name_id = ? ORDER BY gallery ASC'); 
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
	    <input type="hidden" name="action" value="now-select">
	    <input type="submit" class="btn btn-primary btn-md" name="submit" value="Select">
  	</div>
  	<div>
  		<a class="btn btn-default btn-md pull-right" href="#upload" data-toggle="modal">Upload Photo<span class="glyphicon glyphicon-camera"></span></a>
	  	<!-- Upload Image Modal -->
	  	<div class="modal fade modal" id="upload">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					  	<h4 class="modal-title">Select image to upload</h4>
						</div>
						<div class="modal-body">
							
							<div class="form-group" id="form-space">
								<input type="file" name="image" class="image">
					  	</div>
					  	
					  	<div class="form-group" id="form-space">
					    	<input type="text" name="image-name" class="image-name" placeholder="Name Image">
					    </div>
					    
					    <div class="form-group" id="form-space">
					    	<textarea name="description" placeholder="Enter Description"></textarea>
					  	</div>
					  	<input type="hidden" name="action" value="old-select">
					    <input type="submit" class="btn btn-primary btn-md" id="preview" name="sumit" value="Upload">
					    <!--
							<div class="progress">
							  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
							    <span class="sr-only">0% Complete</span>
							  </div>
							</div>
							-->
					  </div>
					</div>
				</div>
			</div>
  	</div>
  </form>
	</div> 
	<!-- Enlarge Image Modal -->
	<div class="modal fade modal" id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="title-name"></h3>
				</div>
	      <div class="modal-body" id="my-body">
	      	<img src="" id="imagepreview" class="img-responsive">
	      	<p id="modal-description"></p>
	      </div>
	      <div class="modal-footer">
	      	<a class="btn btn-primary btn-md pull-left" href="#edit-name" data-toggle="modal">Edit Name</a>
	      	<a class="btn btn-primary btn-md pull-left" href="#edit-description" data-toggle="modal">Edit Description</a>
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      	</div>
	    </div>
	  </div>
	</div> 
	<!-- Edit Image Name Modal -->
	<div class="modal fade modal" id="edit-name" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Edit Name</h3>
				</div>				
				<div class="modal-body">
				<form class="edit-name-form" method="POST">
				  <div class="form-group">
				  	<input type="text" class="form-control-sm" name="new-name" id="new-name" placeholder="New Name">
				  </div>
				</div> 				  
			  <div class="modal-footer">
			  	<input type="submit" name="change-name" id="change-name" class="btn btn-primary" value="Change" data-dismiss="modal">
			  </form>
				</div>
			</div>
		</div>
	</div>
	<!-- Edit Image Description Modal -->
	<div class="modal fade modal" id="edit-description" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Edit Description</h3>
				</div>				
				<div class="modal-body">
				<form class="edit-description-form" method="POST">
				  <div class="form-group">
				  	<textarea name="new-description" id="new-description" placeholder="New Description"></textarea>
				  </div>
				</div> 				  
			  <div class="modal-footer">
			  	<input type="submit" name="change-description" id="change-description" class="btn btn-primary" value="Change" data-dismiss="modal">
			  </form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<?php
		try {
		  $get_img = $db->prepare('SELECT * FROM image_collection WHERE name_id = ? AND gallery = ? ORDER BY id DESC');
		  $get_img->bindValue(1,$user_id);
		  $get_img->bindValue(2,$prev);
		  $get_img->execute();
		  
		  // Displays Images 
		  $i = 0;
		  foreach ($get_img as $get) {
		  	if (!empty($get['image'])) {
			    echo 
			    '<div class="col-xs-6 col-md-3" id="item-row"><span data-id=' . $get['id'] . '></span>' . 
				  	'<h3><span id="edited_' . $get['id'] . '_name">' . htmlspecialchars($get['image_name']) .  '</span></span>' . '</h3>' .
				    '<a href="#" id="name" class="thumbnail" data-toggle="modal"><span data-id=' . $get['id'] . '></span>' .
				    	'<img class="show-img"  src="data:image;base64,' . $get['image'] . '" id="imageresource' . $get['id'] . '">'  . 
					    '<p><span id="edited_' . $get['id'] . '_description">' . htmlspecialchars($get['description']) . '</span></p>' .
						'</a>' .	    		   
		        /*
				    '<a href="#" class="show-img">' . $get['views'] . ' '. 'View<span data-id=' . $get['id'] . 
				    	' class="glyphicon glyphicon-eye-open"></span>' . 
				    '</a>' . 
						*/	    		   
			    	'<a href="javascript:void(0);" id="my-likes">' . $get['likes'] . ' ' . 'Like<span data-id=' . $get['id'] . 
			    		' class="glyphicon glyphicon-thumbs-up">
			    	 </a>' .
			      '<a href="#" class="rotate-img">Rotate<span data-id=' . $get['id'] . ' class="glyphicon glyphicon-refresh"></span>' . 
			      '</a>' .
						'<a href="" class="delete-img">Delete<span data-id=' . $get['id'] . ' class="glyphicon glyphicon-trash"></span>' . 
						'</a>' . 
			    '</div>';
			    // Loops 4 Images per Row, 2 in Mobile Devices
					$i++;
					if ($i%2 == 0) echo '<div class="clearfix visible-xs"></div>';
					if ($i%4 == 0) echo '</div><div class="row">';
				}
			} 
		} catch (Exception $e) {
		  echo "Data was not retrieved from the database successfully.";
		  exit;
		}
		?>
	</div>
	<a class="btn btn-default btn-md pull-right" id="delete-gallery" href="">Delete Gallery<span class="glyphicon glyphicon-trash"></span></a>
  <a class="btn btn-default btn-md pull-right" href="#edit-galleryname">Rename Gallery<span class="glyphicon glyphicon-pencil"></span></a>
</div>
<?php require_once(ROOT_PATH . 'inc/footer.php'); ?>
