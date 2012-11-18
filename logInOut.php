<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<?php 
	if (isset($_SESSION['MM_Username'])) {
		if ($_SESSION['MM_Username'] != NULL) {
			echo "<p><a href=\"$logoutAction\">ログアウト</a></p>";
		} else {
			echo "<p><a href=\"login.php\">	サインイン </a></p>";
		}
	} else{
		echo "<p><a href=\"login.php\">	サインイン </a></p>";
	}
?>
 