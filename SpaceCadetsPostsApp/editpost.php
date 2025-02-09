<!-- HEADER.PHP -->
<?php 
  require "templates/header.php";
?>

<main class="container p-4 bg-dark mt-3 futuristic-form">
  <?php
    // Check if user is logged in and if post ID is present
    if (isset($_SESSION['userId']) && isset($_GET['id'])) {
      require './includes/connect.inc.php';

      // Page variables
      $id = $conn->real_escape_string($_GET['id']); 
      $id = intval($id);

      // PRE-POPULATE POST 
      $sql = "SELECT title, subject, imagename, comment, imagepath, reference FROM posts WHERE id=?";
      $statement = $conn->stmt_init();
      if (!$statement->prepare($sql)) {
        header("Location: editpost.php?id=$id&error=sqlerror"); 
        exit();
      }

      $statement->bind_param("i", $id);
      $statement->execute();
      $result = $statement->get_result();
      $row = $result->fetch_assoc();

    } else {
      header("Location: index.php");
      exit();
    }
  ?>

  <form action="includes/editpost.inc.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
    <h2 class="futuristic-title">Edit Post</h2>

    <?php 
      // DYNAMIC ERROR ALERTS FOR EDIT POST
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
          $errorMsg = "Please fill in all required fields before submitting the form.";
        } else if ($_GET['error'] == "sqlerror") {
          $errorMsg = "We encountered an issue while processing your request. Please try again later or contact support.";
        } else if ($_GET['error'] == "servererror") {
          $errorMsg = "A server error occurred while processing your request. If this issue persists, please reach out to support.";
        } else if ($_GET['error'] == "file-upload-error") {
          $errorMsg = "There was a problem uploading your file. Please ensure the file meets the requirements and try again.";
        } else if ($_GET['error'] == "bad-ext") {
          $errorMsg = "The file type you uploaded is not supported. Please upload a valid jpg, jpeg, png, or gif file.";
        } else if ($_GET['error'] == "file-size") {
          $errorMsg = "The file you uploaded is too large. Please ensure the file size is under 2MB.";
        } else if ($_GET['error'] == "file-exists") {
          $errorMsg = "A file with this name already exists on the server. Please rename your file and try again.";
        } else {
          $errorMsg = "An unexpected error occurred. Please try again or contact support.";
        }
        echo '<div class="futuristic-alert alert-danger" role="alert">' . $errorMsg . '</div>';
      }
    ?>

    <!-- 1. TITLE -->
    <div class="mb-3">
      <label for="title" class="form-label futuristic-label">Title</label>
      <input type="text" class="form-control futuristic-input" name="title" placeholder="Title" value="<?php echo $row['title'] ?>">
    </div>  

    <!-- SUBJECT FIELD -->
    <div class="mb-3">
      <label for="subject" class="form-label futuristic-label">Subject</label>
      <select class="form-control futuristic-input" id="subject" name="subject">
        <option value="Astronomy" <?php if ($row['subject'] == 'Astronomy') echo 'selected'; ?>>Astronomy</option>
        <option value="Geology" <?php if ($row['subject'] == 'Geology') echo 'selected'; ?>>Geology</option>
        <option value="Physics" <?php if ($row['subject'] == 'Physics') echo 'selected'; ?>>Physics</option>
        <option value="Biology" <?php if ($row['subject'] == 'Biology') echo 'selected'; ?>>Biology</option>
        <option value="Chemistry" <?php if ($row['subject'] == 'Chemistry') echo 'selected'; ?>>Chemistry</option>
        <!-- Add more subjects as needed -->
      </select>
    </div>

    <!-- 2. IMAGE PREVIEW AND UPLOAD -->
    <div class="text-center mb-3">
      <img id="imagePreview" style="max-width: 25%; height: auto;" src="<?php echo $row['imagepath'] ?>" alt="<?php echo $row['imagename'] ?>">
    </div>

    <!-- Hidden input to pass the old image path -->
    <input type="hidden" name="oldImagePath" value="<?php echo $row['imagepath']; ?>">

    <div class="mb-3">
      <div class="d-flex align-items-center justify-content-center" style="margin-bottom: 1rem;">
        <label for="imageFile" class="form-label futuristic-label mb-0 me-3">Change Image (optional)</label>
        <button type="button" class="btn btn-outline-primary futuristic-button" onclick="document.getElementById('imageFile').click();">Choose New Image</button>
      </div>
      <div class="upload-area text-center">
        <input type="file" class="form-control mt-3" id="imageFile" name="imageFile" onchange="previewImage(event)" style="display: none;">
      </div>
    </div>

    <!-- 3. COMMENT SECTION -->
    <div class="mb-3">
      <label for="comment" class="form-label futuristic-label">Comment</label>
      <textarea class="form-control futuristic-input" name="comment" rows="3" placeholder="Comment"><?php echo $row['comment'] ?></textarea>
    </div>

    <!-- REFERENCE FIELD -->
    <div class="mb-3">
      <label for="reference" class="form-label futuristic-label">Reference</label>
      <input type="text" class="form-control futuristic-input" name="reference" placeholder="Reference (e.g., Source or Website Title)" value="<?php echo $row['reference'] ?>">
    </div>

    <!-- 5. SUBMIT BUTTON -->
    <button type="submit" name="edit-submit" class="btn btn-primary w-100 futuristic-button">Edit</button>
  </form>
</main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php";
?>

<!-- JavaScript to handle image preview -->
<script>
  function previewImage(event) {
    const reader = new FileReader();
    const output = document.getElementById('imagePreview');
    output.style.opacity = 0;  // Start with opacity 0 for fade-in effect
    reader.onload = function(){
      output.src = reader.result;
      output.onload = function() {
        output.style.opacity = 1;  // Fade in the image once loaded
      };
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
