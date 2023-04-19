<?php
include __DIR__."/sessionlogin.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 08: RCE via PHP</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
    <body>
      <h1>Carica la tua creazione!</h1>
      <h2>Primo premio: la <a target="_blank" href="flag/flag.html">flag</a>!</h2>
      <div id="load_img" style="background-color: #ecf0f1;">
        <h2>Seleziona l'immagine da caricare sul server:</h2>
        <form action="" method="POST" enctype="multipart/form-data">
          <label for="img">File:</label><br>
          <input type="file" id="img" name="fileToUpload" required><br>
          <input id="btn" name="submit" type="submit" value="Submit">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && isset($_SESSION["user"]) && isset($_FILES["fileToUpload"])) {
            $target_dir ="uploads/".$_SESSION["random"]."/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower($_FILES['fileToUpload']['type']);   //Istruzione sbagliata!!!!
            // Check if image file is a actual image or fake image
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
              echo "<span  class='error'>File di dimensioni troppo elevate!</span>";
              $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "image/png" && $imageFileType != "image/jpeg" && $imageFileType != "image/jpg") {
              echo "<span  class='error'>Formato non corretto!</span>";
              $uploadOk = 0;
            }
            if ($uploadOk == 1) {
                if (!file_exists($target_dir)) {
                  mkdir($target_dir, 0777, true);
                }
                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                    echo "<span class='ok'>File caricato correttamente! Eccolo <a target='_blank' href='".$url."/".$target_file."'>qui</a>.</span>";
                }else{
                    echo "<span class='error'>File non corretto!</span>";
                  }
            }
          }
        ?>
      </div>
      <div id="backbtn">
        <a id="back" href="logout.php">Logout</a>
      </div>
    </body>
</html>
