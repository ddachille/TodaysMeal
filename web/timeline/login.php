#!/usr/local/bin/php

<?php
	session_start();
	if(!empty($_GET['username']) && !empty($_GET['hashedpw']) ){	
		$username = $_GET['username'];
		$hashedpw = $_GET['hashedpw'];
	
		$db = pg_connect("host=postgres dbname=meal user=js7 password=MealAdminOfDoom123");
		//connection 
		if(!$db){
  			echo "Connection failed";
 	 	}
  	
 	 	$query = "SELECT EXISTS(SELECT * FROM Users WHERE username = '".$username."'
  			AND hashedpw = '".$hashedpw."');";
  				
 	 	$result = pg_query($db, $query);
  	
 	 	if(!$result){
			echo "An error occured.\n";
			exit;
		}
		
		$exists = pg_fetch_result($result, 0, "exists");
		if($exists == "t"){
			echo "Authentication success";
			$_SESSION['username'] = $username;
			$_SESSION['login'] = $exists;
		}else{
			echo "Authenticiation failed";
		}
	}else{
		echo "Checkink _SESSION array";
		
		echo $_SESSION['username'];
		echo $_SESSION['login'];
	}
	
?>

