<!-- 导入配置 -->
<?php session_start();include('config.php');?>
<?php
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

if (!$isLoggedIn) {
    header("Location: ../index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDir = $rootDir;


    error_log("Upload Directory: $uploadDir");
    error_log("File Name: " . basename($file['name']));
    error_log("Temporary File Path: " . $file['tmp_name']);
    error_log("File Error Code: " . $file['error']);
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . '/' . basename($file['name']);

        // Attempt to move the file
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $message = '文件上传成功。';
            error_log("File successfully moved to $uploadFile");
        } else {
            $message = '文件上传失败。';
            error_log("Failed to move uploaded file to $uploadFile");
        }
    } else {
        $message = '上传过程中出现错误。';
        error_log("File upload error code: " . $file['error']);
    }
}

// Redirect to the index page
header("Location: ../index.php?dir=" . urlencode($_GET['dir']));
exit;
?>
