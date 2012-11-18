<?php require_once('Connections/conMaterial.php'); ?>

<?php
// In an application, this could be moved to a config file
$upload_errors = array(
	// http://www.php.net/manual/en/features.file-upload.errors.php
  UPLOAD_ERR_OK => "No errors.",
  UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
  UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
  UPLOAD_ERR_PARTIAL => "Partial upload.",
  UPLOAD_ERR_NO_FILE => "No file.",
  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
  UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
);

if(isset($_POST['submit'])) {
	// process the form data
	$tmp_file = $_FILES['fileName']['tmp_name'];
	$upload_dir = "uploads";
	$name = $_FILES['fileName']['name'];		

	$fileId = $_GET['id'];	
	$fileExt = substr(strrchr($name, '.'), 1);
	$target_file = $fileId . ".". $fileExt;

	if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)) {
		$message = "File uploaded successfully.";
		$message .= "<br/>"."fileName = ".$name;			
	} else {
		$error = $_FILES['fileName']['error'];
		$message = $upload_errors[$error];
	}
}	
?>

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

$id = $_GET['id'];
// $name = $id.$_FILES['fileName']['name'];
if (isset($_FILES['fileName']['name']))
	$name = $_FILES['fileName']['name'];
else 
	$name = "";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO `file` (id, fileName) VALUES (%s, %s)",
                       $id,GetSQLValueString($name, "text"));
  mysql_select_db($database_conMaterial, $conMaterial);
  // added 2011.01.26 BuiThanhTung set names cp932
  mysql_query("set names utf8");  
  // mysql_query('set names sjis');
  // mysql_query("set names euc-jp");  
  $Result1 = mysql_query($insertSQL, $conMaterial) or die(mysql_error());
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf8" />
<title>Upload</title>
</head>
<body>

<?php $pageNum_rsMaterial = $_GET['pageNum_rsMaterial']; ?>
<p><a href="index.php?pageNum_rsMaterial=<?php echo $pageNum_rsMaterial; ?>">Return</a></p>

<?php if(!empty($message)) { echo "<p>{$message}</p>"; } ?>
<form name="form1" action="" enctype="multipart/form-data" method="post">

  <!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />-->
  <input type="file" name="fileName" />

  <input type="submit" name="submit" value="Upload" />
  <input type="hidden" name="MM_insert" value="form1">
</form>	

</body>
</html>