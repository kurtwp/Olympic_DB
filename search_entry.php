<?php
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());
// LIst out parent name
$query = "SELECT * FROM master_name";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

echo "<table><tr> <th>Id</th> <th>First Name</th>
	<th>Last Name</th></tr>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 4 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";
// LIst out Sibling table
$query = "SELECT * FROM sibling";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);
echo "<table><tr> <th>Id</th> <th>masterID</th>
	<th>Child1</th><th>Child2</th><th>Child3</th><th>Subdivision</th></tr>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 6 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";
// List out Address table
$query = "SELECT * FROM address";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);
echo "<table><tr> <th>Id</th> <th>masterID</th>
	<th>address</th><th>Mail Stop</th><th>City</th><th>State</th><th>Zipcode</th><Type</th></tr>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 7 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";
// LIst out Telephone table
$query = "SELECT * FROM telephone";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);
echo "<table><tr> <th>Id</th> <th>masterID</th>
	<th>home</th><th>work</th><th>cell</th><th>fax</th></tr>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 6 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";
// LIst out EMail table
$query = "SELECT * FROM email";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);
echo "<table><tr> <th>Id</th> <th>masterID</th>
	<th>home</th><th>work</th></tr>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 4 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";
echo <<<_END
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>
_END;
?>