<?php include __DIR__."/header.php"; ?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Home</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
  <h1> <a href="https://owasp.org/www-project-top-ten/" target="_blank">Top 10 OWASP</a> Challenges </h1>
  <table>
  <tr>
    <th>Titolo</th>
    <th>Categoria</th>
    <th>Convalidazione (Flag)</th>
    <th>Difficoltà</th>
  </tr>
  <tr>
    <td><a href="https://challenge01.gamebox:8081" target="_blank">CSRF</a></td>
    <td><a href="https://owasp.org/Top10/A01_2021-Broken_Access_Control/" target="_blank">A01:2021 – Broken Access Control</a></td>
    <td>
      <form action="" method="POST">
      <input type="hidden" name="challenge" value="1">
      <input type="text" name="flag" autocomplete="off" id="flag1">
      <input type="submit" value="submit">
      </form>
    </td>
    <td class="score">2/5</td>
  </tr>
  <tr>
    <td><a href="http://challenge02.gamebox:8082" target="_blank">JWT Weak Secret</a></td>
    <td><a href="https://owasp.org/Top10/A02_2021-Cryptographic_Failures/" target="_blank">A02:2021 – Cryptographic Failures</a></td>
    <td>
      <form action="" method="POST">
      <input type="hidden" name="challenge" value="2">
      <input type="text" name="flag" autocomplete="off" id="flag2">
      <input type="submit" value="submit">
      </form>
    </td>
    <td class="score">2/5</td>
  </tr>
  <tr>
    <td><a href="http://challenge03.gamebox:8083" target="_blank">Blind SQL Injection</a></td>
    <td><a href="https://owasp.org/Top10/A03_2021-Injection/" target="_blank">A03:2021 – Injection</a></td>
    <td>
      <form action="" method="POST">
      <input type="hidden" name="challenge" value="3">
      <input type="text" name="flag" autocomplete="off" id="flag3">
      <input type="submit" value="submit">
      </form>
    </td>
    <td class="score">4/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge04.gamebox:8084" target="_blank">HTTP Request Smuggling (TE.CL)</a></td>
    <td><a href="https://owasp.org/Top10/A04_2021-Insecure_Design/" target="_blank">A04:2021 – Insecure Design</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="4">
    <input type="text" name="flag" autocomplete="off" id="flag4">
    <input type="submit" value="submit">
    </form>
  </td>
  <td class="score">3/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge05.gamebox:8085" target="_blank">XXE Injection</a></td>
  <td><a href="https://owasp.org/Top10/A05_2021-Security_Misconfiguration/" target="_blank">A05:2021 – Security Misconfiguration</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="5">
    <input type="text" name="flag" autocomplete="off" id="flag5">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">2/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge06.gamebox:8086" target="_blank">XSS in SVG</a></td>
  <td><a href="https://owasp.org/Top10/A06_2021-Vulnerable_and_Outdated_Components/" target="_blank">A06:2021 – Vulnerable and Outdated Components</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="6">
    <input type="text" name="flag" autocomplete="off" id="flag6">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">3/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge07.gamebox:8087" target="_blank">Assumed-Immutable Cookies</a></td>
  <td><a href="https://owasp.org/Top10/A07_2021-Identification_and_Authentication_Failures/" target="_blank">A07:2021 – Identification and Authentication Failures</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="7">
    <input type="text" name="flag" autocomplete="off" id="flag7">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">1/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge08.gamebox:8088" target="_blank">RCE via PHP</a></td>
  <td><a href="https://owasp.org/Top10/A08_2021-Software_and_Data_Integrity_Failures/" target="_blank">A08:2021 – Software and Data Integrity Failures</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="8">
    <input type="text" name="flag" autocomplete="off" id="flag8">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">3/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge09.gamebox:8089" target="_blank">Log Injection</a></td>
  <td><a href="https://owasp.org/Top10/A09_2021-Security_Logging_and_Monitoring_Failures/" target="_blank">A09:2021 – Security Logging and Monitoring Failures</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="9">
    <input type="text" name="flag" autocomplete="off" id="flag9">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">2/5</td>
  </tr>
  <tr>
  <td><a href="http://challenge10.gamebox:8090" target="_blank">SSRF</a></td>
  <td><a href="https://owasp.org/Top10/A10_2021-Server-Side_Request_Forgery_%28SSRF%29/" target="_blank">A10:2021 – Server-Side Request Forgery (SSRF)</a></td>
  <td>
    <form action="" method="POST">
    <input type="hidden" name="challenge" value="10">
    <input type="text" name="flag" autocomplete="off" id="flag10">
    <input type="submit" value="submit">
    </form>
  </td>
    <td class="score">2/5</td>
  </tr>
</table>
<?php include __DIR__."/flagconvalidator.php";?>
<footer>Contatto (per soluzioni): <a href="mailto:christian.cioffi@studenti.unimi.it">christian.cioffi@studenti.unimi.it</a></footer>
</body>
</html>
