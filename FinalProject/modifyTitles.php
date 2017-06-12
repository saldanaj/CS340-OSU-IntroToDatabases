<!--PHP code to enable the server connection to the server --> 

<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the titles table.  
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<?php  

	$titleName = $_POST["TitleEntered"]; 

	echo $titleName; 
	echo "<br/>";   

	if(isset($_POST["AddTitle"]))
	{
		if(strcmp($titleName, "") == 0) 
		{
			echo "An error occured.  Please ensure you entered a title name to add.  You cannot add an empty string to the table"; 
			echo "<br/>"; 
		}
		else
		{
			if(!($stmt = $mysqli->prepare("INSERT INTO titles(title_name) VALUES (?)")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("s", $titleName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Added " . $stmt->affected_rows . " row(s) to titles.";
			}

			echo "<br/>"; 

		}

	}
	else 
	{
		if(strcmp($titleName, "") == 0) 
		{
			echo "An error occured.  Please ensure you entered a title name to remove.  You cannot remove an empty string to the table"; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("DELETE FROM titles WHERE title_name = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("s", $titleName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Removed " . $stmt->affected_rows . " row(s) to titles.";
			}

			echo "<br/>"; 
		}

	}




	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>