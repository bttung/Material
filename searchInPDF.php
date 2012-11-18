<?php include("pdf2text.php"); ?>

<?php
	function searchInPDF ( $searchKeyword, $realFileName, $dbFileName ) {
				
		$document = pdf2text($dbFileName);
		$charset = mb_detect_encoding($document);
		$pattern = "/". $searchKeyword . "/i";
				
		if ( $charset != "" ) {
			mb_substitute_character('entity');
			$convertedKeyword = mb_convert_encoding($searchKeyword, $charset, 'UTF-8');
			$pattern = "/". $convertedKeyword . "/i";
			$found = preg_match($pattern, $document);						
		} else {					
			$document2 = mb_convert_encoding($document, 'UTF-8');						
			$found = preg_match($pattern, $document2);									
		}						
		
		if ( preg_match($pattern, $realFileName ) ) {
			$found++;
		}
	
		return array($found, $pattern, $document);		
	}
?>
