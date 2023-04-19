<?php
include __DIR__."/sessionlogin.php";
#$username=$_SESSION["user"];
$filename = __DIR__."/uploads/".$_SESSION["random"]."/image.png";
$handle = fopen($filename, "rb");
if($handle){
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  header("content-type: image/png");
  echo $contents;
}else{
  echo "Impossibile visualizzare alcuna immagine.";
}
?>
