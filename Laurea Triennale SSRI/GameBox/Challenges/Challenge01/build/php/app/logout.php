<?php
include "sessionlogin.php";
include __DIR__."/url.php";
unset($_SESSION["login"]);
unset($_SESSION["user"]);
#session_destroy();
header('Location: '.$url.'/index.php');
?>
