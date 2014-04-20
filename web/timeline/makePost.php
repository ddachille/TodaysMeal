#!/usr/local/bin/php

<html>
	<head><title>New Post Created!</title></head>
<body>

<?php 

	$db = pg_connect("host=postgres dbname=meal user= js7 password=MealAdminOfDoom123");
	//connection 
	if(!$db){
  		echo "Connection failed";
  	}
	//code to find greatest pid and increment
	$query = "SELECT pid FROM Post ORDER BY pid DESC LIMIT 1";
	$result = pg_query($db, $query);
	$arr = pg_fetch_row($result);
	$arr[0] = $arr[0] +1; 

	//code to find greatest ingid and increment
	$query2 = "SELECT ingid FROM Post ORDER BY ingid DESC LIMIT 1";
	$result2 = pg_query($db, $query2);
	$arr2 = pg_fetch_row($result2);
	$arr2[0] = $arr2[0] +1; 	

	$query3 = "INSERT INTO Post VALUES($arr[0], TRUE, '2014-04-21','$_POST[caption]','$_POST[recipe]', '$_POST[img]')";
	$result3 = pg_query($db,$query3);

	//redirect to user's timeline?
	$username =$_POST[username];
   	header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;

?>  

</body>