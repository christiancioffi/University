<?php
    $servername = "ch1_db";
    $user = "root";
    $pass = '87W1%^xfBuYl';
    $dbname = "ch1challenge";

      // Create connection
    try{
      $conn = new mysqli($servername, $user, $pass, $dbname);
      // Check connection
      if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
      }
    }catch(Exception $e){
      #echo "<span style='color=red'>".$e->getMessage()."</span>";
      echo "<span style='color=red'>Database non disponibile</span>";
    }
?>
