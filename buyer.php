<?php
session_start();
if(!isset($_SESSION['user'])){
  echo '<script type="text/javascript">location.href = \'login.php\';</script>';
}?>
<a href="buyer.php?type=buy">buy</a>
<a href="buyer.php?type=all">all</a>

<?php

define('BUYSTATE_JUST_REQUESED',1);
define('BUYSTATE_CANCELED_BY_USER',2);
define('BUYSTATE_NOT_ASSIGNED',3);
define('BUYSTATE_ASSIGNED',4);
define('BUYSTATE_SUSPEND',5);
define('BUYSTATE_COMPLETE',6);

function getDollarPrice(){
  $ROF =3500;
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

  $sql = "SELECT price FROM price WHERE id=1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
      $ROF=$row["price"];
    }
  }
  $conn->close();
  return $ROF;
}

$ROF = getDollarPrice();
$price_array=array(
    '7720,1,1'=>array('price'=>(10*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 10$'),
    '7720,1,2'=>array('price'=>(20*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 20$'),
    '7720,1,3'=>array('price'=>(25*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 25$'),
    '7720,1,4'=>array('price'=>(50*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 50$'),
    '7720,1,5'=>array('price'=>(100*$ROF*1.07)+(17*$ROF),'code'=>19654258,'title'=>'Visa 100$'),

    '7720,2,1'=>array('price'=>10*$ROF*1.084,'code'=>19654258,'title'=>'iTunes 10$'),
    '7720,2,2'=>array('price'=>15*$ROF*1.078,'code'=>19654258,'title'=>'iTunes 15$'),
    '7720,2,3'=>array('price'=>25*$ROF*1.070,'code'=>19654258,'title'=>'iTunes 25$'),
    '7720,2,4'=>array('price'=>50*$ROF*1.059,'code'=>19654258,'title'=>'iTunes 50$'),
    '7720,2,5'=>array('price'=>100*$ROF*1.044,'code'=>19654258,'title'=>'iTunes 100$'),

    '7720,3,1'=>array('price'=>10*$ROF*1.14,'code'=>19654258,'title'=>'Amazon 10$'),
    '7720,3,2'=>array('price'=>15*$ROF*1.114,'code'=>19654258,'title'=>'Amazon 15$'),
    '7720,3,3'=>array('price'=>25*$ROF*1.114,'code'=>19654258,'title'=>'Amazon 25$'),
    '7720,3,4'=>array('price'=>50*$ROF*1.068,'code'=>19654258,'title'=>'Amazon 50$'),
    '7720,3,5'=>array('price'=>100*$ROF*1.056,'code'=>19654258,'title'=>'Amazon 100$'),

    '7720,4,1'=>array('price'=>10*$ROF*1.109,'code'=>19654258,'title'=>'Google Play 10$'),
    '7720,4,2'=>array('price'=>15*$ROF*1.101,'code'=>19654258,'title'=>'Google Play 15$'),
    '7720,4,3'=>array('price'=>25*$ROF*1.166,'code'=>19654258,'title'=>'Google Play 25$'),
    '7720,4,4'=>array('price'=>50*$ROF*1.105,'code'=>19654258,'title'=>'Google Play 50$'),
    '7720,4,5'=>array('price'=>100*$ROF*1.01,'code'=>19654258,'title'=>'Google Play 100$'),

    '7720,5,1'=>array('price'=>10*$ROF*1.104,'code'=>19654258,'title'=>'Xbox 10$'),
    '7720,5,2'=>array('price'=>15*$ROF*1.061,'code'=>19654258,'title'=>'Xbox 15$'),
    '7720,5,3'=>array('price'=>25*$ROF*1.084,'code'=>19654258,'title'=>'Xbox 25$'),
    '7720,5,4'=>array('price'=>50*$ROF*1.033,'code'=>19654258,'title'=>'Xbox 50$'),
    '7720,5,5'=>array('price'=>100*$ROF*1.018,'code'=>19654258,'title'=>'Xbox 100$'),

    '7720,6,1'=>array('price'=>10*$ROF*1.108,'code'=>19654258,'title'=>'PlayStation 10$'),
    '7720,6,2'=>array('price'=>20*$ROF*1.128,'code'=>19654258,'title'=>'PlayStation 20$'),
    '7720,6,3'=>array('price'=>50*$ROF*1.81,'code'=>19654258,'title'=>'PlayStation 50$'),

    '7720,7,1'=>array('price'=>10*$ROF*1.14,'code'=>19654258,'title'=>'Microsoft 10$'),
    '7720,7,2'=>array('price'=>15*$ROF*1.114,'code'=>19654258,'title'=>'Microsoft 15$'),
    '7720,7,3'=>array('price'=>25*$ROF*1.114,'code'=>19654258,'title'=>'Microsoft 25$'),
    '7720,7,4'=>array('price'=>50*$ROF*1.068,'code'=>19654258,'title'=>'Microsoft 50$'),
    '7720,7,5'=>array('price'=>100*$ROF*1.056,'code'=>19654258,'title'=>'Microsoft 100$')


);
function get_product_name($path){
  return $GLOBALS['price_array'][$path]['title'];
}
function get_product_code($path){
  return $GLOBALS['price_array'][$path]['code'];
}
function get_state_name($state){
  switch ($state) {
    case 1:
      return 'BUYSTATE_JUST_REQUESED';
      break;
    case 2:
      return 'BUYSTATE_CANCELED_BY_USER';
      break;
    case 3:
      return 'BUYSTATE_NOT_ASSIGNED';
      break;
    case 4:
      return 'BUYSTATE_ASSIGNED';
      break;
    case 5:
      return 'BUYSTATE_SUSPEND';
      break;
    case 6:
      return 'BUYSTATE_COMPLETE';
      break;
  }
}
function get_action_link($state,$id,$user_id){
  switch($state) {
  case BUYSTATE_NOT_ASSIGNED:
    return '<a href="buyer.php?action=assign&type=all&id='.$id.'">assign to me</a>';
    break;
  case BUYSTATE_ASSIGNED:
    if($_SESSION['user']['id']==$user_id)
      return '<a href="complete.php?action=complete&type=all&id='.$id.'">complete</a> <a href="buyer.php?action=suspend&type=all&id='.$id.'">suspend</a>';
    break;

  }
}
function getContent($type){
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

  if ($type == 'all')$sql = "SELECT * FROM buy";
  else if($type == 'buy')$sql = "SELECT * FROM buy WHERE trace_code<>-1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      print '<tr>
      <td>'.$row["mobile_number"].'</td>
      <td>'.get_product_name($row["path"]).'</td>
      <td>'.get_product_code($row["path"]).'</td>
      <td>'.number_format($row["amount"], 0, '', ',').'</td>
      <td>'.$row["trace_code"].'</td>
      <td>'.$row["timestamp"].'</td>
      <td>'.get_state_name($row["state"]).'</td>
      <td>'.get_action_link($row["state"],$row["id"],$row['user_id']).'</td>
    </tr>';

    }
  }

  $conn->close();
}
if($_GET['action']=='assign'){
  $id = $_GET['id'];
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
  $sql = "LOCK TABLES buy WRITE; UPDATE buy SET state=".BUYSTATE_ASSIGNED.", user_id=".$_SESSION['user']['id']." WHERE state=".BUYSTATE_NOT_ASSIGNED." and id=".$id."; UNLOCK TABLES;";

  if ($conn->multi_query($sql) === TRUE) {
    error_log("New record created successfully");
  } else {
    error_log("Error: " . $sql . "<br>" . $conn->error);
  }
  $conn->close();
}
?>


<?php if(isset($_GET['type'])):?>


  <!DOCTYPE html>
  <html>

  <head>
    <style>
      table {

      }
      table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
      }
      th, td {
        padding: 5px;
        text-align: left;
      }
      table#t01 tr:nth-child(even) {
        background-color: #eee;
      }
      table#t01 tr:nth-child(odd) {
        background-color:#fff;
      }
      table#t01 th	{
        background-color: black;
        color: white;
      }
    </style>
  </head>

  <body>


  <table id="t01">
    <tr>
      <th>mobile number</th>
      <th>product name</th>
      <th>product code</th>
      <th>price</th>
      <th>trace code</th>
      <th>timestamp</th>
      <th>state</th>
      <th>actions</th>
    </tr>
    <?php
    getContent($_GET['type']);
    ?>

  </table>

  </body>
  </html>


<?php endif; ?>

