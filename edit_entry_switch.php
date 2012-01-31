<?php
require_once 'functions.php';
require_once 'db_connect.php';
session_start();
$edit_id = $_SESSION['id'];
echo "Updating ";
$get_name = mysql_query("SELECT *
                          FROM master_name
                          WHERE master_name.id=$edit_id") or die ("Issue selecting rows - " . mysql_error());
while ($line = mysql_fetch_assoc($get_name)){
        echo $line["f_name"] . " " . $line["L_name"] . "<br /> ";
}
$get_email = mysql_query ("SELECT email.home, email.work
                                FROM email
                                WHERE email.master_id=$edit_id");
$line = mysql_fetch_array($get_email);
echo "<br />";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['value']) && !empty($_POST['value'])){
    $id = $edit_id;
    switch ($_POST['value']) {
      case 'address': {
        echo "In address switch statement<br />";
        break;
      }
      case 'sibling': {
        echo "In sibling switch statement<br />";
        break;
      }
      case 'telephone': {
        echo "In telephone switch statement<br />";
        break;
      }
      case 'email': {
        echo "In EMail IF<br />";
        $get_email = mysql_query ("SELECT email.home, email.work
                                FROM email
                                WHERE email.master_id=$id");
        while ($line = mysql_fetch_assoc($get_email)) {
          //echo $line['home'] . " " . $line['work'] . "<br />";
          echo "Home: <input type='text' value='$line[home]'/>";
          echo "Work: <input type='text' value='$line[work]'/>";
        }
        break;
      }
    }
  }
}
echo <<<_END
<form name="form" action="edit_entry.php" method="post">
   <!-- Home: <input type="text" name="home" value="$line[home]"/> <br /> -->
  <select name="value">
        <option value="address">Address</option>
        <option value="sibling">Children</option>
        <option value="email">EMail</option>
        <option value="telephone">Telephone</option>
        <option value="all">All</option>
   </select> 
    <br /> 
    <input type='submit' value = 'Filter'> 
</form>
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>
_END;
?>