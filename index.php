    <?php include "header.php" ?>
    <main>
      <h1>Would You Rather?</h1>
    <?php

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      /*Check for connection error*/
      if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }

      if(isset($_GET['cardId']) && !empty($_GET['cardId'])){
        $query = "select * from CardsView Where cardId=" . $_GET['cardId'];
        $stmt = $db->prepare($query);
        $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded, $cardId);
      }else{
        $query = "select * from RandomCard";
        $stmt = $db->prepare($query);
        $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded, $cardId);
      }

      $stmt->execute();
      $stmt->fetch();

      echo "<ul class='card-container'>";
      echo "<li><button> $alt1 </button></li>";
      echo "<li><button> $alt2 </button></li>";
      echo "</ul>";
      echo "<ul class='upvote-container'>";
      echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
      echo "<li><p>$rating</p></li>";
      echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
      echo  "</ul>";
      echo  "<p class='textWithLink'>Made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";

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
        <li><button>Previous Question</button></li>
        <li><button>Next Question</button></li>
      </ul>

      <?php
      /*Create View CardComments AS
      Select Cards.title, Users.username, Comments.comment, Comments.dateAdded, Cards.cardId
      from Cards
      Join Comments ON Cards.cardId = Comments.cardId
      Join Users ON Users.userId = Comments.userId;
      /*Where Cards.cardId = 1;*/

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

      <li class="commentField comment">
        <form class="" action="index.html" method="post">
          <textarea name="" rows="6" cols="80" placeholder="Write a comment."></textarea>
          <br>
          <input type="submit" name="" value="Post Your Comment">
        </form>
      </li>
    </ul>

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
