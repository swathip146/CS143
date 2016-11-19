<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
   <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
   
   </div>
   </body>

<?php
     // ini_set('error_reporting', E_ALL);
     // ini_set('display_errors', 'On');
    if(isset($_GET['search_text']))
    {
      $search_text1 = $_GET["search_text"];
      $search_text = explode(' ',strtolower($search_text1));  
      // echo "<h1>$search_text[0]</h1>";
      $conn = mysqli_connect("localhost","cs143","","CS143");
              if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($conn,"CS143");

        $query_actor = "select id,concat(first,' ',last) as Name,dob as DOB from Actor where first like '%$search_text[0]%' and last like '%$search_text[1]%' or last like '%$search_text[0]%' and first like '%$search_text[1]%'";
      //   /*$query_movie = "select id,title as Title,year as Year from Movie where title like '%$search_text[0]%'";
        
        // for($i=1; $i<count($search_text);++$i)
          // $query_movie = $query_movie." and title like '%search_text[$i]%' "%' . $individual_term . '%"";*/
        $query_movie = "SELECT Movie.id, Movie.title as Title, Movie.year as Year FROM Movie WHERE 1";
        foreach ($search_text as $individual_term=>$value ) {
          # code...
          $query_movie .=" AND replace(lower(Movie.title),',','') LIKE '%" . $value . "%'";
        }
        // echo $query_movie;
        if ($result=mysqli_query($conn,$query_actor))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Actors</h2>";
        echo '<table class="table table-bordered table-inverse"><thead-inverse>';  
        echo '</tr>'; //end tr tag

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td><a href='actor_info.php?id=".$row["id"]."'>". $row['Name']."</td><td>" .$row['DOB']. '</a></td>'; 
            echo '</tr>';
        }
        echo "</table>";
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }

       if ($result=mysqli_query($conn,$query_movie))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo "<div class='col-md-10 col-md-push-1'>";
        echo "<h2 class='title'>Movies</h2>";
        echo '<table class="table table-bordered"><thead-inverse>';  
        echo '</tr>'; //end tr tag

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td><a href='movie_info.php?id=".$row["id"]."'>". $row['Title']."</td><td>" .$row['Year']. '</a></td>'; 
            echo '</tr>';
        }
                   echo '</tr>';
        
        echo "</table>";
        echo "</div>";
        // Free result set
        mysqli_free_result($result);
      }

     }
    
      ?>

</html>