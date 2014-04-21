#!/usr/local/bin/php

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
		header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/homepage.php?login=failedpost");
	}
	
	$_SESSION['img'] = $_POST['img'];
	$_SESSION['caption'] = $_POST['caption'];
	$_SESSION['recipe'] = $_POST['recipe'];
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

    <title>Ingredients</title>

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
			<li><a href="#">&nbsp;</a>
			</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas id dui vitae libero semper placerat id et mauris. Sed fermentum lorem eu fermentum semper. Pellentesque blandit. 
			</li>
			<li><a href="#"></a>
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
			  max-width: 1000px;
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
						<h1 id="timeline"><div id="textbox"><p class="alignleft"><img src="logo/banner1.png"></p><p class="alignright">New Post</p></div></h1>
						<div style="clear: both;"></div>
					</div>
					  <form class="form-signin" role="form" action="makePost.php" method="post">
						<h3 class="form-signin-heading">Input your ingredients! &nbsp;&nbsp;&emsp;</h3>
						<?php
						$count = $_POST['ingnum'];
						
						for($i = 0; $i < $count; $i++){
							echo "<div class=\"row\">";
  								echo "<div class=\"col-xs-4\">";
    								echo "<input type=\"text\" class=\"form-control\" name=\"name[]\" placeholder=\"Ingredient\">";
  								echo "</div>";
  								echo "<div class=\"col-xs-4\">";
    								echo "<input type=\"number\" class=\"form-control\" name=\"amount[]\" placeholder=\"Amount\">";
 								echo "</div>";
  								echo "<div class=\"col-xs-4\">";
    								echo "<input type=\"text\" class=\"form-control\" name=\"unit[]\" placeholder=\"Unit\">";
								echo "</div>";
							echo "</div>";
							echo "<br>";
							echo "<br>";

						}
						?>
						<button class="btn btn-primary btn-lg" type="submit">Submit</button>
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
