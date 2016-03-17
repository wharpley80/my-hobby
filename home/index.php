<?php
session_start();

$thisPage = "home";
require_once('../inc/config.php');
require_once(ROOT_PATH . 'inc/database.php');

// Creates a new username.
if (isset($_POST['signup'])) {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password = hash("sha256", $password);
  if (empty($username) || empty($email) || empty($password)) {
  	echo "Please complete all fields.";
	}
  // Validates Email
	foreach($_POST as $value) {
		if(stripos($value,'Content-Type:') !== FALSE) {
			echo "There was a problem with the information you entered.";
			exit;
		}
	}
	try {
	  $sql = $db->prepare('INSERT IGNORE INTO user_pass (username,email,password) VALUES (?,?,?)');
	  $sql->bindParam(1,$username);
	  $sql->bindParam(2,$email);
		$sql->bindParam(3,$password);
	  $sql->execute();
	} catch (Exception $e) {
	  echo 'Data could not be submitted to the database.';
	  exit;
	}
	// Grabs ID from user_pass Table.
  function user_id($username) {
    require(ROOT_PATH . 'inc/database.php');
  
    try {
      $ids = $db->prepare('SELECT id FROM user_pass WHERE username = ?');
      $ids->bindValue(1,$username);
      $ids->execute();
      foreach ($ids as $id) {
        $user_id = $id['id'];
        return $user_id;
      }
    } catch (Exception $e) {
      echo "Data was not retrieved from the database successfully.";
      exit;
    }
  } 
	$userid = user_id($username);
	$_SESSION['login'] = "1";
	$_SESSION['userid'] = $userid;
  header ("Location: " . BASE_URL . "collection/");
  exit();
}
// Signs In Existing User
if (isset($_POST['email-SI'])) {
	$email_SI = trim($_POST['email-SI']);
	$password_SI = trim($_POST['password-SI']);
	$password_SI = hash("sha256", $password_SI);
	if (empty($email_SI) || empty($password_SI)) {
		echo "Please Complete All Fields";
	} else {
	  // Grabs username from user_pass Table.
		function username($email_SI,$password_SI) {
	    require(ROOT_PATH . 'inc/database.php');
			try {
				$user = $db->prepare('SELECT username FROM user_pass WHERE email = ? AND password = ?');
			  $user->bindParam(1,$email_SI);
			  $user->bindParam(2,$password_SI);
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
		// Grabs email from user_pass Table.
		function email($email_SI,$password_SI) {
	    require(ROOT_PATH . 'inc/database.php');
			try {
				$email = $db->prepare('SELECT email FROM user_pass WHERE email = ? AND password = ?');
			  $email->bindParam(1,$email_SI);
			  $email->bindParam(2,$password_SI);
			  $email->execute();
			  foreach ($email as $mail) {
			    $email = $mail['email'];
			    return $email;
			  }
			} catch (Exception $e) {
				echo 'Data could not be retrieved from the database.';
			  exit;
			}
		}
			
		$verified_email = email($email_SI,$password_SI);
		$username_SI = username($email_SI,$password_SI);
		// Grabs ID from user_pass Table.
	  function user_id_si($username_SI) {
	    require(ROOT_PATH . 'inc/database.php');
	  
	    try {
	      $ids = $db->prepare('SELECT id FROM user_pass WHERE username = ?');
	      $ids->bindValue(1,$username_SI);
	      $ids->execute();
	      foreach ($ids as $id) {
	        $userID = $id['id'];
	        return $userID;
	      }
	    } catch (Exception $e) {
	      echo "Data was not retrieved from the database successfully.";
	      exit;
	    }
	  } 
	  $user_id_si = user_id_si($username_SI);
		if(email($email_SI,$password_SI) == $email_SI) {
			$_SESSION['login'] = "1";
			$_SESSION['userid'] = $user_id_si;
		  header ("Location: " . BASE_URL . "collection/");
		  exit();
		} else { 
			echo "Invalid Email";
		}
	} 
}
require_once(ROOT_PATH . 'inc/header.php');
?>
	<div id="myCarousel" class="carousel slide jumbotron">
  	<div class="container">
			<ol class="carousel-indicators">
				<li class="active" data-target="#myCarousel" data-slide-to="0"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<h1>What do you Collect?</h1>
		 			<p class="lead">Antiques, Coins, Comics, Figurines, Memorabilia, Toys...
		 			</p>
		      <p class="btn-group">
		      	<?php if (!(isset($_SESSION['login']) && !empty($_SESSION['login']))) { ?>
				     	  <a class="btn btn-success btn-sm" data-toggle="modal" href="#signIn">Sign In</a>
				    		<a class="btn btn-info btn-sm" data-toggle="modal"  href="#getStarted">Start Collection</a>
						<?php }	else { ?>
								<a class="btn btn-danger btn-sm" href="<?php echo BASE_URL; ?>index.php">Log Out</a>
						<?php } ?>
		      </p>
				</div>
				<div class="item">
					<h1>What's your Hobby?</h1>
		 			<p class="lead">Painting, Sewing, Wood Work, Traveling, Photography...
		 			</p>
		      <?php if (!(isset($_SESSION['login']) && !empty($_SESSION['login']))) { ?>
		      	<p class="btn-group">
			     	  <a class="btn btn-success btn-sm" data-toggle="modal" href="#signIn">Sign In</a>
			    		<a class="btn btn-info btn-sm" data-toggle="modal"  href="#getStarted">Start Collection</a>
				    </p>
					<?php }	else { ?>
						<p class="btn-group">
							<a class="btn btn-danger btn-sm" href="<?php echo BASE_URL; ?>index.php">Log Out &amp Save</a>
						</p>
					<?php } ?>   
				</div>
			</div>
    </div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			<span class="icon-prev"></span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
			<span class="icon-next"></span>
		</a>
	</div>
	<div class="modal fade" id="signIn">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Sign In with your Email and Password</h4>
				</div>
				<div class="modal-body">
					<form class="signin-form" method="POST">
					  <div class="form-group">
					    <input type="email" class="form-control-sm" name="email-SI" id="email-SI" placeholder="Email" autofocus="autofocus">
					  </div>
					  <div class="form-group">
					    <input type="password" class="form-control-sm" name="password-SI" id="password-SI" placeholder="Password">
					  </div>
					  <input type="submit" name="signin" class="btn btn-primary" value="Sign In">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="getStarted">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Get Started with your Email, Username, and Password</h4>
				</div>
				<div class="modal-body">
					<form class="signup-form" method="POST">
					  <div class="form-group">
					    <input type="email" class="form-control-sm" name="email" id="email" placeholder="Email" autofocus="autofocus">
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control-sm" name="username" id="username" placeholder="Username">
					  </div>
					  <div class="form-group">
					    <input type="password" class="form-control-sm" name="password" id="password" placeholder="Password">
					  </div>
					  <input type="submit" name="signup" class="btn btn-primary" value="Get Started">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="browse-page">
	  <div class="container">
		 	<div class="row">
		 		<div class="col-sm-4">
		 			<b class="glyphicon glyphicon-th"></b>
		 			<h2>Create Collection</h2>
				 	<p>
				 		Sign Up and start creating a Collection of your favorite Hobbies. From Paintings or Sculptures to Action Figures or Memorabilia. It's a fun way to share something that's special to you with others.
				 	</p>
		    </div>
		    <div class="col-sm-4">
		    	<b class="glyphicon glyphicon-camera"></b>
		    	<h2>Upload Photos</h2>
				 	<p>
				 		Take a picture of each item in your Collection. Then Upload the Photo and give it a name and brief description.
				 	</p>
		 		</div>
		 		<div class="col-sm-4">
		 			<b class="glyphicon glyphicon-search"></b>
		 			<h2>Search Collections</h2>
				 	<p>
				 		Browse other Collections and admire somebody else's Hobby.  
				 	</p>
		 		</div>
		 	</div>
		</div>
 
<?php require_once(ROOT_PATH . 'inc/footer.php'); ?>