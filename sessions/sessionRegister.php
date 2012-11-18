
<?php 
session_start();
if (! session_is_registered('hits')) :
     session_register('hits');
endif;
$hits++;
print "You've seen this page $hits times";
?>