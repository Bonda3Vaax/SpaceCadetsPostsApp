<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>

<main class="container mt-3">
    <!-- 1. CONDITIONAL Logged In/Logged Out Alerts -->
    <?php 
      // Checks the $_SESSION for user variable
      if(isset($_SESSION['userId'])){
        $userId = htmlspecialchars($_SESSION['userUid']); // Assuming userUid stores the username or ID
        echo '<div class="futuristic-alert alert-success" role="alert">Welcome, ' . $userId . '! You are logged in!</div>';
      }
      else
      {
        echo '<div class="futuristic-alert alert-warning" role="alert">Welcome! You are not logged in!</div>';
      }
    ?>
</main>
<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>