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
<body style="background-color: #ecf0f1;">
<?php
  try{
    include __DIR__."/dbch9connection.php";
    #include __DIR__."/../dbconnection.php";
    $stmt = $conn->prepare("SELECT Privilegiato from users WHERE Username=?");
    $stmt->bind_param("s",$_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      if($row["Privilegiato"]==1){
        echo "<h1>Flag: Fr0m_Gr34t_L0gs_C0m3s_Gr34t_R3sp0ns4b1l1ty!</h1>";
        /*if($_SESSION["user"]!="admin"){
          $stmt = $conn->prepare("DELETE FROM users WHERE Username=?");
          $stmt->bind_param("s",$_SESSION["user"]);
          $stmt->execute();
        }*/
        #file_put_contents("log.txt","admin logged in.\nadmin logged out.\nadmin got the privilege.\n");
      }else{
        throw new Exception();
      }
    }else{
      throw new Exception();
    }
  }catch(Exception $e){
    echo "<h3>Cosa ci fai qua? Credi di poter conoscere la flag? Non credo proprio!</h3>";
  }finally{
    $conn->close();
    #$connection->close();
  }
  ?>
  <div id="backbtn">
    <a id="back" href="request.php">Indietro</a>
  </div>
</body>
</html>
