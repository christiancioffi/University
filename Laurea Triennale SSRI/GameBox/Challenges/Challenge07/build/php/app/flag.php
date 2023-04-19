<?php
if(!isset($_COOKIE["User"])){
  header("HTTP/1.1 401 Not Authorized");
  echo "Devi prima effettuare il login";
  exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 07: Assumed-Immutable Cookies</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body style="background-color: #ecf0f1;">
  <?php
  if(isset($_COOKIE["User"]) && strtolower($_COOKIE["User"])=="admin"){
    echo "<h1>Us3_C00k13s_C4r3fully!</h1>";
    #setcookie("User", "", time() - 3600);
  }
  else{
    echo "<h1>Non sei l'admin!</h1>";
  }
  ?>

  <div id="backbtn">
    <a id="back" href="logout.php">Logout</a>
  </div>
</body>
</html>
