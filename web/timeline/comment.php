#!/usr/local/bin/php

<html>
	<head><title>Commented!</title></head>
<body>

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
	}
?>
<?php 

	$db = pg_connect("host=postgres dbname=meal user= js7 password=MealAdminOfDoom123");
	//connection 
	if(!$db){
  		echo "Connection failed";
  	}
	
	$query4 = "SELECT uid FROM Users WHERE Users.username =".$session_username;
	$result4 = pg_query($db,$query4);
	$arr3 = pg_fetch_row($result4);
	$uid = $arr3[0];
	
	//$query5 = "SELECT pid FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid)) WHERE uid=".$uid;
	//$result5 = pg_query($db,$query5);
	//$arr2 = pg_fetch_row($result5);
	//$pid = $arr2[0];
	
	//code to find greatest uid and increment
	$query = "SELECT cid FROM Comment ORDER BY cid DESC LIMIT 1";
	$result = pg_query($db, $query);
	$arr = pg_fetch_row($result);
	$arr[0] = $arr[0] +1; 

	$query2 = "INSERT INTO Comment VALUES(".$arr[0].", '".$_POST['comment']."')";
	$query3 = "INSERT INTO MakeComment VALUES(".$uid.", ".$arr[0].", ".$_SESSION['pid'].")";
	$result2 = pg_query($db,$query2);
	$result3 = pg_query($db,$query3);

	
	//redirect
	//$username =$_POST[username];
	
	//session_start();
	//$_SESSION['login'] = "t";
	//$_SESSION['username'] = $username;
	
   	header( "Location: postPage.php?pid=".$_GET['pid']) ;

?>  

</body> </html>