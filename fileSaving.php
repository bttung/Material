<?php
   //Get File From uploads folder
   $file = "uploads"."/".$_GET['fileName'];
   //Get the file Name(Real Name saved in Database)
   $realFileName = $_GET['realFileName'];    
   $file_length = filesize($file);
   //Saving file with the Real Name (saved in Database)
   header("Content-Disposition: attachment; filename=$realFileName");    
   header("Content-Length:$file_length");
   header("Content-Type: application/octet-stream");
   readfile ($file);
?>