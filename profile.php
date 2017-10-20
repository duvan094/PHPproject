<?php include "header.php" ?>

<main id="userProfile">
	<?php

			$username = $_GET["username"];

			@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

			/*Check for connection error*/
			if ($db->connect_error) {
					echo "could not connect: " . $db->connect_error;
					printf("<br><a href=index.php>Return to home page </a>");
					exit();
			}

	      $query = "select * from ListCards Where username='" . $username . "'";
	      $stmt = $db->prepare($query);
	      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded);
			  $stmt->execute();

				echo "<h1>" . $_GET["username"] . "</h1>";
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
					echo "<p class='textWithLink'>Made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
					echo "</li>";
				}
				echo "</ul>";

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
