<?php
  include __DIR__."/sessionlogin.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 09: Log Injection</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Benvenuto!</h1>
      <h2>Solo coloro che detengono il privilegio possono accedere alla <a href="flag.php">flag</a>.</h2>
      <div id="privilege" style="background-color: #ecf0f1;">
        <h2>Richiedi Privilegio</h2>
        <form action="" method="POST">
          <input id="rqst_btn" type="submit" value="Richiedi privilegio" name="request">
        </form>
        <?php
        include __DIR__."/dbch9connection.php";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request']) && $_SESSION["user"]!="admin") {
          try{
            $username=$_SESSION["user"];
            $_SESSION["log"].=$username." asked for the privilege.\n";
            $logged_activities=$_SESSION["log"];
            if(strpos($logged_activities,"\n".$username." got the privilege.\n")){
              $stmt = $conn->prepare("UPDATE users SET Privilegiato=1 WHERE Username=?");
              $stmt->bind_param("s",$username);
              $val=$stmt->execute();
              if ($val) {
                echo "<span id='ok'>Privilegio ottenuto! Flag <a href='flag.php'>qui</a>!</span>";
              }
              else{
                throw new Exception();
              }
            }
            else{
              throw new Exception();
            }
          }catch(Exception $e){
            echo "<span id='error'>Privilegio non autorizzato.</span>";
          }finally{
            $conn->close();
          }
        }
        else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request']) && $_SESSION["user"]=="admin"){
            echo "<span id='ok'>Sei l'admin! Prendila: <a href='flag.php'>flag</a></span>";
        }
        ?>
      </div>
      <div id="logoutbtn">
        <a id="lgt" href="logout.php">Logout</a>
      </div>
</body>
</html>
