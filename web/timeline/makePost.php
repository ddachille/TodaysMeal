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
	$caption = $_SESSION['caption'];
	$recipe = $_SESSION['recipe'];
	$imgpath = $_SESSION['imgpath'];
	$caption = $_SESSION['caption'];
	$recipe = $_SESSION['recipe'];
	$uid = $_SESSION['uid'];

	
	$ingredients = $_POST['name'];
	$amounts = $_POST['amount'];
	$units = $_POST['unit'];
	
	echo "Username: ".$username;
	echo "<br>";
	echo "Caption: ".$caption;
	echo "<br>";
	echo "Recipe: ".$recipe;
	echo "<br>";
	echo "imgpath: ".$imgpath;
	echo "<br>";
	
	$size = count($ingredients);
	for($i = 0; $i < $size; $i++){
		echo $ingredients[$i]." ".$amounts[$i]." ".$units[$i];
		echo "<br>";

	}
	
	
	
	
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
	echo "New post PID: ".$arr[0];
	$pid = $arr[0];

	//code to find greatest ingid and increment
	$query = "SELECT ingid FROM Ingredient ORDER BY ingid DESC LIMIT 1";
	$result = pg_query($db, $query);
	$arr = pg_fetch_row($result);
	$arr[0] = $arr[0] +1; 	
	echo "New ingredient INGID: ".$arr[0];
	$ingid = $arr[0];
	
	
	//Insert the post into Post table
	//post query PID ACTIVE DATE CAPTION RECIPE IMG
	$query = "INSERT INTO Post VALUES(".$pid.", TRUE, '2014-04-21','".$caption."','".$recipe."', '".$imgpath."')";
	$result = pg_query($db,$query);
	if($result){
		echo "Post inserted.";
	}else{
		echo "Post not inserted.";
	}
	echo "<br>";
	
	
	//Make a query to get the uid for this username
	$query = "SELECT uid FROM Users WHERE username = '".$username."'";
	$result = pg_query($db, $query);
	$uid = pg_fetch_result($result, 0, 'uid');
	
	//Insert uid and pid into MakePost relation
	$query = "INSERT INTO MakePost VALUES(".$uid.", ".$pid.")";
	$result = pg_query($db, $query);
	
	if($result){
		echo "MakePost inserted.";
	}else{
		echo "MakePost not inserted.";
	}
	echo "<br>";
	
	
	$amount = $_POST['amount'];
	$units = $_POST['units'];
	$name = $_POST['name'];
	
	$size = count($ingredients);
	
	//Now make a loop to repeatedly query and insert into Ingredient and Stores
		
	for($i = 0; $i < $size; $i++){
		
		echo "i = ".$i."<br>";
		echo "ingid = ".$ingid."<br>";
		//First insert into Ingredient
		$query = "INSERT INTO Ingredient VALUES(".$ingid.", '".$amount[$i]."', '".$units[$i]."', '".$name[$i]."')";
		$result = pg_query($db, $query);
		if($result){
			echo "Ingredient inserted.";
		}else{
			echo "Ingredient not inserted.";
		}
		echo "<br>";
		//Then insert ingid and pid into Stores
		$query = "INSERT INTO Stores VALUES(".$ingid.", ".$pid.")";
		$result = pg_query($db, $query);
		if($result){
			echo "Stores inserted.";
		}else{
			echo "Stores not inserted.";
		}
		echo "<br>";
		
		$ingid++;
		
	}	


	//redirect to user's timeline?
   	//header( "Location: http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=$username" ) ;

?>  

</body>