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
      $actor_id = $_GET["id"];
      //echo "<h1>$actor_id</h1>";
      $conn = mysqli_connect("localhost","cs143","","CS143");
              if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($conn,"CS143");

        $query_actor = "select concat(first,' ',last) as Name,sex as Sex, dob as `Date of Birth`,dod as `Date of Death` from Actor where id = '$actor_id'";
        $query_movie_role = "select m.id as id,title as `Movie Title`, role as Role from MovieActor ma, Actor a, Movie m where a.id = '$actor_id' and ma.aid = a.id and ma.mid = m.id";
        if ($result=mysqli_query($conn,$query_actor))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Actor Information</h2>";
        echo '<table class="table table-bordered table-inverse"><thead-inverse>';  
        echo '</tr>'; //end tr tag
        echo '<thead><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></thead>';
        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td>". $row['Name']."</td><td>".$row['Sex']."</td><td>".$row['Date of Birth']. '</td>';
                if($row['Date of Death'] === "" || $row['Date of Death'] === NULL)
                  $row['Date of Death'] = 'Till Today';
                echo "<td>".$row['Date of Death']."</td>";   
            echo '</tr>';
        }
        echo "</table>";
        
        // Free result set
        mysqli_free_result($result);
      }

      // display actor movies and role
      echo "<h2 class='title'>The Actor's Movies and Roles</h2>";
      echo '<table class="table table-bordered table-inverse"><thead-inverse>';  
      echo '</tr>'; //end tr tag
      echo '<thead><th>Movie Title</th><th>Role</th></thead>';
      if ($result=mysqli_query($conn,$query_movie_role))
        {
        // an array for all the attributes
        $all_property = array();  

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td><a href='movie_info.php?id=".$row["id"]."'>".$row['Movie Title']."</td><td>\"".$row['Role']."\"</td>";
            echo '</tr>';
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
      }        
    
      ?>

</html>