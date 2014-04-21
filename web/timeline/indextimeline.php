#!/usr/local/bin/php

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
	}
?>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="timelineCSS.css" rel="stylesheet">
<link href="css/simple-sidebar.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"><a href="#">Today's Meal</a>
                </li>
                <li><a href="indextimeline.php">Dashboard</a>
                </li>
                <li>
                <?php
                	echo "<a href=\"timeline.php?username=".$session_username."\">My Timeline</a>"
                ?>
                </li>
                <li><a href="search.php">Search</a>
                </li>
                <li><a href="newPost.php">Post</a>
                </li>
                <li><a href="homepage.php?login=logout">Logout</a>
                </li>
                
            </ul>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
	

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
			
			echo "<h1 id=\"timeline\"><div id=\"textbox\"><p class=\"alignleft\"><img src=\"logo/banner1.png\"></p><p class=\"alignright\">Dashboard</p>&emsp;&emsp;&emsp;&emsp;&emsp;</div></h1>";
			echo "<div style=\"clear: both;\"></div>";
			
		?>
    </div>
    <ul class="timeline">
        <?php 
				//Then make the query
				$query = sprintf("WITH Userposts AS(
					SELECT Users.uid, pid, Users.username
					FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid)))
				SELECT Userposts.uid, Userposts.pid, active, date, caption, recipe, Userposts.username, imgpath
				FROM (Userposts JOIN Post ON (Userposts.pid = Post.pid))
				WHERE active =true;");
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
	        		$imgpath = $currRow[7];
	        	
	        		//for each row, create the list object and div class inside of it
	        		if($inverted){ //if it's inverted, make sure to put this in the list
	        			echo "<li class=\"timeline-inverted\">";
	          		}else{
	          			echo "<li>";
	          		}
	          		echo "<div class=\"timeline-badge primary\"><a><i class=\"glyphicon glyphicon-record\" rel=\"tooltip\" title=\"11 hours ago via Twitter\" id=\"\"></i></a></div>";
	          		echo "<div class=\"timeline-panel\">";
	            	echo "<div class=\"timeline-heading\">";
	            		echo "<img class=\"img-responsive\" src=\"".$imgpath."\" />";
	            	echo "</div>";
	        		echo "<div class=\"timeline-body\">";
						echo "<a href=timeline.php?username=".$username."><b>&nbsp;&nbsp;".$username."</b></a>";
	            		echo "<p> ".$caption."</p>"; 
	           		echo "</div>";
	            
	            	echo "<div class=\"timeline-footer\">";
						echo "<a class=\"pull-left\">".$date."</a>";
	                	//echo "<a><i class=\"glyphicon glyphicon-thumbs-up\"></i></a>";
	                	//echo "<a><i class=\"glyphicon glyphicon-share\"></i></a>";
	                	echo "<a href=\"postPage.php?pid=".$pid."\" class=\"pull-right\">View Post</a>";
	            	echo "</div>";
	            	echo "</div>";
	        		echo "</li>";
	        		
	        		$inverted = !$inverted; //flip which side the post will be on each time
					
	        	}
			?>
        
        <li class="clearfix" style="float: none;"></li>
    </ul>
</div>


			</div>
        </div>

</div>

<script src="js/bootstrap.min.js"></script>
<script src="timelineJS.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
    <!-- Custom JavaScript for the Menu Toggle -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
</script>
