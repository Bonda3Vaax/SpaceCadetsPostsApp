<!-- HEADER.PHP -->
<?php 
  require "templates/header.php";
?>

<main class="container p-4 bg-dark mt-3 futuristic-form">
  <form action="includes/createpost.inc.php" method="POST" enctype="multipart/form-data">
    <h2 class="futuristic-title">Create Post</h2>

    <?php
      // VALIDATION: Check that Error Message Type exists in GET superglobal
      if (isset($_GET['error'])) {
        // (i) Empty fields validation 
        if ($_GET['error'] == "emptyfields") {
          $errorMsg = "Please fill in all fields.";
        // (ii) Forbidden request
        } else if ($_GET['error'] == "forbidden") {
          $errorMsg = "Please submit the form correctly.";
        // (iii) 500 Internal server error (sql or server)
        } else if ($_GET['error'] == "sqlerror" || $_GET['error'] == "servererror") {
          $errorMsg = "An internal server error has occurred - please try again later.";
        }
        // (iv) ERROR CATCH-ALL:
        echo '<div class="futuristic-alert alert-danger" role="alert">' . $errorMsg . '</div>';

      // VALIDATION FOR UPLOADING:
      } else if (isset($_GET['uploaderror'])) {
        // (i) PHP File Errors 
        if ($_GET['uploaderror'] == "ini-size" || $_GET['uploaderror'] == "form-size" || $_GET['uploaderror'] == "partial" || $_GET['uploaderror'] == "no-file" || $_GET['uploaderror'] == "tmp-dir" || $_GET['uploaderror'] == "cant-write" || $_GET['uploaderror'] == "extension" ) {
          $errorMsg = "PHP upload error occurred.";
        // (ii) Incorrect file extension
        } else if ($_GET['uploaderror'] == "bad-ext") {
          $errorMsg = "Incorrect file extension. Please upload a jpg, jpeg, png, or gif file.";
        // (iii) Exceeds max file size
        } else if ($_GET['uploaderror'] == "file-size") {
          $errorMsg = "File exceeds max allowable size (2MB).";
        // (iv) File Already Exists
        } else if ($_GET['uploaderror'] == "file-exists") {
          $errorMsg = "File with this name already exists.";
        // (v) Failed upload
        } else if ($_GET['uploaderror'] == "system-error") {
          $errorMsg = "File has not uploaded correctly - please try again later.";
        }
        // (vi) ERROR CATCH-ALL:
        echo '<div class="futuristic-alert alert-danger" role="alert">' . $errorMsg . '</div>';
      }
    ?>

    <!-- 1. TITLE -->
    <div class="mb-3">
      <label for="title" class="form-label futuristic-label">Title</label>
      <input type="text" class="form-control futuristic-input" name="title" placeholder="Title" value="">
    </div>  

    <!-- SUBJECT FIELD -->
    <div class="mb-3">
      <label for="subject" class="form-label futuristic-label">Subject</label>
      <select class="form-control futuristic-input" id="subject" name="subject">
        <option value="Astronomy">Astronomy</option>
        <option value="Geology">Geology</option>
        <option value="Physics">Physics</option>
        <option value="Biology">Biology</option>
        <option value="Chemistry">Chemistry</option>
        <!-- Add more subjects as needed -->
      </select>
    </div>

    <!-- 2. IMAGE FILE UPLOAD -->
    <div class="mb-3 text-center">
      <div class="d-flex align-items-center justify-content-center" style="margin-bottom: 1rem;">
        <label for="imageFile" class="form-label futuristic-label mb-0 me-3">Upload Image</label>
        <button type="button" class="btn btn-outline-primary futuristic-button" onclick="document.getElementById('imageFile').click();">The Chosen One!</button>
      </div>
      <div class="upload-area text-center">
        <img id="imagePreview" style="max-width: 25%; height: auto; opacity: 0; transition: opacity 1.5s ease-in-out;" src="./public/assets/placeholder.png" alt="Image preview will appear here after you select an image.">
        <input type="file" class="form-control mt-3" id="imageFile" name="imageFile" onchange="previewImage(event)" style="display: none;">
      </div>
    </div>

    <!-- 3. COMMENT SECTION -->
    <div class="mb-3">
      <label for="comment" class="form-label futuristic-label">Comment</label>
      <textarea class="form-control futuristic-input" name="comment" rows="3" placeholder="Comment"></textarea>
    </div>

    <!-- REFERENCE FIELD -->
    <div class="mb-3">
      <label for="reference" class="form-label futuristic-label">Reference</label>
      <input type="text" class="form-control futuristic-input" name="reference" placeholder="Reference (e.g., Source or Website Title)">
    </div>

    <!-- 5. SUBMIT BUTTON -->
    <button type="submit" name="post-submit" class="btn btn-primary w-100 futuristic-button">Post</button>
  </form>
</main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php";
?>

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
