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
	      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded,$cardId);
			  $stmt->execute();
				$stmt->store_result();

        /*If no user with that specific username can be found the page displays an error message*/
        if($stmt->num_rows() == 0){
					echo "<h1>There's nothing here :(</h1>";
		    }else{

					echo "<h1>" . $username . "</h1>";
					echo "<ul>";

					while($stmt->fetch()){
						echo "<li><h3>Would You Rather</h3>";
						echo "<ul class='card-container'>";
						echo "<li><button>$alt1</button></li>";
						echo "<li><button>$alt2</button></li>";
						echo "</ul>";
						echo "<ul class='upvote-container'>";
						echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
						echo "<li><p>$rating</p></li>";
						echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
						echo "</ul>";
						echo "<p class='textWithLink'><a href='index.php?cardId=$cardId'>$title</a> made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
						echo "</li>";
					}
					echo "</ul>";
				}

		}else{
			//If no specific user is requested the page prints out this Error message
			echo "<h1>There's nothing here :(</h1>";
		}
	?>

<!--
	<h1>steffe94</h1>
	<ul>

		<li>
			<h3>If You Where A Cat Would You Do...</h3>
			<ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
			<ul class="upvote-container">
				<li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
				<li><p>0</p></li>
				<li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
			</ul>
			<p class="textWithLink">Made by <a href="#">steffe94</a>, 45 days ago.</p>
		</li>
		<li>
			<h3>Would You Rather Do...</h3>
			<ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
			<ul class="upvote-container">
				<li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
				<li><p>0</p></li>
				<li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
			</ul>
			<p class="textWithLink">Made by <a href="#">steffe94</a>, 2 days ago.</p>
		</li>
		<li>
			<h3>Would You Rather Do...</h3>
			<ul class="card-container">
				<li><button>This?</button></li>
				<li><button>That?</button></li>
			</ul>
			<ul class="upvote-container">
				<li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
				<li><p>0</p></li>
				<li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
			</ul>
			<p class="textWithLink">Made by <a href="#">steffe94</a>, 32 days ago.</p>
		</li>
	</ul>
-->

</main>


<?php  include "footer.php"?>
