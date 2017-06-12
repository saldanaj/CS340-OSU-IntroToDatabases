
<!--PHP code to enable the server connection to the server --> 

<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the houses table.  We also check to see if the user selected "none" from the drop down menu of the house castle option.
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<?php 

	$houseName = $_POST["HouseName"]; 
	$ancestralWeapon = $_POST["AncestralWeapon"]; 
	$houseCastle = $_POST["HouseCastle"]; 


	echo $houseName . " + " . $ancestralWeapon . " + " . $houseCastle;

	echo "<br/>";   

	if(isset($_POST["AddHouse"]))
	{

		if(strcmp($houseName, "") == 0)
		{

			echo "An error occured.  Please ensure you have house name to add.  You cannot add an empty string to the table"; 
			echo "<br/>"; 

		}
		else 
		{

			if(strcmp($houseCastle, "None") == 0)
			{
				if(!($stmt = $mysqli->prepare("INSERT INTO houses(house_name, ancestral_weapon) VALUES (?,?)")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("ss", $houseName, $ancestralWeapon)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "Added " . $stmt->affected_rows . " row(s) to houses.";
				}
			}
			else
			{

				if(!($stmt = $mysqli->prepare("INSERT INTO houses(house_name, ancestral_weapon, house_castle) VALUES (?,?, ?)")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("ssi", $houseName, $ancestralWeapon, $houseCastle)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "Added " . $stmt->affected_rows . " row(s) to houses.";
				}

			}

		}

	}
	else if(isset($_POST["UpdateHouse"]))
	{

		if(strcmp($houseName, "") == 0)
		{

			echo "An error occured.  Please ensure you have house name to update.  You cannot update an empty string to the table"; 
			echo "<br/>"; 
		}
		else
		{


			if(strcmp($houseCastle, "None") == 0)
			{

				if(!($stmt = $mysqli->prepare("UPDATE houses SET ancestral_weapon = ?, house_castle = NULL WHERE house_name = ?")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("ss", $ancestralWeapon, $houseName)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "Updated " . $stmt->affected_rows . " row(s) to houses.";
				}

			}
			else 
			{
				if(!($stmt = $mysqli->prepare("UPDATE houses SET ancestral_weapon = ?, house_castle = ? WHERE house_name = ?")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("sis", $ancestralWeapon, $houseCastle, $houseName)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "Updated " . $stmt->affected_rows . " row(s) to houses.";
				}

			}
		}

	}
	else
	{
		if(strcmp($houseName, "") == 0)
		{

			echo "An error occured.  Please ensure you have house name to remove.  You cannot remove an empty string from the table"; 
			echo "<br/>"; 
		}
		else 
		{

			if(!($stmt = $mysqli->prepare("DELETE FROM houses WHERE house_name = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("s", $houseName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Removed " . $stmt->affected_rows . " row(s) to houses.";
			}
		}

	}

	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>