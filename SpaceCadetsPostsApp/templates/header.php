<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5.0 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <!-- External CSS -->
  <link rel="stylesheet" href="./styles.css">

  <title>SpaceAcademyPOSTSystem</title>
</head>
<body>
  <!-- Header: START -->
  <header class="container mt-4">
    <div class="row align-items-center">
      <!-- Logo on the left -->
      <div class="col-2">
        <img src="./public/assets/rocket.svg" alt="rocket" class="img-fluid">
      </div>

      <!-- Title in the center -->
      <div class="col-8 text-center">
        <h1 class="futuristic-title">Space Cadets POSTs</h1>
      </div>

      <!-- Navigation on the right -->
      <div class="col-2">
        <ul class="nav justify-content-end">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <?php 
            // Only display the Posts button if the user is logged in
            if(isset($_SESSION['userId'])) {
              echo '<li class="nav-item">
                      <a class="nav-link" href="posts.php">Posts</a>
                    </li>';
            }
          ?>
          <!-- CONDITIONAL NAV-LINKS -->
          <?php 
            // LOGGED IN STATE (Createpost link + Logout button)
            if(isset($_SESSION['userId'])){
              echo '<li class="nav-item">
                <a class="nav-link" href="createpost.php">Create Post</a>
              </li>
              <li class="nav-item">
                <form action="includes/logout.inc.php" method="POST">
                  <button type="submit" class="nav-link logout-button">Logout</button>
                </form>
              </li>';
            }
            // LOGGED OUT STATE (Signup link + Login modal button)
            else {
              echo '<li class="nav-item">
                <a class="nav-link active" href="signup.php">Signup</a>
              </li>
              <li class="nav-item">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-modal">
                  Login
                </button>
              </li>';
            }
          ?>  
        </ul>
      </div>
    </div>
  </header>
  <!-- Header: END -->



  <!-- Login Modal: START -->
<div class="modal fade" id="login-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content futuristic-modal">
      <div class="modal-header">
        <h5 class="modal-title futuristic-title" id="staticBackdropLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- LOGIN FORM: START -->
        <form action="includes/login.inc.php" method="POST">
          <div class="mb-3">
            <label for="email" class="col-form-label futuristic-label">Email address:</label>
            <input type="email" class="form-control futuristic-input" id="email" aria-describedby="emailHelp" name="mailuid" placeholder="Email Address">
            <small id="emailHelp" class="form-text text-muted futuristic-small-text">We'll never share your email with anyone else.</small>
          </div>
          <div class="mb-3">
            <label for="password" class="col-form-label futuristic-label">Password:</label>
            <input type="password" class="form-control futuristic-input" id="password" name="pwd" placeholder="Password">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary w-100 futuristic-button" name="login-submit">Login</button>
          </div>
        </form>
        <!-- LOGIN FORM: END -->
      </div>
    </div>
  </div>
</div>

  <!-- Login Error Message from GET: START -->
  <section class="container mt-3">
    <?php
      // DYNAMIC LOGIN MESSAGES 
      if(isset($_GET['loginerror'])){
        // (i) Empty fields in Login 
        if($_GET['loginerror'] == "emptyfields"){
          $errorMsg = "Please fill in all fields";
        // (ii) 500 ERROR: SQL Error
        } else if ($_GET['loginerror'] == "sqlerror"){
          $errorMsg = "Internal server error - please try again later";
        // (iii) uidUsers / emailUsers do not match
        } else if ($_GET['loginerror'] == "nouser"){
          $errorMsg = "Incorrect credentials";
        // (iv) Password does NOT match DB 
        } else if ($_GET['loginerror'] == "wrongpwd"){
          $errorMsg = "Incorrect credentials";
        // (v) loginerror=forbidden
        } else if($_GET['loginerror'] == "forbidden"){
          $errorMsg = "Please submit form correctly";
        }
        // ERROR CATCH-ALL: 
        echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';
      } else if (isset($_GET['login']) == "success"){
        // SUCCESS LOGIN:
        // echo '<div class="alert alert-primary" role="alert">Welcome ' . $_SESSION['userUid'] . '</div>';    
      }
    ?>
  </section>
