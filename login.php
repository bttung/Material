<?php require_once('Connections/conMaterial.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conMaterial, $conMaterial);
  
  $LoginRS__query=sprintf("SELECT userName, password FROM `admin` WHERE userName=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conMaterial) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    // header("Location: " . $MM_redirectLoginSuccess );	
  }
  else {
	  //$_SESSION['MM_Username'] = "NULL";
	  $_SESSION['MM_Username'] = NULL;
	  $_SESSION['MM_UserGroup'] = NULL;
	  $_SESSION['PrevUrl'] = NULL;
	  unset($_SESSION['MM_Username']);
	  unset($_SESSION['MM_UserGroup']);
	  unset($_SESSION['PrevUrl']);	  
    // header("Location: ". $MM_redirectLoginFailed );
  }
  header("Location: " . $MM_redirectLoginSuccess );  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log In</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.textBoxClass {
	margin-left: auto;
	position: absolute;
	left: 125px;
}
</style>
</head>

<body>
<div id="mainContent">
<h1>Please Log In</h1>
    <form ACTION="<?php echo $loginFormAction; ?>" name="loginForm" method="POST">
        <fieldset id="loginFieldset">
            <p>
                <label for="username">User Name:</label>
<span id="spryusername">
<input name="username" type="text" class="textBoxClass" id="username" />
<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></p>
            <p>            	
            <label for="password">Password:</label>
            <span id="sprytextfield2">
            <input name="password" type="password" class="textBoxClass" id="password" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></p>
            <p>
                <input type="submit" value="Submit"/>
            </p>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryusername", "none", {validateOn:["blur"], maxChars:50});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"], maxChars:50});
</script>
</body>
</html>