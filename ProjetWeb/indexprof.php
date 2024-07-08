<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Accueil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
 
</head>
<body>

<?php

if(!isset($_SESSION["submit"])):
include_once('login.php'); 
endif;
 
?>

 <?php
if(isset($_SESSION["submit"])):

  include_once('menuprof.php');
 include_once('acceuil.php');
 endif;
  ?> 




</body>