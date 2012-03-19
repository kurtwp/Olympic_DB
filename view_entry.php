<?php
require_once 'functions.php';
require_once 'db_connect.php';
$search_name = "";
$edit = 0;
$table = "";

session_start();
$id = $_SESSION['id'];

$get_name = mysql_query("SELECT * FROM master_name
                              WHERE master_name.id=$id") or die ("Issue selecting rows - " . mysql_error());
      $row = mysql_num_rows($get_name);
      echo "Showing Record of : ";
      while ($line = mysql_fetch_assoc($get_name)){
        echo $line["f_name"] . " " . $line["L_name"] . "<br /> ";
      }
      $get_address = mysql_query("SELECT * FROM address WHERE address.master_id=$id");
      $rows = mysql_num_rows($get_address);
      if ($rows > 0){
        while ($line = mysql_fetch_assoc($get_address)) {
          echo $line["address1"] . " " . $line["address2"] . "<br /> ";
          echo $line["city"] . " " . $line['state'] . " " . $line['zipcode'] . "<br />";
        }
      } 
      $get_telephone = mysql_query("SELECT * FROM telephone WHERE telephone.master_id=$id");
      $rows = mysql_num_rows($get_telephone);
      if ($rows > 0) {
        while ($line = mysql_fetch_assoc($get_telephone)){
          echo "HOME : " . $line['home'] . "<br /> ";
          echo "WORK : " . $line['work'] . "<br /> ";
          echo "CELL : " . $line['cell'] . "<br /> ";
          echo " FAX  : " . $line['fax'] . "<br />";
          } 
      } 
      $get_sibling = mysql_query("SELECT * FROM sibling WHERE sibling.master_id=$id");
      $rows = mysql_num_rows($get_sibling);
      if ($rows > 0){
        while ($line = mysql_fetch_assoc($get_sibling)){
          echo "Child 1: " . $line["sibling1"] . "<br /> ";
          echo "Child 2: " . $line["sibling2"] . "<br /> ";
          echo "Child 3: " . $line['sibling3'] . "<br /> ";
        } 
      } 
      $get_email = mysql_query("SELECT * FROM email WHERE email.master_id=$id");
      $rows = mysql_num_rows($get_email);
      if ($rows > 0) {
        while ($line = mysql_fetch_assoc($get_email)){
          echo "HOME: " . $line["home"] . "<br /> ";
          echo "WORK: " . $line["work"] . "<br /> ";
        } 
      }
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
      echo "Do you want to update this record<br />";
	  echo "<a href=" . $_SERVER['PHP_SELF'] . "?id=" . $id . "&mode=edit>UPDATE</a>";
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
_END;
?>