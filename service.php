<?php
require_once "lib/nusoap.php";

function finalMessage($state, $lang, $timeStamp, $message){
    return "state=$state|lang=$lang|timestamp=$timeStamp|message=$message|errorCode=0";
}
function finalBuyMessage($state, $lang, $timeStamp, $message,$mpaadCode, $amount){
  return "state=$state|lang=$lang|timestamp=$timeStamp|message=$message|errorCode=0|mpaadCode=$mpaadCode|amount=$amount";
}
function progressSession($data) {
//  ini_set("log_errors", 1);
//  ini_set("error_log", "/home/amir/www/asan/PHP_errors.log");
  $ROF=3500;
  error_log($data);
  $price_array = array(
    11=>array('price'=>(10*$ROF*1.07)+(17*$ROF),'code'=>19654258),
    12=>array('price'=>(20*$ROF*1.07)+(17*$ROF),'code'=>19654258),
    13=>array('price'=>(25*$ROF*1.07)+(17*$ROF),'code'=>19654258),
    14=>array('price'=>(50*$ROF*1.07)+(17*$ROF),'code'=>19654258),
    15=>array('price'=>(100*$ROF*1.07)+(17*$ROF),'code'=>19654258),

    21=>array('price'=>10*$ROF*1.084,'code'=>19654258),
    22=>array('price'=>15*$ROF*1.078,'code'=>19654258),
    23=>array('price'=>25*$ROF*1.070,'code'=>19654258),
    24=>array('price'=>50*$ROF*1.059,'code'=>19654258),
    25=>array('price'=>100*$ROF*1.044,'code'=>19654258),

    31=>array('price'=>10*$ROF*1.14,'code'=>19654258),
    32=>array('price'=>15*$ROF*1.114,'code'=>19654258),
    33=>array('price'=>25*$ROF*1.114,'code'=>19654258),
    34=>array('price'=>50*$ROF*1.068,'code'=>19654258),
    35=>array('price'=>100*$ROF*1.056,'code'=>19654258),

    41=>array('price'=>10*$ROF*1.109,'code'=>19654258),
    42=>array('price'=>15*$ROF*1.101,'code'=>19654258),
    43=>array('price'=>25*$ROF*1.166,'code'=>19654258),
    44=>array('price'=>50*$ROF*1.105,'code'=>19654258),
    45=>array('price'=>100*$ROF*1.01,'code'=>19654258),

    51=>array('price'=>10*$ROF*1.104,'code'=>19654258),
    52=>array('price'=>15*$ROF*1.061,'code'=>19654258),
    53=>array('price'=>25*$ROF*1.084,'code'=>19654258),
    54=>array('price'=>50*$ROF*1.033,'code'=>19654258),
    55=>array('price'=>100*$ROF*1.018,'code'=>19654258),

    61=>array('price'=>10*$ROF*1.108,'code'=>19654258),
    62=>array('price'=>20*$ROF*1.128,'code'=>19654258),
    63=>array('price'=>50*$ROF*1.81,'code'=>19654258),

    71=>array('price'=>10*$ROF*1.14,'code'=>19654258),
    72=>array('price'=>15*$ROF*1.114,'code'=>19654258),
    73=>array('price'=>25*$ROF*1.114,'code'=>19654258),
    74=>array('price'=>50*$ROF*1.068,'code'=>19654258),
    75=>array('price'=>100*$ROF*1.056,'code'=>19654258)


  );
  $blks = explode('|', $data);
  $traceCode="-1";
  $content = 0;
  $mobileNumber = 0;
  foreach ($blks as $blk) {
    $keyvalue = explode('=', $blk);
    $key = $keyvalue[0];
    $value = $keyvalue[1];
    if ($key == 'content') {
      if(!empty($value))
        $content = $value;
    } else if ($key == 'mobileNumber') {
      if(!empty($value))
      $mobileNumber = $value;
    } else if ($key == 'state') {
      $state = $value;
    } else if ($key == 'traceCode') {
      if(!empty($value))
        $traceCode = $value;
    } else if ($key == 'lang') {
      $lang = $value;
    } else if ($key == 'timestamp') {
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

  $sql = "SELECT price FROM price WHERE id=1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
      $ROF=$row["price"];
    }
  }


    $conn->close();
  $date = new DateTime();
  $date->setTimezone(new DateTimeZone('Asia/Tehran'));
  if($state==0){
    $state=3;
    $lang=2;
    $timeStamp = $date->format('YmdHis');
    $message = 'خرید موفق انجام شد. اطلاعات کارت خریداری شده به شما پیامک خواهدشد.';
    return finalMessage($state,$lang,$timeStamp,$message);
  }
    if($content=='7720'){
      $state=2;
      $lang=2;
      $timeStamp = $date->format('YmdHis');
        $message =
            'TehranVisaCard.Com
1. Visa
2. iTunes
3. Amazon
4. Google Play
5. Xbox
6. PlayStation
7. Microsoft';
      $data = finalMessage($state,$lang,$timeStamp,$message);
      return $data;
    }
  else if($content=='1'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = (10*$ROF*1.07)+(17*$ROF);
    $price20 = (20*$ROF*1.07)+(17*$ROF);
    $price25 = (25*$ROF*1.07)+(17*$ROF);
    $price50 = (50*$ROF*1.07)+(17*$ROF);
    $price100 = (100*$ROF*1.07)+(17*$ROF);

    $message = 'Visa gift cards:
11. 10$, '.$price10.' toman
12. 20$, '.$price20.' toman
13. 25$, '.$price25.' toman
14. 50$, '.$price50.' toman
15. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='2'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.084;
    $price15 = 15*$ROF*1.078;
    $price25 = 25*$ROF*1.070;
    $price50 = 50*$ROF*1.059;
    $price100 = 100*$ROF*1.044;

    $message = 'iTunes gift cards:
21. 10$, '.$price10.' toman
22. 15$, '.$price15.' toman
23. 25$, '.$price25.' toman
24. 50$, '.$price50.' toman
25. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='3'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 25*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = 'Amazon gift cards:
31. 10$, '.$price10.' toman
32. 15$, '.$price15.' toman
33. 25$, '.$price25.' toman
34. 50$, '.$price50.' toman
35. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='4'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.109;
    $price15 = 15*$ROF*1.101;
    $price25 = 25*$ROF*1.166;
    $price50 = 50*$ROF*1.105;
    $price100 = 100*$ROF*1.01;

    $message = 'Google Play cards:
41. 10$, '.$price10.' toman
42. 15$, '.$price15.' toman
43. 25$, '.$price25.' toman
44. 50$, '.$price50.' toman
45. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='5'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.104;
    $price15 = 15*$ROF*1.061;
    $price25 = 25*$ROF*1.084;
    $price50 = 50*$ROF*1.033;
    $price100 = 100*$ROF*1.018;

    $message = 'Xbox cards:
51. 10$, '.$price10.' toman
52. 15$, '.$price15.' toman
53. 25$, '.$price25.' toman
54. 50$, '.$price50.' toman
55. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='6'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.108;
    $price20 = 20*$ROF*1.128;
    $price50 = 50*$ROF*1.81;

    $message = 'Playstation cards:
61. 10$, '.$price10.' toman
62. 20$, '.$price20.' toman
63. 50$, '.$price50.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($content=='7'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 25*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = 'microsoft cards:
71. 10$, '.$price10.' toman
72. 15$, '.$price15.' toman
73. 25$, '.$price25.' toman
74. 50$, '.$price50.' toman
75. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else{

    $index = intval($content);
    if($index!=0){
      $state = 0;
      $lang = 2;
      $timeStamp = $date->format('YmdHis');

      $amount = $price_array[$index]['price'];
      $mpaadcode = $price_array[$index]['code'];
      $message="";
      return finalBuyMessage($state, $lang, $timeStamp, $message,$mpaadcode,$amount);
    }else {
      $state = 3;
      $lang = 2;
      $timeStamp = $date->format('YmdHis');

//    $message = mb_convert_encoding("به زودی راه اندازی خواهد شد.","UTF-8","UTF-8");
      $message = "مقدار وارد شده صحیح نمی باشد.";
      $data = finalMessage($state, $lang, $timeStamp, $message);
      //$data = mb_convert_encoding($data,"UTF-8","UTF-8");
      return $data;
    }
  }
}

$server = new soap_server();
$server->configureWSDL("asanservice", "urn:asanservice");
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;
$server->register("progressSession",
    array("parameters" => "xsd:string"),
    array("parameters" => "xsd:string"),
    "urn:asanservice",
    "urn:asanservice#progressSession",
    "rpc",
    "encoded",
    "Get a listing of products by category");

$server->service($HTTP_RAW_POST_DATA);