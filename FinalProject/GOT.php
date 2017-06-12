
<!--PHP code to enable the server connection to the server --> 

<?php

/*
Student: Joaquin Saldana 
Course: CS340 - Intro to Databases
Assignment: Final Assignment

This assignment requires I implement a user interactive MySQL database accessed 
via an HTML interface.  This is the main page that must be visited by the user.  
*/ 


//Turn on error reporting
ini_set('display_errors', 'On');


//Connects to the database
// TO CONNECT TO THE SERVER, WE USE THE SERVER ADDRESS, USER NAME AND PASSWORD AND THE  
// DATA BASE NAME  
// MAY NEED TO COPY THIS FROM THE ONID PAGE DIRECTLY

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","saldanaj-db","0S0izAWxuolhADrl","saldanaj-db");

// if statement to ensure we are connected

if($mysqli->connect_errno)
{
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

?>

<!--  Start of the HTML comments -->  
<!doctype html>
<html>
	
	<head>
		<title>Joaquin Saldana CS340 Database</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="HTML5EditableTable.css">
	</head> 

	<body>


	<div class="container">
  		<h1>Game of Thrones Database</h1>
  		<p>This is a database containing information of the Game of Thrones universe.  This database contains the following tables:</p>
  
  		<ul>
    		<li><strong>Characters</strong> - first name, last name, castle born (if information is available), and house affiliation. </li> 
    		<li><strong>Houses</strong> - the house name, the houses ancestral weapon (if one does exists), and the house castle</li>
    		<li><strong>Ancestral Castle</strong> -  the castle name and it's location</li>
    		<li><strong>Titles</strong> - available titles in the world of Game of Thrones</li>
    		<li><strong>Character Titles</strong> - titles associated with characters.  A character may have more than one title, and a title may have been held by more than one character</li>
    		<li><strong>Family</strong> - association amongst characters in respect to mother and father.  Some characters may have missing information because the books or show have not informed us who is the characters father and/or mother</li>
  		</ul>
			
		<h2>Characters Table</h2>
  		<p>Below is the table for the characters already entered in the database:</p>


  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>First Name</th>
        			<th>Last Name</th>
        			<th>Castle Born</th>
        			<th>House Affiliation</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT characters.first_name, characters.last_name, ancestral_castles.castle_name, houses.house_name FROM characters LEFT JOIN ancestral_castles ON characters.castle_born = ancestral_castles.id LEFT JOIN houses ON characters.house_affiliation = houses.id")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($first_name, $last_name, $castle_born, $house_affiliation))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $first_name . "</td><td>" . $last_name . "</td><td>" . $castle_born . "</td><td>" . $house_affiliation  ."</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>
  
		<div id="table" class="table-editable">
  			<form method="post" action="modifyCharacter.php">
  				<h3>Modify Characters Table</h3>
  				<p>
  					Note: if you wish to udpate or delete a row from the table, the characters first and last name must be an exact match.  
  				</p>
  				
				<label>First Name</label>
				<input type="text" name="FirstName">

				<label>Last Name</label>
  				<input type="text" name="LastName">

  				<label>Castle Born</label>
  				<select name="CastleBorn">  	
  					<option id="0">None</option>				
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, castle_name FROM ancestral_castles")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $castleName))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $id . ' "> ' . $castleName . '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>

				<label>House Affiliation</label>
				<select name="HouseAffiliation">
  					<option id="0">None</option>
					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, house_name FROM houses")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $houseName))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $houseName . '</option>\n';
						}
						$stmt->close();
  					?>
				</select>
				
				<p>
					<input type="submit" name="AddCharacter" value="Add Character">	
					<input type="submit" name="UpdateCharacter" value="Update Character">
					<input type="submit" name="RemoveCharacter" value="Remove Character">
				</p>

  			</form>
  		</div>	
	</div>

	<!--  This is the section of the page that will contain the characters title table  --> 

	<div class="container">
			
		<h2>Character Titles</h2>
  		<p>Below is the table for the characters titles already entered in the database, this is a many to many relationship table:</p>
  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>Character First Name</th>
        			<th>Character Last Name</th>
        			<th>Associated Title</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT characters.first_name, characters.last_name, titles.title_name FROM character_title LEFT JOIN characters ON character_title.char_id = characters.id LEFT JOIN titles ON titles.id = character_title.title_id")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($char_FirstName, $char_LastName, $char_TitleName))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $char_FirstName. "</td><td>" . $char_LastName. "</td><td>" . $char_TitleName. "</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>

  		<div id="table" class="table-editable">
  			<form method="post" action="modifyCharacterTitles.php">
  				<h3>Modify Character Titles Table</h3>
  				<p>
  					Note: if you wish to delete a row from the table, the characters  name must be an exact match.  
  				</p>
  				
				<label>First Name</label>
				<input type="text" name="Char_FirstName">

				<label>Last Name</label>
  				<input type="text" name="Char_LastName">

  				<label>Title Association</label>
  				<select name="Char_TitleAssociation">  				
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, title_name FROM titles")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($char_id, $char_title))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $char_id . ' "> ' . $char_title . '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>
				<p>
					<input type="submit" name="AddCharTitle" value="Add Character Title">	
					<input type="submit" name="RemoveCharTitle" value="Remove Character Title">
				</p>
  			</form>

  			<!-- form post that will allow the user to filter through the character titles 
  			menu, the many to many relationship --> 

  			<form method="post" action="filterCharacterTitles.php">
  				<h3>Filter through Character Titles Table</h3>
  				<p>
  					You can filter to see which characters have which titles and which titles are associated with more than one character.  
  				</p>

  				<label>Character</label>
  				<select name="Filter_Character">  				
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT characters.id, characters.first_name, characters.last_name FROM character_title LEFT JOIN characters ON characters.id = character_title.char_id GROUP BY characters.id")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($filter_characterID, $filter_charFirstName, $filter_charLastName))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $filter_characterID . '  "> ' . $filter_charFirstName . " " . $filter_charLastName . '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>

  				<label>Title</label>
  				<select name="Filter_Title">  				
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT titles.id, titles.title_name FROM character_title LEFT JOIN titles ON titles.id = character_title.title_id GROUP BY titles.id")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($filter_titleID, $filter_titleName))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $filter_titleID .' "> ' . $filter_titleName . '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>
				<p>
					<input type="submit" name="FilterCharacter" value="Filter via Character">	
					<input type="submit" name="FilterTitle" value="Filter via Title">
				</p>
  			</form>


  		</div>	
	</div>

	<!--  This is the section of the page that will contain the famiy table  --> 

	<div class="container">
			
		<h2>Family</h2>
  		<p>Below is the table for the family already entered in the database:</p>
  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>Child First Name</th>
        			<th>Child Last Name</th>
        			<th>Father First Name</th>
        			<th>Father Last Name</th>
        			<th>Mother First Name</th>
        			<th>Mother Last Name</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT child.first_name, child.last_name, father.first_name, father.last_name, mother.first_name, mother.last_name FROM family LEFT JOIN characters AS child ON family.char_id = child.id LEFT JOIN characters AS father ON family.father_id = father.id LEFT JOIN characters AS mother ON family.mother_id = mother.id")))	
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($child_firstName, $child_lastName, $father_firstName, $father_lastName, $mother_firstName, $mother_lastName))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $child_firstName. "</td><td>" . $child_lastName. "</td><td>" . $father_firstName. "</td><td>" . $father_lastName. "</td><td>" . $mother_firstName. "</td><td>" . $mother_lastName. "</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>

  		<div id="table" class="table-editable">
  			<form method="post" action="modifyFamily.php">
  				<h3>Modify Family Table</h3>
  				<p>
  					Note: if you wish to add, update or delete a row from the table, a child must be selected.  
  				</p>

				<label>Child</label>
				<select name="Child_Name">  	
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $child_FIRSTNAME, $child_LASTNAME))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $id . ' "> ' . $child_FIRSTNAME . " " . $child_LASTNAME. '</option>\n';
						}
						
						$stmt->close();
  					?>
				</select>

				<label>Father</label>
				<select name="Father_Name">  	
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $father_FIRSTNAME, $father_LASTNAME))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $id . ' "> ' . $father_FIRSTNAME . " " . $father_LASTNAME. '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>

				<label>Mother</label>
				<select name="Mother_Name">  	
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $mother_FIRSTNAME, $mother_LASTNAME))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $id . ' "> ' . $mother_FIRSTNAME . " " . $mother_LASTNAME. '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>

				<p>
					<input type="submit" name="AddFamily" value="Add Family">
					<!-- 
					<input type="submit" name="UpdateFamily" value="Update Family">	
					--> 
					<input type="submit" name="RemoveFamily" value="Remove Family">
				</p>

  			</form>
  		</div>	
	</div>

	<!--  This is the section of the page that will contain the Houses table  --> 

	<div class="container">
			
		<h2>Houses Table</h2>
  		<p>Below is the table for the Houses already entered in the database:</p>

  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>House Name</th>
        			<th>Ancestral Weapon</th>
        			<th>House Castle</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT houses.house_name, houses.ancestral_weapon, ancestral_castles.castle_name FROM houses LEFT JOIN ancestral_castles ON houses.house_castle = ancestral_castles.id")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($house_name, $house_weapon, $house_castle))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $house_name . "</td><td>" . $house_weapon . "</td><td>" . $house_castle  ."</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>

  		<div id="table" class="table-editable">
  			<form method="post" action="modifyHouses.php">
  				<h3>Modify Houses Table</h3>
  				<p>
  					Note: if you wish to udpate or delete a row from the table, the house name must be an exact match.  
  				</p>
  				
				<label>House Name</label>
				<input type="text" name="HouseName">

				<label>Ancestral Weapon</label>
  				<input type="text" name="AncestralWeapon">

  				<label>House Castle</label>
  				<select name="HouseCastle">  	
  					<option id="0">None</option>				
  					<?php  

						if(!($stmt = $mysqli->prepare("SELECT id, castle_name FROM ancestral_castles")))
						{
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute())
						{
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $castleName))
						{
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}

						while($stmt->fetch())
						{
							echo '<option value=" '. $id . ' "> ' . $castleName . '</option>\n';
						}
						
						$stmt->close();
  					?>
  				</select>
				
				<p>
					<input type="submit" name="AddHouse" value="Add House">	
					<input type="submit" name="UpdateHouse" value="Update House">
					<input type="submit" name="RemoveHouse" value="Remove House">
				</p>

  			</form>
  		</div>	
	</div>

	<!--  This is the section of the page that will contain the ancestral castles table  --> 

	<div class="container">
			
		<h2>Ancestral Castles Table</h2>
  		<p>Below is the table for the Ancestral Castles already entered in the database:</p>
  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>Castle Name</th>
        			<th>Location</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT castle_name, location FROM ancestral_castles")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($castle_name, $castle_location))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $castle_name . "</td><td>" . $castle_location . "</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>

  		<div id="table" class="table-editable">
  			<form method="post" action="modifyAncestralCastles.php">
  				<h3>Modify Ancestral Castle Table</h3>
  				<p>
  					Note: if you wish to udpate or delete a row from the table, the castle name must be an exact match.  
  				</p>
  				
				<label>Castle Name</label>
				<input type="text" name="CastleName">

				<label>Castle Location</label>
  				<input type="text" name="CastleLocation">
				
				<p>
					<input type="submit" name="AddCastle" value="Add Castle">	
					<input type="submit" name="UpdateCastle" value="Update Castle">
					<input type="submit" name="RemoveCastle" value="Remove Castle">
				</p>

  			</form>
  		</div>	
	</div>

	<!--  This is the section of the page that will contain the titles table  --> 

	<div class="container">
			
		<h2>Titles</h2>
  		<p>Below is the table for the Titles already entered in the database:</p>
  
  		<div id="table" class="table-editable">
    			<table class="table">
      			<tr>
        			<th>Titles</th>
      			</tr>

      			<?php  

					if(!($stmt = $mysqli->prepare("SELECT title_name FROM titles")))
					{
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute())
					{
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($titles))
					{
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					while($stmt->fetch())
					{
	
					 	echo "<tr><td>" . $titles. "</td></tr>";
					}

					$stmt->close();

      			?>
	    		</table>
  		</div>

  		<div id="table" class="table-editable">
  			<form method="post" action="modifyTitles.php">
  				<h3>Modify Titles Table</h3>
  				<p>
  					Note: if you wish to delete a row from the table, the title name must be an exact match.  
  				</p>
  				
				<label>Title</label>
				<input type="text" name="TitleEntered">
				
				<p>
					<input type="submit" name="AddTitle" value="Add Title">	
					<input type="submit" name="RemoveTitle" value="Remove Title">
				</p>

  			</form>
  		</div>	
	</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="HTML5EditableTable.js"></script>
	</body>  <!--- This is the end of the body tag --> 
</html> <!--- This is the end of the html page --> 







	