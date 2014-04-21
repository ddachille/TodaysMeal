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
		$isEqual = strcmp(trim($result), trim($dbHashedPassword));
				
		if ($isEqual == 0){
			echo "Authentication success";
			echo "<br>";
			echo "Is equal: ".$isEqual;
			echo "<br>";
			$_SESSION['username'] = $username;
			$_SESSION['login'] = "t";
			echo $password;
			echo "<br>";
			echo $result;
			echo "<br>";
			echo $dbHashedPassword;
			echo "<br>";
			//header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;
		}else{
			echo "Authenticiation failed ";
			echo "<br>";
			echo "Is equal: ".$isEqual;
			echo "<br>";
			echo "Password: ".$password;
			echo "<br>";
			echo $dbHashedPassword;
			echo "<br>"; 
			echo $result;
			$_SESSION['login'] = "f";
			//header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/homepage.php?login=failed");
		}
	}else{
		echo "Checking $_SESSION array ";
		echo $_SESSION['username'];
		echo " ";
		echo $_SESSION['login'];
	}
	
?>

