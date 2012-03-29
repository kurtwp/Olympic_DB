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
  if ($_POST['travel_types']) $travel_types = sanitizeMySQL($_POST['travel_types']);
    if (!empty($travel_types)) {
        $query = "INSERT INTO travel_type
        VALUES(NULL, '$masterID', '$travel_types')";
        $results = mysql_query($query);
        if (!$results) die ("Database access failed: " . mysql_error());
    }
  
  if ($_POST['notes']) $notes = sanitizeMySQL($_POST['notes']); {
    if (trim($notes) !== "") {
        $query = "INSERT INTO notestext VALUES(NULL, '$masterID','$notes')";
        $results = mysql_query($query);
        $notes_id = mysql_insert_id();
        if (!$results) die ("Database access failed: " . mysql_error());
        $query = "INSERT INTO notesdt (id, master_id, date, time)
        VALUES ('$notes_id','$masterID', NOW(), CURTIME() )";
        $results = mysql_query($query);
        if (!$results) die ("Database access failed: " . mysql_error());
    }
  }
 
    session_start();
        $_SESSION['id'] = $masterID;
    header('Location: view_entry.php');
    exit; 
} 
echo <<<_END
<div class="containter">
    <h1> Add a Customer</h1>
    <div>
        <form action="3col.php" method="post">
        <label>Parent Name</label><br />
        First Name:<input type='text' size="20" maxlength='50' id="f_name" name='f_name' value='$f_name' /><br />
        Last Name:<input type='text' size="20" maxlength='50' id="l_name" name='l_name' value='$l_name' /><br />
        Children Names<br />
        Child 1:<input type='text' size="15" maxlength='20' id='sibling1' name='sibling1' value='$sibling1' /><br />
        Child 2:<input type='text' size="15" maxlength='20' id='sibling2' name='sibling2' value='$sibling2' /><br />
        Child 3:<input type='text' size="15" maxlength='20' id='sibling3' name='sibling3' value='$sibling3' /><br />
        Telephone<br />
        Home :<input type='text' size='15' maxlength='15' id='thome' name='thome' value='$thome' /><br />
        Work :<input type='text' size='15' maxlength='15' id='twork' name='twork' value='$twork' /><br />
        Cell :<input type='text' size='15' maxlength='15' id='cell' name='cell' value='$cell' /><br />
        Fax :<input type='text' size='15' maxlength='15' id='fax' name='fax' value='$fax' /><br />
    </div>    
    <div>
       Spouse's Name <br />
       First Name:<input type='text' size="20" maxlength='50' id="sf_name" name='sf_name' value='$sf_name' /><br />
       Last Name:<input type='text' size="20" maxlength='50' id="sl_name" name='sl_name' value='$sl_name' /><br />
       Billing Address <br />
       Street Address :<input type='text' maxlength='50' id="address1" name='address1' value='$address1' /> <br />
       APT/PO Box :<input type='text' maxlength='50' id="address2" name='address2' value='$address2' /> <br />
       City :<input type='text' maxlength='50' id="city" name='city' value='$city' /> <br />
       State :<input type='text' size='2' maxlength='2' id='state' name='state' value='$state' /> <br />
       ZipCode :<input type='text' size='5' maxlength='5' id="zipcode" name='zipcode' value='$zipcode' /> <br />
       Email Addresses <br />
       Home :<input type='text' size='35' maxlength='50' id='ehome' name='ehome' value='$ehome' /><br />
       Work  :<input type='text' size='35' maxlength='50' id='ework' name='ework' value='$ework' /><br />
    </div>
    <div>
      Emergency Contact <br />
      First Name:<input type='text' size="20" maxlength='50' id="ef_name" name='ef_name' value='$ef_name' /><br />
      Last Name:<input type='text' size="20" maxlength='50' id="el_name" name='el_name' value='$el_name' /><br />
      Telephone :<input type="text" size="15" maxlength="15" id="ephone" name="ephone" value="$ephone" /><br />
      Pick Up:
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
      echo <<<_END
        <br />
        Drop Off:
_END;
?>
<?php
      $result = mysql_query("SELECT *
                          FROM pickdrop") or die ("Issue selecting rows - " . mysql_error());
      $row = mysql_num_rows($result);
        echo "<select name='drop'>";
        while ($line = mysql_fetch_assoc($result)) {
        echo "<option value=".$line['id']." '>" .$line['pickdrop']."</option>";
       }
      echo "</select> ";
echo <<<_END
    <br />
    Type of Travel Needed <br />
_END;
?>
<?php
      $result = mysql_query("SELECT *
                          FROM ttype") or die ("Issue selecting rows - " . mysql_error());
      $row = mysql_num_rows($result);
        echo "<select name='travel_types'>";
        while ($line = mysql_fetch_assoc($result)) {
        echo "<option value=' ".$line['id']." '>" .$line['ttype']."</option>";
       }
      echo "</select> ";
      ?>
      <?php
echo <<<_END
    </div>
</div>
<div id="footer">
    Customer Notes <br />
    <textarea id ='notes' name='notes' value='$notes' row = "5" cols = "60"> </textarea><br /><br />
    <p>
    <input class="addbutton" type='submit' value='Add' />
</form><br />
<ul>
    <li><a href="add_entry.php">Add another Customer</a></li>
    <li><a href="delete_entry.php">Delete a Customer</a></li>
    <li><a href="search_entry.php">Search a Customer</a></li>
</ul>
    </p>
</div>
</body>
</html>
_END;
?>