<?php
  /*Fetch all the comments for a specific card*/
  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  /*Check for connection error*/
  if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
  }

  $query = "select title,username,countryName,comment,dateAdded,cardId from CardComments where cardId = " . $cardId;
  $stmt = $db->prepare($query);
  $stmt->bind_result($title, $username, $countryName, $comment, $dateAdded, $cardId);
  $stmt->execute();
  $stmt->store_result();
  $nbrOfComments = $stmt->num_rows();

    echo "<ul id='commentContainer'>";
//  }
  echo "<li><h4>$nbrOfComments comments</h4></li>";
  while ($stmt->fetch()) {
    echo "<li class='commentField'>";
    echo "<a href='profile.php?username=$username'><i class='fa fa-user' aria-hidden='true'></i></a>";
    echo "<a href='profile.php?username=$username'>$username</a>";
    echo "<p><i>$dateAdded</i>, <b>$countryName</b></p>";
    echo "<p class='commentText'>$comment</p>";
    echo "</li>";
  }

  if (isset($_SESSION['username'])) {//Show a commentfield if logged in.
    echo "<li class='commentField comment'>";
    echo "<form class='' action='index.php?cardId={$cardIdGlobal}' method='post'>";
    echo "<textarea name='comment' rows='6' cols='80' maxlength='200' placeholder='Write a comment.'></textarea>";
    echo "<br>";
    echo "<input type='submit' name='' value='Post Your Comment'>";
    echo "</form>";
    echo "</li>";
  }else{//else show a message
    echo "<li class='comment commentField'><h4>Log in to comment.</h4></li>";
  }
  echo "</ul>";
?>
