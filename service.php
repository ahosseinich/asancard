<?php
require_once "lib/nusoap.php";

function progressSession($data) {
//  ini_set("log_errors", 1);
//  ini_set("error_log", "/home/amir/www/asan/PHP_errors.log");
  $ROF=3500;
  error_log($data);
  $blks = explode('|', $data);
  $traceCode="-1";
  foreach ($blks as $blk) {
    $keyvalue = explode('=', $blk);
    $key = $keyvalue[0];
    $value = $keyvalue[1];
    if ($key == 'content') {
      $content = $value;
    } else if ($key == 'mobileNumber') {
      $mobileNumber = $value;
    } else if ($key == 'state') {
      $state = $value;
    } else if ($key == 'traceCode') {
      $traceCode = $value;
    } else if ($key == 'lang') {
      $lang = $value;
    } else if ($key == 'timeStamp') {
      $timeStamp = $value;
    }

  }

    $servername = "localhost";
    $username = "casanca7_admin";
    $password = "zZ7(2^67_hrq";
    $dbname = "casanca7_service";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
      error_log("Connection failed: " . $conn->connect_error);
      die;
    }

    $sql = "INSERT INTO input (content, mobile_number, state, trace_code, lang, timestamp)
VALUES (".$content.", ".$mobileNumber.", ".$state.", ".$traceCode.", ".$lang.", ".$timeStamp.")";

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
  $date = new DateTime();
    if($content=='7720'){
      $state=2;
      $lang=2;
      $timeStamp = $date->getTimestamp();
        $message =
            'TehranVisaCard.Com
1. Visa
2. iTunes
3. Amazon
4. Google Play
5. Xbox
6. PlayStation
7. Microsoft';
      $data = $state."|".$lang."|".$timeStamp."|".$message;
      return $data;
    }
  else if($content=='1'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = (10*$ROF*1.07)+(17*$ROF);
    $price20 = (20*$ROF*1.07)+(17*$ROF);
    $price25 = (25*$ROF*1.07)+(17*$ROF);
    $price50 = (50*$ROF*1.07)+(17*$ROF);
    $price100 = (100*$ROF*1.07)+(17*$ROF);

    $message = '11. 10$, '.$price10.' toman
12. 20$, '.$price20.' toman
13. 25$, '.$price25.' toman
14. 50$, '.$price50.' toman
15. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='2'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.084;
    $price15 = 15*$ROF*1.078;
    $price25 = 25*$ROF*1.070;
    $price50 = 50*$ROF*1.059;
    $price100 = 100*$ROF*1.044;

    $message = '21. 10$, '.$price10.' toman
22. 15$, '.$price15.' toman
23. 25$, '.$price25.' toman
24. 50$, '.$price50.' toman
25. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='3'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 15*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = '31. 10$, '.$price10.' toman
32. 15$, '.$price15.' toman
33. 25$, '.$price25.' toman
34. 50$, '.$price50.' toman
35. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='4'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.109;
    $price15 = 15*$ROF*1.101;
    $price25 = 15*$ROF*1.166;
    $price50 = 50*$ROF*1.105;
    $price100 = 100*$ROF*1.01;

    $message = '41. 10$, '.$price10.' toman
42. 15$, '.$price15.' toman
43. 25$, '.$price25.' toman
44. 50$, '.$price50.' toman
45. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='5'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.104;
    $price15 = 15*$ROF*1.061;
    $price25 = 15*$ROF*1.084;
    $price50 = 50*$ROF*1.033;
    $price100 = 100*$ROF*1.018;

    $message = '51. 10$, '.$price10.' toman
52. 15$, '.$price15.' toman
53. 25$, '.$price25.' toman
54. 50$, '.$price50.' toman
55. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='6'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.108;
    $price20 = 20*$ROF*1.128;
    $price50 = 50*$ROF*1.81;

    $message = '61. 10$, '.$price10.' toman
62. 20$, '.$price20.' toman
63. 50$, '.$price50.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else if($content=='7'){
    $state=2;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 15*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = '71. 10$, '.$price10.' toman
72. 15$, '.$price15.' toman
73. 25$, '.$price25.' toman
74. 50$, '.$price50.' toman
75. 100$, '.$price100.' toman';
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
  else{
    $state=3;
    $lang=2;
    $timeStamp = $date->getTimestamp();

    $message = "به زودی راه اندازی خواهد شد.";
    $data = $state."|".$lang."|".$timeStamp."|".$message;
    return $data;
  }
}

$server = new soap_server();
$server->configureWSDL("asanservice", "urn:asanservice");

$server->register("progressSession",
    array("parameters" => "xsd:string"),
    array("parameters" => "xsd:string"),
    "urn:asanservice",
    "urn:asanservice#progressSession",
    "document",
    "literal",
    "Get a listing of products by category");

$server->service($HTTP_RAW_POST_DATA);