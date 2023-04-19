<?php
include "sessionlogin.php";
include __DIR__."/url.php";
if($_SESSION["user"]=="admin"){
  unset($_SESSION["current_dir"]);
  setcookie("flag", "", time() - 3600);
}
unset($_SESSION["login"]);
unset($_SESSION["user"]);
#session_destroy();
header('Location: '.$url.'/index.php');
?>
