<?php
include __DIR__."/session.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 09: Log Injection</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <div id="registration" style="background-color: #ecf0f1;">
        <h2>Registrazione</h2>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off" required><br>
          <label for="password">Password:</label><br>
            <input type="text" id="password" name="password" style="text-security:disc; -webkit-text-security:disc;" required><br><br>
          <input type="submit" value="Submit">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
          $username = htmlspecialchars($_POST['username']);
          $password = $_POST['password'];
          if (!empty($username) && !empty($password)) {
            try{
              include __DIR__."/dbch9connection.php";
              $stmt = $conn->prepare("INSERT INTO users(Username,Password) VALUES (?,?)");
              $hashed = hash("sha512", $password);
              $stmt->bind_param("ss", $username,$hashed);
              $val=$stmt->execute();
              if($val){
                header('Location: '.$url."/index.php");
              }
              else{
                throw new Exception();
              }
            }catch(Exception $e){
              echo "<span style='color=red'>Registrazione non Riuscita!</span>";
            }finally{
              $conn->close();
            }
          }
        }
        ?>
      </div>
      <div id="backbtn">
        <a id="back" href="index.php">Indietro</a>
      </div>
    </body>
</html>
