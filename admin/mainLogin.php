<?php
  session_start();
  if (isset($_SESSION['admin'])) {
      header("location:index.php");
  }
?>

<?php include "../config.php" ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Admin</h1>

    <?php

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=mainLogin.php>Return to home page </a>");
          exit();
      }

      if (isset($_POST['username'], $_POST['password'])) {
          #with statement under we're making it SQL Injection-proof
          $username = htmlentities($_POST['username']);
          $username = mysqli_real_escape_string($db, $username);

          #here we hash the password, and we want to have it hashed in the database as well
          #optimally when you create a user (through code) you simply send a hash
          #hasing can be done using different methods, MD5, SHA1 etc.

          $upass = htmlentities($_POST['password']);
          $upass = mysqli_real_escape_string($db, $upass);
          $upass = sha1($upass);

          #just to see what we are selecting, and we can use it to test in phpmyadmin/heidisql

          echo "SELECT * FROM AdminView WHERE username = '" . $username . "' AND password = '" . $upass . "'";
          $query = "select * from AdminView where username = '" . $username . "' AND password = '" . $upass . "'";

          $stmt = $db->prepare($query);
          $stmt->execute();
          $stmt->store_result();

          $totalcount = $stmt->num_rows();

      }
      ?>


      <?php
        if (isset($totalcount)) {
            if ($totalcount == 0) {
                echo '<h2>You got it wrong. Can\'t break in here!</h2>';
            } else {
                $_SESSION['admin'] = $username;
                header("location:index.php");
                exit;
            }
        }
      ?>

      <form method="POST" action="" id="loginField">
          <h3>Login to Admin</h3><br>
          <input type="text" name="username">
          <input type="password" name="password">
          <input type="submit" value="Go">
      </form>
      <a href="../index.php">Return to regular site</a>


  </body>
</html>
