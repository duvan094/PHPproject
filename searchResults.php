<?php include "header.php" ?>
<main id="searchPage">
  <div id="searchMenu">
    <?php
      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      /*Check for connection error*/
      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

        $query = "select * from CardsView Where title LIKE'%" .  $_GET['searchField'] . "%' OR alt1 LIKE'%" .  $_GET['searchField'] . "%' OR alt2 LIKE'%" .  $_GET['searchField'] . "%' OR username LIKE'%" .  $_GET['searchField'] . "%'";
        $stmt = $db->prepare($query);
        $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded,$cardId);
        $stmt->execute();
        $stmt->store_result();
        $nbrOfResults = $stmt->num_rows();
    ?>

    <div class="searchMenuWrapper">
      <button type="button" name="button">Cards</button>
      <button type="button" name="button">Users</button>
      <p><?php echo $nbrOfResults ?> card results for <i><?php echo $_GET['searchField'] ?></i></p>
    </div>
  </div>
  <ul>
    <?php
      while($stmt->fetch()){
       echo "<li>";
       echo "<h3>Would You Rather</h3>";
       echo "<ul class='card-container'>";
       echo "<li><button>$alt1</button></li>";
       echo "<li><button>$alt2</button></li>";
       echo "</ul>";
       echo "<ul class='upvote-container'>";
       echo "<li><button class='like-button'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></button></li>";
       echo "<li><p>$rating</p></li>";
       echo "<li><button class='like-button'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></i></button></li>";
       echo "</ul>";
       echo  "<p class='textWithLink'><a href='index.php?cardId=$cardId'>$title</a>made by <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
       echo "</li>";
      }
    ?>
    <!--<li>
      <h3>If You Where A Cat Would You Do...</h3>
      <ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
      <ul class="upvote-container">
        <li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
        <li><p>0</p></li>
        <li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
      </ul>
      <p class="textWithLink">Made by <a href="#">steffe94</a>, 32 days ago.</p>
    </li>
    <li>
      <h3>Would You Rather Do...</h3>
      <ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
      <ul class="upvote-container">
        <li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
        <li><p>0</p></li>
        <li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
      </ul>
      <p class="textWithLink">Made by <a href="#">johan32</a>, 1 year ago.</p>
    </li>
    <li>
      <h3>Would You Rather Do...</h3>
      <ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
      <ul class="upvote-container">
        <li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
        <li><p>0</p></li>
        <li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
      </ul>
      <p class="textWithLink">Made by <a href="#">joppeBoi</a>, 32 days ago.</p>
    </li>-->
  </ul>
</main>
<?php include "footer.php" ?>
