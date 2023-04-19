<?php
  session_start();
  if(!isset($_SESSION["log"])){
    $_SESSION["log"]="[Log data after ".date("d-m-Y",time())."]\nadmin asked for the privilege.\nadmin got the privilege.\n";
  }
  include "header.php";
?>
