<?php
require_once 'functions.php';
require_once 'db_connect.php';
$search_name = "";
$edit_id = 0;
$home = "";
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
if (isset($_GET['mode']) && !empty($_GET['mode'])){
  $id = $_GET['id'];
// View customer information
  if ($_GET['mode'] == "view"){
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
          echo $line["city"] . " " . $line['state'] . ", " . $line['zipcode'] . "<br />";
          echo "Address Type : " . $line['type'] . "<br />";
        }
      } 
      $get_telephone = mysql_query("SELECT * FROM telephone WHERE telephone.master_id=$id");
      $rows = mysql_num_rows($get_telephone);
      if ($rows > 0) {
        while ($line = mysql_fetch_assoc($get_telephone)){
          echo "HOME : " . $line['home'] . "<br /> ";
          echo "WORK : " . $line['work'] . "<br /> ";
          echo "CELL : " . $line['cell'] . "<br /> ";
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
      echo "Do you want to update this record<br />";
	  echo "<a href=" . $_SERVER['PHP_SELF'] . "?id=" . $id . "&mode=edit>UPDATE</a>";
  } // End if view
// Redirected to edit_entry.php to edit/update customer information
  if ($_GET['mode'] == "edit") {
        session_start();
        $_SESSION['id'] = $id;
        header('Location: edit_entry.php');
        exit;
      }// End if edit*/
} // End isset if
echo <<<_END
<form action="search_entry.php" method="post">
<p><strong>Search by Last name only</strong></p>
Search <input type='text' size="20" maxlength='50' name='search_name' value='$search_name' /><br />
<input type='submit' value='Search' />
</form>
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>
_END;
?>