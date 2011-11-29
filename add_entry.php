<?php
require_once 'login.php';
require_once 'functions.php';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());
$f_name = ""; // First Name
$l_name =""; // Last Name
$error =""; // Error message
if (isset($_SESSION['f_name'])) destroySession();
if (isset($_POST['f_name']))
{
  $f_name = sanitizeString($_POST['f_name']);
  $l_name = sanitizeString($_POST['l_name']);
  if ($f_name == "" || $l_name == "")
  {
    $error = "Not all fields were entered<br />";
  }
  else
  {
    $query = "INSERT INTO master_name VALUES(NULL, '$f_name', '$l_name')";
    $f_name = $l_name = "";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
}


// $query = "INSERT INTO master_name VALUES(NULL, '$f_name', '$l_name')";

//$results = mysql_query($query);
//if (!$results) die ("Database access failed: " . mysql_error());

echo <<<_END
<form method='post' action='add_entry.php'>$error
First Name <input type='text' maxlength='16' name='f_name' value='$f_name' /><br />
Last Name <input type='text' maxlength='16' name='l_name' value='$l_name' /><br />
<input type='submit' value='Add' />
</form><br />
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>    
_END;

?>