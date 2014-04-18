#!/usr/local/bin/php

<html>
	<head><title>Ingredient Name Search</title></head>
<body>

<?php  
$ingname= $_GET['SearchNameIng'];
$db = pg_connect("host=postgres dbname=meal user= js7 password=MealAdminOfDoom123");  
$query = "SELECT pid, name FROM Ingredient, Stores WHERE name = $ingname";
$result = pg_query($db,$query);
?>  

</body>
</html>
