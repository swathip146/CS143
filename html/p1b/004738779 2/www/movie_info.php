<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
   <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
   
   </div>
   </body>

<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 'On');
      $movie_id = $_GET["id"];
      $conn = mysqli_connect("localhost","cs143","","CS143");
              if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($conn,"CS143");

        $query_movie = "select title, year, company, rating from Movie where id='$movie_id'";
        $query_actor = "select a.id as id,concat(first,' ',last) as Name, role as Role from Actor a, MovieActor ma where a.id =  ma.aid and ma.mid='$movie_id'";
        $query_comment = "select name,rating,comment from Review where mid='$movie_id'";
        $query_avg = "select avg(rating) as average from Review where mid = '$movie_id'";
       // $query_movie_role = "select title as `Movie Title`, role as Role from MovieActor ma, Actor a, Movie m where a.id = '$actor_id' and ma.aid = a.id and ma.mid = m.id";
        if ($result=mysqli_query($conn,$query_movie))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Movie Information</h2>";
        echo '<table class="table table-bordered table-inverse"><thead-inverse>';  
        echo '</tr>'; //end tr tag
        echo "<tr>";
                echo "<thead><th>Title</th>";
                echo "<th>Year:</th>";
                echo "<th>Producer:</th>";
                echo "<th>MPAA Rating:</th></thead>";
                
            echo '</tr>';
        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td>".$row['title']."</td>";
                echo "<td>".$row['year']."</td>";
                echo "<td>".$row['company']."</td>";
                echo "<td>".$row['rating']."</td>";
                
            echo '</tr>';
        }
        echo "</table>";
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }

       if ($result=mysqli_query($conn,$query_actor))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Actors</h2>";
        echo '<table class="table table-bordered"><thead-inverse>';  
        echo '</tr>'; //end tr tag

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td><a href='actor_info.php?id=".$row["id"]."'>". $row['Name']."</td><td>" .$row['Role']. '</a></td>'; 
            echo '</tr>';
        }
                   echo '</tr>';
        
        echo "</table>";
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }

      if ($result=mysqli_query($conn,$query_avg))
        {
        // an array for all the attributes
         

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Average Rating</h2>";
        

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
                
                $avg = $row['average'];
                if($avg === "" || $avg === NULL)
                  $avg = "Nobody's rated this movie yet!";
                else $avg ="The average rating is:". $avg;
                echo $avg; 
            
        }
                  
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }

      if ($result=mysqli_query($conn,$query_comment))
        {
        // an array for all the attributes
         

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>User comments</h2>";
        

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
                echo $row['name']." has given a ". $row['rating']." and reviewed as:" . $row['comment']; 
        }
        echo "<a class='submit-btn' href='add_comments.php?id=".$movie_id."'>Add Comment</a>";
                  
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }
    
      ?>

</html>