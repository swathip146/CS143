
<html>
<head><title>CS143 Project 1B</title></head>
<body>
<p>

<p>Please do not run a complex query here. You may kill the server. </p>
Type an SQL query in the following box: <p>
Example: <tt>SELECT * FROM Actor WHERE id=10;</tt><br />
<p>
<form action="<?php echo $query;?>" method="GET">
<textarea name="query" cols="60" rows="8"></textarea><br />
<input type="submit" value="Submit" />
</form>
</p>
<p><small>Note: tables and fields are case sensitive. All tables in Project 1B are availale.</small>
</p>

<h3>Results from MySQL:</h3>
<p>
<?php
echo $query
</p>