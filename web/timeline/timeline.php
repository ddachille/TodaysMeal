#!/usr/local/bin/php

<link href="css/bootstrap.css" rel="stylesheet">
<link href="timelineCSS.css" rel="stylesheet">
	

<div class="container">
    <div class="page-header text-center">
        <h1 id="timeline">Today's Meal</h1>
    </div>
    <ul class="timeline">
        
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <img class="img-responsive" src="http://lorempixel.com/1600/500/sports/2" />
              
            </div>
            <div class="timeline-body">
            	<?php 

					#let's access some databases.  username=js7 password=MealAdminOfDoom123

					$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
  	
					if(!$conn){
  						echo "Connection failed";
					}
  	
  					$query = sprintf("WITH Userposts AS(
					SELECT Users.uid, pid
					FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid))
					WHERE Users.uid = 15)
					SELECT Userposts.uid, Userposts.pid, active, date, caption, recipe
					FROM (Userposts JOIN Post ON (Userposts.pid = Post.pid));");
					$result = pg_query($conn, $query);
  	
					if(!$result){
  						echo "An error occured.\n";
  						exit;
  					}
  					
  					$arr = pg_fetch_row($result);
  					echo $arr[0];
  					echo $arr[1];
  					echo $arr[2]; 
  					echo $arr[3];
  					echo $arr[4];
  					
  					
  				#	$query2 = sprintf("SELECT username FROM Users WHERE uid = 17" . $arg[0]);
 				# 	$result2 = pg_query($conn, $query2);
 				# 	$arr2 = pg_fetch_row($result2);
 				# 	echo "Username: " . $arr2[0];
 				 	echo $arr[4];
 		 	

				?>
            </div>
            
            <div class="timeline-footer">
                <a><i class="glyphicon glyphicon-thumbs-up"></i></a>
                <a><i class="glyphicon glyphicon-share"></i></a>
                <a class="pull-right">Continuar Lendo</a>
            </div>
          </div>
        </li>
        
        
        <?php 
        	//This PHP scrip makes a query for all uid=15 posts
        	//It then creates a div box for each post with a for loop
        	
        	//First connect to the database        	
        	$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
  	
			if(!$conn){
				echo "Connection failed";
			}
			
			//Then make the query
			$query = sprintf("WITH Userposts AS(
			SELECT Users.uid, pid
			FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid))
			WHERE Users.uid = 15)
			SELECT Userposts.uid, Userposts.pid, active, date, caption, recipe
			FROM (Userposts JOIN Post ON (Userposts.pid = Post.pid));");
			$result = pg_query($conn, $query);
			//Find the number of divs you will need to generate
			$numOfRows = pg_num_rows ($result);

			if(!$result){
				echo "An error occured.\n";
				exit;
			}
        	
        	//make a boolean to track whether the post will be on the left or right.
        	$inverted = true;
        	$count = 0;
        	for ($count=0; $count<$numOfRows; $count++){
        		//for each row, create the list object and div class inside of it
        		if($inverted){ //if it's inverted, make sure to put this in the list
        			echo "<li class=\"timeline-inverted\">";
          		}else{
          			echo "<li>";
          		}
          		echo "<div class=\"timeline-badge primary\"><a><i class=\"glyphicon glyphicon-record\" rel=\"tooltip\" title=\"11 hours ago via Twitter\" id=\"\"></i></a></div>";
          		echo "<div class=\"timeline-panel\">";
            	echo "<div class=\"timeline-heading\">";
            	  
            	echo "</div>";
        		echo "<div class=\"timeline-body\">";
            		$currRow = pg_fetch_row($result, $count);
            		echo "<p>".$currRow[4]."</p>"; 
           		echo "</div>";
            
            	echo "<div class=\"timeline-footer\">";
                	echo "<a><i class=\"glyphicon glyphicon-thumbs-up\"></i></a>";
                	echo "<a><i class=\"glyphicon glyphicon-share\"></i></a>";
                	echo "<a class=\"pull-right\">Continuar Lendo</a>";
            	echo "</div>";
            	echo "</div>";
        		echo "</li>";
        		$inverted = !$inverted; //flip which side the post will be on each time
        	
        	}
        ?>
        
        <li class="clearfix" style="float: none;"></li>
    </ul>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="timelineJS.js"></script>