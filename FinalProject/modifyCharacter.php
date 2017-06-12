
<!--PHP code to enable the server connection to the server --> 

<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the characters table.  It checks to see if user wants to 
add to the table, update, or delete.  It also checks to see if the user selected a house or a 
castle born to add to the table.  
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>


<?php 


	$firstName = $_POST["FirstName"]; 
	$lastName = $_POST["LastName"]; 
	$castleNumber = $_POST["CastleBorn"]; 
	$houseAffiliation = $_POST["HouseAffiliation"]; 

	echo $firstName . " + " . $lastName . " + " . $castleNumber . " + " . $houseAffiliation;
	echo "<br/>";   

	if(isset($_POST["AddCharacter"]))
	{

		// the user has chosen to add a character to the table 
		// but first we need to check if the user selected "none"
		// in the fields of castle born or house affiliation 

		if(strcmp($firstName, "") == 0 || strcmp($lastName, "") == 0)
		{
			echo "An error occured.  Please ensure you have a character first name and last name to add.  You cannot add an empty string to the table"; 
			echo "<br/>"; 
		}
		else 
		{


			if(strcmp($castleNumber, "None") == 0 || strcmp($houseAffiliation, "None") == 0)
			{
				echo "Either the castle number was empty or the house affiliation number was empty"; 

				if(strcmp($castleNumber, "None") == 0 && strcmp($houseAffiliation, "None") != 0)
				{

					if(!($stmt = $mysqli->prepare("INSERT INTO characters(first_name, last_name, house_affiliation) VALUES (?,?,?)")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}


					if(!($stmt->bind_param("ssi", $firstName, $lastName, $houseAffiliation)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Added " . $stmt->affected_rows . " row(s) to characters.";
					}

				}
				else if(strcmp($castleNumber, "None") != 0 && strcmp($houseAffiliation, "None") == 0)
				{

					if(!($stmt = $mysqli->prepare("INSERT INTO characters(first_name, last_name, castle_born) VALUES (?,?,?)")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("ssi", $firstName, $lastName, $castleNumber)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Added " . $stmt->affected_rows . " row(s) to characters.";
					}

				}
				else
				{
					if(!($stmt = $mysqli->prepare("INSERT INTO characters(first_name, last_name) VALUES (?,?)")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("ss", $firstName, $lastName)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Added " . $stmt->affected_rows . " row(s) to characters.";
					}
				}
				
			}
			else
			{

				if(!($stmt = $mysqli->prepare("INSERT INTO characters(first_name, last_name, castle_born, house_affiliation) VALUES (?,?,?,?)")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}


				if(!($stmt->bind_param("ssii", $firstName, $lastName, $castleNumber, $houseAffiliation)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "<br/>"; 				
					echo "Added " . $stmt->affected_rows . " row(s) to characters.";
				}

			}
		}
	}
	else if(isset($_POST["UpdateCharacter"]))
	{

		// customer has choosen to delete a character from the table 
		if(strcmp($firstName, "") == 0 || strcmp($lastName, "") == 0)
		{
			echo "An error occured.  Please ensure you have a character first name and last name to in order to update.  You cannot update an empty string to the table"; 
			echo "<br/>"; 
		}
		else 
		{
			if(strcmp($castleNumber, "None") == 0 || strcmp($houseAffiliation, "None") == 0)
			{

				if(strcmp($castleNumber, "None") == 0 && strcmp($houseAffiliation, "None") != 0)
				{
					if(!($stmt = $mysqli->prepare("UPDATE characters SET castle_born = NULL, house_affiliation = ? WHERE first_name = ? AND last_name = ?")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("iss", $houseAffiliation, $firstName, $lastName)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Updated " . $stmt->affected_rows . " row(s) to characters.";
					}

				}
				else if(strcmp($castleNumber, "None") != 0 && strcmp($houseAffiliation, "None") == 0)
				{

					if(!($stmt = $mysqli->prepare("UPDATE characters SET castle_born = ?, house_affiliation = NULL WHERE first_name = ? AND last_name = ?")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("iss", $castleNumber, $firstName, $lastName)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Updated " . $stmt->affected_rows . " row(s) to characters.";
					}

				}
				else
				{

					if(!($stmt = $mysqli->prepare("UPDATE characters SET castle_born = NULL, house_affiliation = NULL WHERE first_name = ? AND last_name = ?")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!($stmt->bind_param("ss", $firstName, $lastName)))
					{
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					else 
					{
						echo "Updated " . $stmt->affected_rows . " row(s) to characters.";
					}
				}
			
			}
			else
			{

				if(!($stmt = $mysqli->prepare("UPDATE characters SET castle_born = ?, house_affiliation = ? WHERE first_name = ? AND last_name = ?")))
				{
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!($stmt->bind_param("iiss", $castleNumber, $houseAffiliation, $firstName, $lastName)))
				{
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute())
				{
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} 
				else 
				{
					echo "Updated " . $stmt->affected_rows . " row(s) to characters.";
				}

			}

		}
	}
	else
	{
		
		// user has choosen to remove a character from the table
		if(strcmp($firstName, "") == 0 || strcmp($lastName, "") == 0)
		{
			echo "An error occured.  Please ensure you have a character first name and last name in order to remove.  You cannot remove an empty string from the table"; 
			echo "<br/>"; 
		}
		else
		{

			if(!($stmt = $mysqli->prepare("DELETE FROM characters WHERE first_name = ? AND last_name = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("ss", $firstName, $lastName)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Removed " . $stmt->affected_rows . " row(s) to characters.";
			}

		}

	}

	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>
