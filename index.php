<?php
  include "header.php";
  $cardIdGlobal = "";

  if (isset($_SESSION['cardsClicked']) === false){//Creates an empty array
      $_SESSION['cardsClicked'] = array();
  }
?>


<main>

  <?php

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    /*Here we check if a specific card is requested*/
    if(isset($_GET['cardId']) && !empty($_GET['cardId'])){

      $query = "select * from CardsView Where cardId=" . $_GET['cardId'];

      $stmt = $db->prepare($query);
      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$countryName,$dateAdded, $cardId);
      $stmt->execute();
      $stmt->store_result();

      /*If no card can be found, the page is refreshed and selects a random card.*/
      if($stmt->num_rows() == 0){
        echo '<meta http-equiv="refresh" content= "0; URL=index.php">';
        exit;
      }

    }else{
        /*If no specific card is requested from the GET, a random card is selected*/
      $query = "select * from RandomList";

      if(isset($_GET['categoryName']) && !empty($_GET['categoryName'])){
        $query = $query . " Where categoryName='".$_GET['categoryName']."'";
      }

      $stmt = $db->prepare($query);
      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$countryName,$dateAdded, $cardId);
      $stmt->execute();
    }

    $stmt->fetch();



      if(isset($_POST['altClicked']) && !empty($_POST['altClicked'])){  //Check if an alternative has been clicked
        if (isset($_SESSION['cardsClicked']) === false){//If array storing clicked cards don't exist
            $altClickedArr = array($cardId => $_POST['altClicked']);  //Add cardId to array
            $_SESSION['cardsClicked'] = $altClickedArr; //Which is then stored in a Session
        }else{  //If the array already exists in session the value is
          $altClickedArr = $_SESSION['cardsClicked'];
          $altClickedArr[$cardId]=$_POST['altClicked'];
          $_SESSION['cardsClicked'] = $altClickedArr;
        }
      }




    /*Check if an alternative has been clicked*/
    if(isset($_POST['altClicked']) && !empty($_POST['altClicked'])){
      echo "<div class='card-container'>";

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      /*Check for connection error*/
      if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }

      /*Check which alternative that has been clicked*/
      if($_POST['altClicked'] == $alt1 || $_SESSION['cardsClicked'][$cardId] == $alt1){/*If altClicked == alt1, it means that the first alternative was clicked*/
        /*Increase the card for the selected card*/
        if(isset($_POST['altClicked'])){//Only update if clicked the first time
          $query = ("Update Cards SET alt1Count = alt1Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();
          $alt1Count = $alt1Count+1;/*Since alt1Count is the value before the Update operation we increase it by 1*/
        }
        $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));/*Calculate the percentage for card 1*/
        $percent2 = 100-$percent1;/*Calculate the percentage for card 2*/
        echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} agree with you</p><h5>{$alt1}</h5></div></div>";
        echo "<div><div><h3><span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} disagree with you</p><h5>{$alt2}</h5></div></div>";
      }else{
        if(isset($_POST['altClicked'])){//Only update if clicked the first time
          $query = ("Update Cards SET alt2Count = alt2Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();

          $alt2Count = $alt2Count + 1;/*Since alt1Count is the value before the Update operation we increase it by 1*/
        }
        /*An if case, if alt1Count is 0, which would lead to division by 0, resulting in an error*/
        $percent1 = ($alt1Count == 0 ? 0 : round(100 * ($alt1Count/($alt1Count+$alt2Count))));
        $percent2 = 100 - $percent1;

        echo "<div><div><h3><span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} disagree with you</p><h5>{$alt1}</h5></div></div>";
        echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} agree with you</p><h5>{$alt2}</h5></div></div>";
      }
      echo "</div>";

    }else if(array_key_exists($cardId,$_SESSION['cardsClicked'])){//Check if card has been clicked before
      echo "<div class='card-container'>";
      if($_SESSION['cardsClicked'][$cardId] == $alt1){/*If altClicked == alt1, it means that the first alternative was clicked*/

        $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));/*Calculate the percentage for card 1*/
        $percent2 = 100-$percent1;/*Calculate the percentage for card 2*/
        echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} agree with you</p><h5>{$alt1}</h5></div></div>";
        echo "<div><div><h3><span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} disagree with you</p><h5>{$alt2}</h5></div></div>";

      }else{
        /*An if case, if alt1Count is 0, which would lead to division by 0, resulting in an error*/
        $percent1 = ($alt1Count == 0 ? 0 : round(100 * ($alt1Count/($alt1Count+$alt2Count))));
        $percent2 = 100 - $percent1;

        echo "<div><div><h3><span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} disagree with you</p><h5>{$alt1}</h5></div></div>";
        echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} agree with you</p><h5>{$alt2}</h5></div></div>";
      }
      echo "</div>";

    }else{/*If no alternative has been clicked*/
      echo "<form class='card-container' action='index.php?cardId={$cardId}' method='post'>";
      echo "<div><input type='submit' name='altClicked' value='{$alt1}'></div>";
      echo "<div><input type='submit' name='altClicked' value='{$alt2}'></div>";
      echo "</form>";
    }

  if(isset($_COOKIE['color_mode'])){
    if($_COOKIE['color_mode'] == "light"){
      echo "<div id='nextPrevButtonsContainer' class='light'>";
    }else{
      echo "<div id='nextPrevButtonsContainer'>";
    }
  }else{
    echo "<div id='nextPrevButtonsContainer'>";
  }
  ?>

    <ul>
      <li><a href="index.php?cardId=<?php echo $cardId-1;?>">Previous Question</a></li>
      <li><a href="index.php?cardId=<?php echo $cardId+1;?>">Next Question</a></li>
    </ul>
  </div>
  <div class="container">
  <div>

    <?php
      /*Connect to the database to insert the comment*/
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



  <?php
    /*Connect to the database to insert the comment*/
    if (isset($_POST['comment']) && $_POST['comment'] != "") {
      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      /*Check for connection error*/
      if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }

      $cardId = $_GET['cardId'];
      $userId = $_SESSION['userId'];
      $comment = mysqli_real_escape_string($db, $_POST['comment']);
      $comment = htmlentities($comment);

      $query = ("INSERT INTO Comments (cardId, comment, userId) VALUES ({$cardId}, '{$comment}', {$userId})");
      $stmt = $db->prepare($query);
      $stmt->execute();

      /*Code to keep the form from sending the information several times. Borrowed from Ellen Brage.*/
      unset($_POST);
      echo "<script> window.location.href ='index.php?cardId=$cardId';</script>";
    }
  ?>

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


  <?php
    /*Display the quicklinks for each category*/
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $query = "select * from CategoriesView";
    $stmt = $db->prepare($query);
    $stmt->bind_result($categoryId,$categoryName);
    $stmt->execute();

    echo "<ul class='categoriesList'>";
    echo "<p>Filter Cards By Category.</p>";
    while ($stmt->fetch()) {
      echo "<li><a href='index.php?categoryName=$categoryName'>$categoryName</a></li>";
    }
    echo "</ul>";

  ?>
  </div>
  </div>
</main>

<?php
  /*Only include Javascript animation if an alternative has been clicked.*/
  if(isset($_POST['altClicked']) && !empty($_POST['altClicked'])){
    echo "<script type='text/javascript' src='js/incNbr.js'></script>";
    echo "<script type='text/javascript'>";
    echo "incEltNbr('percent1');/*Call this funtion with the ID-name for that element to increase the number within*/";
    echo "incEltNbr('percent2');";
    echo "</script>";
  }
?>
<?php  include "footer.php"?>
