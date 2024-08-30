<!-- 导入配置 -->
<?php session_start();include('config.php');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$panTitle?></title>
    <style>
        .photo-list {
            list-style-type: none;
            padding: 0;
        }

        .photo-list li {
            margin-bottom: 10px;
            cursor: pointer;
            color: black;
            font-size: 18px;
            text-decoration: underline;
        }

        #photoViewer {
            margin-top: 20px;
            display: none;
        }

        #photoViewer img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>
    <main>
        <h1>图片列表</h1>
        <h3>正在预览：</h3>
        <div class="content">
            <ul class="photo-list mp3-list">
                <?php
                // 获取图片目录下的所有图片文件
                $photoDir = $rootDir . '/img/';
                $photoFiles = array_merge(
                    glob($photoDir . '*.jpg'),
                    glob($photoDir . '*.jpeg'),
                    glob($photoDir . '*.png')
                );

                // 打乱文件顺序
                shuffle($photoFiles);

                // 显示文件名
                foreach ($photoFiles as $file) {
                    $fileName = basename($file);  // 获取带扩展名的文件名
                    echo "<li onclick=\"showPhoto('$fileName')\" class=\"song-li\">$fileName</li>";
                }
                ?>
            </ul>
        </div>
        <div id="photoViewer">
            <h2>图片预览</h2>
            <img id="previewImage" src="" alt="图片预览">
        </div>
    </main>

    <script>
        function showPhoto(fileName) {
    var photoViewer = document.getElementById('photoViewer');
    var previewImage = document.getElementById('previewImage');

    // 确保元素存在
    if (photoViewer && previewImage) {
        // 设置图片的 src 以显示选定的图片
        previewImage.src = './API_readPhotos.php?file=' + encodeURIComponent(fileName);

        // 显示图片预览区域
        photoViewer.style.display = 'block';
    } else {
        console.error('无法找到预览区域或图片元素。');
    }
}

    </script>
</body>
</html>
