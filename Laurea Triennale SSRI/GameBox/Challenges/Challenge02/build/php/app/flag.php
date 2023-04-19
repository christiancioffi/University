<?php
if(!isset($_COOKIE["jwt"])){
  header("HTTP/1.1 403 Forbidden");
  echo "<span class='error'>Effettua prima il login!</span>";
  exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 02: JWT Weak Secret</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Benvenuto!</h1>
      <div id="flag" style="background-color: #ecf0f1;">
        <?php
        require __DIR__ . '/../../vendor/autoload.php';
        use Firebase\JWT\JWT;
        use Firebase\JWT\Key;
        if(isset($_COOKIE["jwt"])){
          #echo $_COOKIE["jwt"];
          $key = 'hard!to-guess_secret';
          $jwt=$_COOKIE["jwt"];
          try{
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'),["HS256"]);
            $token = (array) $decoded;
            $expirationTime = $token['exp'];
            $now = time();
            if($expirationTime < $now) {
              throw new Exception("Token scaduto!");
            }
            else{
                $user = $token['user'];
                if($user=="admin"){
                  echo "<span class='ok'>W34k_S3cr3t5_W3aK_S3cur1ty!</span>";
                }else{
                  echo "<span class='error'>Flag non disponibile</span>";
                }
            }
          }
          catch(Exception $e){
            echo "<span class='error'>".$e->getMessage()."</span>";
          }
        }
        ?>
      </div>
      <div id="logoutbtn">
        <a id="lgt" href="logout.php">Logout</a>
      </div>
</body>
</html>
