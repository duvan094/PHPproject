<?php include "header.php" ?>
<main id="searchPage">
  <?php
    /*Check if either searchfield is filled or if a user chose a specific category*/
    if((isset($_GET['searchField']) && !empty($_GET['searchField'])) || (isset($_GET['category']) && !empty($_GET['category']))){

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      /*Check for connection error*/
      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query;
      $searchVariable;

      /*If a user chose a category*/
      if(isset($_GET['category']) && !empty($_GET['category'])){
        $searchVariable =  mysqli_real_escape_string($db, $_GET['category']);
        $searchVariable = htmlentities($searchVariable);
        $query = "select * from CardsView Where categoryName='" . $searchVariable . "'";
      }else{
        $searchVariable =  mysqli_real_escape_string($db, $_GET['searchField']);
        $searchVariable = htmlentities($searchVariable);
        $query = "select * from CardsView Where title LIKE'%" .  $searchVariable . "%' OR alt1 LIKE'%" . $searchVariable . "%' OR alt2 LIKE'%" . $searchVariable . "%' OR username LIKE'%" . $searchVariable . "%'";
      }

      $stmt = $db->prepare($query);
      $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$dateAdded,$cardId);
      $stmt->execute();
      $stmt->store_result();
      $nbrOfResults = $stmt->num_rows();

  ?>

  <div id="searchMenu">

    <div class="searchMenuWrapper">
      <button type="button" name="button">Cards</button>
      <button type="button" name="button">Users</button>
      <p><?php echo $nbrOfResults ?> card results for <i><?php echo $searchVariable ?></i></p>
    </div>
  </div>
  <ul>
    <?php
      while($stmt->fetch()){
        echo "<li>";
        echo "<form class='card-container' action='index.php?cardId={$cardId}' method='post'>";
        echo "<div><input type='submit' name='altClicked' value='{$alt1}'></div>";
        echo "<div><input type='submit' name='altClicked' value='{$alt2}'></div>";
        echo "</form>";
        echo "<ul class='upvote-container'>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-down' aria-hidden='true'></i></i></button></li>";
        echo "<li><p>$rating</p></li>";
        echo "<li><button class='like-button'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button></li>";
        echo  "</ul>";
        echo  "<p class='textWithLink'><a class='cardLinkTitle' href='index.php?cardId=$cardId'>$title</a><br>Made by <i class='fa fa-user' aria-hidden='true'></i> <a href='profile.php?username=$username'>$username</a>, $dateAdded</p>";
        echo "</li>";
      }


      /*At the bottom of the page we put some buttons for quick access for searching a specific category*/
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

      echo "<ul class='categoriesList searchCategories'>";
      echo "<p>Search Cards By Category.<br></p>";
      while ($stmt->fetch()) {
        echo "<li><a href='searchResults.php?category=$categoryName'>$categoryName</a></li>";
      }
      echo "</ul>";


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
<?php
  }else{
    echo "<form id='searchBarLarge' action='searchResults.php' method='GET'>";
    echo "<h2><i class='fa fa-search' aria-hidden='true'></i> Please enter a search value.</h2>";
    echo "<input type='text' name='searchField' placeholder='Search Users or Questions...' value=''>";
    echo "<input type='submit' name='' value='Search'>";
    echo "</form>";

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

    echo "<ul class='categoriesList searchCategories'>";
    echo "<p>Or Search Cards By Category.<br></p>";
    while ($stmt->fetch()) {
      echo "<li><a href='searchResults.php?category=$categoryName'>$categoryName</a></li>";
    }
    echo "</ul>";


  }
?>
</main>
<?php include "footer.php" ?>
