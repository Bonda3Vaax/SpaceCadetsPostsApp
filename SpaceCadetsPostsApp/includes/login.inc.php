<?php
  if(isset($_POST['login-submit'])){
    require './connect.inc.php';

    // Form variables
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    // VALIDATION:
    // (i) Check empty fields
    if(empty($mailuid) || empty($password)){
      header("Location: ../index.php?loginerror=emptyfields"); 
      exit();
    }
    
    // AUTH: Check if User Exists in Database
    // (a) Template SQL Check
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?"; 
    $statement = $conn->stmt_init();
    if(!$statement->prepare($sql)) {
      header("Location: ../index.php?loginerror=sqlerror"); 
      exit(); 
    }

    // (b) Data Binding & Execution
    $statement->bind_param("ss", $mailuid, $mailuid);
    $statement->execute();
    $result = $statement->get_result();       

    // AUTH: Check $result if user EXISTS in DB
    if($row = $result->fetch_assoc()){
      // (i) Matching user -> compare password to DB
      $pwdCheck = password_verify($password, $row['pwdUsers']);
      if(!$pwdCheck){
        // (ii) ERROR: User exists BUT fails AUTH
        header("Location: ../index.php?loginerror=wrongpwd");
        exit(); 

      } else {
      // (iii) AUTH SUCCESS: User exists + Password match
        session_start();
        $_SESSION['userId'] = $row['idUsers']; 
        $_SESSION['userUid'] = $row['uidUsers']; 
        header("Location: ../index.php?login=success");
        exit(); 
      }
    } else {
      // (iv) ERROR: No user was found in DB
      header("Location: ../index.php?loginerror=nouser");
      exit(); 
    }
  } else {
    // ERROR: User has NOT submitted the form correctly
    header("Location: ../index.php?loginerror=forbidden");
    exit();
  }
?>