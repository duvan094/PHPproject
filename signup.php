
<?php
	if(isset($_POST['username']) && isset($_POST['password1']) && $_POST["password1"] === $_POST["password2"]){

    include "config.php";

		@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
    /*@ $db = new mysqli($dbname, $dbuser, $dbpass, $dbserver);*/

	    if ($db->connect_error) {
	        echo "could not connect: " . $db->connect_error;
	        printf("<br><a href=index.php>Return to home page </a>");
          exit();
	    }


        $username = mysqli_real_escape_string($db,$_POST['username']);
        $password = mysqli_real_escape_string($db,$_POST['password1']);
				$password = SHA1($password);
        $countryId = ($_POST['countrySelect']);



        if(isset($_POST['countrySelect']) && $_POST['countrySelect'] !== ""){
          $query = "INSERT INTO users(username, password, countryId) VALUES('{$username}','{$password}',{$countryId})";
        }else{
          $query = "INSERT INTO users(username, password, countryId) VALUES('{$username}','{$password}', NULL)";
        }

        $stmt = $db->prepare($query);
        $stmt->execute();

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
    /*@ $db = new mysqli($dbname, $dbuser, $dbpass, $dbserver);*/

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
         exit();
      }

      $query = "select userId From Users Where username = '{$username}'";

      $stmt = $db->prepare("$query");
      $stmt->bind_result($userId);
      $stmt->execute();

      $stmt->fetch();

      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['userId'] = $userId;
  }



  header("location: index.php")
?>
