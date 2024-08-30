<?php
include 'config.php'; // 引入配置文件

// 获取文件名并确保路径安全
$file = isset($_GET['file']) ? $_GET['file'] : '';
$file = basename($file); // 确保路径安全

// 构建文件路径
$filePath = realpath($rootDir . '/mp3/' . $file);

// 验证文件路径是否在允许的目录内
if ($filePath !== false && strpos($filePath, realpath($rootDir)) === 0 && file_exists($filePath)) {
    // 确保文件是 MP3 文件
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    if (strtolower($ext) === 'mp3') {
        // 设置适当的 HTTP 头部
        header('Content-Type: audio/mpeg'); // MP3 文件的 MIME 类型
        header('Content-Description: File Transfer');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"'); // 使用 inline 以便于在浏览器中直接播放
        flush(); // 刷新系统输出缓冲区
        readfile($filePath); // 读取文件并输出到浏览器
        exit;
    } else {
        echo '不允许访问非 MP3 文件。';
    }
} else {
    echo '文件不存在或无权访问。';
}
?>
