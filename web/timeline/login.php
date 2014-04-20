#!/usr/local/bin/php

<?php
	$username = $_GET['username'];
	$hashedPW = $_GET['hashedPW'];
	
	$db = pg_connect("host=postgres dbname=meal user=js7 password=MealAdminOfDoom123");
	//connection 
	if(!$db){
  		echo "Connection failed";
  	}
  	
  	$query = "SELECT EXISTS(SELECT * FROM Users WHERE username = '".$username."'
  			AND hashedpw = '".$hashedPW."');";
  				
  	$result = pg_query($conn, $query);
  	
  	if(!$result){
		echo "An error occured.\n";
		exit;
	}
			
	$authentic = pg_fetch_result($result, 0, "exists");
	
	if($authentic){
		$_SESSION['username'] = $username; 
		$_SESSION['login'] = TRUE;
		header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;
	}else{
		$_SESSION['login'] = FALSE;
		header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/homepage.php");
	}
	
?>

