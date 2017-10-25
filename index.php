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

        /*Check which alternative that has been clicked*/
        if($_POST['altClicked'] == $alt1){/*If altClicked == alt1, it means that the first alternative was clicked*/
          /*Increase the card for the selected card*/
          $query = ("Update Cards SET alt1Count = alt1Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();

          $alt1Count = $alt1Count+1;/*Since alt1Count is the value before the Update operation we increase it by 1*/
          $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));/*Calculate the percentage for card 1*/
          $percent2 = 100-$percent1;/*Calculate the percentage for card 2*/
          echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} agree with you</p><h5>{$alt1}</h5></div></div>";
          echo "<div><div><h3><span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} disagree with you</p><h5>{$alt2}</h5></div></div>";
        }else{
          $query = ("Update Cards SET alt2Count = alt2Count + 1 WHERE cardId={$cardId}");
          $stmt = $db->prepare($query);
          $stmt->execute();

          $alt2Count = $alt2Count + 1;/*Since alt1Count is the value before the Update operation we increase it by 1*/

          /*In the case that alt1Count is 0, which would lead to division by 0, resulting in an error*/
          if($alt1Count!=0){
            $percent1 = round(100 * ($alt1Count/($alt1Count+$alt2Count)));
            $percent2 = 100 - $percent1;
          }else{
            $percent1 = 0;
            $percent2 = 100;
          }

          echo "<div><div><h3><span id='percent1'>{$percent1}</span>%</h3><p>{$alt1Count} agree with you</p><h5>{$alt1}</h5></div></div>";
          echo "<div><div><h3><i class='fa fa-check' aria-hidden='true'></i> <span id='percent2'>{$percent2}</span>%</h3><p>{$alt2Count} disagree with you</p><h5>{$alt2}</h5></div></div>";
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

    </main>

    <script type="text/javascript">
      /*This script makes a Count animation for the percentage numbers*/
      var speed = 10;

      /* Call this function with a string containing the ID name to
       * the element containing the number you want to do a count animation on.*/
      function incEltNbr(id){
        elt = document.getElementById(id);
        endNbr = Number(document.getElementById(id).innerHTML);
        incNbrRec(0,endNbr,elt);
      }

      /*A recursive function to increase the number.*/
      function incNbrRec(i,endNbr,elt){
        if(i <= endNbr){
          elt.innerHTML = i;
          setTimeout(function() {
            incNbrRec(i+1,endNbr,elt);
          }, speed);
        }
      }

      incEltNbr("percent1");/*Call this funtion with the ID-name for that element to increase the number within*/
      incEltNbr("percent2");/*Call this funtion with the ID-name for that element to increase the number within*/

    </script>

    <?php  include "footer.php"?>
