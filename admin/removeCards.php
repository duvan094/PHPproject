<?php
  session_start();
  if (!isset($_SESSION['admin'])) {/*Redirect to the login page if not logged in*/
      header("location:mainLogin.php");
  }

  include ("../config.php");

  $cardId = trim($_GET['cardId']);
  $cardId = addslashes($cardId);

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $stmt = $db->prepare("Delete From Comments Where cardId=$cardId");
    $stmt->execute();


    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $stmt = $db->prepare("Delete From Cards Where cardId=$cardId");
    $stmt->execute();

    header("location:cards.php");
    exit;

?>
