<?php
  session_start();
  if (!isset($_SESSION['admin'])) {/*Redirect to the login page if not logged in*/
      header("location:mainLogin.php");
  }

  include ("../config.php");

$commentId = trim($_GET['commentId']);
$commentId = addslashes($commentId);

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $stmt = $db->prepare("Delete From Comments Where commentId=$commentId");
  $stmt->execute();

  header("location:comments.php");
  exit;

?>
