    <?php include "header.php" ?>
    <?php
      $cardIdGlobal = "";
     ?>

    <main>


      <h3>Would You Rather?</h3>
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
        $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded, $cardId);
        $stmt->execute();
        $stmt->store_result();


        /*If no card can be found, the page is refreshed and selects a random card.*/
        if($stmt->num_rows() == 0){
          echo '<meta http-equiv="refresh" content= "0; URL=index.php">';
          exit;
        }

      }else{
        /*If no specific card is requested from the GET, a random card is selected*/
        $query = "select * from RandomCard";

        if(isset($_GET['categoryName']) && !empty($_GET['categoryName'])){
          $query = "Select * from RandomList Where categoryName='".$_GET['categoryName']."'";
        }

        $stmt = $db->prepare($query);
        $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded, $cardId);
        $stmt->execute();
      }

      $stmt->fetch();
/*
      echo "<ul class='card-container'>";
      echo "<li><button> $alt1 </button></li>";
      echo "<li><button'> $alt2 </button></li>";
      echo "</ul>";
      echo "<ul class='upvote-container'>";
      echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
      echo "<li><p>$rating</p></li>";
      echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
      echo  "</ul>";
      echo  "<p class='textWithLink'><a href='index.php?cardId=$cardId'>$title</a> made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
*/
      if(isset($_POST['altClicked']) && !empty($_POST['altClicked'])){
        echo "<form class='card-container'>";


        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

        /*Check for connection error*/
        if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
        }
        //      UPDATE Orders SET Quantity = Quantity + 1 WHERE ...


        if($_POST['altClicked'] == $alt1){
          $query = ("Update Cards SET alt1Count = alt1Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();

          $alt1Count = $alt1Count+1;
          $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));
          $percent2 = 100-$percent1;
          echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> {$percent1}%</h3><p>{$alt1Count} agree</p><h5>{$alt1}</h5></div></div>";
          echo "<div><div><h3>{$percent2}%</h3><p>{$alt2Count} disagree</p><h5>{$alt2}</h5></div></div>";
        }else{
          $query = ("Update Cards SET alt2Count = alt2Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();

          $alt2Count = $alt2Count + 1;

          if($alt1Count!=0){
            $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));
            $percent2 = 100 - $percent1;
          }else{
            $percent1 = 0;
            $percent2 = 100;
          }

          echo "<div><div><h3>{$percent1}%</h3><p>{$alt1Count} disagree</p><h5>{$alt1}</h5></div></div>";
          echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> {$percent2}%</h3><p>{$alt2Count} agree</p><h5>{$alt2}</h5></div></div>";
        }
        echo "</form>";
        echo "<ul class='upvote-container'>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
        echo "<li><p>$rating</p></li>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
        echo  "</ul>";
        echo  "<p class='textWithLink'><a href='index.php?cardId=$cardId'>$title</a> made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
      }else{
        echo "<form class='card-container' action='index.php?cardId={$cardId}' method='post'>";
        echo "<div><input type='submit' name='altClicked' value='{$alt1}'></div>";
        echo "<div><input type='submit' name='altClicked' value='{$alt2}'></div>";
        echo "</form>";
        echo "<ul class='upvote-container'>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
        echo "<li><p>$rating</p></li>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
        echo  "</ul>";
        echo  "<p class='textWithLink'><a href='index.php?cardId=$cardId'>$title</a> made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
      }

      $cardIdGlobal = $cardId;
?>

<!--
      <ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
      <ul class="upvote-container">
        <li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
        <li><p>0</p></li>
        <li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
      </ul>
      <p class="textWithLink">Made by <a href="profile.php">steffe94</a>, 32 days ago.</p>
-->
      <ul id="nextPrevButtons">
        <li><a href="index.php?cardId=<?php echo $cardId-1;?>">Previous Question</a></li>
        <li><a href="index.php?cardId=<?php echo $cardId+1;?>">Next Question</a></li>
      </ul>


      <?php

        if (isset($_POST['comment'])) {
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



          #<iframe style="position:fixed; top:10px; left:10px; width:100%; height:100%; z-index:99;" border="0" src="http://ju.se/"  />
          #try the iframe after you add the "htmlentities"

          $query = ("INSERT INTO Comments (cardId, comment, userId) VALUES ({$cardId}, '{$comment}', {$userId})");
          $stmt = $db->prepare($query);
          $stmt->execute();
        }

      ?>

      <?php

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

        /*Check for connection error*/
        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        $query = "select * from CardComments where cardId = " . $cardId;
        $stmt = $db->prepare($query);
        $stmt->bind_result($title, $username, $comment, $dateAdded, $cardId);
        $stmt->execute();
        $stmt->store_result();
        $nbrOfComments = $stmt->num_rows();


        echo "<ul id='commentContainer'>";
        echo "<li><h4>$nbrOfComments comments</h4></li>";
        while ($stmt->fetch()) {
          echo "<li class='commentField'>";
          echo "<a href='profile.php?username=$username'>$username</a>";
          echo "<p><i>$dateAdded</i></p>";
          echo "<p>$comment</p>";
          echo "</li>";
        }
      ?>

      <?php

        if (isset($_SESSION['username'])) {//The header if logged in.
          echo "<li class='commentField comment'>";
          echo "<form class='' action='index.php?cardId={$cardIdGlobal}' method='post'>";
          echo "<textarea name='comment' rows='6' cols='80' placeholder='Write a comment.'></textarea>";
          echo "<br>";
          echo "<input type='submit' name='' value='Post Your Comment'>";
          echo "</form>";
          echo "</li>";
        }else{
          echo "<li class='comment commentField'><h4>Log in to comment.</h4></li>";
        }
       ?>

    </ul>

    <?php
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
      <!--<ul id="commentContainer">
        <li><h4>4 comments</h4></li>
        <li class="commentField">
            <a href="#">joppeBoii</a>
            <p><i>2017-09-28</i></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. </p>
        </li>
        <li class="commentField">
            <a href="#">robben55</a>
            <p><i>2017-09-28</i></p>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
              deserunt mollit anim id est laborum. </p>
        </li>
        <li class="commentField">
            <a href="#">joppeBoii</a>
            <p><i>2017-09-28</i></p>
            <p>Sed do eiusmod tempor incididunt ut. </p>
        </li>
        <li class="commentField">
            <a href="#">oveMann</a>
            <p><i>2017-09-29</i></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
              abore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
              sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </li>-->

    </main>


    <?php  include "footer.php"?>
