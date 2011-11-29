<?php
//create tables for Olympic DB
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

$query = "CREATE TABLE master_name (
			id INT NOT NULL AUTO_INCREMENT,
			f_name VARCHAR(32) NOT NULL,
			L_name VARCHAR(75) NOT NULL,
			PRIMARY KEY (id)
		)";

$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
?>