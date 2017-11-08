<?php
  session_start();

  include ("config.php");

  $cardId = trim($_GET['cardId']);
  $cardId = addslashes($cardId);

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $stmt = $db->prepare("DELETE FROM Comments WHERE cardId=$cardId");
    $stmt->execute();

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $stmt = $db->prepare("Delete From CardsUsersRating Where cardId=$cardId");
      $stmt->execute();


    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $stmt = $db->prepare("Delete From Cards Where cardId=$cardId");
    $stmt->execute();

    header("location: profile.php?username={$_SESSION['username']}");
    exit;

?>
