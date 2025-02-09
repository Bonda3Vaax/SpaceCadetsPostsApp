<?php 
  // B. Declare general variables initial states 
  $directory = "uploads";
  $uploadOk = 1;
  $the_message = "";
  $the_message_ext = "";

  // F. Set PHP upload errors using superglobal error array within $_FILES
  // REF: http://php.net/manual/en/features.file-upload.errors.php

  // F.(1) We set custom message extensions depending on the number passed in by PHP when an upload error occurs
  $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
  ); 

  // C. Save upload data to variables (using $_FILES superglobal)
  if(isset($_POST['submit'])){
    // (1) File name of the temporary copy of the file stored on the server
    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    // (2) Name of the uploaded file
    $target_file = $_FILES['fileToUpload']['name'];
    // (3) Name of file type extension (converted to lower case for better handling)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // (4) Stores our URL path to the uploaded image on the server
    $directory . DIRECTORY_SEPARATOR . $target_file;

    // G (BONUS): File validation for File Size & MIME type
    $maxSize = 1024 * 1024 * 2;     // 2MB
    $imageFileSize = $_FILES['fileToUpload']['size'];
    $imageFileMimeType = mime_content_type($temp_name);

    // F.(2) Set additional error handler to pick up the PHP error number & pass back the custom message corresponding to the number
    // NOTE: $_FILES['fileToUpload']['error'];  this stores the error code if a error occurred inside the variable $the_error
    $the_error = $_FILES['fileToUpload']['error'];
    if($_FILES['fileToUpload']['error'] != 0){
      $the_message_ext = $phpFileUploadErrors[$the_error];
      $uploadOk = 0;
    }
  
    // D. Set custom error handlers
    // (1) File Already Exists
    // NOTE: We also set if statement to check if message extension is empty ($the_message_ext == "") to check there are no previous errors & stop it overriding $the_message_ext if we already have a error
    if($the_message_ext == "" && file_exists($my_url)){
      $the_message_ext = "The file already exists.";
      $uploadOk = 0;
    }

    // (2) Incorrect File Extension
    if($the_message_ext == "" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
      $the_message_ext = "File type is not allowed, please choose a jpg, png, jpeg or gif file";
      $uploadOk = 0;
    }

    // G.(1) Max File Size
    if($the_message_ext == "" && $imageFileSize > $maxSize ){
      $the_message_ext = "File is too large";
      $uploadOk = 0;
    }

    // G.(2) MIME File Type (block files posing as accepted file types)
    if($the_message_ext == "" && $imageFileMimeType != "image/jpg" && $imageFileMimeType != "image/gif" && $imageFileMimeType != "image/jpeg" && $imageFileMimeType != "image/png") {
      $the_message_ext = "File is not an accepted image type";
      $uploadOk = 0;
    }

    // E. Set our main error capture & successful upload case 
    // (1) Check for error existing by checking if uploadOk is set to 0 by an error
    if($uploadOk == 0) {
      // (a) ERROR STATE
      $the_message = "<p>Sorry, your file was not uploaded.</p>" . "<strong>Error: </strong>" . $the_message_ext;
    } else {
      // (b) SUCCESS STATE: If all ok (remains value of 1) - try to upload file to permanent location
      if(move_uploaded_file($temp_name, $directory . "/" . $target_file)){
        $the_message = "<p>File Uploaded Successfully. " . 'Preview it: <a href="' . $my_url . '" target="_blank">' . $my_url . '</a></p>';
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Image|Push</title>
  <style>
    h2 > span {
      font-weight: 800;
    }

    svg {
      color: orangered;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="text-center mb-4">
      <h2 class="display-4 mb-2">
        Image<span>Push</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-cloud-arrow-up-fill mb-1" viewBox="0 0 16 16">
          <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2z"/>
        </svg>
      </h2>
      <p class="lead">Select image to upload:</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-8">
        <!-- A. File Upload Form: START -->
        <form action="upload.php" method="POST" enctype="multipart/form-data">
          <div class="input-group mb-3">     
            <!-- File Input -->
            <input type="file" class="form-control" id="inputGroupFile" name="fileToUpload">
            <!-- Submit Button -->
            <input type="submit" value="Upload" name="submit" class="btn btn-primary input-group-text"></input>
          </div>

        </form>
        <!-- File Upload Form: START -->

        <!-- Alert Message -->
        <?php 
          // F. Create Feedback to user in event of nothing, error or success
          if($the_message == ""){
            echo null;
          } else if($uploadOk == 0){
            echo '<div class="alert alert-danger" role="alert">' . $the_message . '</div>';
          } else {
            echo '<div class="alert alert-success" role="alert">' . $the_message . '</div>';
          }
        ?>
      </div>
    </div>
  </div>  
</body>
</html>