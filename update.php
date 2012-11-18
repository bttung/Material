<?php require_once('Connections/conMaterial.php'); ?>
<?php include("initializeSession.php"); ?>
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

$pageNum = $_GET['pageNum_rsMaterial']; 

$editFormAction = $_SERVER['PHP_SELF']."?pageNum_rsMaterial=$pageNum";
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE material SET materialName=%s, productName=%s, producerName=%s, contact=%s, telephone=%s, fax=%s, adress=%s, productPrice=%s, materialLoss=%s, madeIn=%s, notes=%s, other=%s WHERE id=%s",
                       GetSQLValueString($_POST['materialName'], "text"),
                       GetSQLValueString($_POST['productName'], "text"),
                       GetSQLValueString($_POST['producerName'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['adress'], "text"),
                       GetSQLValueString($_POST['productPrice'], "text"),
                       GetSQLValueString($_POST['materialLoss'], "text"),
                       GetSQLValueString($_POST['madeIn'], "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['other'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conMaterial, $conMaterial);
  $Result1 = mysql_query($updateSQL, $conMaterial) or die(mysql_error());

  if (isset($_SERVER['QUERY_STRING'])) {
	$posPageNo = strpos($_SERVER['QUERY_STRING'], '&pageNum');
	if (($posPageNo >= 0) && ($posPageNo != NULL)) {
		// $updateGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";	
		// $updateGoTo .= $_SERVER['QUERY_STRING'];			
		$length = strlen($_SERVER['QUERY_STRING']);
		$query = "?".substr($_SERVER['QUERY_STRING'],$posPageNo+1,$length-$posPageNo);
	} else {
		// $query = "";
		$query = "?pageNum_rsMaterial=0";	
	}
  }
  $updateGoTo = "index.php".$query;
  header(sprintf("Location: %s", $updateGoTo));  
}


$colname_rsMaterialUpdate = "-1";
if (isset($_GET['id'])) {
  $colname_rsMaterialUpdate = $_GET['id'];
}
mysql_select_db($database_conMaterial, $conMaterial);
$query_rsMaterialUpdate = sprintf("SELECT * FROM material WHERE id = %s", GetSQLValueString($colname_rsMaterialUpdate, "int"));
$rsMaterialUpdate = mysql_query($query_rsMaterialUpdate, $conMaterial) or die(mysql_error());
$row_rsMaterialUpdate = mysql_fetch_assoc($rsMaterialUpdate);
$totalRows_rsMaterialUpdate = mysql_num_rows($rsMaterialUpdate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update</title>
<style type="text/css">
.trLabel {
	margin-right: 10px;
	margin-left: 10px;
	padding-right: 10px;
	padding-left: 10px;
}
</style>
</head>

<body>
<p><a href="index.php">Top Page</a> </p>

<?php include("logInOut.php"); ?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">原料名</td>
      <td><input type="text" name="materialName" value="<?php echo htmlentities($row_rsMaterialUpdate['materialName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">商品名</td>
      <td><input type="text" name="productName" value="<?php echo htmlentities($row_rsMaterialUpdate['productName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">メーカー</td>
      <td><input type="text" name="producerName" value="<?php echo htmlentities($row_rsMaterialUpdate['producerName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">連絡先</td>
      <td><input type="text" name="contact" value="<?php echo htmlentities($row_rsMaterialUpdate['contact'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">電話番号</td>
      <td><input type="text" name="telephone" value="<?php echo htmlentities($row_rsMaterialUpdate['telephone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">FAX</td>
      <td><input type="text" name="fax" value="<?php echo htmlentities($row_rsMaterialUpdate['fax'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">所在地</td>
      <td><input type="text" name="adress" value="<?php echo htmlentities($row_rsMaterialUpdate['adress'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">原料の価格</td>
      <td><input type="text" name="productPrice" value="<?php echo htmlentities($row_rsMaterialUpdate['productPrice'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">原料のロット</td>
      <td><input type="text" name="materialLoss" value="<?php echo htmlentities($row_rsMaterialUpdate['materialLoss'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">産地</td>
      <td><input type="text" name="madeIn" value="<?php echo htmlentities($row_rsMaterialUpdate['madeIn'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">備考</td>
      <td><input type="text" name="notes" value="<?php echo htmlentities($row_rsMaterialUpdate['notes'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">他</td>
      <td><input type="text" name="other" value="<?php echo htmlentities($row_rsMaterialUpdate['other'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">&nbsp;</td>
      <td>
	  	<?php if ($_SESSION['MM_Username'] != NULL) { ?>
        	<input type="submit" value="Update" />
        <?php } ?>
      </td>      
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_rsMaterialUpdate['id']; ?>" />
</form>

<?php 
	// echo $posPageNo."<br/>";	
	// echo "query = ".$query."<br/>";
	// echo "pageNum = ".$pageNum."<br/>";
?>
</body>
</html>
<?php
mysql_free_result($rsMaterialUpdate);
?>
