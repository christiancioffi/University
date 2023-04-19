<?php
include __DIR__."/sessionlogin.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 05: XXE Injection</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
    <body>
      <h1>Carica la tua immagine!</h1>
      <div id="load_img" style="background-color: #ecf0f1;">
        <h2>Seleziona l'immagine da caricare sul server:</h2>
        <form action="" method="POST" enctype="multipart/form-data">
          <label for="svg_img">File:</label><br>
          <input type="file" id="svg_img" name="fileToUpload" required><br>
          <input id="btn" name="submit" type="submit" value="Submit">
        </form>
      </div>
      <div id="backbtn">
        <a id="back" href="logout.php">Logout</a>
      </div>
      <div id="result_img">
      <?php
        #  ini_set('display_errors', '1');
        #  ini_set('display_startup_errors', '1');
        #  error_reporting(E_ALL);
        #  phpinfo();
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            #$username=strtolower($_SESSION["user"]);
            $target_dir = "uploads/".$_SESSION["random"]."/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            //Fai la validazione dell'immagine svg.
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
              $fileContent = file_get_contents($_FILES['fileToUpload']['tmp_name']);
              libxml_use_internal_errors(true);
              libxml_disable_entity_loader(false);
              $svg=simplexml_load_string($fileContent, 'SimpleXMLElement',LIBXML_NOENT);
              if(!$svg){
                echo "<span  class='error'>File .svg non corretto!</span>";
              }else{
                if (!file_exists($target_dir)) {
                  mkdir($target_dir, 0777, true);
                }
                $im = new Imagick();

                $im->readImageBlob($svg->asXML());

                /*png settings*/
                $im->setImageFormat("png24");
                $im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);  /*Optional, if you need to resize*/
                $target_file=$target_dir."image.png";
                $myfile = fopen("./".$target_file, "w");
                fclose($myfile);
                $im->writeImage($target_file);/*(or .jpg)*/
                chmod($target_file, 0777);
                $im->clear();
                $im->destroy();
                header("Location: ".$url."/view.php");
                }
            }
          }
        ?>
</div>
</body>
</html>
