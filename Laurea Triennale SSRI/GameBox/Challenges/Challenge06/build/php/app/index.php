<?php
include __DIR__."/session.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 06: XSS in SVG</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
  <h1>Partecipa al concorso!</h1>
  <h3>Invia la tua creazione in SVG e prova a vincere. L'admin valuterà ogni immagine e stabilirà la migliore. Attenzione però: se credi di essere furbo inserendo contenuto malevolo all'interno</br> 
  dell'immagine ti sbagli di grosso! Il server adotta un' <a href="https://github.com/advisories/GHSA-fqx8-v33p-4qcc">infallibile</a> sanitizzatore di file SVG (versione 0.13.0).</br>
  Impossibile rubargli i cookie!</h3>
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
                include __DIR__."/dbch6connection.php";
                $stmt = $conn->prepare("SELECT Password from users WHERE Username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                  while($row = $result->fetch_assoc()) {
                    $hashed = hash("sha512", $password);
                    if($hashed===$row['Password']){
                      $_SESSION['user'] = $username;
                      $_SESSION['login'] = true;
                      if ($username=="admin"){
                        setcookie("flag", "C0n5t4ntly_Upd4t3_Y0ur_D3p3nd3nc135!", time() + (3600), "/","challenge06.gamebox",false,false);
                      }
                      header('Location: '.$url."/image.php");
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
</html>
