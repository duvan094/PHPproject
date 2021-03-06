<?php
#first measurement is to change the settings in phpini which is not usually touched
#we change the 'session.cookie_httponly' to true, saying that the cookie can only be accessed via PHP
#this will prevent any Javascript attacks getting the cookie
ini_set('session.cookie_httponly', true);

session_start ();

include "setcookie.php";

/*Prevent session hijacking*/
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

?>

<?php include "config.php" ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Would you rather!</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css">
    <script src="https://use.fontawesome.com/8718023d1d.js"></script>
  </head>


  <?php
    if(isset($_COOKIE['color_mode'])){//Check if cookie is set, and set respective color theme.
        if($_COOKIE['color_mode'] == "light"){
          echo "<body class='light'>";
          echo "<nav class='light'>";
        }else{
          echo "<body>";
          echo "<nav>";
        }
      }else{//If no cookie is set
        echo "<body>";
        echo "<nav>";
      }
    ?>

      <div class="navWrapper">
        <a class="home" href="index.php">
          <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 197.94 59.57"><defs><style>.cls-1{fill:#7BB296;}.cls-2{fill:#fff;}.cls-3{fill:#FF5B44;}</style></defs><title>logo2</title><path class="cls-1" d="M30.92.47h7.47L27.52,22.57H20L19.14,9.39,13.78,22.57H6.25L2.75.47h7.82l.95,14.47L17.18.5l7.12,0,.95,14.47Z"/><path class="cls-1" d="M55.4,1.34A9.73,9.73,0,0,1,59.29,5a10.46,10.46,0,0,1,1.39,5.39,12.1,12.1,0,0,1-1.77,6.45,12.54,12.54,0,0,1-4.82,4.54,14,14,0,0,1-6.78,1.65,11.9,11.9,0,0,1-5.75-1.36A9.77,9.77,0,0,1,37.67,18a10.62,10.62,0,0,1-1.39-5.42A12,12,0,0,1,38,6.11a12.34,12.34,0,0,1,4.82-4.49A14.22,14.22,0,0,1,49.65,0,12,12,0,0,1,55.4,1.34ZM46.54,6.87a5.94,5.94,0,0,0-2,2.16,6.13,6.13,0,0,0-.76,3,5.55,5.55,0,0,0,.57,2.52,4.52,4.52,0,0,0,1.53,1.78A3.67,3.67,0,0,0,48,17a4.43,4.43,0,0,0,2.54-.8A5.76,5.76,0,0,0,52.44,14a6.62,6.62,0,0,0,.71-3.06A5.24,5.24,0,0,0,52,7.45a3.61,3.61,0,0,0-2.88-1.37A4.64,4.64,0,0,0,46.54,6.87Z"/><path class="cls-1" d="M83.31,13.21a12,12,0,0,1-2.24,5.11,11.31,11.31,0,0,1-4.21,3.37,13.17,13.17,0,0,1-5.69,1.2,12,12,0,0,1-4.9-.93A7.36,7.36,0,0,1,63,19.29a7.17,7.17,0,0,1-1.15-4.07,11.43,11.43,0,0,1,.22-2L64.65.47H72L69.41,13.21a3.67,3.67,0,0,0-.09.82,2.66,2.66,0,0,0,.79,2,2.75,2.75,0,0,0,2,.76,3.63,3.63,0,0,0,2.49-1A4.58,4.58,0,0,0,76,13.21L78.55.47h7.31Z"/><path class="cls-1" d="M91.57,16.48h9.2l-1.23,6.08H83L87.44.47h7.31Z"/><path class="cls-1" d="M120.66,1.69a8.15,8.15,0,0,1,3.64,3.47,9.79,9.79,0,0,1,1.06,5.25,12.16,12.16,0,0,1-7,10.65,16.06,16.06,0,0,1-7.09,1.51H101.15L105.53.47h9.36A12.77,12.77,0,0,1,120.66,1.69Zm-3.89,5.64a3.71,3.71,0,0,0-2.92-1.18h-2.14l-2.11,10.75h3a4.7,4.7,0,0,0,2.68-.8,5.37,5.37,0,0,0,1.88-2.27,7.83,7.83,0,0,0,.68-3.33A4.58,4.58,0,0,0,116.76,7.33Z"/><path class="cls-2" d="M150.13.47,139.69,15.76l-1.13,6.81h-7.31l1.1-6.71L126.83.47h7.28l3,8.51L142.85.47Z"/><path class="cls-2" d="M167,1.34A9.73,9.73,0,0,1,170.87,5a10.46,10.46,0,0,1,1.39,5.39,12.1,12.1,0,0,1-1.77,6.45,12.54,12.54,0,0,1-4.82,4.54,14,14,0,0,1-6.78,1.65,11.9,11.9,0,0,1-5.75-1.36A9.77,9.77,0,0,1,149.24,18a10.62,10.62,0,0,1-1.39-5.42,12,12,0,0,1,1.76-6.43,12.34,12.34,0,0,1,4.82-4.49A14.22,14.22,0,0,1,161.22,0,12,12,0,0,1,167,1.34Zm-8.86,5.53a5.94,5.94,0,0,0-2,2.16,6.13,6.13,0,0,0-.76,3,5.55,5.55,0,0,0,.57,2.52,4.52,4.52,0,0,0,1.53,1.78,3.67,3.67,0,0,0,2.1.65,4.43,4.43,0,0,0,2.54-.8A5.76,5.76,0,0,0,164,14a6.62,6.62,0,0,0,.71-3.06,5.24,5.24,0,0,0-1.15-3.48,3.61,3.61,0,0,0-2.88-1.37A4.64,4.64,0,0,0,158.12,6.87Z"/><path class="cls-2" d="M195.39,13.21a12,12,0,0,1-2.24,5.11,11.31,11.31,0,0,1-4.21,3.37,13.16,13.16,0,0,1-5.69,1.2,12,12,0,0,1-4.9-.93,7.35,7.35,0,0,1-3.25-2.66A7.18,7.18,0,0,1,174,15.22a11.43,11.43,0,0,1,.22-2L176.73.47H184l-2.55,12.73a3.61,3.61,0,0,0-.09.82,2.67,2.67,0,0,0,.79,2,2.75,2.75,0,0,0,2,.76,3.62,3.62,0,0,0,2.49-1,4.57,4.57,0,0,0,1.42-2.6L190.63.47h7.31Z"/><path class="cls-3" d="M31.16,44.49a12.56,12.56,0,0,1-5.38,5l4.14,10.13H18.13L16,51.38H12.06l-1.62,8.19H0L6.3,28H21.55q5.54,0,8.5,2.36a8.1,8.1,0,0,1,3,6.73A14.35,14.35,0,0,1,31.16,44.49Zm-17.48-1H18.5a4.18,4.18,0,0,0,3.22-1.28,4.79,4.79,0,0,0,1.19-3.4,2.78,2.78,0,0,0-.77-2.09A3,3,0,0,0,20,35.94H15.17Z"/><path class="cls-3" d="M57.6,59.57l-.81-4.46H45l-2.38,4.46H31.95L50.49,28H61.2L68.8,59.57ZM48.91,47.64h6.57l-1.67-9.18Z"/><path class="cls-3" d="M99.36,28l-1.67,8.24h-9L84,59.57H73.57l4.68-23.31h-9L71,28Z"/><path class="cls-3" d="M122.89,28h10.44L127,59.57H116.59l2.29-11.38h-9.77l-2.29,11.38H96.39L102.69,28h10.44L110.7,40.26h9.77Z"/><path class="cls-3" d="M162.72,35.94H146.47l-.81,3.87h14.8l-1.58,7.92h-14.8l-.81,3.92H160l-1.57,7.92H131.31L137.61,28h26.68Z"/><path class="cls-3" d="M193.7,44.49a12.56,12.56,0,0,1-5.38,5l4.14,10.13H180.67l-2.16-8.19H174.6L173,59.57H162.54L168.84,28h15.25q5.54,0,8.5,2.36a8.1,8.1,0,0,1,3,6.73A14.35,14.35,0,0,1,193.7,44.49Zm-17.48-1H181a4.18,4.18,0,0,0,3.22-1.28,4.79,4.79,0,0,0,1.19-3.4,2.78,2.78,0,0,0-.77-2.09,3,3,0,0,0-2.16-.74H177.7Z"/>
          </svg>
        </a>
        <button id="hamburgerButton" type="button" name="button">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <?php
          /*Displays a different header if the user is logged in*/
          if (isset($_SESSION['username'])) {//The header if logged in.
            echo "<ul>";
            echo "<li><a href='logout.php'>Log&nbsp;Out</a></li>";
            echo "<li><a class='" . ($current_page == ('profile.php?username=' . $_SESSION['username']) ? 'active' : NULL) . "' href='profile.php?username=" . $_SESSION['username'] . "'>Profile</a></li>";
            echo "<li><a class='" . ($current_page == 'topcards.php' ? 'active' : NULL) . "' href='topcards.php'>Top&nbsp;Cards</a></li>";
            echo "<li><a class='" . ($current_page == 'addCards.php' ? 'active' : NULL) . "' href='addCards.php'>+Add&nbsp;Cards</a></li>";
            echo "<li><a class='" . (($current_page == 'index.php' || $current_page == '' || strpos($current_page,'index.php') !== false) ? 'active' : NULL) . "' href='index.php'>Home</a></li>";
            echo "<li>";
            echo "<form id='searchBar' action='searchResults.php' method='GET'>";
            echo "<input type='text' name='searchField' placeholder='Search Users or Questions...' value=''>";
            echo "</form>";
            echo "</li>";
            echo "</ul>";
          }else{//The header if not logged in.
            echo "<ul>";
            echo "<li><a id='signupShow1' href=''>Sign&nbsp;Up</a></li>";
            echo "<li><a id='loginShow' href=''>Log&nbsp;In</a></li>";
            echo "<li><a class='" . ($current_page == 'topcards.php' ? 'active' : NULL) . "' href='topcards.php'>Top&nbsp;Cards</a></li>";
            echo "<li><a class='" . ($current_page == 'addCards.php' ? 'active' : NULL) . "' href='addCards.php'>+Add&nbsp;Cards</a></li>";
            echo "<li><a class='" . (($current_page == 'index.php' || $current_page == '' || strpos($current_page,'index.php') !== false) ? 'active' : NULL) . "' href='index.php'>Home</a></li>";
            echo "<li>";
            echo "<form id='searchBar' action='searchResults.php' method='GET'>";
            echo "<input type='text' name='searchField' placeholder='Search Users or Questions...' value=''>";
            echo "</form>";
            echo "</li>";
            echo "</ul>";
          }
        ?>

      </div>
    </nav>

    <?php
      if(!isset($_SESSION['username'])) {//Only include loginModule if not logged in.
        include "loginModule.php";
      }
    ?>

    <script>
      /*Hamburger button*/
      document.querySelector("#hamburgerButton").addEventListener("click", function(event) {
              event.preventDefault();
              document.querySelector("nav>div>ul").classList.toggle("clicked");
              document.querySelector("#hamburgerButton").classList.toggle("clicked");
      }, false);
    </script>
    <!-- Cookie disclaimer bar -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/cookie-bar/cookiebar-latest.min.js?theme=grey"></script>
