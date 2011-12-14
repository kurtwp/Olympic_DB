<?php
function sanitizeMySQL($var)
// Will sanitize Text and MySQL injection
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysql_real_escape_string($var);
}
function sanitizeString($var)
// Sanitize Text input only
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return $var;
}
?>