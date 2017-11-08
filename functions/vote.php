<?php
  /*Check if vote button is pressed and user is logged in.*/
  if (isset($_POST['vote']) && isset($_SESSION['userId'])) {
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $cardId = $_GET['cardId'];
    $userId = $_SESSION['userId'];

    /*Check if user exists in the CardsUsersRating table, which means they already voted*/
    $query = "Select * From CardsUsersRating Where cardId ={$cardId} AND userId={$userId}";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows() != 1){

      /*Check for connection error*/
      if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }

      $cardId = $_GET['cardId'];
      $userId = $_SESSION['userId'];
      $query = "";

      /*Add the vote to the Card rating*/
      if($_POST['vote'] == "upvote"){
        $query = ("Update Cards SET rating = rating + 1 WHERE cardId={$cardId}");
        $rating++;
        $vote = 1;
      }else if($_POST['vote'] == "downvote"){
        $query = ("Update Cards SET rating = rating - 1 WHERE cardId={$cardId}");
        $rating--;
        $vote = -1;
      }

      $stmt = $db->prepare($query);
      $stmt->execute();

      $voted = $vote;

      /*Save that the user has voted a specific alternative*/
      if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }

      $query = "Insert INTO CardsUsersRating(cardId,userId,vote) values({$cardId},{$userId},{$vote})";
      $stmt = $db->prepare($query);
      $stmt->execute();

    }
  }
?>

<?php
  /*This is two invisble forms that are called from the upvote/downvote buttons*/
  echo "<form class='invisibleForm' action='index.php?cardId=$cardId' method='POST' id='downvoteForm'>";
  echo "<input type='text' value='downvote' name='vote' readonly>";
  echo "</form>";
  echo "<form class='invisibleForm' action='index.php?cardId=$cardId' method='POST' id='upvoteForm'>";
  echo "<input type='text' value='upvote' name='vote' readonly>";
  echo "</form>";
?>
<?php
  echo "<ul class='upvote-container'>";
  echo "<li><button class='like-button' type='submit' form='upvoteForm'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button></li>";
  echo "<li><p>$rating</p></li>";
  echo "<li><button class='like-button' type='submit' form='downvoteForm'><i class='fa fa-thumbs-down' aria-hidden='true'></i></button></li>";
  echo  "</ul>";
  echo  "<p class='textWithLink'><a class='cardLinkTitle' href='index.php?cardId=$cardId'>$title</a>, <a href='searchResults.php?category=$categoryName'>$categoryName</a><br>Made by <i class='fa fa-user' aria-hidden='true'></i> <a href='profile.php?username=$username'>$username</a>, $dateAdded, <b>$countryName</b>.</p>";

  $cardIdGlobal = $cardId;/*Save the cardId in a global variable*/

?>
