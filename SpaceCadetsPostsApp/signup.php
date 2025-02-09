<!-- HEADER.PHP -->
<?php 
  require "templates/header.php";
?>

<main class="container p-4 bg-light mt-3">
  <?php
    // Check if signup was successful
    if (isset($_GET['signup']) && $_GET['signup'] == "success") {
      echo '<div class="futuristic-alert alert-success" role="alert">
              <h4 class="alert-heading">Sign Up Successful!</h4>
              <p>Welcome aboard! Please log in to continue.</p>
            </div>';
      echo '<div class="text-center mt-3">
              <a href="index.php" class="btn btn-primary futuristic-button">Go to Login</a>
            </div>';
    } else {
  ?>
  <form action="includes/signup.inc.php" method="POST">
    <h2 class="futuristic-title">Signup</h2>
    <?php
      // DYNAMIC SIGNUP MESSAGES
      if (isset($_GET['error'])) {
        // (i) Empty fields validation 
        if ($_GET['error'] == "emptyfields") {
          $errorMsg = "Please fill in all fields";
        // (ii) Invalid Email AND Password
        } else if ($_GET['error'] == "invalidmailuid") {
          $errorMsg = "Invalid email and Password";
        // (iii) Invalid Email
        } else if ($_GET['error'] == "invalidmail") {
          $errorMsg = "Invalid email";
        // (iv) Invalid Username
        } else if ($_GET['error'] == "invaliduid") {
          $errorMsg = "Invalid username";
        // (NEW) Invalid Password
        } else if ($_GET['error'] == "invalidpwd") {
          $errorMsg = "Invalid password - you need to create a password with at least 1 capital letter, 1 number & 1 special character";
        // (v) Password Confirmation Error
        } else if ($_GET['error'] == "passwordcheck") {
          $errorMsg = "Passwords do not match";
        // (vi) Username MATCH in database on save
        } else if ($_GET['error'] == "usertaken") {
          $errorMsg = "Username already taken";
        // (vii) Internal server error 
        } else if ($_GET['error'] == "sqlerror") {
          $errorMsg = "An internal server error has occurred - please try again later";
        }
        
        // ERROR CATCHALL
        echo '<div class="futuristic-alert alert-danger" role="alert">
          <h4 class="alert-heading">Sign Up Failed</h4>
          <p>' . $errorMsg . '</p>
        </div>';
      }
    ?>

    <!-- 1. USERNAME -->
    <div class="mb-3">
      <label for="username" class="form-label futuristic-label">Username</label>
      <input 
        type="text" 
        class="form-control futuristic-input" 
        name="uid" 
        placeholder="Username" 
        value="<?php if (isset($_GET['uid'])) { echo $_GET['uid']; } ?>" 
      >
    </div>  

    <!-- 2. EMAIL -->
    <div class="mb-3">
      <label for="email" class="form-label futuristic-label">Email address</label>
      <input 
        type="email" 
        class="form-control futuristic-input" 
        name="mail" 
        placeholder="Email Address" 
        value="<?php if (isset($_GET['mail'])) { echo $_GET['mail']; } ?>" 
      >
    </div>

    <!-- 3. PASSWORD -->
    <div class="mb-3">
      <label for="password" class="form-label futuristic-label">Password</label>
      <input 
        type="password" 
        class="form-control futuristic-input" 
        name="pwd" 
        placeholder="Password"
      >
    </div>

    <!-- 4. PASSWORD CONFIRMATION -->
    <div class="mb-3">
      <label for="password" class="form-label futuristic-label">Confirm Password</label>
      <input 
        type="password" 
        class="form-control futuristic-input" 
        name="pwd-repeat" 
        placeholder="Confirm Password"
      >
    </div>

    <!-- 5. SUBMIT BUTTON -->
    <button type="submit" name="signup-submit" class="btn btn-primary w-100 futuristic-button">Signup</button>
  </form>
  <?php } // Close the PHP else block ?>
</main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php";
?>
