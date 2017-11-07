<?php include "header.php" ?>

<main id="addCardsContainer">

  <?php
    if(!isset($_SESSION['username'])) {//Only include loginModule if logged in.
      echo "<h1>You have to Log in to create cards</h1>";

    } else {

      echo "<div class='addCardsContainer'>";

        echo "<h3>Create your own cards</h3>";
        echo "<p>Fill out a title, two alternatives and a category. As simple as that!</p><br>";

        echo "<h3>Title:</h3>";

        //FORM START - title, alternative x2, categories, submit button
        echo "<form action='' method='post'> <input type='text' name='title' maxlength='30'>";

          echo "<h3><br>Would you rather?</h3><br>";

          echo "<div class='card-container'>";
            echo "<div><textarea class='card' type='text' name='alt1' placeholder='Alternative One...' maxlength='80'></textarea></div>";
            echo "<div><textarea class='card' type='text' name='alt2' placeholder='Alternative Two...' maxlength='80'></textarea></div>";
          echo "</div>";

          echo "<h3><br>Select category:</h3>";
          //Take data from table: Categories. Fill out in the Select-drop-down:
          echo "<select name='categorySelect'>";

              /*Here we enter all the categories as options in the select menu*/
              @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

              //Check if you can connect.
              if ($db->connect_error) {
                  echo "could not connect: " . $db->connect_error;
                  printf("<br><a href=index.php>Return to home page </a>");
                  exit();
              }

              $stmt = $db->prepare("select * From Categories");
              $stmt->bind_result($categoryId,$categoryName);
              $stmt->execute();

              while($stmt->fetch()){
                echo "<option value='{$categoryId}'>{$categoryName}</option>";
              }

          echo "</select> <br> <br>";

          echo "<input id='submitCards' type='submit' name='submit' value='Submit Card'>";

        //FORM END
        echo "</form>";

      echo "</div>";

    }

    if(isset($_POST['title']) && isset($_POST['alt1']) && isset($_POST["alt2"]) && $_POST['categorySelect'] !== ""){

      include "config.php";

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $title = mysqli_real_escape_string($db,$_POST['title']);
      $alt1 = mysqli_real_escape_string($db,$_POST['alt1']);
      $alt2 = mysqli_real_escape_string($db,$_POST['alt2']);
      $categoryId = $_POST['categorySelect'];
      $userId = $_SESSION['userId'];

      $query = "INSERT INTO cards(title, alt1, alt2, userId, categoryId) VALUES('{$title}','{$alt1}','{$alt2}',{$userId},{$categoryId})";

      $stmt = $db->prepare($query);
      $stmt->execute();

      unset($_POST);
      echo "<script> window.location.href ='addCards.php';</script>";
    }

  ?>

</main>

<?php include "footer.php" ?>
