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
// ****** Get Email information *******************
$get_email = mysql_query ("SELECT email.home, email.work
                                FROM email
                                WHERE email.master_id=$edit_id");
$line = mysql_fetch_array($get_email);
echo "<br />";
// ****** Get Siblings information **********
$get_sibling = mysql_query("SELECT sibling.sibling1,sibling.sibling2,sibling.sibling3
                           FROM sibling
                           WHERE sibling.master_id=$edit_id");
$sib = mysql_fetch_array($get_sibling);
// ************ Start of Edit *************** 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
// ************ Start of EMail edit ********* 
  if ($_POST['ehome'] || $_POST['ework']) {
    $table="email";
    if (match_column($table, $edit_id)) {
      $line['ehome'] = sanitizeMySQL($_POST['ehome']);
      $line['ework'] = sanitizeMySQL($_POST['ework']);
      $result = mysql_query("UPDATE email
                          SET home='$line[ehome]', work='$line[ework]'
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
    } else {
      $line['ehome'] = sanitizeMySQL($_POST['ehome']);
      $line['ework'] = sanitizeMySQL($_POST['ework']);
      $result = mysql_query("INSERT INTO email (master_id, home, work)
                            VALUES ('$edit_id','$line[ehome]','$line[ework]')");
      if (!$result) die ("MySQL query access failed: " . mysql_error());
    }
  } elseif (!$_POST['ehome'] && !$_POST['ework']) {
    $result = mysql_query("DELETE FROM email
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
  }
// ************ End of EMail edit *********************
// ************ Start of Sibling  *********************
  if ($_POST['esibling1']) $sib['esibling1'] = sanitizeMySQL($_POST['esibling1']);
  if ($_POST['esibling2']) $sib['esibling2'] = sanitizeMySQL($_POST['esibling2']);
  if ($_POST['esibling3']) $sib['esibling3'] = sanitizeMySQL($_POST['esibling3']);
  if ($_POST['subdivision']) $subdivision = sanitizeMySQL($_POST['subdivision']);
  $table = "sibling";
  $result = mysql_query("UPDATE sibling
                          SET sibling1='$sib[esibling1]',sibling2='$sib[esibling2]',sibling3='$sib[esibling3]',subdivision='$subdivision'
                          WHERE master_id=$edit_id");
      if (!$result) die ("Database access failed: " . mysql_error());
  session_start();
        $_SESSION['id'] = $edit_id;
  header('Location: view_entry.php');
  exit;
}
echo <<<_END
<form name="form" action="edit_entry.php" method="post">
  Home: <input type='text' size='30' maxlength='25' name='ehome' value='$line[home]' /><br />
  Work: <input type='text' size='30' maxlength='25' name='ework' value='$line[work]' /><br />
  <p><strong>Child Names</strong></p>
  Child1: <input type='text' size="20" maxlength='30' name='esibling1' value='$sib[sibling1]' /><br />
  Child2: <input type='text' size="20" maxlength='30' name='esibling2' value='$sib[sibling2]' /><br />
  Child3: <input type='text' size="20" maxlength='30' name='esibling3' value='$sib[sibling3]' /><br />
  Subdivision: <select name="subdivision" size="1">
  <option selected="selected" value="other">Other</option>
  <option value="sub1">Sub1</option>
  <option value="sub2">Sub2</option>
  <option value="sub3">Sub3</option>
</select>
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