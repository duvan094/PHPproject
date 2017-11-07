<?php
  /*Display the quicklinks for each category*/
  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  /*Check for connection error*/
  if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
  }

  $query = "select * from CategoriesView";
  $stmt = $db->prepare($query);
  $stmt->bind_result($categoryId,$categoryName);
  $stmt->execute();

  echo "<ul class='categoriesList'>";
  echo "<p>Filter Cards By Category.</p>";
  while ($stmt->fetch()) {
    echo "<li><a href='index.php?categoryName=$categoryName'>$categoryName</a></li>";
  }
  echo "</ul>";

?>
