<?php session_start();

?>

<?php
if(isset($_SESSION["submit"])):

session_destroy();
header("location:indexprof.php");
 endif;
  ?> 