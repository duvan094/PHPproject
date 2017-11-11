<?php include "header.php" ?>

<main id="listContainer">

	<h1>Top 10</h1>
	<table id="list">
		<tr>
			<th>Rank</th>
			<th>Title</th>
			<th>Author</th>
			<th>Rating</th>
		</tr>

		<?php
		@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		/*Check for connection error*/
		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
		}

		$query = "select * from TopListView";
		$stmt = $db->prepare($query);
		$stmt->bind_result($title, $username, $rating, $cardId);
		$stmt->execute();

		$i = 1;
		while($stmt->fetch()){
			echo "<tr>";
			echo "<td>$i</td>";
		    echo "<td><a href='index.php?cardId=$cardId'>$title</a></td>";
		    echo "<td><a href='profile.php?username=$username'>$username</a></td>";
		    echo "<td>$rating</td>";
		  	echo "</tr>";
			$i++;
		}
		?>

	</table>

</main>

<?php include "footer.php" ?>
