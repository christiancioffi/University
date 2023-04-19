<?php
  include __DIR__."/sessionlogin.php";
  if(!isset($_SESSION["user"]) || $_SESSION["user"]!="admin"){
    header("HTTP/1.1 403 Forbidden");
    exit;
  }
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 06: XSS in SVG</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Immagini caricate:</h1>
      <div id="svg_img">
      <?php
      if(!isset($_SESSION["current_dir"])){
          $_SESSION["current_dir"]=2;
      }
      $upload_dir = "uploads";
      $dirs = scandir ($upload_dir);
      if($_SESSION["current_dir"]<count($dirs)){
        $next_dir = $upload_dir."/". $dirs[$_SESSION["current_dir"]];// because [0] = "." [1] = ".."
        $_SESSION["current_dir"]=$_SESSION["current_dir"]+1;
        $svg_image=fopen($next_dir."/image.svg","r");
        $size=filesize($next_dir."/image.svg");
        if($svg_image){
          echo fread($svg_image,$size);
          unlink($next_dir."/image.svg");
          rmdir($next_dir);
        }
        else{
          echo "<span>File non disponibile.</span>";
        }
      }else{
        echo "<span id='end'>Nessuna immagine da visualizzare</span>";
        $_SESSION["current_dir"]=2;
      }
      ?>
    </div>
    <div id="next_img" style="background-color: #ecf0f1;">
      <form action="" method="POST">
        <input id="btn" name="next" type="submit" value="Next">
      </form>
    </div>
    <div id="profilebtn">
      <a id="profile" href="image.php">Indietro</a>
    </div>
</body>
</html>
