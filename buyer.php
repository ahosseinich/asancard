<?php if($_GET['type']=='buy') {
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

  $sql = "SELECT * FROM input WHERE trace_code";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $row["price"];
    }
  }

  $conn->close();
}


