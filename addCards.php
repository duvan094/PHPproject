<?php include "header.php" ?>

<main>
  <?php
    if(!isset($_SESSION['username'])) {//Only include loginModule if logged in.
      echo "<h3>You have to Log in to create cards.</h3>";
    }
  ?>


</main>

<?php include "footer.php" ?>
