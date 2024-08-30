<!-- 导入配置 -->
<?php session_start();include('config.php');?>
<?php
// 检查用户是否登录
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // 用户未登录，重定向到 login.php
    header('Location: ./login.php');
    exit;
}

$isLoggedIn = true; // 用户已登录
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$panTitle?></title>
    <style>
        .video-list {
            list-style-type: none;
            padding: 0;
        }

        .video-list li {
            margin-bottom: 10px;
            cursor: pointer;
            color: black;
            font-size: 18px;
            text-decoration: underline;
        }

        #videoViewer {
            margin: 20px auto;
            text-align: center;
            display: none;
            width: 100%;
            max-width: 100%; 
        }

        #videoViewer video {
            width: 100%; 
            height: 100%;
            object-fit: cover;
            border-radius: 8px; 
        }

    </style>
</head>
<body>
<?php include "navbar.php"; ?>
    <main>
        <h1>视频列表</h1>
        <h3>正在预览：</h3>
        <div class="content">
            <ul class="video-list mp3-list">
                <?php
                $videoDir = $panDir . '/video/';
                $videoFiles = array_merge(
                    glob($videoDir . '*.mp4'),
                    glob($videoDir . '*.webm'),
                    glob($videoDir . '*.ogv')
                );

                // 打乱文件顺序
                shuffle($videoFiles);
                // 显示文件名
                foreach ($videoFiles as $file) {
                    $fileName = basename($file);  // 获取带扩展名的文件名
                    echo "<li onclick=\"showVideo('$fileName')\" class=\"song-li\">$fileName</li>";
                }
                ?>
            </ul>
        </div>
        <div id="videoViewer">
            <h2>在线播放</h2>
            <video id="previewVideo" controls>
                <source id="videoSource" src="" type="">
                您的浏览器不支持视频播放。
            </video>
        </div>
    </main>

    <script>
function showVideo(fileName) {
    var videoViewer = document.getElementById('videoViewer');
    var videoElement = document.getElementById('previewVideo');
    var videoSource = document.getElementById('videoSource');

    // 打印调试信息
    console.log('Selected file:', fileName);

    // 设置 MIME 类型
    var mimeType = '';
    var extension = fileName.split('.').pop().toLowerCase();

    switch (extension) {
        case 'mp4':
            mimeType = 'video/mp4';
            break;
        case 'webm':
            mimeType = 'video/webm';
            break;
        case 'ogv':
            mimeType = 'video/ogg';
            break;
        default:
            console.error('Unsupported video format:', extension);
            return;
    }

    // 打印调试信息
    console.log('Setting video source to:', './API_readVideo.php?file=' + encodeURIComponent(fileName));
    console.log('Setting video type to:', mimeType);

    videoSource.src = './API_readVideo.php?file=' + encodeURIComponent(fileName);
    videoSource.type = mimeType;

    // 重新加载视频元素
    videoElement.load();

    // 打印调试信息
    console.log('Video source set, displaying video viewer.');

    // 显示视频预览区域
    videoViewer.style.display = 'block';
}
    </script>
</body>
</html>
