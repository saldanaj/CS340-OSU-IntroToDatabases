<!--PHP code to enable the server connection to the server --> 

<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the ancestral castle table.  
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<?php  

	$castleName = $_POST["CastleName"]; 
	$castleLocation = $_POST["CastleLocation"]; 

	echo $castleName . " + " . $castleLocation; 
	echo "<br/>";   

	if(isset($_POST["AddCastle"]))
	{
	
		if(strcmp($castleLocation, "") == 0 || strcmp($castleName, "") == 0) 
		{
			echo "An error occured.  Please ensure you have castle name and location to add.  You cannot add an empty string to the table"; 
			echo "<br/>"; 

		}
		else
		{

			if(!($stmt = $mysqli->prepare("INSERT INTO ancestral_castles(castle_name, location) VALUES (?,?)")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("ss", $castleName, $castleLocation)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Added " . $stmt->affected_rows . " row(s) to ancestral castles.";
			}

			echo "<br/>"; 
		}		
	}
	if(isset($_POST["UpdateCastle"]))
	{

		if(strcmp($castleLocation, "") == 0 || strcmp($castleName, "") == 0) 
		{
			echo "An error occured.  Please ensure you have castle name and location to update.  You cannot update an empty string to the table"; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("UPDATE ancestral_castles SET location = ? WHERE castle_name = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("ss", $castleLocation, $castleName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Updated " . $stmt->affected_rows . " row(s) to ancestral castles.";
			}

			echo "<br/>"; 

		}

	}
	if(isset($_POST["RemoveCastle"]))
	{
		if(strcmp($castleName, "") == 0)
		{
			echo "An error occured.  Please ensure you have castle name remove.  You cannot remove an empty string from the table"; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("DELETE FROM ancestral_castles WHERE castle_name = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("s", $castleName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Removed " . $stmt->affected_rows . " row(s) to ancestral castles.";
			}

			echo "<br/>"; 
		}

	}

	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>

