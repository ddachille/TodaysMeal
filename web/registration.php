#!/usr/local/bin/php

<html>
	<head><title>Registering...</title></head>
<body>

<?php 

	$db = pg_connect("host=postgres dbname=meal user= js7 password=MealAdminOfDoom123");
	//connection 
	if(!$db){
  		echo "Connection failed";
  	}
	//code to find greatest uid and increment
	$query = "SELECT uid FROM Users ORDER BY uid DESC LIMIT 1";
	$result = pg_query($db, $query);
	$arr = pg_fetch_row($result);
	$arr[0] = $arr[0] +1; 

	if(isPrivate == "true" || "TRUE"){
		$query2 = "INSERT INTO Users VALUES($arr[0], '$_POST[username]',TRUE,'$_POST[hashedpw]')";
		$result2 = pg_query($db,$query2);
	}
	else{
		$query2 = "INSERT INTO Users VALUES($arr[0], '$_POST[username]',FALSE,'$_POST[hashedpw]')";
		$result2 = pg_query($db,$query2);
	}
	
?>  
