<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 10: SSRF</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
      <h1>Curl Online</h1>
     <h2>Il server in questione appartiene alla sottorete privata 10.0.10.0/24, di cui fa parte anche un altro web server in ascolto sulla porta 80.</br>
     CURL ammette solo i protocolli HTTP e HTTPS, e utilizza GET come unico metodo. Trova la flag.</h2>
      <div id="curl" style="background-color: #ecf0f1;">
        <h2>Inserisci l'url desiderato!</h2>
        <form action="" method="POST">
          <label for="url">Url:</label><br>
          <input type="text" id="url" name="url" autocomplete="off" required><br>
          <input id="btn" type="submit" value="Submit">
        </form>
      </div>
<iframe id="page_container" srcdoc='
  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['url'])) {
      $url=$_POST['url'];
      if(filter_var($url, FILTER_VALIDATE_URL)){ # && !strpos($url,'phpmyadmin') &&  !strpos($url,'10.0.4.') && !strpos($url,':3306')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); #10
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS | CURLPROTO_HTTP);
        curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
          echo htmlspecialchars("<html><head></head><body><h3>".curl_error($ch)."</h3></body></html>");
        }
        else{
          echo htmlspecialchars($result);
        }
        curl_close ($ch);
      }
      else{
        echo htmlspecialchars("<html><head></head><body><h3>URL non valido.</h3></body></html>");
      }
    }
  ?>'>
</iframe>
</body>
</html>
