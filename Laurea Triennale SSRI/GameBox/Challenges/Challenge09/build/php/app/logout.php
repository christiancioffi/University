<?php
include "sessionlogin.php";
include __DIR__."/url.php";
$username=$_SESSION["user"];
unset($_SESSION["login"]);
unset($_SESSION["user"]);
#unset($_SESSION["timestamp"]);
#session_destroy();
#$_SESSION["log"].=$username." logged out.\n";
header('Location: '.$url.'/index.php');
?>
