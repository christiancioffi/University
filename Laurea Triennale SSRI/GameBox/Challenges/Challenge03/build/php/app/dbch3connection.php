<?php
    $servername = "ch3_db";
    $user = "ch3_user";
    $pass = 'M+w*RLkv6rKbFsNE';
    $dbname = "ch3challenge";

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
