<?php
include 'config.php'; // 引入配置文件

// 获取文件名并确保路径安全
$file = isset($_GET['file']) ? $_GET['file'] : '';
$file = basename($file); // 确保路径安全

// 构建文件路径
$videoDir = $panDir . '/video/';
$filePath = realpath($videoDir . $file);

// 验证文件路径是否在允许的目录内
if ($filePath !== false && strpos($filePath, realpath($rootDir)) === 0 && file_exists($filePath)) {
    // 确保文件是允许的视频类型
    $mimeTypes = [
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'ogv' => 'video/ogg'
    ];
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if (array_key_exists($ext, $mimeTypes)) {
        // 设置适当的 HTTP 头部
        header('Content-Type: ' . $mimeTypes[$ext]);
        header('Content-Description: File Transfer');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"'); // 使用 inline 以便于在浏览器中直接播放
        readfile($filePath); // 读取文件并输出到浏览器
        exit;
    } else {
        echo '不允许访问非视频文件。';
    }
} else {
    echo '文件不存在或无权访问。';
}
?>
