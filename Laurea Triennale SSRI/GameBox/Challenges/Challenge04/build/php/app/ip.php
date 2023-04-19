<?php
include __DIR__."/sessionlogin.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 04: HTTP Request Smuggling TE.CL</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
<div id="ip" style="background-color: #ecf0f1;">
<h2 id="title_form">Ottieni il tuo IP!</h2>
<h3>(coloro che detengono il privilegio riceveranno invece la flag!)</h3>
<form action="" method="POST">
<input id="btn" type="submit" value="Ottieni IP">
</form>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$ipaddress = '';
           	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
              		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            	else if(isset($_SERVER['HTTP_X_FORWARDED']))
              		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
              		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            	else if(isset($_SERVER['HTTP_FORWARDED']))
              		$ipaddress = $_SERVER['HTTP_FORWARDED'];
            	else if(isset($_SERVER['REMOTE_ADDR']))
              		$ipaddress = $_SERVER['REMOTE_ADDR'];
            	else
              		$ipaddress = 'UNKNOWN';
		try{
    			include "dbch4connection.php";
    			$stmt = $conn->prepare("SELECT Privilegiato from users WHERE Username=?");
    			$stmt->bind_param("s",$_SESSION["user"]);
    			$stmt->execute();
    			$result = $stmt->get_result();
    			if($result->num_rows == 1){
      				$row = $result->fetch_assoc();
      				if($row["Privilegiato"]==1){
      					echo "<span class='result'>Flag: Smuggl1ng_15_1ll3g4l!</span>";
      				}else{
        				throw new Exception();
      				}
    			}else{
      				throw new Exception();
    			}
  		}catch(Exception $e){
    			echo "<span class='result'>".$ipaddress."</span>";
    			#echo $e->getMessage();
  		}finally{
    			$conn->close();
  		}
	}
?>
</div>
<div id="prfbtn">
	<a id="prf" href="profile.php">Indietro</a>
</div>
</body>
</html>
