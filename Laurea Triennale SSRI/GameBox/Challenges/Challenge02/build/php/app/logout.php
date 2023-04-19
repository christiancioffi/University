<?php
include __DIR__."/url.php";
setcookie("jwt", "", time() - 3600);
header('Location: '.$url.'/index.php');
?>
