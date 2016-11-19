<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
      <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
    <form method="POST">
      	<div class="box">
      		<h1 class="title center">ADD COMMENTS</h1>
      		<div class="field">
    	  		<h2 class="title">MOVIE NAME : 
              <?php
                $movie_id = $_GET['id'];
                $conn = mysqli_connect("localhost","cs143","","CS143");
                // Check connection
                if (mysqli_connect_errno())
                  {
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  }
                  else
                  {
                    // Change database to CS143
                    mysqli_select_db($conn,"CS143");
                    $query0 = "select title from Movie where id='$movie_id'";
                    $result0=mysqli_query($conn,$query0);
                    while($row = $result0->fetch_assoc()){
                      $movie_name=$row['title'];
                      echo $row['title'];}
                  }
              ?>
            </h2>
          </div>
          <div class="field">
            <h2 class="title">REVIEWER'S NAME <input  autofocus type="text" autocomplete="off" name="rname"/></h2>
          </div>
        </div>
        <div>
          <div class="field">
            <h2 class="title">RATING
              <select class="selectpicker" name="rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            </h2>
          </div>
        </div>
        <div>
          <div>  
    	  		<h2 class="title">COMMENT</h2>
            <textarea  name="query" rows="10" cols="80"></textarea>
        </div>
    	</div> 		
      <input type="submit" class="submit-btn" name="submit" value="Add!"/>  
    </form>

   </div>
   </body>

<?php
    // ini_set('error_reporting', E_ALL);
    // ini_set('display_errors', 'On');
    if(isset($_POST['rname']))
    {
      $name = $_POST["rname"];
      $comment = $_POST["query"];
      $rating = $_POST["rating"];
      $conn = mysqli_connect("localhost","cs143","","CS143");
      // check if values are entered
      if( $name == "")
      	echo "Enter your name!";
      // Check connection
      else if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
	        // Change database to CS143
	        mysqli_select_db($conn,"CS143");
          $query1 = "insert into Review(name, mid, rating, comment) values ('$name','$movie_id','$rating','$comment')";
          $result1=mysqli_query($conn,$query1);
          if($result1)
            echo "<div><h2 class='title'>You just added your comment successfully!</h2></div>";
	        mysqli_close($conn);
        } 
     }
      ?>

</html>