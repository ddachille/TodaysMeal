#!/usr/local/bin/php

<html>
	<head><title>Registered!</title></head>
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

	$query2 = "INSERT INTO Users VALUES($arr[0], '$_POST[username]','$_POST[hashedpw]')";
	$result2 = pg_query($db,$query2);

	//redirect
	$username =$_POST[username];
   	header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;

?>  

</body>