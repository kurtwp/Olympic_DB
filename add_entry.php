<?php
header("Cache-Control: no-cache, must-revalidate");
require_once 'functions.php';
require_once 'db_connect.php';
$f_name = "";
$l_name = "";
$sibling1 = "";
$sibling2 = "";
$sibling3 = "";
$address1 = "";
$address2 ="";
$city = "";
$state = "";
$zipcode = "";
$thome = "";
$twork = "";
$cell = "";
$fax = "";
$ehome = "";
$ework  ="";

if($_SERVER['REQUEST_METHOD'] == "POST") {
//****************************************
// Check Customer Name Entry
// f_name = First name
// l_name = Last name
//****************************************
  if ($_POST['f_name'])
  {
    $f_name = sanitizeMySQL($_POST['f_name']);
  }
  else
  {
    echo "Please enter First Name";
  }
  if ($_POST['l_name'])
  {
    $l_name = sanitizeMySQL($_POST['l_name']);
  }
  else
  {
    echo "Please enter Last Name";
  }
  
  if (!empty($f_name) && !empty($l_name))
  {
    $query = "INSERT INTO master_name VALUES(NULL, '$f_name', '$l_name')";
    $f_name = $l_name = "";
    $results = mysql_query($query);
    $masterID = mysql_insert_id();
    if (!$results) die ("Database access failed: " . mysql_error());
  }
//*************************************************************
// Customer Address Entry check
// $address1 = Street Address
// $address2 = addition address information
// $city = City name
// $state = Two letter state
// $zipcode = City zip code
// $add_type = type of address and be only home, work, or other
//*************************************************************
  if ($_POST['address1'])
  {
    $address1 = sanitizeMySQL($_POST['address1']);
  }
  else
  {
    echo "Please enter a street address";
  }
  if ($_POST['address2']) $address2 = sanitizeMySQL($_POST['address2']);
  if ($_POST['city'])
  {
    $city = sanitizeMySQL($_POST['city']);
  }
  else
  {
    echo "Please enter a city";
  }
  if ($_POST['state'])
  {
    $state = sanitizeMySQL($_POST['state']);
  }
  else
  {
    echo "Please enter a state";
  }
  if ($_POST['zipcode'])
  {
    $zipcode = sanitizeMySQL($_POST['zipcode']);
  }
  else
  {
    echo "Please enter a zip code";
  }
  if ($_POST['add_type']) $add_type = sanitizeMySQL($_POST['add_type']);

  if (!empty($address1) && !empty($city) && !empty($zipcode) )
  {
    $query = "INSERT INTO address VALUES(NULL,'$masterID','$address1','$address2','$city','$state','$zipcode','$add_type')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
//*********************************************************
// Check Sibling data
// $sibling1 = First child
// $sibling2 = Second child
// $sibling3 = Thrid child
// $subdivision = The development the are picked up in
//*********************************************************
  if ($_POST['sibling1']) $sibling1 = sanitizeMySQL($_POST['sibling1']);
  if ($_POST['sibling2']) $sibling2 = sanitizeMySQL($_POST['sibling2']);
  if ($_POST['sibling3']) $sibling3 = sanitizeMySQL($_POST['sibling3']);
  if ($_POST['subdivision']) $subdivision = sanitizeMySQL($_POST['subdivision']);
  if (!empty($sibling1))
  {
    $query = "INSERT INTO sibling VALUES(NULL,'$masterID','$sibling1','$sibling2','$sibling3','$subdivision')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
  else
  {
    echo "Need to add at least one sibling";
  }
//*****************************************************************
// Enter data into EMAIL table
// $ework = Work email
// $ehome = Home email
//*****************************************************************
  if ($_POST['ework']) $ework = sanitizeMySQL($_POST['ework']);
  if ($_POST['ehome']) $ehome = sanitizeMySQL($_POST['ehome']);
  if (!empty($ework) || !empty($ehome))
  {
    $query = "INSERT INTO email VALUES(NULL,'$masterID','$ehome','$ework')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error()); 
  }
// Enter data into TELEPHONE table
  if ($_POST['twork']) $twork = sanitizeMySQL($_POST['twork']);
  if ($_POST['thome']) $thome = sanitizeMySQL($_POST['thome']);
  if ($_POST['cell']) $cell = sanitizeMySQL($_POST['cell']);
  if ($_POST['fax']) $fax = sanitizeMySQL($_POST['fax']);
  if (!empty($twork) || !empty($thome) || !empty($cell))
  {
    $query = "INSERT INTO telephone VALUES(NULL,'$masterID','$thome','$twork','$cell','$fax')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
  else
  {
    echo "need at least one Telephone number";
  }
} 
echo <<<_END
<form action="add_entry.php" method="post">
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