<?php
require_once 'login.php';
require_once 'functions.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());
// Search Customer by Last name
if ($_SERVER['REQUEST_METHOD'] ==  "POST"){
  if ($_POST['search_name']){
    $search_name = sanitizeMySQL($_POST['search_name']);
    $search_name = $search_name . "%";
    $result = mysql_query("SELECT id, L_name
                          FROM master_name
                          WHERE L_name
                          LIKE '$search_name'") or die ("Issue selecting rows - " . mysql_error());
    echo "<table><tr><th>Last Name</th><th>VIEW</th><th>EDIT</th></tr>";
    while ($line = mysql_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>$line[L_name]</td>";
      echo "<td><a href=" . $_SERVER['search_entry.php'] . "?id=" . $line['id'] . "&mode=view>VIEW</a></td>";
      echo "<td><a href=" . $_SERVER['search_entry.php'] . "?id=" .$line['id'] . "&mode=edit>EDIT</a></td>";
      echo "</tr>";
    }
    echo "</table>";
  }
}
if (isset($_GET['mode']) && !empty($_GET['mode'])){
  $id = $_GET[id];
  switch ($_GET['mode']){
    case 'view': {
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
      } else {
        echo "Has no address - UPDATE <br />";
      }
      $get_telephone = mysql_query("SELECT * FROM telephone WHERE telephone.master_id=$id");
      $rows = mysql_num_rows($get_telephone);
      if ($rows > 0) {
        while ($line = mysql_fetch_assoc($get_telephone)){
          echo "HOME : " . $line['home'] . "<br /> ";
          echo "WORK : " . $line['work'] . "<br /> ";
          echo "CELL : " . $line['cell'] . "<br /> ";
          } 
      } else {
        echo "Has no Telephone numbers - UPDATE <br />";
      }
      $get_sibling = mysql_query("SELECT * FROM sibling WHERE sibling.master_id=$id");
      $rows = mysql_num_rows($get_sibling);
      if ($rows > 0){
        while ($line = mysql_fetch_assoc($get_sibling)){
          echo "Child 1: " . $line["sibling1"] . "<br /> ";
          echo "Child 2: " . $line["sibling2"] . "<br /> ";
          echo "Child 3: " . $line['sibling3'] . "<br /> ";
          echo "Subdivision : " . $line['subdivision'] . "<br />";
        } 
      } else {
        echo "Has no children - UPDATE <br />";
      }
      $get_email = mysql_query("SELECT * FROM email WHERE email.master_id=$id");
      $rows = mysql_num_rows($get_email);
      if ($rows > 0) {
        while ($line = mysql_fetch_assoc($get_email)){
          echo "HOME: " . $line["home"] . "<br /> ";
          echo "WORK: " . $line["work"] . "<br /> ";
        } 
      } else {
        echo "has no emails - UPDATE <br />";
      }
      break;
      } // End View
  } // End Switch
} // End isset if
echo <<<_END
<form action="search_entry.php" method="post">$error
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