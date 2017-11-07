<?php
  session_start();
  if (!isset($_SESSION['admin'])) {/*Redirect to the login page if not logged in*/
      header("location:mainLogin.php");
  }
?>

<?php include "adminHeader.php" ?>
<main id="listContainer">

	<h1>Remove Comments</h1>
	<table id="list" class="commentTd">
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Username</th>
      <th>Comment</th>
      <th>Date</th>
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

		$query = "select cardId,commentId,title,username,comment,dateAdded from cardcomments ORDER BY dateAdded DESC";
		$stmt = $db->prepare($query);
		$stmt->bind_result($cardId, $commentId, $title, $username,$comment,$dateAdded);
		$stmt->execute();

    while($stmt->fetch()){
			echo "<tr>";
	    echo "<td>$cardId</td>";
	    echo "<td>$title</td>";
	    echo "<td>$username</td>";
      echo "<td class='commentTd'>$comment</td>";
      echo "<td>$dateAdded</td>";
      echo "<td><a href='removeComments.php?commentId=$commentId'>Remove</a></td>";
	  	echo "</tr>";
		}
		?>

	</table>

</main>
