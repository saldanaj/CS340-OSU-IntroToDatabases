<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the characters and titles associated with them table.  
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<?php  

	$char_firstName = $_POST["Char_FirstName"]; 
	$char_lastName = $_POST["Char_LastName"]; 
	$char_TitleEntered = $_POST["Char_TitleAssociation"]; 

	echo $char_firstName . " + " . $char_lastName . " + " . $char_TitleEntered; 
	echo "<br/>";  


	if(isset($_POST["AddCharTitle"]))
	{
		if(strcmp($char_firstName, "") == 0 || strcmp($char_lastName, "") == 0)
		{
			echo "An error occured.  Please ensure you entered a first and last name to add to the table.  You cannot add an empty string to the table"; 
			echo "<br/>"; 
		}
		else
		{
			if(!($stmt = $mysqli->prepare("INSERT INTO character_title(char_id, title_id) VALUES ((SELECT id FROM characters WHERE first_name = ? AND last_name = ?) ,?)")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("ssi",$char_firstName, $char_lastName, $char_TitleEntered)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Added " . $stmt->affected_rows . " row(s) to character titles.";
			}

			echo "<br/>"; 
		}
	}
	else
	{
		if(strcmp($char_firstName, "") == 0 || strcmp($char_lastName, "") == 0)
		{
			echo "An error occured.  Please ensure you entered a first and last name to remove from the table.  You cannot add an empty string to the table"; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("DELETE FROM character_title WHERE char_id = (SELECT id FROM characters WHERE first_name = ? AND last_name = ?) AND title_id = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("ssi", $char_firstName, $char_lastName, $char_TitleEntered)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Removed " . $stmt->affected_rows . " row(s) to character titles.";
			}

			echo "<br/>"; 

		}
	}

	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>