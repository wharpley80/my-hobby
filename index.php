 <!DOCTYPE html>
 <html>
 <head>
 	<title>MyHobbyMyCollection</title>
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
 	<link href="css/bootstrap-theme	.min.css" rel="stylesheet" media="screen">
 	<link href="css/my-styles.css" rel="stylesheet" media="screen">
 </head>
 <body>
 	<div class="navbar navbar-inverse navbar-fixed-top">
 		<div class="container">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 			<a class="navbar-brand text-muted" href="#">My Hobby My Collection</a>
 			<div class="collapse navbar-collapse">
	 			<ul class="nav navbar-nav navbar-right">
	 				<li><a href="#">Home</a></li>
	 				<li><a href="#">My Collection</a></li>
	 				<li><a href="#">Browse</a></li>
	 			</ul>
 			</div> 
		</div>
	</div>
	<div id="myCarousel" class="carousel slide jumbotron">
  	<div class="container">
			<ol class="carousel-indicators">
				<li class="active" data-target="#myCarousel" data-slide-to="0"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<h1>What's your Hobby?</h1>
		 			<p class="lead">Painting, Sewing, Wood Work, Traveling, Gardening...
		 			</p>
		      <p class="btn-group">
				    <a class="btn btn-success btn-sm" data-toggle="modal" href="#signIn">Sign In</a>
				    <a class="btn btn-default btn-sm" data-toggle="modal"  href="#getStarted">Start Collection</a>
		      </p>
				</div>
				<div class="item">
					<h1>What do you Collect?</h1>
		 			<p class="lead">Action Figures, Memorabilia, Trains, Cars, Jewelry, Comics...
		 			</p>
		      <p class="btn-group">
				    <a class="btn btn-success btn-sm" data-toggle="modal" href="#signIn">Sign In</a>
				    <a class="btn btn-default btn-sm" data-toggle="modal"  href="#getStarted">Start Collections</a>
		      </p>
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
					<form class="form">
					  <div class="form-group">
					    <label for="email-SI">Email address</label>
					    <input type="email" class="form-control-sm" id="email-SI" placeholder="Email">
					  </div>
					  <div class="form-group">
					    <label for="password-SI">Password</label>
					    <input type="password" class="form-control-sm" id="password-SI" placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-primary" data-dismiss="modal">Sign In</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="getStarted">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Get Started with your Email, Username, and Password</h4>
				</div>
				<div class="modal-body">
					<form class="form">
					  <div class="form-group">
					    <label for="email">Email address</label>
					    <input type="email" class="form-control-sm" id="email" placeholder="Email">
					  </div>
					  <div class="form-group">
					    <label for="username">Username</label>
					    <input type="text" class="form-control-sm" id="usrname" placeholder="Username">
					  </div>
					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" class="form-control-sm" id="password" placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-primary" data-dismiss="modal">Get Started</button>
					</form>
				</div>
			</div>
		</div>
	</div>
  <div class="container">
	 	<div class="row">
	 		<div class="col-sm-4">
	 			<b class="glyphicon glyphicon-th"></b>
	 			<h2>Create Collection</h2>
			 	<p>Sign Up and start creating a Collection of your favorite Hobbies. From Paintings or Sculptures to Action Figures or 
			 		Memorabilia. It's a fun way to share something that's special to you with others.
			 	</p>
	    </div>
	    <div class="col-sm-4">
	    	<b class="glyphicon glyphicon-camera"></b>
	    	<h2>Upload Photos</h2>
			 	<p>Take a picture of each item in your Collection. Then Upload the Photo and give it a name and brief description.
			 	</p>
	 		</div>
	 		<div class="col-sm-4">
	 			<b class="glyphicon glyphicon-search"></b>
	 			<h2>Search Collections</h2>
			 	<p>Browse other Collections and admire somebody else's Hobby.  
			 	</p>
	 		</div>
	 	</div>
	</div>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>