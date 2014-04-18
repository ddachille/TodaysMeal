#!/usr/local/bin/php

<link href="css/bootstrapPOST.css" rel="stylesheet">
<link href="postPageCSS.css" rel="stylesheet">
	

<div class="container">
    <div class="page-header text-center">
        <h1 id="timeline">Timeline 2.1</h1>
    </div>
    <ul class="timeline">   
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <img class="img-responsive" src="http://lorempixel.com/1600/500/sports/2" />
              
            </div>
            <div class="timeline-body"><p>
            	<?php 

					#let's access some databases.  username=js7 password=MealAdminOfDoom123

					$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
  	
					if(!$conn){
  						echo "Connection failed";
					}

					//first get the username stored in the URL
			$username = $_GET["username"];
			
			//make sure that username exists
			$query = sprintf("SELECT EXISTS(SELECT * FROM Users WHERE username = '".$username."');");
			$result = pg_query($conn, $query);
			if(!$result){
				echo "An error occured.\n";
				exit;
			}
			
			$usernameExists = pg_fetch_result($result, 0, "exists");
			
			if($usernameExists == "t"){
				$query = sprintf("SELECT uid FROM Users WHERE username = '".$username."';");
				$result = pg_query($conn, $query);
	
				if(!$result){
					echo "An error occured.\n";
					exit;
				}
			
				$temp = pg_fetch_row($result, 0);
				$uid = $temp[0];
				//echo "<h1 id=\"timeline\">".$username."</h1>";
			}else{
				echo "<h1 id=\"timeline\">Error: Username \"".$username."\" does not exists</h1>";
			}
  	
  					$query = sprintf(
					"WITH Userposts AS(
						SELECT username, pid
						FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid))
						WHERE Users.uid = 15 AND pid=2)
					SELECT username, caption, recipe, Post.pid FROM (Userposts JOIN Post ON (Post.pid = Userposts.pid))");

					$query2 = sprintf(
					"SELECT Ingredient.amount, Ingredient.units, Ingredient.name
						FROM (Stores JOIN Ingredient ON (Ingredient.ingid = Stores.ingid))
						WHERE Stores.pid=2");
					
					$result = pg_query($conn, $query);
					$result2 = pg_query($conn, $query2);
  	
					$numOfIngred = pg_num_rows ($result2);

					if(!$result){
  						echo "An error occured.\n";
  						exit;
  					}
  					
  					$arr = pg_fetch_row($result);
					$arr2 = pg_fetch_row($result2);

					echo "<i>&#34;".$arr[1]."&#34;</i>";
  					echo " -- " . $arr[0] . "<br><br>";
					echo "Ingredients: <br><small>";
					for ($count=0; $count<$numOfIngred; $count++){
        			            	$currRow = pg_fetch_row($result2, $count);
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$currRow[2]." ".$currRow[0]." ".$currRow[1]."<br>";
  					}
					echo "</small><br>";
  					echo "Recipe: <small>".$arr[2]."</small>";
				?></p>
            </div>     
            <div class="timeline-footer">
		<?php
                echo "<a href=\"timeline.php?username=".$username."\" class=\"pull-right\">Back to Timeline</a>";
		?>
            </div>
          </div>
        </li>
        
    </ul>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="timelineJS.js"></script>