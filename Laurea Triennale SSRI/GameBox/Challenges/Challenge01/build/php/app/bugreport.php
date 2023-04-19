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
      <h1>Hai individuato un bug? Segnalalo!</h1>
      <h3>L'admin valuterà la segnalazione. Se il bug si rivela essere pericoloso, verrai contattato e ricompensato!</h3>
      <div id="report" style="background-color: #ecf0f1;">
        <h2>Bug Report</h2>
        <form action="" method="POST">
          <label for="mail">Mail:</label><br>
          <input type="mail" id="mail" name="mail" autocomplete="off" required><br>
          <label for="url">URL:</label><br>
          <input type="url" id="url" name="url" autocomplete="off" required></input><br><br>
          <input type="submit" value="Submit">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mail']) && isset($_POST['url'])) {
          $url = filter_var(htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8'), FILTER_SANITIZE_URL); //Sanitizing for XSS.
          $uniqueid= time()."-".mt_rand();
          if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            try{
              include __DIR__."/dbch1connection.php";
              $stmt = $conn->prepare("INSERT INTO bugs(url,id) VALUES (?,?)");
              $stmt->bind_param("ss", $url,$uniqueid);
              $val=$stmt->execute();
              if($val){
                echo "<span id='ok'>Bug riportato!</span>";
              }
              else{
                throw new Exception();  //$stmt->error
              }
            }catch(Exception $e){
              echo "<span id='error'>Bug non riportato.".$e->getMessage()."</span>";
            }finally{
              $conn->close();
            }
        }
        else{
            echo "<span style='color=red'>Bug non riportato.</span>";
        }
      }
        ?>
      </div>
      <div id="backbtn">
        <a id="back" href="profile.php">Indietro</a>
      </div>
</body>
</html>
