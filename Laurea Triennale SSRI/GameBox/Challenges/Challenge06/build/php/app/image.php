<?php
require '/var/vendor/autoload.php';
include __DIR__."/sessionlogin.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 06: XSS in SVG</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
    <body>
      <h1>Carica la tua creazione!</h1>
      <div id="load_img" style="background-color: #ecf0f1;">
        <h2>Seleziona l'immagine da caricare sul server:</h2>
        <form action="" method="POST" enctype="multipart/form-data">
          <label for="svg_img">File:</label><br>
          <input type="file" id="svg_img" name="fileToUpload" required><br>
          <input id="btn" name="submit" type="submit" value="Submit">
        </form>
        <?php
            use enshrined\svgSanitize\Sanitizer;
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
              #$username=strtolower($_SESSION["user"]);
              $target_dir = "uploads/".$_SESSION["random"]."/";
              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              // Check if image file is a actual image or fake image
              // Check file size
              if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "<span  class='error'>File di dimensioni troppo elevate!</span>";
                $uploadOk = 0;
              }
              // Allow certain file formats
              if($imageFileType != "svg") {
                echo "<span  class='error'>L'unico formato accettato è il .svg</span>";
                $uploadOk = 0;
              }
              if ($uploadOk == 1) {

                // Create a new sanitizer instance
                $sanitizer = new Sanitizer();
                $sanitizer->removeRemoteReferences(true);
                $dirtysvg = file_get_contents($_FILES['fileToUpload']['tmp_name']);
                $cleansvg = $sanitizer->sanitize($dirtysvg);
                if(!$cleansvg){
                  echo "<span  class='error'>File .svg non corretto!</span>";
                }else{
                  if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                  }
                  $target_file=$target_dir."image.svg";
                  $myfile = fopen("./".$target_file, "w");
                  fwrite($myfile, $cleansvg);
                  fclose($myfile);
                  chmod($target_file, 0777);
                  echo "<span class='ok'>File caricato!</span>";
                }
              }
              else{
                echo "<span  class='error'>File .svg non corretto!</span>";
              }
            }
          ?>
      </div>
      <div id="backbtn">
        <a id="lgt" href="logout.php">Logout</a>
      </div>

  <?php
    if($_SESSION["user"]=="admin"){
      echo "<div id='imgbtn'><a href='admin.php'>Controlla Immagini</a></div>";
    }
  ?>
</body>
</html>
