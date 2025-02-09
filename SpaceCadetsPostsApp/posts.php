<!-- HEADER.PHP -->
<?php 
  require "templates/header.php";
?>

<main class="container p-4 bg-light mt-3">
  <?php
    // 1. QUERY DATABASE for ALL POSTS
    require './includes/connect.inc.php';
    $sql = "SELECT id, title, subject, imagename, comment, imagepath, reference FROM posts";
    $result = $conn->query($sql);
  ?>

  <?php 
    // ERROR: ON DELETION OF POST 
    if(isset($_GET['error'])){
      // (i) Internal server error 
      if ($_GET['error'] == "sqlerror" || $_GET['error'] == "servererror") {
        $errorMsg = "An internal server error has occurred - please try again later.";
      }

      echo '<div class="futuristic-alert alert-danger" role="alert">' . $errorMsg . '</div>';
    
    // SUCCESS: POST CREATE
    } else if(isset($_GET['post']) && $_GET['post'] == "success"){
      echo '<div class="futuristic-alert alert-success" role="alert">
        Post created successfully!
      </div>';  

    // SUCCESS: POST EDIT 
    } else if(isset($_GET['edit']) && $_GET['edit'] == "success"){
      echo '<div class="futuristic-alert alert-success" role="alert">
        Post edited successfully!
      </div>'; 

    // SUCCESS: POST DELETE
    } else if (isset($_GET['delete']) && $_GET['delete'] == "success"){
      echo '<div class="futuristic-alert alert-success" role="alert">
        Post deleted successfully!
      </div>';    
    }
  ?>

  <?php
    // 2. CHECK FOR POSTS RETURNED RESULT & DISPLAY ON SUCCESS
    if($result->num_rows > 0){
      echo '<div class="row">'; // Start Bootstrap row
      while($row = $result->fetch_assoc()) {
        echo '
          <div class="col-md-4 mb-4"> <!-- Use col-md-4 for 3 columns on medium+ screens -->
            <div class="card border-0 shadow-sm h-100">
              <img src="./public/uploads/posts/' . $row['imagename'] . '" class="card-img-top img-fluid" alt="' . $row['title'] . '" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title">' . $row['title'] . '</h5>
                <p class="card-text">' . $row['comment'] . '</p>
                <a href="' . $row['imagepath'] . '" class="btn btn-primary w-100" target="_blank">' . $row['reference'] . '</a>';
                
                // ADMIN FEATURES:
                if(isset($_SESSION['userId'])){
                  echo '
                  <div class="admin-btn mt-3">
                    <a href="editpost.php?id=' . $row['id'] . '" class="btn btn-secondary w-100 mb-2" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Edit</a>
                    <button type="button" class="btn btn-danger w-100" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-post-id="' . $row['id'] . '">Delete</button>
                  </div>';
                }

        echo '
              </div>
            </div>
          </div>
        ';
      }
      echo '</div>'; // End Bootstrap row
    } else {
      echo '
        <div class="futuristic-alert alert-warning text-center" role="alert">
          <h4 class="alert-heading">No Posts Available</h4><br>
          <p>It looks like there are no posts here yet.</p>
          <p> Why not be the first to create one?</p>
          <hr>
          <a href="./createpost.php" class="btn btn-primary">Create Your First Post</a>
        </div>';
    }
    $conn->close();
  ?>
</main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php";
?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this post? This action cannot be undone!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="confirmDeleteButton" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript to handle delete button and modal -->
<script>
  const confirmDeleteModal = document.getElementById('confirmDeleteModal');
  confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const postId = button.getAttribute('data-post-id'); // Extract info from data-* attributes
    const confirmButton = document.getElementById('confirmDeleteButton');
    confirmButton.href = 'includes/deletepost.inc.php?id=' + postId; // Update link to include the post ID
  });
</script>
