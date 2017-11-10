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

    if(isset($_GET['categoryName']) && !empty($_GET['categoryName'])){//Check if a specific category is requested
      $query = $query . " Where categoryName='".$_GET['categoryName']."'";
    }

    $stmt = $db->prepare($query);
    $stmt->bind_result($title, $alt1, $alt2, $alt1Count, $alt2Count, $rating, $categoryName,$username,$countryName,$dateAdded, $cardId);
    $stmt->execute();
  }

  $stmt->fetch();

    /*Here we save the clicked alternative into an array.*/
    if(isset($_POST['altClicked']) && !empty($_POST['altClicked'])){  //Check if an alternative has been clicked
      if (isset($_SESSION['cardsClicked']) === false){//If array storing clicked cards don't exist
          $altClickedArr = array($cardId => $_POST['altClicked']);  //Add cardId to array
          $_SESSION['cardsClicked'] = $altClickedArr; //Which is then stored in a Session
      }else{  //If the array already exists in session the value is
        $altClickedArr = $_SESSION['cardsClicked']; //Save the session array into a temp variable
        $altClickedArr[$cardId]=$_POST['altClicked']; //Save the clicked alternative into the array
        $_SESSION['cardsClicked'] = $altClickedArr; //Save the temp array into the session
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
        $query = ("UPDATE Cards SET alt1Count = alt1Count + 1 WHERE cardId={$cardId}");
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
  ?>
