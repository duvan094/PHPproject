    <?php include "header.php" ?>
    <main>
      <h1>Would You Rather?</h1>

      <ul class="card-container">
        <li><button>This?</button></li>
        <li><button>That?</button></li>
      </ul>
      <ul class="upvote-container">
        <li><button class="like-button"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></li>
        <li><p>0</p></li>
        <li><button class="like-button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></i></button></li>
      </ul>
      <p class="textWithLink">Made by <a href="#">steffe94</a>, 32 days ago.</p>

      <ul id="nextPrevButtons">
        <li><button>Previous Question</button></li>
        <li><button>Next Question</button></li>
      </ul>

      <ul id="commentContainer">
        <li><h4>4 comments</h4></li>
        <li class="commentField">
            <a href="#">joppeBoii</a>
            <p><i>2017-09-28</i></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. </p>
        </li>
        <li class="commentField">
            <a href="#">robben55</a>
            <p><i>2017-09-28</i></p>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
              deserunt mollit anim id est laborum. </p>
        </li>
        <li class="commentField">
            <a href="#">joppeBoii</a>
            <p><i>2017-09-28</i></p>
            <p>Sed do eiusmod tempor incididunt ut. </p>
        </li>
        <li class="commentField">
            <a href="#">oveMann</a>
            <p><i>2017-09-29</i></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
              abore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
              sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </li>
        <li class="commentField comment">
          <form class="" action="index.html" method="post">
            <textarea name="" rows="6" cols="80" placeholder="Write a comment."></textarea>
            <br>
            <input type="submit" name="" value="Post Your Comment">
          </form>
        </li>
      </ul>
    </main>
    <?php  include "footer.php"?>
