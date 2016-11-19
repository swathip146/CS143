<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
<?php
$conn = mysqli_connect("localhost","cs143","","CS143");
              if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_select_db($conn,"CS143");

 ?>
      <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
    <form method="POST">
        <div class="box">
          <h1 class="title center">ADD ACTOR TO MOVIE</h1>
          <div class="field">
            <select name= 'title' class='form-control selectpicker'>
              <?php
                            echo '<option value="$title">'.'Select Movie Title'.'</option>';
                            $sql = "SELECT title FROM Movie order by title";
                            $query = mysqli_query($conn,$sql);
                  while($row=mysqli_fetch_array($query,MYSQLI_NUM)){
                            echo "<option value='". $row[0]."'>".$row[0]. '</option>';
                            }
                        ?>
                        </select>
                        <br/>
                        <select name= 'actor' class='form-control selectpicker'>
                   <?php
                    
                            echo '<option value="$actor">'.'Select Actor Name'.'</option>';
                            $sql = "SELECT concat(first,' ',last) FROM Actor order by first";
                            $query = mysqli_query($conn,$sql);
                  while($row=mysqli_fetch_array($query,MYSQLI_NUM)){
                            echo "<option value='". $row[0]."'>".$row[0]. '</option>';
                            }
                        ?>
                        </select>
                    
            <h2 class="title">Role <input type="text" autocomplete="off" name="role"/></h2>
                    
        </div>
        </div>
        <br/>
      <input type="submit" class="submit-btn" name="submit" value="Done!">  
    </form>
   </div>
   </body>

<?php
    // ini_set('error_reporting', E_ALL);
    // ini_set('display_errors', 'On');
    if(isset($_POST['title']))
    {
      $title = $_POST["title"];
      $actor = $_POST["actor"];
      $role = $_POST["role"];
      
      // check if values are entered
      if($title == "")
        echo "<div><h2 class='title'>Select a Movie Name from the List!</h1></div>";
      else if($actor == "")
        echo "<div><h2 class='title'>Select an Actor's Name from the List!</h1></div>";
      else if($role == "")
        echo "<div><h2 class='title'>Enter a Role!</h1></div>";

      else
        {
          // find movie id from Movie
          $mid = mysqli_query($conn,"SELECT id from Movie where title = '$title'");
          // find actor id from Actor
          $aid = mysqli_query($conn,"SELECT id from Actor where concat(first,' ',last) like '$actor'");
          $midRow=mysqli_fetch_array($mid,MYSQLI_NUM)[0];
          $aidRow=mysqli_fetch_array($aid,MYSQLI_NUM)[0];
          // insert into MovieActor
          $query1 = "insert into MovieActor(mid,aid,role) values ('$midRow','$aidRow','$role')";
          $result1=mysqli_query($conn,$query1);
          mysqli_close($conn);
          if($result1)
            echo "<div><h2 class='title'>Inserted successfully!</h2></div>";
        } 
     }
    
      ?>

</html>