<?php
//create tables for Olympic DB
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

/* $query = "CREATE TABLE master_name (
			id INT NOT NULL AUTO_INCREMENT,
			f_name VARCHAR(32) NOT NULL,
			L_name VARCHAR(75) NOT NULL,
			PRIMARY KEY (id)
		)"; */
        
/*$query = "CREATE TABLE address (
			id INT NOT NULL AUTO_INCREMENT,
            master_id INT NOT NULL,
			address1 VARCHAR(255),
			address2 VARCHAR(255),
            city VARCHAR(30),
            state CHAR(2),
            zipcode VARCHAR(10),
            type ENUM('home','work','other'),
            PRIMARY KEY (id)
		)";*/
/*$query = "CREATE TABLE telephone (
			id INT NOT NULL AUTO_INCREMENT,
            master_id INT NOT NULL,
			home VARCHAR(25),
			work VARCHAR(25),
            cell VARCHAR(25),
            fax VARCHAR(25),
            PRIMARY KEY (id)
		)";*/
/*$query = "CREATE TABLE email (
			id INT NOT NULL AUTO_INCREMENT,
            master_id INT NOT NULL,
			home VARCHAR(150),
			work VARCHAR(150),
            PRIMARY KEY (id)
		)";*/
$query = "CREATE TABLE sibling (
			id INT NOT NULL AUTO_INCREMENT,
            master_id INT NOT NULL,
			sibling1 VARCHAR(32),
			sibling2 VARCHAR(32),
            sibling3 VARCHAR(32),
            subdivision VARCHAR(75),
            PRIMARY KEY (id)
		)";

$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
?>