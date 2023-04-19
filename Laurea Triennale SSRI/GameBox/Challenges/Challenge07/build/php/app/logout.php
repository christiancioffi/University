<?php
include __DIR__."/url.php";
if(!isset($_COOKIE["User"])){
  header("HTTP/1.1 401 Not Authorized");
  echo "Devi prima effettuare il login";
  exit;
}
setcookie("User", "", time() - 3600);
#session_destroy();
header('Location: '.$url.'/index.php');
?>
