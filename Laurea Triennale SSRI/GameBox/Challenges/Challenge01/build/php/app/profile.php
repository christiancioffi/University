<?php
  include __DIR__."/sessionlogin.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 01: CSRF</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Benvenuto!</h1>
      <h3>Questo è il pannello di controllo che l'admin usa per assegnare il privilegio di conoscere la <a href="/flag.php">flag</a>.</h3></br>
      <div id="ctrlpanel" style="background-color: #ecf0f1;">
        <h2>Pannello</h2>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off"><br>
          <input type="radio" id="action1" name="action" value="in">
          <label for="action1">Accetta</label><br>
          <input type="radio" id="action2" name="action" value="out">
          <label for="action2">Espelli</label><br><br>
          <input type="submit" value="Submit" <?php if($_SESSION["user"]!="admin"){echo "disabled";}?>>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['action'])) {
          $username = $_POST['username'];
          $action = ($_POST['action']=="in")?1:0;
          if (!empty($username) && !empty($_POST['action']) && $_SESSION["user"]=="admin" && $username!="admin") {
            try{
              include __DIR__."/dbch1connection.php";
              $stmt = $conn->prepare("UPDATE users SET Privilegiato=? WHERE Username=?");
              $stmt->bind_param("is", $action,$username);
              $val=$stmt->execute();
              if ($val && $action==1) {
                echo "<span id='ok'>L'utente ".$username."è stato aggiunto</span>";
              }
              elseif($val && $action==0){
                echo "<span id='error'>L'utente ".$username." è stato espulso</span>";
              }
              else{
                throw new Exception();
              }
            }catch(Exception $e){
              echo "<span id='error'>Errore</span>";
            }finally{
              $conn->close();
            }
          }else {
            echo "<span id='error'>Non sei l'admin</span>";
          }
        }
        ?>
      </div>
      <div id="logoutbtn">
        <a id="lgt" href="logout.php">Logout</a>
      </div>
      <div id="bugbtn">
        <?php
          if($_SESSION["user"]=="admin"){
            echo "<a href='admin.php'>Controlla Bug</a>";
          }
          else{
            echo "<a href='bugreport.php'>Riporta Bug</a>";
          }
        ?>
      </div>
</body>
</html>
