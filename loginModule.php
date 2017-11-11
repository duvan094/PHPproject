<div id=loginWrapper>

  <?php
    //Open the database...
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    //Check if you can connect.
    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    if (isset($_POST['username'], $_POST['password'])) {

      $username = mysqli_real_escape_string($db, $_POST['username']);
      //Make everything you write into a string... Can't change code with html entitites. Same for password.
      $username = htmlentities($username);

      $password = mysqli_real_escape_string($db, $_POST['password']);
      $password = htmlentities($password);
      $password = SHA1($password);


      $stmt = $db->prepare("SELECT * From Users Where username = '{$username}' AND password ='{$password}'");
      $stmt->bind_result($userId,$username,$password,$country);
      $stmt->execute();
      $stmt->store_result();

      //If there is a match (login), totalcount = number of rows found. One row for one login.
      $totalcount = $stmt->num_rows();
      $stmt->fetch();

      if (isset($totalcount)) {
        if ($totalcount == 0) {
          //Nothing happens when wrong password is typed.
        } else {
            //What's going to happen when you press SUBMIT:
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $userId;
            echo '<meta http-equiv="refresh" content= "0; URL="index.php">';
          }
        }

    }
  ?>



  <div class="logincontainer">
    <button id="close-button1" class="close-button" type="button" name="button"><i class="fa fa-window-close" aria-hidden="true"></i></button>
    <h3>Log In</h3>

    <form method="POST" action="">
      <p>Username</p>
      <input type="text" name="username"> <br>
      <p>Password</p>
      <input type="password" name="password"> <br>
      <input id="loginSubmit" type="submit" name="SIGN IN" value="SIGN IN">
    </form>
    <p class = "textWithLink">Don't have an account? <a href="" id="signupShow2">Sign Up</a> for free!</p>

  </div>
</div>


<div id=signupWrapper>

  <div class="logincontainer">
    <button id="close-button2" class="close-button" type="button" name="button"><i class="fa fa-window-close" aria-hidden="true"></i></button>
    <h3>Sign Up</h3>

    <form method="POST" action="signup.php">
      <p>Username</p>
      <input type="text" name="username"> <br>
      <p>Password</p>
      <input type="password" name="password1"> <br>
      <p>Confirm Password</p>
      <input type="password" name="password2"> <br>
      <select name="countrySelect">
        <?php
          /*Here we enter all the countries as options in the select menu*/
          @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

          //Check if you can connect.
          if ($db->connect_error) {
              echo "could not connect: " . $db->connect_error;
              printf("<br><a href=index.php>Return to home page </a>");
              exit();
          }

          $stmt = $db->prepare("select * From Countries");
          $stmt->bind_result($countryId,$countryName);
          $stmt->execute();

          echo "<option value=''>Select Country:</option>";
          while($stmt->fetch()){
            echo "<option value='{$countryId}'>{$countryName}</option>";
          }
        ?>
      </select>
      <p class="message">(Optional)</p>
      <input type="submit" id="newmember" name="SIGN UP" value="SIGN UP">
    </form>

  </div>
</div>




<script>

  //Makes it possible to close the modal by clicking on the transparent area.
  document.querySelector("#signupWrapper").addEventListener("click", function(event){
    document.getElementById("signupWrapper").style.display = "none";
  }, false);

  //This prevents the modal from closing when the user clicks on elements within the modal.
  document.querySelector("#signupWrapper").children[0].addEventListener('click', function(e) {
      e.stopPropagation();
  }, false);

  //Makes it possible to close the modal by clicking on the transparent area.
  document.querySelector("#close-button2").addEventListener("click", function(event){
    document.getElementById("signupWrapper").style.display = "none";
  }, false);

  //Makes it possible to close the modal by clicking on the transparent area.
  document.querySelector("#loginWrapper").addEventListener("click", function(event){
    document.getElementById("loginWrapper").style.display = "none";
  }, false);

  //This prevents the modal from closing when the user clicks on elements within the modal.
  document.querySelector("#loginWrapper").children[0].addEventListener('click', function(e) {
      e.stopPropagation();
  }, false);

  //Makes it possible to close the modal by clicking on the transparent area.
  document.querySelector("#close-button1").addEventListener("click", function(event){
    document.getElementById("loginWrapper").style.display = "none";
  }, false);


  document.querySelector("#loginShow").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("loginWrapper").style.display = "block";
    }, false);


  document.querySelector("#signupShow1").addEventListener("click", function(event) {
      event.preventDefault();
      document.getElementById("loginWrapper").style.display = "none";
      document.getElementById("signupWrapper").style.display = "block";
    }, false);

    document.querySelector("#signupShow2").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("loginWrapper").style.display = "none";
        document.getElementById("signupWrapper").style.display = "block";
      }, false);

</script>
