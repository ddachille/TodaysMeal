#!/usr/local/bin/php

<?php
	if($_GET['login'] == "logout"){
		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"],
    	   				 $params["secure"], $params["httponly"]);
		}
		
		session_destroy();
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Today's Meal</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
          <a class="navbar-brand" href="#"></a>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="login.php" role="form" method="post"> 
          
            <div class="form-group">
            
              <input type="text" placeholder="Email" class="form-control" name="username">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
            
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" style="padding-top:50px">
      <div class="container">
        <h1><img src="logo/banner1.png"></h1>
        <p>Welcome to Today's Meal! 
		<br>A fun new way to share your life and passion for food with friends.        
		<br><a href="indextimeline.php">secret link to dashboard (for dev purposes)</a></p>
        <p><a class="btn btn-primary btn-lg" role="button" href="register.php">Register </a></p>
      </div>
      <?php
		if($_GET['login'] == "logout"){
    		echo "<div class=\"alert alert-danger\">You have been logged out</div>";
    	}
    	if($_GET['login'] == "failed"){
    		echo "<div class=\"alert alert-danger\">Login failed, please try again</div>";
    	}
    	if($_GET['login'] == "failedpost"){
    		echo "<div class=\"alert alert-danger\">You must log in to make a post</div>";
    	}
    	
    ?> 
      </div>
      
      
      <img src="image/redicecream.jpg" width="33.33333333%"><img src="image/egg.jpg" width="33.33333334%" height="50%"><img src="image/sushi.jpg" width="33.33333333%">   
    </div><!-- /container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>