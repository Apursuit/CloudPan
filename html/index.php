<?php
# 导入配置
session_start();
include("./src/config.php");
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

// 获取根目录下的文件和文件夹
$dir = isset($_GET['dir']) ? urldecode($_GET['dir']) : '';
$currentDir = realpath($panDir . '/' . $dir);

if ($currentDir === false || strpos($currentDir, $panDir) !== 0) {
    $currentDir = $panDir;
}

$files = scandir($currentDir);

// 返回上一级目录
function getParentDir($dir) {
    $parentDir = dirname($dir);
    return $parentDir === '.' ? '' : $parentDir;
}

// 处理创建文件夹请求
umask(0022);
if ($isLoggedIn && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['folder_name'])) {
        $folderName = $_POST['folder_name'];

        // 验证文件夹名是否符合要求
        if (preg_match('/^[\p{L}\p{N}_-]+$/u', $folderName)) {
            $newFolderPath = $currentDir . '/' . $folderName;

            // 验证文件夹是否已经存在
            if (is_dir($newFolderPath)) {
                $message = '文件夹已存在。';
            } else {
                // 创建文件夹
                mkdir($newFolderPath);
                $message = '文件夹创建成功。';
                header("Location: index.php?dir=" . urlencode($dir)); // 重定向回当前目录
                exit; // 确保脚本在重定向后停止执行
            }
        } else {
            $message = '文件夹名只允许包含字母、数字、汉字、减号和下划线。';
        }        
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?=$panTitle?></title>
    <link rel="stylesheet" href="styles/index.css?v=1.0">
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="index.php?dir=">首页</a>
            <a href="./src/music.php">音乐</a>
            <a href="./src/photos.php">图片</a>
            <a href="./src/video.php">视频</a>
            <?php if ($isLoggedIn): ?>
                <!-- 如果用户已登录，显示退出选项 -->
                <a href="./src/logout.php">退出</a>
            <?php else: ?>
                <!-- 如果用户未登录，显示登录选项 -->
                <a href="./src/login.php">登录</a>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <div class="theme-toggle">
                <span class="theme-icon" id="theme-toggle-icon">
                    <!-- Sun Icon -->
                    <span class="sun" id="sun-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" height="24">
                            <circle cx="12" cy="12" r="5" />
                            <path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M16.36 16.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M16.36 7.64l1.42-1.42"/>
                        </svg>
                    </span>
                    <!-- Moon Icon -->
                    <span class="moon" id="moon-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                        </svg>
                    </span>
                </span>
            </div>
        </div>
    </nav>
    <main>
        <h1>在线网盘</h1>
        <!-- 未登录不显示 -->
        <?php if ($isLoggedIn): ?>
        <div class="box">
            <!-- 创建文件夹表单 -->
            <form method="post">
                <input type="text" name="folder_name" placeholder="输入文件夹名称" required>
                <button type="submit" class="newFolder">创建文件夹</button>
            </form>
            <?php if (isset($message)): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="./src/upload.php?dir=<?php echo urlencode($_GET['dir']); ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="file" required>
                <button type="submit" class="upload">上传</button>
            </form>
        </div>
        <?php endif; ?>
        <div class="content">
            <ul>
                <?php

                // 显示返回上一级目录的链接
                if ($rootDir !== realpath($panDir)) {
                    echo '<li class="folder"><a href="index.php?dir=' . urlencode(getParentDir($_GET['dir'])) . '"><img src="icons/folder_icon.png" alt="icon" class="icon-img"> 返回上一级</a></li>';
                }

                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $filePath = $currentDir . '/' . $file;
                        $relativePath = $dir ? $dir . '/' . $file : $file; // 相对路径
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        
                        if (is_dir($filePath)) {
                            $icon = '<img src="' . $icons['folder'] . '" alt="icon" class="icon-img">';
                            echo '<li class="folder"><a href="index.php?dir=' . urlencode($relativePath) . '">' . $icon . $file . '</a></li>';
                        } else {
                            $fileUrl = './src/API_download.php?file=' . urlencode($filePath); // 自动生成下载链接
                            $icon = isset($icons[$ext]) ? '<img src="' . $icons[$ext] . '" alt="icon" class="icon-img">' : '<img src="icons/file_icon.png" alt="icon" class="icon-img">';
                            echo '<li class="file">' . $icon . $file . '<a href="' . $fileUrl . '" download><div class="download-btn"><i class="fa-solid fa-download"></i> 下载</div></a></li>';
                        }
                    }
                }
                
                ?>
            </ul>
        </div>
    </main>
    <script src="js/theme.js"></script>
</body>
</html>
