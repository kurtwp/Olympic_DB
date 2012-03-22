<?php
require_once 'functions.php';
require_once 'db_connect.php';
require_once 'header.html';
$search_name = "";
$edit_id = 0;
$home = "";
$mode = "";
// Search Customer by Last name
if ($_SERVER['REQUEST_METHOD'] ==  "POST"){
  if ($_POST['search_name']){
    $search_name = sanitizeMySQL($_POST['search_name']);
    $search_name = $search_name;if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $id = $edit_id;
}
    $result = mysql_query("SELECT id, L_name
                          FROM master_name
                          WHERE L_name
                          LIKE '$search_name'") or die ("Issue selecting rows - " . mysql_error());
    $row = mysql_num_rows($result);
    if ($row > 0) {
      echo "<table><tr><th>Last Name</th><th>VIEW</th><th>EDIT</th></tr>";
      while ($line = mysql_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>$line[L_name]</td>";
        echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?id=" . $line['id'] . "&mode=view>VIEW</a></td>";
        echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?id=" . $line['id'] . "&mode=edit>EDIT</a></td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "No record found<br />";
    }
  }
}
// Check to make sure MODE is set and not empty
  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } 
  if ($mode == "view") {
    $id = $_GET['id'];
    session_start();
    $_SESSION['id'] = $id;
    header('Location: view_entry.php');
    exit;
  }
  if ($mode == "edit") {
    $id = $_GET['id'];
    session_start();
    $_SESSION['id'] = $id;
    header('Location: edit_entry.php');
    exit;
  }// End if edit*/
echo <<<_END
<form action="search_entry.php" method="post">
<p><strong>Search by Last name only</strong></p>
Search <input type='text' size="20" maxlength='50' name='search_name' value='$search_name' /><br />
<input class="searchbutton" type='submit' value='Search' />
</form>
_END;
require_once 'footer.html';
?>