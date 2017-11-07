<?php
  session_start();
  if (!isset($_SESSION['admin'])) {/*Redirect to the login page if not logged in*/
      header("location:mainLogin.php");
  }
?>

<?php include "adminHeader.php" ?>
<main>
  <h1>Welcome Admin!</h1>
</main>
<?php //include "footer.php" ?>
