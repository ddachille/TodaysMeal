#!/usr/local/bin/php

<html>
	<head><title>Username Search</title></head>
<body>
	
<?php  
$username= $_GET['SearchUser'];
$db = pg_connect("host=postgres dbname=meal user= js7 password=MealAdminOfDoom123");  
$query = sprintf("SELECT username FROM users WHERE username=$username;");
$result = pg_query($db,$query);
?>  

</body>
</html>
