<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$requestURI =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// echo $requestURI . "\n";

$pos = strpos($requestURI, "localhost");
// echo "pos = ".$pos;
$hostname_conMaterial = "localhost";
$database_conMaterial = "material";
$username_conMaterial = "root";
$password_conMaterial = "";
$conMaterial = mysql_pconnect($hostname_conMaterial, $username_conMaterial, $password_conMaterial) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("set names utf8");
?>