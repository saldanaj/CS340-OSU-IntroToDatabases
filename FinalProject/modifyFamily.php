<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page where we modify the family table and add, update, and delete the father and mother relationships.  
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<?php  

	$child_value = $_POST["Child_Name"]; 
	$father_value = $_POST["Father_Name"];
	$mother_value = $_POST["Mother_Name"];


	echo $child_value . " + " . $father_value . " + " . $mother_value; 
	echo "<br/>";  

	if(isset($_POST["AddFamily"]))
	{

		if($child_value == $father_value || $child_value == $mother_value || $father_value == $mother_value)
		{
			echo "An error occured.  Please ensure the child, father, and mother you selected are not the same."; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("INSERT INTO family(char_id, father_id, mother_id) VALUES (?, ?, ?)")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("iii", $child_value, $father_value, $mother_value)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Added " . $stmt->affected_rows . " row(s) to family table.";
			}

			echo "<br/>"; 
		}

	}
	if(isset($_POST["RemoveFamily"]))
	{
		if(!($stmt = $mysqli->prepare("DELETE FROM family WHERE char_id = ?")))
		{
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("i", $child_value)))
		{
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute())
		{
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} 
		else 
		{
			echo "Deleted " . $stmt->affected_rows . " row(s) to family table.";
		}

		echo "<br/>"; 

	}

	/*
	if(isset($_POST["UpdateFamily"]))
	{
		if($child_value == $father_value || $child_value == $mother_value || $father_value == $mother_value)
		{
			echo "An error occured.  Please ensure the child, father, and mother you selected are not the same."; 
			echo "<br/>"; 
		}
		else 
		{
			if(!($stmt = $mysqli->prepare("UPDATE family SET father_id = ? AND mother_id = ? WHERE char_id = ?")))
			{
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!($stmt->bind_param("iii", $father_value, $mother_value, $child_value)))
			{
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute())
			{
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} 
			else 
			{
				echo "Updated " . $stmt->affected_rows . " row(s) to family table.";
			}

			echo "<br/>"; 
		}
	}
	*/ 

	echo "<br/>"; 
	echo "<a href=GOT.php>Return to Home</a>"; 

?>