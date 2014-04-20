#!/usr/local/bin/php
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
                <li><a href="#">My Timeline</a>
                </li>
                <li><a href="search.php">Search</a>
                </li>
                <li><a href="homepage.php">Logout</a>
                </li>
                <li><a href="#">&nbsp;</a>
                </li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas id dui vitae libero semper placerat id et mauris. Sed fermentum lorem eu fermentum semper. Pellentesque blandit, lorem at consequat rutrum, magna arcu consectetur massa, at tempor magna purus ut sem. Aliquam sodales laoreet massa nec semper. 
                </li>
                <li><a href="#"></a>
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
			echo "<h1 id=\"timeline\"><div id=\"textbox\"><p class=\"alignleft\"><img src=\"logo/banner1.png\"></p><p class=\"alignright\">Timeline of ".$username."</p></div></h1>";
			echo "<div style=\"clear: both;\"></div>";	
			}else{
				echo "<h1 id=\"timeline\">Error: Username \"".$username."\" does not exists</h1>";
			}
		?>
    </div>
    <ul class="timeline">
        <!-- Keeping this around to see how the pic fits in
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <img class="img-responsive" src="http://lorempixel.com/1600/500/sports/2" />
              
            </div>
            <div class="timeline-body">
            	<?php 
					/*
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
 		 	
					*/
				?>
            </div>
            
            <div class="timeline-footer">
                <a><i class="glyphicon glyphicon-thumbs-up"></i></a>
                <a><i class="glyphicon glyphicon-share"></i></a>
                <a class="pull-right">Continu</a>
            </div>
          </div>
        </li>
        
        -->
        <?php 
			if($usernameExists == "t"){
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
				WHERE Users.uid = ".$uid.")
				SELECT Userposts.uid, Userposts.pid, active, date, caption, recipe, imgpath
				FROM (Userposts JOIN Post ON (Userposts.pid = Post.pid))
				WHERE active =true
				ORDER BY date DESC;");
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
					$imgpath = $currRow[6];
	        	
	        		//for each row, create the list object and div class inside of it
	        		if($inverted){ //if it's inverted, make sure to put this in the list
	        			echo "<li class=\"timeline-inverted\">";
	          		}else{
	          			echo "<li>";
	          		}
	          		echo "<div class=\"timeline-badge primary\"><a><i class=\"glyphicon glyphicon-record\" rel=\"tooltip\" title=\"11 hours ago via Twitter\" id=\"\"></i></a></div>";
	          		echo "<div class=\"timeline-panel\">";
	            	/*
	            	<div class="timeline-heading">
              			<img class="img-responsive" src="http://lorempixel.com/1600/500/sports/2" />              
            		</div>
	            	*/
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
	                	echo "<a href=\"postPage.php?username=".$username."&pid=".$pid."\" class=\"pull-right\">View Post</a>";
	            	echo "</div>";
	            	echo "</div>";
	        		echo "</li>";
	        		
	        		$inverted = !$inverted; //flip which side the post will be on each time
					
	        	}
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