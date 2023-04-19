<?php
#ini_set('display_errors', '1');
#ini_set('display_startup_errors', '1');
#error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['challenge']) && isset($_POST['flag'])) {
  $challenge = intval($_POST['challenge']);
  $flag = $_POST['flag'];
  if (!empty($challenge) && !empty($flag)) {
    try{
      include __DIR__."/dbconnection.php";
      $stmt = $conn->prepare("SELECT Flag from flags WHERE Challenge=?");
      $stmt->bind_param("s",$challenge);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows == 1){
          while($row = $result->fetch_assoc()) {
            if($row["Flag"]==hash("sha512",$flag)){
            echo "<style>#flag".$challenge."{ background-color: #2ecc71; }</style>";
            }
            else{
              throw new Exception();
            }
          }
      }else{
        throw new Exception();
      }
    }catch(Exception $e){
      echo "<style>#flag".$challenge."{ background-color: #e74c3c; }</style>";
    }finally{
      $conn->close();
    }
  }
}
?>
