<?php include "header.php" ?>


<main id="userProfile">
	<?php
		/*Here we check if a specific user page is selected from the GET*/
		if(isset($_GET['username']) && !empty($_GET['username'])){
			$username = $_GET["username"];

			@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

			/*Check for connection error*/
			if ($db->connect_error) {
					echo "could not connect: " . $db->connect_error;
					printf("<br><a href=index.php>Return to home page </a>");
					exit();
			}

	      $query = "select * from CardsView Where username='" . $username . "'";
	      $stmt = $db->prepare($query);
	      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$countryName,$dateAdded,$cardId);
			  $stmt->execute();
				$stmt->store_result();

        /*If no user with that specific username can be found the page displays an error message*/
        if($stmt->num_rows() == 0){
					echo "<h1>" . $username . "</h1>";
					if(isset($_SESSION['username'])){
						if($_SESSION['username'] == $username){
							echo "<p class='profileError'>You have not created any cards yet.</p>";
						}else{
							echo "<p class='profileError'>This user has not created any cards yet.</p>";
						}
					}else{
						echo "<p class='profileError'>This user has not created any cards yet.</p>";
					}
		    }else{

					echo "<h1>" . $username . "</h1>";
					echo "<ul>";

					while($stmt->fetch()){
						echo "<li>";
		        echo "<form class='card-container' action='index.php?cardId={$cardId}' method='post'>";
		        echo "<div><input type='submit' name='altClicked' value='{$alt1}'></div>";
		        echo "<div><input type='submit' name='altClicked' value='{$alt2}'></div>";
		        echo "</form>";
		        echo "<ul class='upvote-container'>";
						echo "<li><button class='like-button'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button></li>";
		        echo "<li><p>$rating</p></li>";
						echo "<li><button class='like-button'><i class='fa fa-thumbs-down' aria-hidden='true'></i></i></button></li>";
						echo  "</ul>";
				echo "<a href='removeOwnCard.php?cardId=$cardId'>Remove</a>";
		        echo  "<p class='textWithLink'><a class='cardLinkTitle' href='index.php?cardId=$cardId'>$title</a>, <a href='searchResults.php?category=$categoryName'>$categoryName</a><br>Made by <i class='fa fa-user' aria-hidden='true'></i> <a href='profile.php?username=$username'>$username</a>, $dateAdded, <b>$countryName.</b></p>";
		        echo "</li>";

					}
					echo "</ul>";
				}

		}else{
			//If no specific user is requested the page prints out this Error message
			echo "<p class='profileError'>There's nothing here :(</p>";
		}
	?>

</main>


<?php  include "footer.php"?>
