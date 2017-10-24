<?php include "config.php"; ?>

<?php 

	if(isset($_POST['username']) && isset($_POST['password'])){

		@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	    if ($db->connect_error) {
	        echo "could not connect: " . $db->connect_error;
	        printf("<br><a href=index.php>Return to home page </a>");
	      exit();
	    }

        $username = mysqli_real_escape_string($db,$_POST['username']);
        $password = mysqli_real_escape_string($db,$_POST['password']);
        $result = mysqli_query($db,$query);
        $numResults = mysqli_num_rows($result);

        mysql_query("INSERT INTO users(username, password) VALUES('".$username."','".$password."')");
        }
    }
	
?>