#!/usr/local/bin/php

<link href="css/bootstrap.css" rel="stylesheet">
<link href="timelineCSS.css" rel="stylesheet">
	

<div class="container">
    <div class="page-header text-center">
		<?php
			$conn = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123');
	
			if(!$conn){
				echo "Connection failed";
				$connEstablished = false;
			}else{
				$connEstablished = true;
			}
		?>
    </div>
    <ul class="timeline">
        <?php 
				//Then make the query
				$ingnum= $_GET['SearchNumIng'];
				$query = sprintf("SELECT COUNT(Stores.ingid) as count1, pid FROM Ingredient, Stores
						WHERE Ingredient.ingid=Stores.ingid GROUP BY pid HAVING COUNT(Stores.ingid) = $ingnum;");
				$result = pg_query($conn, $query);
				//Find the number of divs you will need to generate
				$numOfRows = pg_num_rows ($result);
	
				if(!$result){
					echo "An error occured.\n";
					exit;
				}
	        	
	        	//make a boolean to track whether the post will be on the left or right.
	        	$inverted = false;
	        	$count = 0;
	        	for ($count=0; $count<$numOfRows; $count++){
					$currRow = pg_fetch_row($result, $count);
	        		$caption = $currRow[4];
	        		$isActive = $currRow[2];
	        		$date = $currRow[3];
					$pid = $currRow[1];
					$username = $currRow[6];
	        	
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
						echo "<a href=http://cise.ufl.edu/~js7/Pieazza/web/timeline/timeline.php?username=".$username."><b>&nbsp;&nbsp;".$username."</b></a>";
	            		echo "<p> ".$caption."</p>"; 
	           		echo "</div>";
	            
	            	echo "<div class=\"timeline-footer\">";
						echo "<a class=\"pull-left\">".$date."</a>";
	                	//echo "<a><i class=\"glyphicon glyphicon-thumbs-up\"></i></a>";
	                	//echo "<a><i class=\"glyphicon glyphicon-share\"></i></a>";
	                	echo "<a href=\"postPage.php?username=".$username."&pid=".$pid."\" class=\"pull-right\">View Post</a>";
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
