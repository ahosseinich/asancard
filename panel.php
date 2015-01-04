<?php
session_start();
if(!isset($_SESSION['user'])){
  echo '<script type="text/javascript">location.href = \'login.php\';</script>';
}?>
<a href="price.php">dollar price</a><br/>
<a href="buyer.php">buyer report</a>

