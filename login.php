<?php
session_start();
if(isset($_SESSION['user'])){

  ?>
  <script type="text/javascript">location.href = 'panel.php';</script>
<?php
}else{?>

<form id="login" action="login.php" method="post">
  user : <input type="text" id="user" name="user"><br/>
  pass : <input type="password" id="pass" name="pass"><br>
  <input value="login" type="submit">
</form>

<?php
  echo $_POST['user'];
  if(isset($_POST['user'])&&isset($_POST['pass'])) {
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

    $sql = "SELECT * FROM user where user='".$_POST['user']."' and pass='".$_POST['pass']."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      if ($user = $result->fetch_assoc()) {
        $_SESSION['user']=$user;
      }
    }
    $conn->close();
    echo '<script type="text/javascript">location.href = \'panel.php\';</script>';
  }
} ?>