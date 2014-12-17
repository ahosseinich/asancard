<?php
require_once "lib/nusoap.php";
$client = new nusoap_client("service.wsdl", true);

$error = $client->getError();
if ($error) {
  echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}
$date = new DateTime();
$time = $date->getTimestamp();
$result = $client->call("progressSession", array("parameters" => "content=72|state=1|mobileNumber=+989126070186|lang=2|timeStamp=$time|traceCode=-1"));

if ($client->fault) {
  echo "<h2>Fault</h2><pre>";
  print_r($result);
  echo "</pre>";
}
else {
  $error = $client->getError();
  if ($error) {
    echo "<h2>Error</h2><pre>" . $error . "</pre>";
  }
  else {
    echo "<h2>Books</h2><pre>";
    echo $result;
    echo "</pre>";
  }
}