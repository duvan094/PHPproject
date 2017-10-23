<?php include "header.php" ?>

<main id="topListContainer">

	<h1>Top 10</h1>
	<table id="topList">
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

		for($i = 1; $i<=10; $i++){
			$stmt->fetch();
			echo "<tr>";
			echo "<td>$i</td>";
	    echo "<td><a href='index.php?cardId=$cardId'>$title</a></td>";
	    echo "<td><a href='profile.php?username=$username'>$username</a></td>";
	    echo "<td>$rating</td>";
	  	echo "</tr>";
		}
		?>

	</table>

		<!--
		<tr>
				<td>1</td>
    		<td><a href="#">Hitler without a mustasche</a></td>
    		<td><a href="#">Buksmilet420</a></td>
    		<td>346</td>
  		</tr>
  		<tr>
				<td>2</td>
    		<td><a href="#">Exploding kittens or dogs</a></td>
    		<td><a href="#">Oatmeal</a></td>
    		<td>263</td>
  		</tr>
			<tr>
				<td>3</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>4</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>5</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>6</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>7</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>8</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>9</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
			<tr>
				<td>10</td>
				<td><a href="#">Milk or Beer</a></td>
				<td><a href="#">Steffe82</a></td>
				<td>201</td>
			</tr>
	</table>
-->




</main>

<?php include "footer.php" ?>
