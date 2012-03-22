<?php
require_once 'functions.php';
require_once 'db_connect.php';
require_once 'header.html';
$search_name = "";
$edit = 0;
$table = "";

session_start();
$id = $_SESSION['id'];

$get_name = mysql_query("SELECT * FROM master_name t1
                        LEFT JOIN email t2 ON t1.id = t2.master_id
                        LEFT JOIN address t3 ON t1.id = t3.master_id
                        LEFT JOIN sibling t4 ON t1.id = t4.master_id
                        LEFT JOIN telephone t5 ON t1.id = t5.master_id
                        WHERE t1.id = $id") or die ("Issue selecting rows - " . mysql_error());                
$line = mysql_fetch_assoc($get_name);
        echo $line["f_name"] . " " . $line["L_name"] . "<br /> ";
        echo $line["ehome"] . " " . $line["ework"] . "<br />";
        echo $line["address1"] . " " . $line["address2"] . "<br /> ";
        echo $line["city"] . " " . $line["state"] . " " . $line["zipcode"] ."<br />";
        echo $line["sibling1"] . " " . $line["sibling2"] . " " . $line["sibling3"] . "<br />";
        echo "HOME : " . $line['home'] . "<br /> ";
        echo "WORK : " . $line['work'] . "<br /> ";
        echo "CELL : " . $line['cell'] . "<br /> ";
        echo " FAX  : " . $line['fax'] . "<br />";
        $table = "location";
      if (match_column($table, $id)){
        $get_location = mysql_query("SELECT * FROM location WHERE location.master_id=$id");
        $line = mysql_fetch_array($get_location);
        $get_pickdrop = mysql_query("SELECT * FROM pickdrop WHERE pickdrop.id=$line[pickup]");
        $lines = mysql_fetch_array($get_pickdrop);
        echo "Pick up :" . $lines['pickdrop'] . "<br />";
        $get_pickdrop = mysql_query("SELECT * FROM pickdrop WHERE pickdrop.id=$line[dropoff]");
        $lines = mysql_fetch_array($get_pickdrop);
        echo "Drop Off :" . $lines['pickdrop'] . "<br />";
        echo "<p></p>";
      }
      $get_notes = mysql_query("SELECT * FROM notestext, notesdt
                               WHERE notestext.id = notesdt.id and  notestext.master_id=$id
                               ORDER BY date DESC, time DESC");
      $rows = mysql_num_rows($get_notes);
      while ($line = mysql_fetch_assoc($get_notes)) {
        echo "<p>";
        echo $line['date'] . " " . $line['time'] . "<br />";
        echo $line["notetext"];
        echo "</p>";
      }
      echo "Do you want to EDIT this record<br />";
	  echo "<a href=" . $_SERVER['PHP_SELF'] . "?id=" . $id . "&mode=edit>EDIT</a>";
      // End if view
// Redirected to edit_entry.php to edit/update customer information
  if (!isset($_GET['mode'])) {
      $mode = "";
  } else {
    $mode = $_GET['mode'];
  }
  echo $mode . "<br />";
  if ($mode == "edit") {
        session_start();
        $_SESSION['id'] = $id;
        header('Location: edit_entry.php');
        exit;
  }// End if edit*/
echo <<<_END
<form action="search_entry.php" method="post">
<p><strong>Search by Last name only</strong></p>
Search <input type='text' size="20" maxlength='50' name='search_name' value='$search_name' /><br />
<input type='submit' value='Search' />
</form>
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
</ul>
</body>
</html>
_END;
?>
