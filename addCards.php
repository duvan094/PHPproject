<?php include "header.php" ?>

<main id="logintoaddcards">

  <?php
    if(!isset($_SESSION['username'])) {//Only include loginModule if logged in.
      echo "<h1>You have to Log in to create cards</h1>";

    } else {

      echo "<div class='addCardsContainer'>";
      echo "<h3>Here you create your own cards.</h3>";
      echo "<p>Please fill out a title with maximum 30 caracters, and two Would You Rather-alternatives.</p><br>";

      echo "<h3>Title:</h3>";
      echo "<form><input type='text' name='title'></form> <br>";

      echo "<h3>Would you rather?</h3>";
      echo "<ul class='card-container'>";
      echo "<li> <form class='card'> <input id='addCardsInput' type='text' name='alt1' placeholder='Alternative One'> </form> </li>";
      echo "<li> <form class='card'> <input id='addCardsInput' type='text' name='alt2' placeholder='Alternative Two'> </form> </li>";

      echo "</ul>";
      echo "</div>";

    }
  ?>


</main>

<?php include "footer.php" ?>
