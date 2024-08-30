<?php
include"config.php";
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // 使用 basename 以确保文件名安全
    $filePath = realpath($rootDir . '/' . $file);

    // 确保文件路径在根目录下
    if ($filePath !== false && strpos($filePath, $rootDir) === 0 && file_exists($filePath)) {
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
        echo '文件不存在。';
    }
} else {
    echo '无效的下载请求。';
}
?>
