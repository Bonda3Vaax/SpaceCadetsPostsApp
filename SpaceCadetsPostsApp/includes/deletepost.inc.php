<?php
  session_start();
  if(isset($_SESSION['userId']) && isset($_GET['id'])){
    require './connect.inc.php';

    // Form variables
    $id = $conn->real_escape_string($_GET['id']); 
    $id = intval($id);

    // DELETE POST 
    // (a) Template SQL Check
    $sql = "DELETE FROM posts WHERE id=?"; 
    $statement = $conn->stmt_init();
    if(!$statement->prepare($sql)){
      header("Location: ../posts.php?id=$id&error=sqlerror"); 
      exit();
    } 

    // (b) Data Binding & Execution
    $statement->bind_param("i", $id);
    $statement->execute();
    if($statement->error){
      header("Location: ../posts.php?error=servererror");
      exit();
    }
    
    // SUCCESS: Post deletion
    header("Location: ../posts.php?id=$id&delete=success"); 
    exit();

  } else {
    header("Location: ../signup.php");
    exit();
  }
?>