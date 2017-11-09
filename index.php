<?php
  include "header.php";

  $cardIdGlobal = "";//A variable to keep track on which card is currently displayed

  /*Create an array to keep track on which cards has been clicked*/
  if (isset($_SESSION['cardsClicked']) === false){
      $_SESSION['cardsClicked'] = array();
  }
?>


<main>
  <?php include "functions/displayCard.php" ?>

  <?php
  /*Different color scheme for nextPrevious buttons, depending on color cookie*/
  if(isset($_COOKIE['color_mode'])){
      echo "<div id='nextPrevButtonsContainer' class='" . ($_COOKIE['color_mode'] == "light" ? 'light' : NULL) . "'>";
  }else{
    echo "<div id='nextPrevButtonsContainer'>";
  }
  ?>
  <?php
    echo "<ul>";

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $query = "select cardId AS previousCard from Cards Where cardId < {$cardId} Order by cardId DESC limit 1";
    $stmt = $db->prepare($query);
    $stmt->bind_result($previousCard);
    $stmt->execute();
    $stmt->fetch();
    echo "<li><a href='index.php?cardId={$previousCard}'>Previous Question</a></li>";

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }
    $query = "select cardId AS nextCard from Cards Where cardId > {$cardId} Order by cardId ASC limit 1";
    $stmt = $db->prepare($query);
    $stmt->bind_result($nextCard);
    $stmt->execute();
    $stmt->fetch();
    echo "<li><a href='index.php?cardId={$nextCard}'>Next Question</a></li>";
    echo "</ul>";
  ?>
  </div>
  <div class="container">
     <div><!-- a wrapper -->
      <?php include "functions/vote.php" ?>
      <?php include "functions/comment.php" ?>
      <?php include "functions/displayComments.php" ?>
      <?php include "functions/categories.php" ?>
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
