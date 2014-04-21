#!/usr/local/bin/php

<?php
	session_start();
	if($_SESSION['login'] == "t"){
		$session_username = $_SESSION['username'];
	}else{
		$session_username = "f"; 
	}
?>

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
                <li>
                <?php
                	echo "<a href=\"timeline.php?username=".$session_username."\">My Timeline</a>";
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
		
		//Save that pid in the session
		$_SESSION['pid'] = $pid;
		
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
			echo "<h1 id=\"timeline\"><div id=\"textbox\"><p class=\"alignleft\"><img src=\"logo/banner1.png\"></p><p class=\"alignright\">Post</p></div></h1>";
	 		echo "<div style=\"clear: both;\"></div>";
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
				
		$query3 = sprintf(
			"WITH Commenters AS (SELECT Comment.message, MakeComment.uid
				FROM (Comment JOIN MakeComment ON (Comment.cid = MakeComment.cid))
				WHERE MakeComment.pid=".$pid.")
			SELECT Commenters.message, Users.username FROM (Commenters JOIN Users ON (Users.uid=Commenters.uid))");
			
		$result = pg_query($conn, $query);
		$result2 = pg_query($conn, $query2);
		$result3 = pg_query($conn, $query3);

		$numOfIngred = pg_num_rows ($result2);
		$numOfRows = pg_num_rows ($result3);

		if(!$result){
			echo "An error occured.\n";
			exit;
		}
			
		$arr = pg_fetch_row($result);
		$arr2 = pg_fetch_row($result2);
						
	?>
    </div>
    
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
		<?php
			//COMMENTS
			$count = 0;
			for ($count=0; $count<$numOfRows; $count++){
				$arr3 = pg_fetch_row($result3, $count);
				$comment = $arr3[0];
				$commenter = $arr3[1];
				echo "<li>";
				echo "<div class=\"timeline-badge primary\"><a><i class=\"glyphicon glyphicon-record\" rel=\"tooltip\" title=\"11 hours ago via Twitter\" id=\"\"></i></a></div>";
				echo "<div class=\"timeline-panel\">";
				
				echo "<div class=\"timeline-heading\">";
					//echo "<img class=\"img-responsive\" src=\"".$imgpath."\" />";
				echo "</div>";
				echo "<div class=\"timeline-body\">";
					echo "<a href=timeline.php?username=".$commenter."><b>&nbsp;&nbsp;".$commenter."</b></a>";
					echo "<p> ".$comment."</p>"; 
				echo "</div>";
				echo "</div>";
				echo "</li>";
			}
			//COMMENTS END
		?>
        
		<li>
          <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
          <div class="timeline-panel">
            <div class="timeline-body">
				<?php 
					echo "<form class=\"form-signin\" role=\"form\" action=\"comment.php\" method=\"POST\">";
				?>
					<h3 class="form-signin-heading"><div align="right">Comment&emsp;&emsp;</div></h3>
						<div class="col-xs-12">
							<input type="text" class="form-control" placeholder="Comment" required autofocus name="comment">
						</div>
						&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<div class="col-xs-5"><button class="btn btn-lg btn-primary btn-block" type="submit">Post!</button></div>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				 </form>
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