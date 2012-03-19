<?php
function sanitizeMySQL($var)
// Will sanitize Text and MySQL injection
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysql_real_escape_string($var);
}
//------------------------------------------
function sanitizeString($var)
// Sanitize Text input only
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return $var;
}
//-----------------------------------------------
function match_column($table, $master)
/* ----------------------------------------------
  Used to search the MySQL master_id columns
  to if there is a matching record to determine
  if the edit_entry.php script should use INSERT
  or UPDATE to modify the record.
------------------------------------------------*/
{
require_once 'functions.php';
require_once 'db_connect.php';
$table = $table;
$master = $master;
$storeArray =Array();
$result = mysql_query("SELECT master_id FROM $table")or die ("Issue selecting rows - " . mysql_error());

while ($row = mysql_fetch_assoc($result)) {
  if ($row['master_id'] == $master){
     return true;
	  echo "Function return true <br />";
      exit;
  }
}
return false;
}
?>