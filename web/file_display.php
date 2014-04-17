<?php
 include "file_constants.php";
 // just so we know it is broken
 error_reporting(E_ALL);
 // some basic sanity checks
 if(isset($_GET['id']) && is_numeric($_GET['id'])) {
     //connect to the db
     $link = pg_connect('user=js7 host=postgres dbname=meal password=MealAdminOfDoom123') or die("Could not connect: " . pg_last_error());

     // get the image from the db
     $sql = "SELECT image FROM test_image WHERE id=" .$_GET['id'] . ";";

     // the result of the query
     $result = pg_query("$sql") or die("Invalid query: " . pg_last_error());

     // set the header for the image
     header("Content-type: image/jpeg");
     echo pg_result($result, 0);

     // close the db link
     pg_close($link);
 }
 else {
     echo 'Please use a real id number';
 }
?>