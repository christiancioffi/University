<?php
  include __DIR__."/sessionlogin.php";
  if(!isset($_SESSION["user"]) || $_SESSION["user"]!="admin"){
    header("HTTP/1.1 403 Forbidden");
    exit;
  }
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 01: CSRF</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Bug riportati:</h1>
      <table>
      <tr>
        <th>URL</th>
        <th>ID</th>
      </tr>
      <?php
      try{
        include __DIR__."/dbch1connection.php";
        $stmt = $conn->prepare("SELECT URL,ID from bugs Where Cliccato=0");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $stmt2 = $conn->prepare("UPDATE bugs SET Cliccato=1 Where ID='".$row["ID"]."'");
            $stmt2->execute();
            if($stmt2->affected_rows==1){
              echo "<tr><td><a class='url' href='".$row["URL"]."' target='_blank'>".$row["URL"]."</a></td><td class='id'>".$row["ID"]."</td></tr>";
            }
            else{
              echo $stmt2->error;
            }
          }
        }
        else {
          throw new Exception();
        }
      }catch(Exception $e){
        echo "<tr><td>Nessun url</td><td>-</td></tr>";
      }finally{
        $conn->close();
      }
      ?>
    </table>
    <div id="profilebtn">
      <a id="profile" href="profile.php">Indietro</a>
    </div>
</body>
</html>
