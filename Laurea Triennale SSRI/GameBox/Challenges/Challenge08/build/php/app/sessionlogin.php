<?php
include "session.php";
#var_dump(isset($_SESSION["login"]));
#var_dump($_SESSION);
#phpinfo();
if(!isset($_SESSION["login"]) || !($_SESSION["login"])){
  header("HTTP/1.1 401 Not Authorized");
  echo "Devi prima effettuare il login";
  exit;
}
?>
