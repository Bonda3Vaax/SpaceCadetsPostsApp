<?php
session_start();

if(isset($_POST['post-submit']) && isset($_SESSION['userId'])){
    require './connect.inc.php';

    // 1. FILE VARIABLES
    // File variables
    $fileName = $_FILES['imageFile']['name'];
    $fileTempName = $_FILES['imageFile']['tmp_name'];
    $fileError = $_FILES['imageFile']['error'];
    $fileSize = $_FILES['imageFile']['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // File restrictions
    $allowedFiles = array('jpg', 'jpeg', 'png', 'gif');
    $maxSize = 1024 * 1024 * 2;  // 2MB

    // File upload path variables
    $fileUploadPath = str_replace('/', DIRECTORY_SEPARATOR, '../public/uploads/posts');
    $fileUploadName = $_SESSION['userId'] . "_" . uniqid('', true) . ".$fileExt"; // Ensure unique filename with userId and uniqid
    $fileUploadUrl = $fileUploadPath . DIRECTORY_SEPARATOR . $fileUploadName;

    // File download path variables
    $fileDownloadUrl = './public/uploads/posts/' . $fileUploadName;

    // 2. FILE VALIDATION
    // (i) PHP File Error
    if($fileError){
      $phpFileErrors = array(
        1 => 'ini-size',
        2 => 'form-size',
        3 => 'partial',
        4 => 'no-file',
        6 => 'tmp-dir',
        7 => 'cant-write',
        8 => 'extension',
      ); 
      $fileUploadError = $phpFileErrors[$fileError];
      header("Location: ../createpost.php?uploaderror=$fileUploadError"); 
      exit();
    }

    // (ii) Incorrect file extension
    if(!in_array($fileExt, $allowedFiles)){
      header("Location: ../createpost.php?uploaderror=bad-ext"); 
      exit();
    }

    // (iii) Exceeds max file size
    if($fileSize > $maxSize){
      header("Location: ../createpost.php?uploaderror=file-size"); 
      exit();
    }

    // (iv) File Already Exists
    if(file_exists($fileUploadUrl)){
      header("Location: ../createpost.php?uploaderror=file-exists"); 
      exit();
    }

    // 3. FORM VARIABLES
    $title = $_POST['title'];
    $subject = $_POST['subject']; 
    $comment = $_POST['comment'];
    $reference = $_POST['reference'];
     // New subject field

    // 4. FORM VALIDATION
    if (empty($title) || empty($subject) || empty($comment) || empty($reference)) {
      header("Location: ../createpost.php?error=emptyfields");
      exit();
    }

    // 5. UPLOAD IMAGE TO SERVER
    $uploadResult = move_uploaded_file($fileTempName, $fileUploadUrl);
    if(!$uploadResult){
      header("Location: ../createpost.php?uploaderror=system-error"); 
      exit();
    } 

    // 6. SAVE POST 
    // (a) Template SQL Check
    $sql = "INSERT INTO posts (title, subject, imagename, comment, imagepath, reference) VALUES (?, ?, ?, ?, ?, ?)"; 
    $statement = $conn->stmt_init();
    if(!$statement->prepare($sql)){
      unlink($fileUploadUrl); // Remove the uploaded file if SQL preparation fails
      header("Location: ../createpost.php?error=sqlerror"); 
      exit();
    }

    // (b) Data Binding & Execution
    $statement->bind_param("ssssss", $title, $subject, $fileUploadName, $comment, $fileDownloadUrl, $reference);
    $statement->execute();
    if($statement->error){
      unlink($fileUploadUrl); // Remove the uploaded file if execution fails
      header("Location: ../createpost.php?error=servererror");
      exit();
    }

    // (c) SUCCESS Post Submission
    header("Location: ../posts.php?post=success"); 
    exit();

} else {
    header("Location: ../createpost.php?error=forbidden");
    exit();
}
?>
