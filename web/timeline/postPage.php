#!/usr/local/bin/php

<link href="css/bootstrapPOST.css" rel="stylesheet">
<link href="postPageCSS.css" rel="stylesheet">
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
                <li><a href="#">Search</a>
                </li>
                <li><a href="#">Logout</a>
                </li>
                <li><a href="#">&nbsp;</a>
                </li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas id dui vitae libero semper placerat id et mauris. Sed fermentum lorem eu fermentum semper. Pellentesque blandit. 
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
        <h1 id="timeline"></h1>
    </div>
    <?php
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
		
		//first get the pid stored in the URL
		$pid = $_GET["pid"];
		
		//make sure that pid exists
		$query = sprintf("SELECT EXISTS(SELECT * FROM Post WHERE pid = '".$pid."');");
		$result = pg_query($conn, $query);
		if(!$result){
			echo "An error occured.\n";
			exit;
		}
		
		$pidExists = pg_fetch_result($result, 0, "exists");
		
		if($pidExists == "t"){
			$query = sprintf("SELECT pid FROM Post WHERE pid = '".$pid."';");
			$result = pg_query($conn, $query);

			if(!$result){
				echo "An error occured.\n";
				exit;
			}

			$temp = pg_fetch_row($result, 0);
			$pid = $temp[0];
			//echo "<h1 id=\"timeline\">".$pid."</h1>";
		}
		
		$query = sprintf(
			"WITH Userposts AS(
				SELECT username, pid
				FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid))
				WHERE pid=".$pid.")
			SELECT username, caption, recipe, Post.pid, imgpath FROM (Userposts JOIN Post ON (Post.pid = Userposts.pid))");

		$query2 = sprintf(
			"SELECT Ingredient.amount, Ingredient.units, Ingredient.name
				FROM (Stores JOIN Ingredient ON (Ingredient.ingid = Stores.ingid))
				WHERE Stores.pid=".$pid);
			
		$result = pg_query($conn, $query);
		$result2 = pg_query($conn, $query2);

		$numOfIngred = pg_num_rows ($result2);

		if(!$result){
			echo "An error occured.\n";
			exit;
		}
			
		$arr = pg_fetch_row($result);
		$arr2 = pg_fetch_row($result2);
						
	?>
    
    
    <ul class="timeline">   
        <li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
            <?php
              echo "<img class=\"img-responsive\" src=\"".$arr[4]."\" />"
             ?> 
            </div>
            <div class="timeline-body">
            <p>
            <?php 
				if($pidExists == "f"){
					echo "<h1 id=\"timeline\">Error: pID \"".$pid."\" does not exists</h1>";
				}else{
					echo "<i>&#34;".$arr[1]."&#34;</i>";
					echo " -- " . "<a href=\"timeline.php?username=" . $arr[0] . "\">" . $arr[0] . "</a><br><br>";
					echo "Ingredients: <br><small>";
					for ($count=0; $count<$numOfIngred; $count++){
						$currRow = pg_fetch_row($result2, $count);
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$currRow[2]." ".$currRow[0]." ".$currRow[1]."<br>";
					}
					echo "</small><br>";
					echo "Recipe: <small>".$arr[2]."</small>";
				}
			?>
			</p>
            </div>     
            <div class="timeline-footer">
		<?php
                echo "<a href=\"indextimeline.php\" class=\"pull-right\">Back to Dashboard</a>";
		?>
            </div>
          </div>
        </li>
        
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