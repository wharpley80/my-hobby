 <?php session_start(); ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>MyHobbyMyCollection</title>
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300|Raleway" rel="stylesheet" type="text/css">
 	<link href="<?php echo BASE_URL; ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
 	<link href="<?php echo BASE_URL; ?>css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
 	<link href="<?php echo BASE_URL; ?>css/tooltipster.css"rel="stylesheet" type="text/css">
 	<link href="<?php echo BASE_URL; ?>css/my-styles.css" rel="stylesheet" media="screen">
 </head>
 <body class="browse-page">
 	<div class="navbar navbar-inverse navbar-fixed-top">
 		<div class="container">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 			<a class="navbar-brand text-muted" href="#">My Hobby My Collection</a>
 			<div class="collapse navbar-collapse">
	 			<ul class="nav nav-pills navbar-nav navbar-right">
	 				<?php if (!(isset($_SESSION['login']) && !empty($_SESSION['login']))) { ?>
		 			  <li <?php if ($thisPage=="home") 
							echo " class=\"active\""; ?> >
							<a href="<?php echo BASE_URL; ?>home/">Home</a>
						</li>
						<li <?php if ($thisPage=="browse") 
							echo " class=\"active\""; ?> >
							<a href="<?php echo BASE_URL; ?>browse/">Browse</a>
						</li>
					<?php }	else { ?>
		 			  <li <?php if ($thisPage=="home") 
							echo " class=\"active\""; ?> >
							<a href="<?php echo BASE_URL; ?>home/">Home</a>
						</li>
						<li <?php if ($thisPage=="collection") 
							echo " class=\"active\""; ?> >
							<a href="<?php echo BASE_URL; ?>collection/">My Collection</a>
						</li>
						<li <?php if ($thisPage=="browse") 
							echo " class=\"active\""; ?> >
							<a href="<?php echo BASE_URL; ?>browse/">Browse</a>
						</li>
	 				<?php } ?>  
	 			</ul>
 			</div> 
		</div>
	</div>