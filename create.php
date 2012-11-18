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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO material (materialName, productName, producerName, contact, telephone, fax, adress, productPrice, materialLoss, madeIn, notes, other) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['other'], "text"));

  mysql_select_db($database_conMaterial, $conMaterial);
  $Result1 = mysql_query($insertSQL, $conMaterial) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	  if ($_SERVER['QUERY_STRING'] != NULL) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];		  
	  }
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create</title>
<style type="text/css">
.trLabel {
	margin-right: 10px;
	margin-bottom: 10px;
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
      <td><input type="text" name="materialName" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">商品名</td>
      <td><input type="text" name="productName" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">メーカー</td>
      <td><input type="text" name="producerName" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">連絡先</td>
      <td><input type="text" name="contact" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">電話番号</td>
      <td><input type="text" name="telephone" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">FAX</td>
      <td><input type="text" name="fax" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">所在地</td>
      <td><input type="text" name="adress" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">原料の価格</td>
      <td><input type="text" name="productPrice" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">原料のロット</td>
      <td><input type="text" name="materialLoss" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">産地</td>
      <td><input type="text" name="madeIn" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">備考</td>
      <td><input type="text" name="notes" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">他</td>
      <td><input type="text" name="other" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="trLabel">&nbsp;</td>
      <td>
	  	<?php if ($_SESSION['MM_Username'] != NULL) { ?>
        	<input type="submit" value="Insert" />
        <?php } ?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>