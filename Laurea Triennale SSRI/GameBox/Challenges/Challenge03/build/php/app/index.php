<?php
include __DIR__."/session.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 03: Blind SQL Injection</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Login</h1>
      <h2>Trova la password dell'utente <i>admin</i></h2>
      <h3>Piccolo indizio: users(<u>Username</u>, Password, DataRegistrazione)</h3>
      <div id="login" style="background-color: #ecf0f1;">
        <h2>Inserisci le credenziali</h2>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (!empty($username) && !empty($password)) {
              try{
                include __DIR__."/dbch3connection.php";
                $sql = "SELECT Username from users WHERE Username='".$username."' AND Password='".$password."';";
                  $result = $conn->query($sql);
                  if($result){
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo "<h2>Benvenuto ".$row["Username"]." !</h2>";
                        echo "<h3>Usa la password come flag</h3>";
                      }
                    } else {
                      throw new Exception("<span class='error'>Login non riuscito</span>");
                    }
                  }else{
                    throw new Exception("<span>".$conn->error."<span>");
                  }
              }catch(Exception $e){
                echo $e->getMessage();
              }finally{
                $conn->close();
              }
            }else {
              echo "<span>Login non riuscito</span>";
            }
          }
        ?>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off" required><br>
          <label for="password">Password:</label><br>
          <input type="text" id="password" name="password" style="text-security:disc; -webkit-text-security:disc;" autocomplete="off" required><br><br>
          <input id="btn" type="submit" value="Submit">
        </form>
      </div>
    </body>
</div>
</body>
</html>
