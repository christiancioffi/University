<?php
include __DIR__."/session.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 04: HTTP Request Smuggling TE.CL</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
  <h3>Un web server (CL) è protetto da un reverse proxy (TE), che blocca tutte richieste di assegnazione del privilegio provenienti dall'esterno della rete privata.</br>
  L'unico modo per effettuare la richiesta è dall'interno della sotto-rete, a cui solo l'admin ha accesso. Il web server non effettua controlli particolari </br>
  sulla richiesta, l'unico vincolo è che l'utente che la effettua sia autenticato. Alla flag può accedere solo chi è dotato del privilegio, assegnabile </br>
  esclusivamente dall'admin. Trova il modo di ottenere la flag.</h3>
      <div id="login" style="background-color: #ecf0f1;">
        <h2>Login</h2>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off" required><br>
          <label for="password">Password:</label><br>
          <input type="text" id="password" name="password" style="text-security:disc; -webkit-text-security:disc;" autocomplete="off" required><br><br>
          <input id="btn" type="submit" value="Submit">
        </form>
        <a id="reg_link" href="registration.php"><b>Registrazione</b></a>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (!empty($username) && !empty($password)) {
              try{
                #ini_set( 'error_reporting', E_ALL );
                #ini_set( 'display_errors', true );
                include __DIR__."/dbch4connection.php";
                $stmt = $conn->prepare("SELECT Password from users WHERE Username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                #echo $result->num_rows;
                if ($result->num_rows == 1) {
                  while($row = $result->fetch_assoc()) {
                    $hashed = hash("sha512", $password);
                    if($hashed===$row['Password']){
                      $_SESSION['user'] = $username;
                      $_SESSION['login'] = true;
                      header('Location: '.$url."/profile.php");
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
                echo "<span>Login non riuscito</span>";
              }finally{
                $conn->close();
              }
            }else {
              echo "<span>Login non riuscito</span>";
            }
          }
        ?>
      </div>
    </body>
</div>
</body>
</html>
