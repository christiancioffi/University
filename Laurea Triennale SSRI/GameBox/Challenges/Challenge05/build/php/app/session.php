<?php
  session_start();
    if(!isset($_SESSION["random"])){
  	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$randomString = '';
    	for ($i = 0; $i < strlen(session_id()); $i++) {
        	$index = rand(0, strlen($characters) - 1);
        	$randomString .= $characters[$index];
    	}
 	$_SESSION["random"]=$randomString;
  }
  include "header.php";
?>
