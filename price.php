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