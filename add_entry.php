<?php
require_once 'login.php';
require_once 'functions.php';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());
$address1 = ""; // Address
$f_name = ""; // First Name
$l_name =""; // Last Name
$error =""; // Error message
$twork = $thome = $cell = $fax = "";
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
    $masterID = mysql_insert_id();
    if (!$results) die ("Database access failed: " . mysql_error());
  }
}

if (isset($_POST['address1']))
{
  $address1 = sanitizeString($_POST['address1']);
  $address2 = sanitizeString($_POST['address2']);
  $city = sanitizeString($_POST['city']);
  $state = sanitizeString($_POST['state']);
  $zipcode = sanitizeString($_POST['zipcode']);
  $add_type = sanitizeString($_POST['add_type']);

  if ($address1 == "" && $city == "")
  {
    $error = "Not all fields were entered in address table <br />";
  }
  else
  {
    $query = "INSERT INTO address VALUES(NULL,'$masterID','$address1','$address2','$city','$state','$zipcode','$add_type')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
}

if (isset($_POST['sibling1']))
{
  $sibling1 = sanitizeString($_POST['sibling1']);
  $sibling2 = sanitizeString($_POST['sibling2']);
  $sibling3 = sanitizeString($_POST['sibling3']);
  $subdivision = sanitizeString($_POST['subdivision']);

  $query = "INSERT INTO sibling VALUES(NULL,'$masterID','$sibling1','$sibling2','$sibling3','$subdivision')";
  $results = mysql_query($query);
  if (!$results) die ("Database access failed: " . mysql_error());
}
// Enter data into EMAIL table
if (isset($_POST['ework']) || isset($_POST['ehome']))
{
 /* $ework = sanitizeString($_POST['ework']);
  $ehome = sanitizeString($_POST['ehome']);
  $query = "INSERT INTO email VALUES(NULL,'$masterID','$ehome','$ework')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error()); */
}
// Enter data into TELEPHONE table
if (isset($_POST['twork']) || isset($_POST['thome']) || isset($_POST['cell']))
{
  /*$twork = sanitizeString($_POST['twork']);
  $thome = sanitizeString($_POST['thome']);
  $cell = sanitizeString($_POST['cell']);
  $fax = sanitizeString($_POST['fax']);
  $query = "INSERT INTO telephone VALUES(NULL,'$masterID','$thome','$twork','$cell','$fax')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  $twork = $thome = $cell = $fax = "";*/
}
echo <<<_END
<form action="add_entry.php" method="post">$error
<p><strong>Parent Name</strong></p>
First Name <input type='text' size="20" maxlength='50' name='f_name' value='$f_name' /><br />
Last Name <input type='text' size="25" maxlength='50' name='l_name' value='$l_name' /><br />
<p><strong>Child Names</strong></p>
Child1<input type='text' size="20" maxlength='30' name='sibling1' value='$sibling1' /><br />
Child2<input type='text' size="20" maxlength='30' name='sibling2' value='$sibling2' /><br />
Child3<input type='text' size="20" maxlength='30' name='sibling3' value='$sibling3' /><br />
Subdivision<select name="subdivision" size="1">
<option selected="selected" value="other">Other</option>
<option value="sub1">Sub1</option>
<option value="sub2">Sub2</option>
<option value="sub3">Sub3</option>
</select>
<p><strong>Customer Address</strong></p>
Street Address <input type='text' maxlength='50' name='address1' value='$address1' /><br />
Address <input type='text' maxlength='50' name='address2' value='$address2' /><br />
City/State/Zipcode <br />
<input type='text' size='25' maxlength='30' name='city' value='$city' />
<input type='text' size='5' maxlength=,2' name='state' value='$state' />
<input type='text' size='10' maxlength='10' name='zipcode' value='$zipcode' /><br />
Address Type:
HOME<input type="radio" name="add_type" value="home" checked="checked"/>
WORK<input type="radio" name="add_type" value="work" />
OTHER<input type="radio" name="add_type" value="other" /><p></p>
<p><strong> Customer Telephone Numbers</strong> </p>
Work<input type='text' size='30' maxlength='25' name='twork' value='$twork' /><br />
Home<input type='text' size='30' maxlength=,25' name='thome' value='$thome' /><br />
Cell<input type='text' size='30' maxlength='25' name='cell' value='$cell' /><br />
Fax<input type='text' size='30' maxlength='25' name='fax' value='$fax' /><br />
<p><strong> Customer EMail Addresses</strong> </p>
Work<input type='text' size='30' maxlength='25' name='ework' value='$ework' /><br />
Home<input type='text' size='30' maxlength=,25' name='ehome' value='$ehome' /><br />
<input type='submit' value='Add' />
</form><br />
<ul>
    <li><a href="add_entry.php">Add another Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>    
_END;
?>