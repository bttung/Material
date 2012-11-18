<?php require_once('Connections/conMaterial.php'); ?>
<?php require_once("initializeSession.php"); ?>
<?php require_once('LinkClass.php'); ?>
<?php include_once('searchInPDF.php'); ?>
<?php
	if ( !isset($_SESSION['MM_Username']) ) {
		$_SESSION['MM_Username'] = NULL;	
	}
?>

<?php 
	if (isset($_POST['materialName'])) 
		$askedMaterial = $_POST['materialName'];
	else 
		$askedMaterial = "";
	if (isset($_POST['producerName'])) 
		$askedProducer = $_POST['producerName'];
	else 
		$askedProducer = "";
	if (isset($_POST['txtKeyword'])) 
		$keyword = $_POST['txtKeyword'];
	else 
		$keyword = "";		
?>

<?php 
	$pageNumber = -1;
	$pageNum_rsMaterial = 0;
	if(isset($_POST['pageNumber'])) {
		// echo "入力したpageNo = ".$_POST['pageNumber']."\n";
		$pageNumber = $_POST['pageNumber'];
		$pageNum_rsMaterial = $_POST['pageNumber'];
		// echo "求めた�EージNo = ".$pageNum_rsMaterial;
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


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsMaterial = 10;
// $pageNum_rsMaterial = 0;
if (isset($_GET['pageNum_rsMaterial'])) {
  $pageNum_rsMaterial = $_GET['pageNum_rsMaterial'];
  if ($pageNumber >= 0) {
	  $pageNum_rsMaterial =  $pageNumber;
	  // $pageNum_rsMaterial =  $_POST['pageNumber'];  
  }
}
$startRow_rsMaterial = $pageNum_rsMaterial * $maxRows_rsMaterial;

mysql_select_db($database_conMaterial, $conMaterial);
$query_rsMaterial = "SELECT * FROM material ORDER BY id ASC";
$query_limit_rsMaterial = sprintf("%s LIMIT %d, %d", $query_rsMaterial, $startRow_rsMaterial, $maxRows_rsMaterial);
$rsMaterial = mysql_query($query_limit_rsMaterial, $conMaterial) or die(mysql_error());
// $row_rsMaterial = mysql_fetch_assoc($rsMaterial);

if (isset($_GET['totalRows_rsMaterial'])) {
  $totalRows_rsMaterial = $_GET['totalRows_rsMaterial'];
} else {
  $all_rsMaterial = mysql_query($query_rsMaterial);
  $totalRows_rsMaterial = mysql_num_rows($all_rsMaterial);
}
$totalPages_rsMaterial = ceil($totalRows_rsMaterial/$maxRows_rsMaterial)-1;

// mysql_select_db($database_conMaterial, $conMaterial);
$query_rsAskedMaterial = "SELECT * FROM material 
							WHERE material.materialName = '$askedMaterial' 
							ORDER BY material.materialName";
$rsAskedMaterial = mysql_query($query_rsAskedMaterial, $conMaterial) or die(mysql_error());
// $row_rsAskedMaterial = mysql_fetch_assoc($rsAskedMaterial);
// $totalRows_rsAskedMaterial = mysql_num_rows($rsAskedMaterial);

// mysql_select_db($database_conMaterial, $conMaterial);
$query_rsAkedProducer = "SELECT * FROM material 
							WHERE material.producerName = '$askedProducer' 
							ORDER BY material.producerName";
$rsAkedProducer = mysql_query($query_rsAkedProducer, $conMaterial) or die(mysql_error());
// $row_rsAkedProducer = mysql_fetch_assoc($rsAkedProducer);
// $totalRows_rsAkedProducer = mysql_num_rows($rsAkedProducer);

// mysql_select_db($database_conMaterial, $conMaterial);
$query_rsSearch = "SELECT * FROM material 
					WHERE material.materialName LIKE '%$keyword%' 
							OR material.productName LIKE '%$keyword%' 
							OR material.producerName LIKE '%$keyword%' 
							OR material.contact LIKE '%$keyword%' 
							OR material.telephone LIKE '%$keyword%' 
							OR material.fax LIKE '%$keyword%' 
							OR material.adress LIKE '%$keyword%' 
							OR material.productPrice LIKE '%$keyword%' 
							OR material.materialLoss LIKE '%$keyword%' 
							OR material.madeIn LIKE '%$keyword%'
							OR material.notes LIKE '%$keyword%' 
							OR material.other LIKE '%$keyword%' 												 
					ORDER BY material.id ASC";
$rsSearch = mysql_query($query_rsSearch, $conMaterial) or die(mysql_error());
// $row_rsSearch = mysql_fetch_assoc($rsSearch);
// $totalRows_rsSearch = mysql_num_rows($rsSearch);


// mysql_select_db($database_conMaterial, $conMaterial);
$query_rsFile = "SELECT * FROM `file` ORDER BY id ASC";
$rsFile = mysql_query($query_rsFile, $conMaterial) or die(mysql_error());
// $row_rsFile = mysql_fetch_assoc($rsFile);
// $totalRows_rsFile = mysql_num_rows($rsFile);



$queryString_rsMaterial = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsMaterial") == false && 
        stristr($param, "totalRows_rsMaterial") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsMaterial = htmlentities("&") . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsMaterial = htmlentities(sprintf("&totalRows_rsMaterial=%d%s", $totalRows_rsMaterial, $queryString_rsMaterial));
?>

<?php 
	function findDistinctName($fieldName){
		global $conMaterial, $database_conMaterial;
		mysql_select_db($database_conMaterial, $conMaterial);
		$query_rsDistinctName = "SELECT DISTINCT $fieldName FROM material 
									WHERE material.$fieldName IS NOT NULL 							
									ORDER BY $fieldName ASC";
									// AND material.$fieldName !=''
		$rsDistinctName = mysql_query($query_rsDistinctName, $conMaterial) or die(mysql_error());
		$row_rsDistinctName = mysql_fetch_assoc($rsDistinctName);
		// $totalRows_rsProducerName = mysql_num_rows($rsProducerName);	
		return $rsDistinctName;	
	}
?>


<?php 
	function printTableTd($row)
	{       					
		// print <td> productName...other </td>
		echo "<td>".$row['productName']."</td>";
		echo "<td>".$row['producerName']."</td>";
		if ($_SESSION['MM_Username'] != NULL) {     
			echo "<td>".$row['contact']."</td>";
			echo "<td>".$row['telephone']."</td>";
			echo "<td>".$row['fax']."</td>";
			echo "<td>".$row['adress']."</td>";
			echo "<td>".$row['productPrice']."</td>";
			echo "<td>".$row['materialLoss']."</td>";
			echo "<td>".$row['madeIn']."</td>";
			echo "<td>".$row['notes']."</td>";
			echo "<td>".$row['other']."</td>";     
		}
	}
?> 

<?php 
	function printRSData2Table ($rsData) {	
		require_once('LinkClass.php');
		global $pageNum_rsMaterial;
		$totalRows_rsData = mysql_num_rows($rsData);
		// take data from recordSetData & print 'em to Table	
		
		if ($totalRows_rsData > 0) {
			echo "<table class=\"sample\">";
				echo "<tr>";
					include("tableHeader.php");
					echo "<th></th><th>File</th>";
				echo "</tr>";	  
				// print data from all rows of recordSetData			              
				for ($RowNo = 0; $RowNo < mysql_num_rows($rsData); $RowNo++ ) { 
					$row_rsData = mysql_fetch_assoc($rsData);		
					echo "<tr>";
						//echo "<td>".$row_rsData['id']."</td>";
						$id = $row_rsData['id'];	  
						$query = "id=".$row_rsData['id']."&"."pageNum_rsMaterial=".$pageNum_rsMaterial;					
						if ($_SESSION['MM_Username'] != NULL) {  
							echo "<td>";  
								$updateLink = new linkClass("update.php",$query,$row_rsData['materialName']);
							echo "</td>";  						 
						} else {
							echo "<td>".$row_rsData['materialName']. "</td>";
						}
						// print <td> productName...other </td>
						printTableTd($row_rsData);				
						
						include_once("fileExist.php");	
						list($fileExist, $fileName) = checkFileExist($id);
						
						if ($_SESSION['MM_Username'] != NULL) {     
							echo "<td>";            
								if ( !$fileExist ) {
									$deleteLink = new deleteLinkClass('delete.php',$query);
								} else {
									$deleteLink = new deleteLinkClass('deleteMultiple.php',$query);								
								}
							echo "</td>";
							echo "<td>";
								// include("fileExistPrint.php");
								if(!$fileExist) { 
									$fileUploadLink = new linkClass("fileUpload.php",$query,"Upload");								
								}        
								if($fileExist) { 
									$ext = substr($fileName, strrpos($fileName, '.') + 1);									
									$downloadQuery = "fileName=".$id.".".$ext."&"."realFileName=".$fileName;										
									$fileDownloadLink = new linkClass("fileSaving.php",$downloadQuery,$fileName);																
									$deleteLink = new deleteLinkClass('fileDelete.php',$query);								
								}                       
							echo "</td>";
						} 			
					echo "</tr>";		    
				}  
			echo "</table>";
			echo "</br>";
		}
		mysql_free_result($rsData);
	}
?>

<?php 
	function printSearchbyFieldForm ($rsData,$searchField,$searchKeyWord) {
		$fieldArr = array("materialName"=>"商品名","producerName"=>"メーカ");
		echo "<form action=\"\" method=\"post\">";
			if (array_key_exists($searchField,$fieldArr)){
				echo "<p>".$fieldArr[$searchField]." ";					
			} else {
				echo "<p>".$searchField." ";						
			}
			// use button or onchange
			echo "<select name=\"$searchField\" class=\"SearchForm\" id=\"id$searchField\" onchange=\"this.form.submit();\">";						
				for ($RowNo = 0; $RowNo < mysql_num_rows($rsData); $RowNo++ ) { 
					$row_rsData = mysql_fetch_assoc($rsData);	
					$optionValue = 	$row_rsData[$searchField];		
					if ($optionValue == $searchKeyWord) {
						echo "<option value=\"$optionValue\" selected=\"selected\">$optionValue</option>";
					} else {						
						echo "<option value=\"$optionValue\">$optionValue</option>";
					}							
				}  	
			echo "</select>"." ";			
			mysql_free_result($rsData);
		echo "</p></form>";
	} 
?>

<?php
	function printResultFromPDF($keyword, $rsFile){
		for ( $RowNo = 0; $RowNo < mysql_num_rows($rsFile); $RowNo++ ) { 
			$row_rsFile = mysql_fetch_assoc($rsFile);							
			$searchFileName = $row_rsFile['fileName'];
			$ext = substr($searchFileName, strrpos($searchFileName, '.') + 1);
			if ( strcmp($ext, "pdf") == 0 ) {		
				$dbFileName = "uploads/".$row_rsFile['id'].".".$ext;		
				list($found, $pattern, $document) = searchInPDF($keyword, $searchFileName, $dbFileName);												
				if ($found) {											
					echo "<p>";					
					if ($_SESSION['MM_Username'] != NULL) {        
						$query = "fileName=".$row_rsFile['id'].".".$ext."&"."realFileName=".$searchFileName;						
						if (preg_match($pattern, $searchFileName)){
							$searchFileName = preg_replace($pattern, "<b><font color = \"red\">".$keyword."</font></b>", $searchFileName);			
						}
						$fileDownloadLink = new linkClass("fileSaving.php",$query,$searchFileName);						
						echo preg_replace($pattern, "<b><font color = \"red\">".$keyword."</font></b>", $document);	
						echo "<br/></p>";														
					} 																		
				}							
			}
		}  	
		mysql_free_result($rsFile);		
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<title>MaterialList</title>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<!--
<div id="apDiv4">
  <form id="pageNumberId" name="pageNumberId" method="post" action="">
    <label> ページ　番号</label>
    <span id="spryPageNumber">
    <input type="text" name="pageNumber" id="pageNumber" />
    <span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span><span class="textfieldMaxValueMsg">The entered value is greater than the maximum allowed.</span><span class="textfieldRequiredMsg">A value is required.</span></span>
	<input type="submit" name="Go" id="Go" value="Go" />
	<?php // echo "求めた�EージNo rsMaterial = ".$pageNum_rsMaterial." ";echo "入力した�EージNo text= ".$_POST['pageNumber'];?>
  </form>
</div>
-->


<?php include("logInOut.php"); ?>
 
<p>
<?php 
	$_SESSION['MM_Username'];
	if ($_SESSION['MM_Username'] != NULL) {
		echo $_SESSION['MM_Username'] . " さん！";	
	} else {
		echo "ゲスト</br>";
	}
?>
</p>

<form action="" method="post" name="frKeyword">
<p></br></br>キーワード  
<input name="txtKeyword" type="text" value="" />
<input type="submit" name="btKeyword" id="btKeyword" value="検索" />
</p>
</form>

<?php 
	$rsMaterialName = findDistinctName('materialName');
	$rsProducerName = findDistinctName('producerName');	
	printSearchbyFieldForm($rsMaterialName,'materialName',$askedMaterial);
	printSearchbyFieldForm($rsProducerName,'producerName',$askedProducer);
	
	if (isset($_POST['txtKeyword'])) {
		$keyword = $_POST['txtKeyword'];
		echo "キーワード: " . $keyword;			
		printRSData2Table($rsSearch); 
		printResultFromPDF($keyword, $rsFile);			
	}

	if (isset($_POST['materialName'])) {
		echo "商品名: " . $_POST['materialName'];
		printRSData2Table($rsAskedMaterial); 	
	}

	if (isset($_POST['producerName'])) {
		echo "メーカ: " . $_POST['producerName'];
		printRSData2Table($rsAkedProducer); 	
	}	
?>


<?php 
if ($_SESSION['MM_Username'] != NULL) { 
	echo "<p><a href=\"create.php\">Create</a></p>";
} else {
	echo "</br>";
}
?>    

<!-- The main Table start -->
<?php 
	//include("paging.php"); 	  
	//printRSData2Table($rsMaterial);
	//include("paging.php"); 
?>
<!-- main Table stop -->

</body>
</html>