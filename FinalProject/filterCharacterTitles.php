<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This is the page that will display the data the user decided to filter by.  This is for the characters titles filter 
*/ 

	ini_set('display_errors', 'On');


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

	if($mysqli->connect_errno)
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Filter Page</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="HTML5EditableTable.css">
</head>
	<body>

		<div class="container">
		  <h2>Character Title Filter</h2>

		  
		  <div id="table" class="table-editable">
		    <table class="table">

				<?php  

					if(isset($_POST["FilterCharacter"]))
					{
						$filter_characterNum = $_POST["Filter_Character"]; 

						echo $filter_characterNum; 
						echo "<br/>";  

						echo "<h3>You've choose to filter by Character<h3>";  

						echo "<tr>\n<th>Character First Name</th>\n<th>Character Last Name</th><th>Title</th>\n</tr>\n"; 


						if(!($stmt = $mysqli->prepare("SELECT queryOne.first_name, queryOne.last_name, queryOne.title_name FROM (SELECT character_title.char_id, character_title.title_id, characters.first_name, characters.last_name, titles.title_name FROM character_title LEFT JOIN characters ON characters.id = character_title.char_id LEFT JOIN titles  ON titles.id = character_title.title_id) AS queryOne WHERE queryOne.char_id = ?")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						
						if(!($stmt->bind_param("i", $filter_characterNum)))
						{
							echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						if(!$stmt->bind_result($filter_charFirstName, $filter_charLastName, $filter_titleNameReturned))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
		
						 	echo "<tr><td>" . $filter_charFirstName. "</td><td>" . $filter_charLastName. "</td><td>" . $filter_titleNameReturned. "</td></tr>";
						}

						$stmt->close();


					}
					if(isset($_POST["FilterTitle"]))
					{
						$filter_titleNum = $_POST["Filter_Title"]; 


						echo $filter_titleNum; 
						echo "<br/>";  

						echo "<h3>You've choose to filter by Title<h3>"; 

						echo "<tr>\n<th>Character First Name</th>\n<th>Character Last Name</th><th>Title</th>\n</tr>\n"; 


						if(!($stmt = $mysqli->prepare("SELECT queryOne.first_name, queryOne.last_name, queryOne.title_name FROM (SELECT character_title.char_id, character_title.title_id, characters.first_name, characters.last_name, titles.title_name FROM character_title LEFT JOIN characters ON characters.id = character_title.char_id LEFT JOIN titles  ON titles.id = character_title.title_id) AS queryOne WHERE queryOne.title_id = ?")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						
						if(!($stmt->bind_param("i", $filter_titleNum)))
						{
							echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						if(!$stmt->bind_result($filter_charFirstName, $filter_charLastName, $filter_titleNameReturned))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
		
						 	echo "<tr><td>" . $filter_charFirstName. "</td><td>" . $filter_charLastName. "</td><td>" . $filter_titleNameReturned. "</td></tr>";
						}

						$stmt->close();

					}
				?>

    	  		<?php 
					echo "<br/>"; 
					echo "<a href=GOT.php>Return to Home</a>"; 
				?>

		    </table>
		  </div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="HTML5EditableTable.js"></script>
	</body>
</html>












