<?php
$hostname = "localhost";
$database = "fw3_db";
$username = "root";
$password = "";
//$conn = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error($conn),E_USER_ERROR); 

$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

?>