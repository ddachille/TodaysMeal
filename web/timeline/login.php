#!/usr/local/bin/php

<?php
	session_start();
	if(!empty($_POST['username']) && !empty($_POST['password']) ){	
		$username = $_POST['username'];
		$password = $_POST['password'];
	
		$db = pg_connect("host=postgres dbname=meal user=js7 password=MealAdminOfDoom123");
		
		//connection 
		if(!$db){
  			echo "Connection failed";
 	 	}
  		
 	 	$query = "SELECT username, hashedpw
 	 			FROM Users
 	 			WHERE username = '".$username."';";
	
 	 	$result = pg_query($db, $query);
  		
 	 	if(!$result){
			echo "An error occured.\n";
			exit;
		}
		
		$user = pg_fetch_row($result, 0);
		$dbHashedPassword = $user[1];
		$result = crypt($password, $dbHashedPassword);
		
		if (strcmp($result, $dbHashedPasword)){
			echo "Authentication success";
			$_SESSION['username'] = $username;
			$_SESSION['login'] = "t";
			header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;
		}else{
			echo "Authenticiation failed ";
			echo $password;
			echo " ";
			echo $dbHashedPassword;
			echo " "; 
			echo $result;
			$_SESSION['login'] = "f";
			header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/homepage.php?login=failed");
		}
	}else{
		echo "Checking $_SESSION array ";
		echo $_SESSION['username'];
		echo " ";
		echo $_SESSION['login'];
	}
	
?>

