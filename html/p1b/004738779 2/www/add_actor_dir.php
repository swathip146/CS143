<!DOCTYPE html>
<title>CS 143 - Project 1C</title>
<html>
   <body>
      <?php include("navbar.php"); ?>
   <div class="col-md-10 col-md-push-1">
    <form method="GET">
      	<div class="box">
      		<h1 class="title center">ADD ACTOR/DIRECTOR DATA</h1>
      		<div class="field">
            <div>Select Actor/Director</div>
            <div class="radio-inline">
          <label><input type="radio" name="val" value="Actor">Actor</label>
            </div>
            <div class="radio-inline">
          <label><input type="radio" name="val" value="Director">Director</label>
            </div>
    	  		<h2 class="title">LAST NAME<input type="text" autocomplete="off" name="last"/></h2>
    	  		<h2 class="title">FIRST NAME <input type="text" autocomplete="off" name="first"/></h2>
            <div>GENDER</div>
            <div class="radio-inline">
          <label><input type="radio" name="sex" value="Male">Male</label>
            </div>
            <div class="radio-inline">
          <label><input type="radio" name="sex" value="Female">Female</label>
            </div>
          <div>
    	  		<h2 class="title">DATE OF BIRTH <input type="text"  name="dob"/></h2>
            <h3><muted>yyyy-mm-dd</muted></h3>
          </div>
          <div>
    	  		<h2 class="title">DATE OF DEATH <input type="text" name="dod"/></h2>
            <h3><muted>Leave this field empty if still alive!</muted></h3>
    	  	</div>
          </div>
    	</div> 		
      <input type="submit" class="submit-btn" name="submit" value="Add!"/>  
    </form>
   </div>
   </body>

<?php
    // ini_set('error_reporting', E_ALL);
    // ini_set('display_errors', 'On');
    if(isset($_GET['val']))
    {
      $val = $_GET["val"];
      $last = $_GET["last"];
      $first = $_GET["first"];
      $sex = $_GET["sex"];
      $dob = htmlspecialchars($_GET["dob"]);
      $dod = htmlspecialchars($_GET["dod"]);

      $dob_parse = date_parse($dob);

      $conn = mysqli_connect("localhost","cs143","","CS143");
      if($val=="")
        return;
       //check if values are entered
      if( $last == "" && $first == "")
      	return;

      if($dob_parse["year"] > date("Y"))
      	echo "<div><h2 class='title'>Enter a valid year!</h2></div>";
      if($dod === "")
          $dod = NULL;
      else
          {
            $dod_parse = date_parse($dod);
            if($dod_parse["year"] > date("Y"))
              echo "<div><h2 class='title'>Enter a valid year!</h2></div>";
          }
      // Check connection*/
       if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
	        // Change database to CS143
	        mysqli_select_db($conn,"CS143");
	        // find max movie id
	        $maxID = mysqli_query($conn,"SELECT max(id) from MaxPersonID");
          $maxIDRow=mysqli_fetch_array($maxID,MYSQLI_NUM);
          $maxID_old = $maxIDRow[0];
          $maxID = $maxIDRow[0]+1;

         if($val=="Actor")
          { if($dod === NULL)
            {
              //echo "DOD NULL".$sex.$last.$first.$maxID;
            $query1 = "insert into Actor(id, last, first, sex,dob,dod) values ('$maxID','$last','$first','$sex','$dob',NULL)";
            }
            else
            $query1 = "insert into Actor(id, last, first, sex, dob, dod) values ('$maxID','$last','$first','$sex','$dob','$dod')";
            $result1=mysqli_query($conn,$query1);
          }
	        else if($val=="Director")
          { if($dod === NULL)
            $query1 = "insert into Director(id, last, first, dob) values ('$maxID','$last','$first','$dob')";
            else
            $query1 = "insert into Director(id, last, first, dob, dod) values ('$maxID','$last','$first','$dob','$dod')";
            $result1=mysqli_query($conn,$query1);
          }
	        
	        // update maxMovieId
	        $query3 = "update MaxPersonID set id = '$maxID' where id = '$maxID_old'";
	        $result3=mysqli_query($conn,$query3);
	        mysqli_close($conn);
	        if($result1 && $result3)
	        	echo "<div><h2 class='title'>$val inserted successfully!</h2></div>";
        } 
     }
      ?>

</html>