<?php
$url="";
if(($_SERVER['REQUEST_SCHEME']=="http" && $_SERVER['SERVER_PORT']=="80") || ($_SERVER['REQUEST_SCHEME']=="https" && $_SERVER['SERVER_PORT']=="443")){
  $url=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'];
}
else{
  $url=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'];
}
?>
