<?php
  session_start();
  if (!isset($_SESSION['admin'])) {/*Redirect to the login page if not logged in*/
      header("location:mainLogin.php");
  }
?>

<?php include "adminHeader.php" ?>
<main id="listContainer">

	<h1>Remove Cards</h1>
	<table id="list">
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Author</th>
      <th>Added</th>
      <th>Remove</th>
    </tr>

		<?php
		@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		/*Check for connection error*/
		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
		}

		$query = "select cardId,title,username,dateAdded from CardsView ORDER BY dateAdded DESC";
		$stmt = $db->prepare($query);
		$stmt->bind_result($cardId, $title, $username, $dateAdded);
		$stmt->execute();

    while($stmt->fetch()){
			echo "<tr>";
	    echo "<td>$cardId</td>";
	    echo "<td>$title</td>";
	    echo "<td>$username</td>";
	    echo "<td>$dateAdded</td>";
      echo "<td><a href='remove.php?cardId=$cardId'>Remove</a></td>";
	  	echo "</tr>";
		}
		?>

	</table>

</main>
