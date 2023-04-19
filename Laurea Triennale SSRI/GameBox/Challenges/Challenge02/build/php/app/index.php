<?php
require '/var/vendor/autoload.php';
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 02: JWT Weak Secret</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Login</h1>
      <h2>Puoi accedere al sito come guest (username=guest e password=guest). Solo l'admin è autorizzato all'accesso della flag.</h2>
      <h3><a target="_blank" href="https://github.com/wallarm/jwt-secrets/blob/master/jwt.secrets.list">Piccolo aiuto</a></h3>
      <div id="login" style="background-color: #ecf0f1;">
        <h2>Inserisci le credenziali</h2>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off" required><br>
          <label for="password">Password:</label><br>
          <input type="text" id="password" name="password" style="text-security:disc; -webkit-text-security:disc;" autocomplete="off" required><br><br>
          <input id="btn" type="submit" value="Submit">
        </form>
        <?php
        use Firebase\JWT\JWT;
        use Firebase\JWT\Key;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];
          if (!empty($username) && !empty($password)) {
            try{
              #ini_set( 'error_reporting', E_ALL );
              #ini_set( 'display_errors', true );
              include __DIR__."/dbch2connection.php";
              $stmt = $conn->prepare("SELECT Password from users WHERE Username=?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $result = $stmt->get_result();
              #echo $result->num_rows;
              if ($result->num_rows == 1) {
                while($row = $result->fetch_assoc()) {
                  $hashed = hash("sha512", $password);
                  if($hashed===$row['Password']){
                    #$_SESSION['user'] = $username;
                    #$_SESSION['login'] = true;
                    $key = 'hard!to-guess_secret';
                    $issuedAt = time();
                    $expirationTime = $issuedAt + (3600);
                    $payload = [
                      'user' => $username,
                      'iat' => $issuedAt,
                      'exp' => $expirationTime
                    ];
                    $alg = 'HS256';
                    $jwt = JWT::encode($payload, $key, $alg);
                    setcookie("jwt", $jwt, time() + (3600), "/"); // 1 ora
                    header('Location: '.$url."/flag.php");
                  }
                  else {
                    $_SESSION['login'] = false;
                    throw new Exception();
                  }
                }
              }
              else {
                throw new Exception();
              }
            }catch(Exception $e){
              #echo $e->getMessage();
              echo "<span class='error'>Login non riuscito</span>";
            }finally{
              $conn->close();
            }
          }else {
            echo "<span class='error'>Login non riuscito</span>";
          }
        }
        ?>
      </div>
    </body>
</div>
</body>
</html>
