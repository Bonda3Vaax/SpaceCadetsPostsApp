<?php         
  // 1. Declare Database Config Variables
  $servername = "localhost";
  $username = "root";
  $password = "root"; // WAMP = ""
  $dbname = "rocketpost_extended"; 

  // 2. Create connection variable
  // OOP CLASS: MYSQLI - https://www.php.net/manual/en/class.mysqli.php
  $conn = new mysqli($servername, $username, $password, $dbname);

  // 3. Call connection with DB
  if ($conn->connect_error) {
    die('<div class="alert alert-warning mt-3" role="alert"><h4>Connection Failed<h4>' . $conn->connect_error . '</div>');
  }
?>