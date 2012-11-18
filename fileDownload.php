<?php require_once('Connections/conMaterial.php'); ?>
<?php $id = $_GET['id']; //echo $id;?>
<?php
//2011.02.28 Really DO NOT NEED this file anymore
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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

mysql_select_db($database_conMaterial, $conMaterial);
// added 2011.01.26 BuiThanhTung set names cp932
mysql_query("set names utf8");  

$query_rsFile = "SELECT * FROM file WHERE file.id LIKE '$id' ORDER BY id ASC";
$rsFile = mysql_query($query_rsFile, $conMaterial) or die(mysql_error());
$row_rsFile = mysql_fetch_assoc($rsFile);
$totalRows_rsFile = mysql_num_rows($rsFile);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Download</title>
</head>

<body>
<?php $pageNum_rsMaterial = $_GET['pageNum_rsMaterial']; ?>
<p><a href="index.php?pageNum_rsMaterial=<?php echo $pageNum_rsMaterial; ?>">Return</a></p>

<?php if ($totalRows_rsFile == 0) echo "File doesn't exist"; ?>
<table border="1" cellpadding="1" cellspacing="1">
  <tr>
    <td>id</td>
    <td>fileName</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsFile['id']; ?></td>
      <td>
        <?php 
			$fileId = $row_rsFile['id'];
			$name = $row_rsFile['fileName'];	
	        $fileExt = substr(strrchr($name, '.'), 1);
	        $dbFileName = $fileId . ".". $fileExt;
			$realFileName = $row_rsFile['fileName'];
		?>
      	<a href="fileSaving.php?fileName=<?php echo $dbFileName; ?>&realFileName=<?php echo $realFileName ?>">
			<?php echo $row_rsFile['fileName']; ?>
        </a>
      </td>
    </tr>
    <?php } while ($row_rsFile = mysql_fetch_assoc($rsFile)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsFile);
?>
