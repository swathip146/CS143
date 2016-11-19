<!DOCTYPE html>
<title>CS 143 - Project 1B</title>
<style>
table{
  border:1px solid #000;
}
td{
  border:1px solid #000;
  padding:10px;
  text-align: center;
}
th{

}
</style>
<body>
    <h1>CS 143 - Project 1B </h1>
    <h3>Hey There!</h3>
    <form method="GET">
      <h3>Enter a <em>valid</em> SQL Query: </h3>
      <textarea name="query" rows="10" cols="80" autofocus></textarea>
      <br/>
      <input type="submit" name="submit" value="Submit">  
    </form>

    <?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 'On');

    if(isset($_GET['query']))
    {
      $query = $_GET["query"];
      echo "<h4>You typed: <em>$query</em></h4>";
      $conn = mysqli_connect("localhost", "cs143", "","mysql");
      // Check connection
      if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
        // Change database to CS143
        mysqli_select_db($conn,"CS143");
        if ($result=mysqli_query($conn,$query))
        {
        // an array for all the attributes
        $all_property = array();  

        // Initializing table
        echo '<table class="data-table">
                <tr class="data-heading">';  
        while ($property = mysqli_fetch_field($result)) {
            // Saving the table headers
            echo '<td>' . $property->name . '</td>';  
            array_push($all_property, $property->name);  
        }
        echo '</tr>'; //end tr tag

        // Displays selected records in the form of a table
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            foreach ($all_property as $item) {
                echo '<td>' . $row[$item] . '</td>'; 
            }
            echo '</tr>';
        }
        echo "</table>";

        // Free result set
        mysqli_free_result($result);
      }

      mysqli_close($conn);
        } 
      
     }
    
      ?>

</body>