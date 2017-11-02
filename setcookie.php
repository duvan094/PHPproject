
<?php
    if(isset($_COOKIE["color_mode"])){//check if cookie exists
      if(isset($_POST['changeColor'])){ //Check if user has pressed button
        if($_COOKIE["color_mode"] == "dark"){ //Check which color scheme currently exists.
          setcookie("color_mode", "light", time() + (86400 * 30), "/"); // 86400 = 1 day
          header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
          die;
        }else{
          setcookie("color_mode", "dark", time() + (86400 * 30), "/"); // 86400 = 1 day
          header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
          die;
        }
      }
    }else{  //Set cookie if it doesn't exist
      setcookie("color_mode", "dark", time() + (86400 * 30), "/"); // 86400 = 1 day
      header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
      die;
    }

  ?>
