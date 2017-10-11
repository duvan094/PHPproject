<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Would you rather!</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  	<meta name="viewport" content="width=devide-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css">
    <script src="https://use.fontawesome.com/8718023d1d.js"></script>
  </head>
  <body>
    <nav>
      <div class="navWrapper">
        <a id="home" href="index.php">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="783.366px" height="744px" viewBox="0 0 783.366 744" enable-background="new 0 0 783.366 744" xml:space="preserve">
            <path fill="#66CAED" d="M411.366,0v246.52c60.793,9.459,107.317,62.035,107.317,125.48s-46.524,116.021-107.317,125.48V744  c205.45,0,372-166.55,372-372S616.816,0,411.366,0"/>
            <path fill="#89DA59" d="M264.683,372c0-63.445,46.524-116.021,107.317-125.48V0C166.551,0,0,166.55,0,372s166.551,372,372,372  V497.48C311.207,488.021,264.683,435.445,264.683,372"/>
          </svg>
        </a>
        <ul>
          <li><a id="signupShow1" href="">Sign Up</a></li>
          <li><a id="loginShow" href="">Log In</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="topcards.php">Top Cards</a></li>
          <li><a href="addCards.php">+ Add Cards</a></li>
          <li>
            <form id="searchBar" action="searchResults.php" method="GET">
              <input type="text" name="searchField" placeholder="Search Users or Questions..."value="">
            </form>
          </li>
        </ul>
      </div>
    </nav>



<div id=loginWrapper>

  <div class="logincontainer">

    <h3>Log In</h3>

    <form>
      <p>USERNAME</p>
      <input type="text" name="username"> <br>
      <p>PASSWORD</p>
      <input type="password" name="password"> <br>
      <input type="submit" name="SIGN IN" value="SIGN IN">
    </form>
    <p class = "textWithLink">Don't have an account? <a href="" id="signupShow2">Sign Up</a> for free!</p>

  </div>
</div>

<div id=signupWrapper>

  <div class="logincontainer">

    <h3>Sign Up</h3>

    <form>
      <p>USERNAME</p>
      <input type="text" name="username"> <br>
      <p>PASSWORD</p>
      <input type="password" name="password"> <br>
      <p>CONFIRM PASSWORD</p>
      <input type="password" name="password"> <br>
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
  document.querySelector("#loginWrapper").addEventListener("click", function(event){
    document.getElementById("loginWrapper").style.display = "none";
  }, false);

  //This prevents the modal from closing when the user clicks on elements within the modal.
  document.querySelector("#loginWrapper").children[0].addEventListener('click', function(e) {
      e.stopPropagation();
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
