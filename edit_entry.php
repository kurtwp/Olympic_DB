<?php
require_once 'functions.php';
require_once 'db_connect.php';

session_start();
$edit_id = $_SESSION['id'];

echo "Updating ";
$get_name = mysql_query("SELECT *
                          FROM master_name
                          WHERE master_name.id=$edit_id") or die ("Issue selecting rows - " . mysql_error());
$line = mysql_fetch_array($get_name);
echo $line["f_name"] . " " . $line["L_name"] . "<br /> ";
// ****** Customer Address information ************
$get_address = mysql_query("SELECT *
                           FROM address
                           WHERE address.master_id=$edit_id");
$address = mysql_fetch_array($get_address);
// ****** Get Email information *******************
$get_email = mysql_query ("SELECT *
                                FROM email
                                WHERE email.master_id=$edit_id");
$email = mysql_fetch_array($get_email);
echo "<br />";
// ****** Get Siblings information **********
$get_sibling = mysql_query("SELECT *
                           FROM sibling
                           WHERE sibling.master_id=$edit_id");
$sib = mysql_fetch_array($get_sibling);
// ****** Get Telephone Numbers *************
$get_tele = mysql_query ("SELECT *
                                FROM telephone
                                WHERE telephone.master_id=$edit_id");
$tele = mysql_fetch_array($get_tele);

// ************ Start of Edit *************** 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
// ************ Start of Address edit *******
  if ($_POST['eaddress1']) $address['eaddress1'] = sanitizeMySQL($_POST['eaddress1']);
  if ($_POST['eaddress2']) $address['eaddress2'] = sanitizeMySQL($_POST['eaddress2']);
  if ($_POST['ecity']) $address['ecity'] = sanitizeMySQL($_POST['ecity']);
  if ($_POST['estate']) $address['estate'] = sanitizeMySQL($_POST['estate']);
  if ($_POST['ezipcode']) $address['ezipcode'] = sanitizeMySQL($_POST['ezipcode']);
  $table = "address";
  if (match_column($table, $edit_id)){
    $result = mysql_query("UPDATE address
                          SET address1='$address[eaddress1]', address2='$address[eaddress2]', city='$address[ecity]', state='$address[estate]', zipcode='$address[ezipcode]'
                          WHERE master_id=$edit_id");
    if (!$result) die ("Database access failed: " . mysql_error());
  } else {
    $result = mysql_query("INSERT INTO address (master_id, address1, address2, city, state, zipcode)
                          VALUES ('$edit_id', '$address[eaddress1]', '$address[eaddress2]', '$address[ecity]', '$address[estate]', '$address[zipcode]')");
    if (!$result) die ("MySQL query access failed: " . mysql_error());
  }
// ************ Start of Sibling  *********************
  if ($_POST['esibling1']) $sib['esibling1'] = sanitizeMySQL($_POST['esibling1']);
  if ($_POST['esibling2']) $sib['esibling2'] = sanitizeMySQL($_POST['esibling2']);
  if ($_POST['esibling3']) $sib['esibling3'] = sanitizeMySQL($_POST['esibling3']);
  $table = "sibling";
  if (!$_POST['esibling1'] && !$_POST['esibling2'] && !$_POST['esibling3']) {
    $result = mysql_query("DELETE FROM sibling
                          WHERE master_id=$edit_id");
  } elseif (match_column($table, $edit_id)) {
  $result = mysql_query("UPDATE sibling
                          SET sibling1='$sib[esibling1]',sibling2='$sib[esibling2]',sibling3='$sib[esibling3]'
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
  } else {
    echo "IN INSERT <br />";
    $result = mysql_query("INSERT INTO sibling (master_id, sibling1, sibling2, sibling3, subdivision)
                            VALUES ('$edit_id','$sib[esibling1]','$sib[esibling2]','$sib[esibling3]')");
      if (!$result) die ("MySQL query access failed: " . mysql_error());
  }
// ************ End of Sibling edit *********
// ************ Start of Telephone edit *****
if ($_POST['twork']) $tele['twork'] = sanitizeMySQL($_POST['twork']);
  if ($_POST['thome']) $tele['thome'] = sanitizeMySQL($_POST['thome']);
  if ($_POST['tcell']) $tele['tcell'] = sanitizeMySQL($_POST['tcell']);
  if ($_POST['tfax']) $tele['tfax'] = sanitizeMySQL($_POST['tfax']);
  $table = "telephone";
  if (match_column($table, $edit_id)){
    $result = mysql_query("UPDATE telephone
                          SET home='$tele[thome]', work='$tele[twork]', cell='$tele[tcell]', fax='$tele[tfax]'
                          WHERE master_id=$edit_id");
    if (!$result) die ("Database access failed: " . mysql_error());
  } else {
    $result = mysql_query("INSERT INTO telephone (master_id, home, work, cell, fax)
                          VALUES ('$edit_id', '$tele[thome]', '$tele[twork]', '$tele[tcell]', '$tele[tfax]')");
    if (!$result) die ("MySQL query access failed: " . mysql_error());
  }
// ************ Start of EMail edit ********* 
  if ($_POST['ehome'] || $_POST['ework']) {
    $table="email";
    if (match_column($table, $edit_id)) {
      $email['ehome'] = sanitizeMySQL($_POST['ehome']);
      $email['ework'] = sanitizeMySQL($_POST['ework']);
      $result = mysql_query("UPDATE email
                          SET home='$email[ehome]', work='$email[ework]'
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
    } else {
      $email['ehome'] = sanitizeMySQL($_POST['ehome']);
      $email['ework'] = sanitizeMySQL($_POST['ework']);
      $result = mysql_query("INSERT INTO email (master_id, home, work)
                            VALUES ('$edit_id','$email[ehome]','$email[ework]')");
      if (!$result) die ("MySQL query access failed: " . mysql_error());
    }
  } elseif (!$_POST['ehome'] && !$_POST['ework']) {
    $result = mysql_query("DELETE FROM email
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
  }
// ************ End of EMail edit *********************

  session_start();
        $_SESSION['id'] = $edit_id;
  header('Location: view_entry.php');
  exit;
}

echo <<<_END
<form name="form" action="edit_entry.php" method="post">
<p><strong>Customer Address</strong></p>
Street Address <input type='text' maxlength='50' name='eaddress1' value='$address[address1]' /><br />
Address <input type='text' maxlength='50' name='eaddress2' value='$address[address2]' /><br />
City/State/Zipcode <br />
<input type='text' size='25' maxlength='30' name='ecity' value='$address[city]' />
<input type='text' size='5' maxlength=,2' name='estate' value='$address[state]' />
<input type='text' size='10' maxlength='10' name='ezipcode' value='$address[zipcode]' /><br />
<p><strong>Children</strong></p>
Child1: <input type='text' size="20" maxlength='30' name='esibling1' value='$sib[sibling1]' /><br />
Child2: <input type='text' size="20" maxlength='30' name='esibling2' value='$sib[sibling2]' /><br />
Child3: <input type='text' size="20" maxlength='30' name='esibling3' value='$sib[sibling3]' /><br />
<p><strong> Customer Telephone Numbers</strong> </p>
Work<input type='text' size='30' maxlength='25' name='twork' value='$tele[work]' /><br />
Home<input type='text' size='30' maxlength=,25' name='thome' value='$tele[home]' /><br />
Cell<input type='text' size='30' maxlength='25' name='tcell' value='$tele[cell]' /><br />
Fax<input type='text' size='30' maxlength='25' name='tfax' value='$tele[fax]' /><br />
<p><strong>Email</strong></p>
Home: <input type='text' size='30' maxlength='25' name='ehome' value='$email[home]' /><br />
Work: <input type='text' size='30' maxlength='25' name='ework' value='$email[work]' /><br />
<p></p>
<input type='submit' value = 'Submit'>
<br />
</form>
<ul>
    <li><a href="add_entry.php">Add a Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>
_END;
?>