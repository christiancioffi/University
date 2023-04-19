<?php
    $servername = "ch5_db";
    $user = "root";
    $pass = 'F79kw1ke%4c2';
    $dbname = "ch5challenge";

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
