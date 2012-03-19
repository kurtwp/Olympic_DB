<?php
require_once 'header.html';
header("Cache-Control: no-cache, must-revalidate");
require_once 'functions.php';
require_once 'db_connect.php';
$f_name = "";
$l_name = "";
$sf_name = "";
$sl_name = "";
$ef_name = "";
$el_name = "";
$ephone = "";
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
$notes = "";
$notesdt_id = "";

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
  if (!empty($address1) && !empty($city) && !empty($zipcode) )
  {
    $query = "INSERT INTO address VALUES(NULL,'$masterID','$address1','$address2','$city','$state','$zipcode')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
//*********************************************************
// Check Sibling data
// $sibling1 = First child
// $sibling2 = Second child
// $sibling3 = Thrid child
//*********************************************************
  if ($_POST['sibling1']) $sibling1 = sanitizeMySQL($_POST['sibling1']);
  if ($_POST['sibling2']) $sibling2 = sanitizeMySQL($_POST['sibling2']);
  if ($_POST['sibling3']) $sibling3 = sanitizeMySQL($_POST['sibling3']);
  if (!empty($sibling1))
  {
    $query = "INSERT INTO sibling VALUES(NULL,'$masterID','$sibling1','$sibling2','$sibling3')";
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
  if ($_POST['pick']) $pick = sanitizeMySQL($_POST['pick']);
  if ($_POST['drop']) $drop = sanitizeMySQL($_POST['drop']);
  if (!empty($pick) || !empty($drop)) {
    $query = "INSERT INTO location
    VALUES(NULL, '$masterID','$pick','$drop')";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
  if ($_POST['notes']) $notes = sanitizeMySQL($_POST['notes']); {
    $query = "INSERT INTO notestext VALUES(NULL, '$masterID','$notes')";
    $results = mysql_query($query);
    $notes_id = mysql_insert_id();
    if (!$results) die ("Database access failed: " . mysql_error());
    $query = "INSERT INTO notesdt (id, master_id, date, time)
    VALUES ('$notes_id','$masterID', NOW(), CURTIME() )";
    $results = mysql_query($query);
    if (!$results) die ("Database access failed: " . mysql_error());
  }
 
session_start();
        $_SESSION['id'] = $masterID;
  header('Location: view_entry.php');
  exit; 
} 
echo <<<_END
<form action="table.php" method="post">
<table>
 <table>
   <tr>
      <th colspan="2"> Parent Name </th><th colspan="2"> Spouses Name </th><th colspan="2"> Emergency Contact </th>
   </tr>
   <tr>
      <td><label for="f_name">First Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="f_name" name='f_name' value='$f_name' /></td>
      <td><label for="sf_name">First Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="sf_name" name='sf_name' value='$sf_name' /></td>
      <td><label for="ef_name">First Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="ef_name" name='ef_name' value='$ef_name' /></td>
   </tr>
   <tr>
      <td><label for="l_name">Last Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="l_name" name='l_name' value='$l_name' /></td>
      <td><label for="sl_name">Last Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="sl_name" name='sl_name' value='$sl_name' /></td>
      <td><label for="el_name">Last Name: </label></td>
      <td><input type='text' size="20" maxlength='50' id="el_name" name='el_name' value='$el_name' /></td>
    </tr>
   <tr>
    <td></td><td></td><td></td><td></td>
    <td><label for="ephone"> Telephone </label></td>
    <td><input type="text" size="15" maxlength="15" id="ephone" name="ephone" value="$ephone" /></td> 
   </tr>
 </table>
 <table>
  <tr>
   <th colspan="2"> Children Names </th><th colspan="2"> Address </th> <th colspan="2">Subdivision</th>
  </tr>
  <tr>
   <td><label for="sibling1">Child 1: </label></td>
   <td><input type='text' size="15" maxlength='20' id='sibling1' name='sibling1' value='$sibling1' /></td>
	 <td><label for="address1">Street Address: </label></td>
	 <td><input type='text' maxlength='50' id="address1" name='address1' value='$address1' /></td>
   <td><label for="pickup">Pick UP: </label></td>
   <td>
_END;
?> 
    <?php
      $result = mysql_query("SELECT *
                          FROM pickdrop") or die ("Issue selecting rows - " . mysql_error());
      $row = mysql_num_rows($result);
        echo "<select name='pick'>";
        while ($line = mysql_fetch_assoc($result)) {
        echo "<option value=' ".$line['id']." '>" .$line['pickdrop']."</option>";
       }
      echo "</select> ";
    ?>  
<?php
echo <<<_END
    </td>          
   </tr>
  <tr>
		<td><label for="sibling2">Child 2: </label></td>
  	<td><input type='text' size="15" maxlength='20' id='sibling2' name='sibling2' value='$sibling2' /></td>
		<td><label for="address2">APT #/PO Box: </label></td>
		<td><input type='text' maxlength='50' id="address2" name='address2' value='$address2' /></td>
    <td><label for="dropoff">Drop Off: </label></td>
    <td>
_END;
?>
    <?php
      $result = mysql_query("SELECT *
                          FROM pickdrop") or die ("Issue selecting rows - " . mysql_error());
      $row = mysql_num_rows($result);
        echo "<select name='drop'>";
        while ($line = mysql_fetch_assoc($result)) {
        echo "<option value=' ".$line['id']." '>" .$line['pickdrop']."</option>";
       }
      echo "</select> "; ?>  
    <?php
echo <<<_END
    </td>
	</tr>
  <tr>
		<td><label for="sibling3">Child 3: </label></td>
  	<td><input type='text' size="15" maxlength='20' id='sibling3' name='sibling3' value='$sibling3' /></td>
		<td><label for="city">City: </label></td>
		<td><input type='text' maxlength='50' id="city" name='city' value='$city' /></td>  
  </tr>
  <tr>
  	<td><td></td></td>
		<td><label for="state">State: </label></td>
		<td><input type='text' size='2' maxlength='2' id='state' name='state' value='$state' /> 
		<label for="zipcode">Zip: </label>
		<input type='text' size='5' maxlength='5' id="zipcode" name='zipcode' value='$zipcode' /></td>    
  </tr>
  <table>
  <tr>
		<th colspan="2">Telephone</th><th colspan="2">EMail</th>  
  </tr>
  <tr>
		<td><label for="thome">Home:</label></td>
		<td><input type='text' size='15' maxlength='15' id='thome' name='thome' value='$thome' /></td>  
		<td><label for="ehome">Home:</label></td>
		<td><input type='text' size='35' maxlength='50' id='ehome' name='ehome' value='$ehome' /></td>  
  </tr>
  <tr>
		<td><label for="twork">Work:</label></td>
		<td><input type='text' size='15' maxlength='15' id='twork' name='twork' value='$twork' /></td>
		<td><label for="ework">Work:</label></td>
		<td><input type='text' size='35' maxlength='50' id='ework' name='ework' value='$ework' /></td>
  </tr>
  <tr>
		<td><label for="cell">Cell:</label></td>
		<td><input type='text' size='15' maxlength='15' id='cell' name='cell' value='$cell' /></td>  
  </tr>
  <tr>
		<td><label for="fax">Fax:</label></td>
		<td><input type='text' size='15' maxlength='15' id='fax' name='fax' value='$fax' /></td>  
  </tr>
 </table>
 <table>
  <th colspan="3">Customer Notes </th>
  <tr>
    <td><textarea id ='notes' name='notes' value='$notes' row = "5" cols = "60"> </textarea> </td>  
  </tr>
  </table>
</table>
<!-- </table> -->
<input class="addbutton" type='submit' value='Add' />
</form><br />
_END;
require_once 'footer.html';
?>