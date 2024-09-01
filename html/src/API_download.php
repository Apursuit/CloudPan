<?php
include("config.php");

if (isset($_GET['file'])) {
    // 对文件名进行 URL 解码
    $filePath = urldecode($_GET['file']);

    // 确保文件路径在根目录下，并且文件存在
    if ($filePath !== false && strpos($filePath, $rootDir) === 0 && file_exists($filePath)) {
        // 进一步检查文件是否确实是一个文件（不是目录）
        if (is_file($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            flush(); 
            readfile($filePath);
            exit;
        } else {
            // 文件路径不是文件
            header("HTTP/1.1 400 Bad Request");
            echo '请求的路径不是一个文件。';
            exit;
        }
    } else {
        // 文件不存在或路径不在根目录下
        header("HTTP/1.1 404 Not Found");
        echo '文件不存在或无权访问。';
        exit;
    }
} else {
    // 无效的请求
    header("HTTP/1.1 400 Bad Request");
    echo '无效的下载请求。';
    exit;
}
?>
