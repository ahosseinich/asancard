<?php
session_start();
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

if(!isset($_SESSION['user'])){
  echo '<script type="text/javascript">location.href = \'login.php\';</script>';
}?>
<?php
echo 'current dollar price is : '.get_dollar_price().'<br/>';
?>
<form id="price_forn" action="price.php" method="post">
    dollar price: <input type="text" id="price" name="price"> toman.
  <br/>
  <input type="submit" value="submit">
</form>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: amir
 * Date: 12/31/14
 * Time: 3:02 PM
 */
if(isset($_POST['price'])){
  print 'you entered '.$_POST['price'];
  $price = $_POST['price'];

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

  $sql = "UPDATE price SET price=".$price." WHERE id =1";

  if ($conn->query($sql) === TRUE) {
    error_log("New record created successfully");
    print 'your new price successfully inserted! '.$price;
  } else {
    error_log("Error: " . $sql . "<br>" . $conn->error);
  }

  $conn->close();
}