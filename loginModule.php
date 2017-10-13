<div id=loginWrapper>

  <div class="logincontainer">
    <button id="close-button1" class="close-button" type="button" name="button"><i class="fa fa-window-close" aria-hidden="true"></i></button>
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
    <button id="close-button2" class="close-button" type="button" name="button"><i class="fa fa-window-close" aria-hidden="true"></i></button>
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

    /*Hamburger button*/
    document.querySelector("#hamburgerButton").addEventListener("click", function(event) {
            event.preventDefault();
            document.querySelector("nav>div>ul").classList.toggle("clicked");
            document.querySelector("#hamburgerButton").classList.toggle("clicked");
    }, false);



</script>
