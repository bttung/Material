<?php require_once('Connections/conMaterial.php'); ?>
<?php
	function checkFileExist($id) {		
		global $database_conMaterial, $conMaterial;		
		$fileExist = false;
				
		mysql_select_db($database_conMaterial, $conMaterial);
		$query_rsFileExist = "SELECT * FROM file WHERE file.id = '$id' ";
		$rsFileExist = mysql_query($query_rsFileExist, $conMaterial) or die(mysql_error());
		$row_rsFileExist = mysql_fetch_assoc($rsFileExist);
		$totalRows_rsFileExist = mysql_num_rows($rsFileExist);
		mysql_free_result($rsFileExist);	
		
		if ($totalRows_rsFileExist > 0) {
			$fileExist = true;	
			$fileName = $row_rsFileExist['fileName'];
		} else {
			$fileName = "";	
		}
		return array($fileExist, $fileName);		
	}	
?>



