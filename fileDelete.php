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
$id = 0;
if ((isset($_GET['id'])) && ($_GET['id'] != "")) { $id = $_GET['id']; }

mysql_select_db($database_conMaterial, $conMaterial);

mysql_query("set names utf8"); 

$query_rsFindFileName = "SELECT fileName FROM file WHERE file.id LIKE '%$id%'";
$rsFindFileName = mysql_query($query_rsFindFileName, $conMaterial) or die(mysql_error());
$row_rsFindFileName = mysql_fetch_assoc($rsFindFileName);
$totalRows_rsFindFileName = mysql_num_rows($rsFindFileName);
 
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM file WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
  $Result1 = mysql_query($deleteSQL, $conMaterial) or die(mysql_error());
}

do {
		$fileId = $_GET['id'];	
		//Get The fileName(saved in database)
		$dbFileName = $row_rsFindFileName['fileName']; 
		$fileExt = substr(strrchr($dbFileName, '.'), 1);
		//Get the fileName(saved in server)
		$target_file = $fileId . ".". $fileExt;
		
		$tmpFile = "./uploads/".$target_file; 
		// $tmpFile = "./uploads/".$tmpFile;
		unlink($tmpFile);
} while ($row_rsFindFileName = mysql_fetch_assoc($rsFindFileName));
   
$pageNum = $_GET['pageNum_rsMaterial']; 

$deleteGoTo = "index.php?pageNum_rsMaterial=$pageNum";

if (isset($_SERVER['QUERY_STRING'])) {
	$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
	$deleteGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $deleteGoTo));

mysql_free_result($rsFindFileName);
?>