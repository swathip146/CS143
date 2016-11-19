<!DOCTYPE html>
<title>CS 143 - Project 1A</title>
<body>
		<h1>CS 143 - Project 1A </h1>
		<h2>PHP Calculator</h2>
		<h3>Constraints</h3>
		<ol start="1">
			<li>No alphabets or alphanumeric characters</li>
			<li>'--' will be converted to '+'</li>
			<li>Parantheses aren't supported!</li>
		</ol>
		<?php
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 'On');


		// define variables and set to empty values
		$expr = $expr1 = $solution = $message = "";


		function display($expr,$expr1,$solution,$message)
		{
		echo "<h4>Expression: ".$expr1."</h4>";
		echo "<h4>Message: ".$message."</h4>";
		if(!empty($solution))
			echo "<h4>Solution: ".$solution."</h4>";
		else
			echo "<h3 style='color:red;text-transform:uppercase;'>No Solution!</h3>";
		}


		if(isset($_GET['expr']))
		{
		  $expr = $expr1 = $_GET["expr"];

		  // remove whitespaces
		  $expr = preg_replace('/\s+/', '', $expr);

		  // replace ++ and -- with + 
		  $expr = preg_replace('/(--)/', '+', $expr);

		  // check for 0 division error
		  $expr_pattern_zero_div = "\/[0]$";

		  $expr_pattern = "^[+-]?[^a-zA-Z]*[0-9]*[.]?[0-9]+((([+-\/]{1}|[*]{1,2}))+[0-9]+)*[^a-zA-Z]*";
		  
		  if(preg_match("/$expr_pattern_zero_div/", $expr))
		  	$message = "Division by Zero!";

		  elseif(!preg_match("/$expr_pattern/",$expr))
		  	$message = "Invalid Expression!";
		  
		  else
		  	{	
		  		try{
		  		eval("\$solution = $expr;");
		  		if($solution == 0)
		  			$solution = "0.0";
		  		$message = "Valid Expression!";
		  		}
		  		catch(ParseError $e){
		  			$message = "Invalid Expression...Can't calculate!";
		  		}
		  	}
		  	  display($expr,$expr1,$solution,$message);
		 }
		
		  ?>


		<form method="GET">
			<h3>Enter expression: <input type="text" name="expr" autocomplete="off" autofocus></h3>
			<br/>
			<input type="submit" name="submit" value="Submit">  
		</form>
</body>