
<?php
    if($_COOKIE["color_mode"] == "dark" || !isset($_COOKIE["color_mode"])){
      if(isset($_POST['changeColor'])){
        setcookie("color_mode", "light", time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        die;
      }
    }else{
      if(isset($_POST['changeColor'])){
        setcookie("color_mode", "dark", time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        die;
      }
    }

  ?>
