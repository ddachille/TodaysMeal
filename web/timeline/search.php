#!/usr/local/bin/php

<html>
	<head><title>Search</title></head>
<body>


<form name="input" action="timeline.php" method="get">
Search by Username: <input type="text" name="username">
<input type="submit" value="Submit">
</form>


<form name="input" action="ingname_search.php" method="get">
Search by Ingredient Name: <input type="text" name="SearchNameIng">
<input type="submit" value="Submit">
</form>


<form name="input" action="ingnum_search.php" method="get">
Search by Number of Ingredients: <input type="number" name="SearchNumIng">
<input type="submit" value="Submit">
</form>



</body>
</html>
