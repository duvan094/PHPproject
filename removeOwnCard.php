<?php
  session_start();
  include ("config.php");

  /*XSS hijacking prevention*/
  if (isset($_SESSION['userip']) === false){
      #here we store the IP into the session 'userip'
      $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
  }

  if ($_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']){
      #if it is not the same, we just remove all session variables
      #this way the attacker will have no session
      session_unset();
      session_destroy();
  }

  /*Check if user is logged in and if there is a cardId in get*/
  if(isset($_SESSION['username']) && isset($_GET['cardId'])){

    $cardId = trim($_GET['cardId']);
    $cardId = addslashes($cardId);

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $stmt = $db->prepare("SELECT * From CardsView Where cardId={$cardId} AND username='{$_SESSION['username']}'");
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows() != 0){//Check if user owns a card with that specific cardId
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

          $stmt = $db->prepare("DELETE From CardsUsersRating Where cardId=$cardId");
          $stmt->execute();


        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        $stmt = $db->prepare("DELETE From Cards Where cardId=$cardId");
        $stmt->execute();

        header("location: profile.php?username={$_SESSION['username']}");
        exit;
      }
  }

  //if not logged in or no cardId in get, go to index
  header("location: index.php");
  exit;

?>
