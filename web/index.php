#!/usr/local/bin/php

<html>
	<head><title>Register</title></head>
<body>

 
<form name="index" action="registration.php" method="POST" >  
Username:<input type="text" name="username" /></br>  
Password:<input type="text" name="hashedpw" /></br>
Set Profile to Private? (true or false): <input type="text" name= "isPrivate" /></br>     
<input type="submit" />  
</form>  


<?php 
	print( "Hello World<br />"); 

#let's access some databases.  username=js7 password=MealAdminOfDoom123

	$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
  	
  	if(!$conn){
  		echo "Connection failed";
  	}
  	
  	$query = sprintf("SELECT username FROM Users WHERE uid = 15");
  	$result = pg_query($conn, $query);
  	
  	if(!$result){
  		echo "An error occured.\n";
  		exit;
  	}
  	
  	$arr = pg_fetch_row($result);
  	$query2 = sprintf("SELECT username FROM Users WHERE uid = 17");
  	$result2 = pg_query($conn, $query2);
  	$arr2 = pg_fetch_row($result2);
  	echo "Username: " . $arr2[0];
 
  	

?>
</body></html>



<!--commenting out entire file for simplicity

<!DOCTYPE html>
<html>
<head>
<title>Today's Meal</title>
</head>

<body>  
<!-- Header and Nav 
  
  <div class="row">
    <div class="large-3 columns">
      <h1> 
	  logo goes here
	  <!-- <img src="http://placehold.it/400x100&text=Logo" />
	  </h1>
    </div>
    <div class="large-9 columns">
      <ul class="inline-list right">
        <li><a href="#">Section 1</a></li>
        <li><a href="#">Section 2</a></li>
        <li><a href="#">Section 3</a></li>
        <li><a href="#">Section 4</a></li>
      </ul>
    </div>
  </div>
  
  <!-- End Header and Nav 
  
  
  <!-- PHP Code for Accessing Database

  
  <?php
  	$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
  	
  	if(!$conn){
  		echo "Connection failed";
  	}
  	
  	$query = sprintf("SELECT * FROM Users");
  	$result = pg_query($conn, $query);
  	
  	if(!$result){
  		echo "An error occured.\n";
  		exit;
  	}
  	
  	$arr = pg_fetch_array($result, 0, PGSQL_NUM);
  	echo $arr[0] . " <- array\n";
  	
  	$arr = pg_fetch_array($result, 1, PGSQL_ASSOC);
  	echo $arr["mycolumn"] . " <- array\n";
  ?>
  

  <div class="row">    
    
    <!-- Main Content Section
    <!-- This has been source ordered to come first in the markup (and on small devices) but to be to the right of the nav on larger screens 
    <div class="large-9 push-3 columns">
      
      <h3>Today's Meal <small>"wow food"</small></h3>
      
      <p>pics go here</p>
            
    </div>
    
    
    <!-- Nav Sidebar
    <!-- This is source ordered to be pulled to the left on larger screens 
    <div class="large-3 pull-9 columns">
        
      <ul class="side-nav">
        <li><a href="#">Section 1</a></li>
        <li><a href="#">Section 2</a></li>
        <li><a href="#">Section 3</a></li>
        <li><a href="#">Section 4</a></li>
        <li><a href="#">Section 5</a></li>
        <li><a href="#">Section 6</a></li>
      </ul>
      
      <p>
	  sidebar pic idek
	  <!--<img src="http://placehold.it/320x240&text=Ad" />
	  </p>
        
    </div>
    
  </div>
    
  
  <!-- Footer 
  
  <footer class="row">
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-6 columns">
          <p>© Copyright Team Pieazza.</p>
        </div>
        <div class="large-6 columns">
          <ul class="inline-list right">
            <li><a href="#">Section 1</a></li>
            <li><a href="#">Section 2</a></li>
            <li><a href="#">Section 3</a></li>
            <li><a href="#">Section 4</a></li>
          </ul>
        </div>
      </div>
    </div> 
  </footer>
</body>  

</html>

-->