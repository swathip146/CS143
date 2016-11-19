<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
      <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
    <form method="GET">
      	<div class="box">
      		<h1 class="title center">ADD MOVIE DATA</h1>
      		<div class="field">
    	  		<h2 class="title">Title <input type="text" autocomplete="off" name="title"/></h2>
    	  		<h2 class="title">Company <input type="text" autocomplete="off" name="company"/></h2>
    	  		<h2 class="title">Year <input type="text" autocomplete="off" name="year"/></h2>
    	  		<h2 class="title">Rating <select class="selectpicker" name="rating">
				  <option value="PG-13">PG-13</option>
				  <option value="R">R</option>
				  <option value="PG">PG</option>
				  <option value="NC-17">NC-17</option>
				  <option value="surrendere">surrendere</option>
				  <option value="G">G</option>
				</select>
				</h2>
    	  		<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="Drama">Drama</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Comedy">Comedy</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Romance">Romance</label>
				</div>
				<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="Crime">Crime</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Horror">Horror</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Mystery" >Mystery</label>
				</div>
				<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="Thriller">Thriller</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Action">Action</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Adventure">Adventure</label>
				</div>
				<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Documentary">Documentary</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Family" >Family</label>
				</div>
				<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Animation">Animation</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Musical" >Musical</label>
				</div>

				<div class="checkbox-inline">
					<label><input type="checkbox" name="genre[]" value="War">War</label>
				</div>
				<div class="checkbox-inline">
				    <label><input type="checkbox" name="genre[]" value="Western">Western</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Adult" >Adult</label>
				</div>
				<div class="checkbox-inline">
					  <label><input type="checkbox" name="genre[]" value="Short" >Short</label>
				</div>
	   		</div>
      	</div>
      <input type="submit" class="submit-btn" name="submit" value="Add Movie!">  
    </form>
   </div>
   </body>

<?php
    // ini_set('error_reporting', E_ALL);
    // ini_set('display_errors', 'On');
    if(isset($_GET['title']))
    {
      $title = $_GET["title"];
      $year = $_GET["year"];
      $company = $_GET["company"];
      $rating = $_GET["rating"];
      $genre = $_GET["genre"];
      $conn = mysqli_connect("localhost","cs143","","CS143");

      // check if values are entered
      if($title == "" && $year == "" && $company == "")
      	return;
      else if($title == "")
      	echo "<div><h2 class='title'>Enter a Movie Name!</h1></div>";
      else if($year > 2030 || $year < 1900)
      	echo "<div><h2 class='title'>Enter valid year!</h1></div>";
      // Check connection
      else if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
	        // Change database to CS143
	        mysqli_select_db($conn,"CS143");
	        // find max movie id
	        $maxID = mysqli_query($conn,"SELECT MAX(id) from MaxMovieID");
	        $maxIDRow=mysqli_fetch_array($maxID,MYSQLI_NUM);
	        $maxID_old = $maxIDRow[0];
	        $maxID = $maxIDRow[0]+1;
	        $query1 = "insert into Movie(id,title,year,rating,company) values ('$maxID','$title','$year','$rating','$company')";
	        $result1=mysqli_query($conn,$query1);
	        for($i = 0; $i < count($genre); ++$i)
	        {
	        $query2 = "insert into MovieGenre values ('$maxID','$genre[$i]')";
	        // echo 'genre: '.$genre[$i];
	        $result2=mysqli_query($conn,$query2);
	        }
	        // update maxMovieId
	        $query3 = "update MaxMovieID set id = '$maxID' where id = '$maxID_old'";
	        $result3=mysqli_query($conn,$query3);
	        mysqli_close($conn);
	        if($result1 && $result2 && $result3)
	        	echo "<div><h2 class='title'>$title inserted successfully!</h2></div>";
        } 
     }
    
      ?>

</html>