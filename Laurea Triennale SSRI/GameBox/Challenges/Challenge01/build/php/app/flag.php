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
<body style="background-color: #ecf0f1;">
<?php
  try{
    include "dbch1connection.php";
    #include __DIR__."/../dbconnection.php";
    $stmt = $conn->prepare("SELECT Privilegiato from users WHERE Username=?");
    $stmt->bind_param("s",$_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      if($row["Privilegiato"]==1){
        echo "<h1>Flag: CSRF_4R3_D4ng3r0u5!</h1>";
      }else{
        throw new Exception();
      }
    }else{
      throw new Exception();
    }
  }catch(Exception $e){
    echo "<h3>Cosa ci fai qua? Credi di poter conoscere la flag? Non credo proprio!</h3>";
    #echo $e->getMessage();
  }finally{
    $conn->close();
  }
  ?>
  <div id="backbtn">
    <a id="back" href="profile.php">Indietro</a>
  </div>
</body>
</html>
