#!/usr/local/bin/php

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
		header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/homepage.php?login=failedpost");
	}
?>

<html>
	<head><title>New Post Created!</title></head>
<body>

<?php 
	
	$username = $session_username;
	$imgpath = $_SESSION['img'];
	
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

	//post query PID ACTIVE DATE CAPTION RECIPE IMG
	$query3 = "INSERT INTO Post VALUES($arr[0], TRUE, '2014-04-21','$_POST[caption]','$_POST[recipe]', '$_POST[img]')";
	$result3 = pg_query($db,$query3);

	//update makepost and stores
	//array query idk UID AND PID
	$query5 = "INSERT INTO MakePost VALUES($uid, $arr[0])";
	$result5 = pg_query($db,$query5);
	
	$amount = $_POST['amount'];
	$units = $_POST['units'];
	$name = $_POST['name'];
	
	$size = size($name);
	
	for($n=0;$n<$size;$n++)
	{
		//code to find greatest ingid and increment
		$query2 = "SELECT ingid FROM Post ORDER BY ingid DESC LIMIT 1";
		$result2 = pg_query($db, $query2);
		$arr2 = pg_fetch_row($result2);
		$arr2[0] = $arr2[0] +1; 

		//ing query INGID AMOUNT UNITS NAME
		$query4="INSERT INTO Ingredient VALUES($arr2[0],'$amount[$n]','$units[$n]', '$name[$n]')";
		$result4 = pg_query($db,$query4);

		//array query idk INGID AND PID
		$query6 "INSERT INTO Stores VALUES($arr2[0], $arr[0])";
		$result6= pg_query($db,$query6);
	}

	//redirect to user's timeline?
	$username =$_POST[username];
   	header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;

?>  

</body>