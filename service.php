<?php
require_once "lib/nusoap.php";

define('BUYSTATE_JUST_REQUESED',1);
define('BUYSTATE_CANCELED_BY_USER',2);
define('BUYSTATE_FAILED_CENTER',7);

define('BUYSTATE_NOT_ASSIGNED',3);
define('BUYSTATE_ASSIGNED',4);
define('BUYSTATE_SUSPEND',5);
define('BUYSTATE_COMPLETE',6);


function connect_to_db(){
  $servername = "localhost";
  $username = "casanca7_admin";
  $password = "zZ7(2^67_hrq";
  $dbname = "casanca7_service";

// Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
  if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    return null;
  }
  return $conn;
}

function update_buy_request_to_cancel($mobile_number){
  $conn= connect_to_db();
  if($conn) {
    $sql = "UPDATE buy SET state=" . BUYSTATE_CANCELED_BY_USER . " WHERE state=1 and mobile_number=" . $mobile_number;

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
  }
}
function update_buy_request_to_fail($mobile_number,$desc){
  $conn= connect_to_db();
  if($conn) {
    $sql = "UPDATE buy SET state=" . BUYSTATE_FAILED_CENTER . ", desc='".$desc."' WHERE state=1 and mobile_number=" . $mobile_number;

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
  }
}

function finalMessage($state, $lang, $timeStamp, $message){
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

  $sql = "INSERT INTO output (state, lang, timestamp, message, mpaadcode, amount)
VALUES (".$state.", ".$lang.", ".$timeStamp.", '".$message."', -1,-1)";

  if ($conn->query($sql) === TRUE) {
    error_log("New record created successfully");
  } else {
    error_log("Error: " . $sql . "<br>" . $conn->error);
  }
  $conn->close();
    return "state=$state|lang=$lang|timestamp=$timeStamp|message=$message|errorCode=0";
}
function finalBuyMessage($state, $lang, $timeStamp, $message,$mpaadCode, $amount,$path,$mobileNumber){
  $conn = connect_to_db();
  if($conn) {
    $sql = "INSERT INTO output (state, lang, timestamp, message, mpaadcode, amount)
VALUES (" . $state . ", " . $lang . ", " . $timeStamp . ", '" . $message . "', " . $mpaadCode . ", " . $amount . ")";

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }

    $sql = "INSERT INTO buy (mobile_number, trace_code, timestamp, amount, path)
VALUES (" . $mobileNumber . ", -1, " . $timeStamp . ", " . $amount . ", '" . $path . "')";

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
  }
  $_SESSION['buy']=1;
  return "state=$state|lang=$lang|timestamp=$timeStamp|message=$message|errorCode=0|mpaadCode=$mpaadCode|amount=$amount";
}
function successful_buy($mobileNumber,$trace_code, $timeStamp,$amount,$path){
  $conn = connect_to_db();
  if($conn) {
    $sql = "UPDATE buy SET state=" . BUYSTATE_NOT_ASSIGNED . ",trace_code=".$trace_code.",timestamp=".$timeStamp." WHERE state=1 and trace_code=-1 and mobile_number=" . $mobileNumber;
//    $sql = "INSERT INTO buy (mobile_number, trace_code, timestamp, amount, path, state)
//VALUES (" . $mobileNumber . ", " . $trace_code . ", " . $timeStamp . ", " . $amount . ", '" . $path . "'," . BUYSTATE_NOT_ASSIGNED . ")";

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
  }
}
function get_dollar_price(){
  $conn = connect_to_db();
  $ROF=3500;
  if($conn) {
    $sql = "SELECT price FROM price WHERE id=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      if ($row = $result->fetch_assoc()) {
        $ROF = $row["price"];
      }
    }
    $conn->close();
    return $ROF;
  }
  return $ROF;
}
function progressSession($data) {
//  ini_set("log_errors", 1);
//  ini_set("error_log", "/home/amir/www/asan/PHP_errors.log");
  $ROF=get_dollar_price();
  error_log($data);
  $price_array = array(
    '7720,1'=>array('leaf'=>false,'text'=>'',),
    '7720,1,1'=>array('price'=>(10*$ROF*1.07)+(17*$ROF),'code'=>196542585,'title'=>'Visa 10$'),
      '7720,1,2'=>array('price'=>(20*$ROF*1.07)+(17*$ROF),'code'=>196542585,'title'=>'Visa 20$'),
      '7720,1,3'=>array('price'=>(25*$ROF*1.07)+(17*$ROF),'code'=>196542585,'title'=>'Visa 25$'),
      '7720,1,4'=>array('price'=>(50*$ROF*1.07)+(17*$ROF),'code'=>196542585,'title'=>'Visa 50$'),
      '7720,1,5'=>array('price'=>(100*$ROF*1.07)+(17*$ROF),'code'=>196542585,'title'=>'Visa 100$'),

      '7720,2,1'=>array('price'=>10*$ROF*1.084,'code'=>196542585,'title'=>'iTunes 10$'),
      '7720,2,2'=>array('price'=>15*$ROF*1.078,'code'=>196542585,'title'=>'iTunes 15$'),
      '7720,2,3'=>array('price'=>25*$ROF*1.070,'code'=>196542585,'title'=>'iTunes 25$'),
      '7720,2,4'=>array('price'=>50*$ROF*1.059,'code'=>196542585,'title'=>'iTunes 50$'),
      '7720,2,5'=>array('price'=>100*$ROF*1.044,'code'=>196542585,'title'=>'iTunes 100$'),

      '7720,3,1'=>array('price'=>10*$ROF*1.14,'code'=>196542585,'title'=>'Amazon 10$'),
      '7720,3,2'=>array('price'=>15*$ROF*1.114,'code'=>196542585,'title'=>'Amazon 15$'),
      '7720,3,3'=>array('price'=>25*$ROF*1.114,'code'=>196542585,'title'=>'Amazon 25$'),
      '7720,3,4'=>array('price'=>50*$ROF*1.068,'code'=>196542585,'title'=>'Amazon 50$'),
      '7720,3,5'=>array('price'=>100*$ROF*1.056,'code'=>196542585,'title'=>'Amazon 100$'),

      '7720,4,1'=>array('price'=>10*$ROF*1.109,'code'=>196542585,'title'=>'Google Play 10$'),
      '7720,4,2'=>array('price'=>15*$ROF*1.101,'code'=>196542585,'title'=>'Google Play 15$'),
      '7720,4,3'=>array('price'=>25*$ROF*1.166,'code'=>196542585,'title'=>'Google Play 25$'),
      '7720,4,4'=>array('price'=>50*$ROF*1.105,'code'=>196542585,'title'=>'Google Play 50$'),
      '7720,4,5'=>array('price'=>100*$ROF*1.01,'code'=>196542585,'title'=>'Google Play 100$'),

      '7720,5,1'=>array('price'=>10*$ROF*1.104,'code'=>196542585,'title'=>'Xbox 10$'),
      '7720,5,2'=>array('price'=>15*$ROF*1.061,'code'=>196542585,'title'=>'Xbox 15$'),
      '7720,5,3'=>array('price'=>25*$ROF*1.084,'code'=>196542585,'title'=>'Xbox 25$'),
      '7720,5,4'=>array('price'=>50*$ROF*1.033,'code'=>196542585,'title'=>'Xbox 50$'),
      '7720,5,5'=>array('price'=>100*$ROF*1.018,'code'=>196542585,'title'=>'Xbox 100$'),

      '7720,6,1'=>array('price'=>10*$ROF*1.108,'code'=>196542585,'title'=>'PlayStation 10$'),
      '7720,6,2'=>array('price'=>20*$ROF*1.128,'code'=>196542585,'title'=>'PlayStation 20$'),
      '7720,6,3'=>array('price'=>50*$ROF*1.81,'code'=>196542585,'title'=>'PlayStation 50$'),

      '7720,7,1'=>array('price'=>10*$ROF*1.14,'code'=>196542585,'title'=>'Microsoft 10$'),
      '7720,7,2'=>array('price'=>15*$ROF*1.114,'code'=>196542585,'title'=>'Microsoft 15$'),
      '7720,7,3'=>array('price'=>25*$ROF*1.114,'code'=>196542585,'title'=>'Microsoft 25$'),
      '7720,7,4'=>array('price'=>50*$ROF*1.068,'code'=>196542585,'title'=>'Microsoft 50$'),
      '7720,7,5'=>array('price'=>100*$ROF*1.056,'code'=>196542585,'title'=>'Microsoft 100$')


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
VALUES ('".$content."', ".$mobileNumber.", ".$state.", ".$traceCode.", ".$lang.", ".$timeStamp.")";

    if ($conn->query($sql) === TRUE) {
      error_log("New record created successfully");
    } else {
      error_log("Error: " . $sql . "<br>" . $conn->error);
    }




    $conn->close();
  $date = new DateTime();
  $date->setTimezone(new DateTimeZone('Asia/Tehran'));
  if($state==0){
    session_id($mobileNumber);
    session_start();

    if($traceCode!=-1 && $traceCode!=null && $traceCode!='null'){
      $state=3;
      $lang=2;
      $timeStamp = $date->format('YmdHis');
      $message = 'خرید موفق انجام شد. اطلاعات کارت خریداری شده به شما پیامک خواهدشد.';
      $path = $_SESSION['path'];
      successful_buy($mobileNumber,$traceCode,$timeStamp,$price_array[$path]['price'],$path);
      session_destroy();
      return finalMessage($state,$lang,$timeStamp,$message);
    }else{
      $state=3;
      $lang=2;
      $timeStamp = $date->format('YmdHis');
      $message = 'خطای ارسالی از مرکز: '.$content;
      update_buy_request_to_fail($mobileNumber,$message);
      session_destroy();
      return finalMessage($state,$lang,$timeStamp,$message);
    }
  }
  if($state==1){
    session_id($mobileNumber);
    session_start();
  }
  if($state==4){
      session_id($mobileNumber);
      session_start();
    if($_SESSION['buy']==1){
       update_buy_request_to_cancel($mobileNumber);
    }
      session_destroy();
      return;
  }
    if($content=='7720'){
      $_SESSION['path']='7720';
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
    if($state==2){
      session_id($mobileNumber);
      session_start();
      $path = $_SESSION['path'];
      $path = $path.','.$content;
      $_SESSION['path']=$path;
    }
  if($path=='7720,1'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = (10*$ROF*1.07)+(17*$ROF);
    $price20 = (20*$ROF*1.07)+(17*$ROF);
    $price25 = (25*$ROF*1.07)+(17*$ROF);
    $price50 = (50*$ROF*1.07)+(17*$ROF);
    $price100 = (100*$ROF*1.07)+(17*$ROF);

    $message = 'Visa gift cards:
1. 10$, '.$price10.' toman
2. 20$, '.$price20.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,2'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.084;
    $price15 = 15*$ROF*1.078;
    $price25 = 25*$ROF*1.070;
    $price50 = 50*$ROF*1.059;
    $price100 = 100*$ROF*1.044;

    $message = 'iTunes gift cards:
1. 10$, '.$price10.' toman
2. 15$, '.$price15.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,3'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 25*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = 'Amazon gift cards:
1. 10$, '.$price10.' toman
2. 15$, '.$price15.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,4'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.109;
    $price15 = 15*$ROF*1.101;
    $price25 = 25*$ROF*1.166;
    $price50 = 50*$ROF*1.105;
    $price100 = 100*$ROF*1.01;

    $message = 'Google Play cards:
1. 10$, '.$price10.' toman
2. 15$, '.$price15.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,5'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.104;
    $price15 = 15*$ROF*1.061;
    $price25 = 25*$ROF*1.084;
    $price50 = 50*$ROF*1.033;
    $price100 = 100*$ROF*1.018;

    $message = 'Xbox cards:
1. 10$, '.$price10.' toman
2. 15$, '.$price15.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,6'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.108;
    $price20 = 20*$ROF*1.128;
    $price50 = 50*$ROF*1.81;

    $message = 'Playstation cards:
1. 10$, '.$price10.' toman
2. 20$, '.$price20.' toman
3. 50$, '.$price50.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else if($path=='7720,7'){
    $state=2;
    $lang=2;
    $timeStamp = $date->format('YmdHis');

    $price10 = 10*$ROF*1.14;
    $price15 = 15*$ROF*1.114;
    $price25 = 25*$ROF*1.114;
    $price50 = 50*$ROF*1.068;
    $price100 = 100*$ROF*1.056;

    $message = 'microsoft cards:
1. 10$, '.$price10.' toman
2. 15$, '.$price15.' toman
3. 25$, '.$price25.' toman
4. 50$, '.$price50.' toman
5. 100$, '.$price100.' toman';
    $data = finalMessage($state,$lang,$timeStamp,$message);
    return $data;
  }
  else{

    //index = intval($content);
    if(!empty($path)&&isset($price_array[$path])){
      $state = 0;
      $lang = 2;
      $timeStamp = $date->format('YmdHis');

      $amount = $price_array[$path]['price'];
      $mpaadcode = $price_array[$path]['code'];
      $message="";
      return finalBuyMessage($state, $lang, $timeStamp, $message,$mpaadcode,$amount,$path, $mobileNumber);
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