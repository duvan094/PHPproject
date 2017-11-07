<?php
  /*Connect to the database to insert the comment*/
  if (isset($_POST['comment']) && $_POST['comment'] != "") {
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    /*Check for connection error*/
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $cardId = $_GET['cardId'];
    $userId = $_SESSION['userId'];
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $comment = htmlentities($comment);

    $query = ("INSERT INTO Comments (cardId, comment, userId) VALUES ({$cardId}, '{$comment}', {$userId})");
    $stmt = $db->prepare($query);
    $stmt->execute();

    /*Code to keep the form from sending the information several times. Borrowed from Ellen Brage.*/
    unset($_POST);
    echo "<script> window.location.href ='index.php?cardId=$cardId';</script>";
  }
?>
