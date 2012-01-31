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
  $id = $edit_id;
  if ($_POST['home'] || $_POST['work']){
    echo "Hello EMAIL<br />";
  }

}
echo <<<_END
<form name="form" action="edit_entry.php" method="post">
  Home: <input type="text" name="home" value="$line[home]"/> <br />
  Work: <input type='text' name="work" value='$line[work]'/> <br />
  <input type='submit' value = 'Submit'>
  <br />
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