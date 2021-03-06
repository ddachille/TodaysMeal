#!/usr/local/bin/php

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
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
    <link rel="shortcut icon" href="/logo/icon.ico">

    <title>Search</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/simple-sidebar.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

<div id="wrapper">
    <!-- Sidebar -->
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand"><a href="#">Today's Meal</a>
			</li>
			<li><a href="indextimeline.php">Dashboard</a>
			</li>
			<li>
			<?php
				echo "<a href=\"timeline.php?username=".$session_username."\">My Timeline</a>"
			?>
			</li>
			<li><a href="search.php">Search</a>
			</li>
			<li><a href="newPost.php">Post</a>
                     </li>
			<li><a href="homepage.php?login=logout">Logout</a>
			</li>
			
		</ul>
	</div>

	<!-- Page content -->
	<div id="page-content-wrapper">
	<!-- Keep all page content within the page-content inset div! -->
		<div class="page-content inset"> 

		<!-- Custom styles for this template -->
		<style>
			body {
			  padding-top: 0px;
			  padding-bottom: 0px;
			  background-color: #fff;
			}
			.form-signin {
			  max-width: 330px;
			  padding: 15px;
			  margin: 0 auto;
			  display: inline-block;
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
			  margin-bottom: 10px;
			}
			.form-signin .checkbox {
			  font-weight: normal;
			}
			.form-signin .form-control {
			  position: relative;
			  height: auto;
			  -webkit-box-sizing: border-box;
				 -moz-box-sizing: border-box;
					  box-sizing: border-box;
			  padding: 10px;
			  font-size: 16px;
			}
			.form-signin .form-control:focus {
			  z-index: 2;
			}
			.form-signin input[type="email"] {
			  margin-bottom: -1px;
			  border-bottom-right-radius: 0;
			  border-bottom-left-radius: 0;
			}
			.form-signin input[type="password"] {
			  margin-bottom: 10px;
			  border-top-left-radius: 0;
			  border-top-right-radius: 0;
			}
		</style>

		   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		</head>
			<div class="container">
				<ul class="timeline" style="padding-left: 0px;">
					<div class="page-header text-center">
						<h1 id="timeline"><div id="textbox"><p class="alignleft"><img src="logo/banner1.png"></p><p class="alignright">Search</p></div></h1>
						<div style="clear: both;"></div>
					</div>
					  <form class="form-signin" role="form" action="timeline.php" method="get">
						<h3 class="form-signin-heading">Search by Username:&nbsp;&nbsp;&emsp;</h3>
						<input type="text" class="form-control" placeholder="User Name" required="" autofocus="" name="username">
						<button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
					  </form>
						&emsp;
					  <form class="form-signin" role="form" action="ingname_search.php" method="get">
						<h3 class="form-signin-heading">Ingredient Name:&emsp;&emsp;&nbsp;&nbsp;&emsp;</h3>
						<input type="text" class="form-control" placeholder="Name" required="" autofocus="" name="SearchNameIng">

						<button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
					  </form>
						&emsp;
					  <form class="form-signin" role="form" action="ingnum_search.php" method="get">
						<h3 class="form-signin-heading">Number of Ingredients:&emsp;</h3>
						<input type="number" min="0" class="form-control" placeholder="Number" required="" autofocus="" name="SearchNumIng">
						<button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
					  </form>
				</ul>
			</div> <!-- /container -->
		</div>
    </div>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
</html>
