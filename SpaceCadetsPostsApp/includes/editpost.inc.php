<?php
session_start();
 

if(isset($_POST['edit-submit']) && isset($_SESSION['userId'])){
    require './connect.inc.php';

    // Form variables
    $id = $conn->real_escape_string($_GET['id']); 
    $id = intval($id);
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $comment = $_POST['comment'];
    $reference = $_POST['reference'];
    $oldImagePath = $_POST['oldImagePath'];
    
    // Include the logError function
    require './logError.php';

    // VALIDATION: 
    if (empty($id) || empty($title) || empty($subject) ||empty($comment) || empty($reference)) {
        logError("Validation failed: Empty fields in edit post form for post ID $id by user {$_SESSION['userId']}");
        header("Location: ../editpost.php?id=$id&error=emptyfields");
        exit();
    }

    // Check if a new image file is being uploaded
    $fileUploadName = null;
    $fileDownloadUrl = null;
    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === 0) {
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
        $fileUploadName = $_SESSION['userId'] . "_" . uniqid() . "." . $fileExt;
        $fileUploadUrl = $fileUploadPath . DIRECTORY_SEPARATOR . $fileUploadName;
        $fileDownloadUrl = './public/uploads/posts/' . $fileUploadName;

        // FILE VALIDATION
        if(!in_array($fileExt, $allowedFiles)){
            logError("Invalid file extension: $fileExt for user {$_SESSION['userId']}");
            header("Location: ../editpost.php?id=$id&error=bad-ext");
            exit();
        }

        if($fileSize > $maxSize){
            logError("File size exceeds limit: $fileSize bytes for user {$_SESSION['userId']}");
            header("Location: ../editpost.php?id=$id&error=file-size");
            exit();
        }

        // UPLOAD IMAGE TO SERVER
        $uploadResult = move_uploaded_file($fileTempName, $fileUploadUrl);
        if(!$uploadResult){
            logError("Failed to upload file: $fileName for user {$_SESSION['userId']}");
            header("Location: ../editpost.php?id=$id&error=file-upload-error");
            exit();
        } 

        // Delete old image file if a new one is uploaded
        if ($oldImagePath && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    // UPDATE POST 
    if ($fileUploadName) {
        $sql = "UPDATE posts SET title=?, subject=?, comment=?, reference=?, imagename=?, imagepath=? WHERE id=?"; 
    } else {
        $sql = "UPDATE posts SET title=?, subject=?, comment=?, reference=? WHERE id=?";
    }

    $statement = $conn->stmt_init();
    if(!$statement->prepare($sql)){
        logError("SQL error during post update for user {$_SESSION['userId']} with post ID $id");
        header("Location: ../editpost.php?id=$id&error=sqlerror");
        exit();
    }

    // Bind parameters depending on whether an image was uploaded
    if ($fileUploadName) {
        $statement->bind_param("ssssssi", $title, $subject, $comment, $referencew, $fileUploadName, $fileDownloadUrl, $id);
    } else {
        $statement->bind_param("ssssi", $title, $subject, $comment, $reference, $id);
    }

    $statement->execute();
    if($statement->error){
        logError("SQL execution error during post update for user {$_SESSION['userId']} with post ID $id: " . $statement->error);
        header("Location: ../editpost.php?id=$id&error=servererror");
        exit();
    }

    // SUCCESS Edit Post
    header("Location: ../posts.php?id=$id&edit=success");
    exit();

} else {
    header("Location: ../signup.php");
    exit();
}
?>
