<!-- 导入配置 -->
<?php session_start();include('config.php');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$panTitle?></title>
    <link rel="stylesheet" href="../styles/index.css?v=1.0">
</head>
<body>
<?php include"navbar.php";?>
    <main>
        <h1>音乐列表</h1>
        <h3>当前播放：</h3>
                <!-- 音频播放器 -->
                <audio id="audioPlayer" controls>
                    <source id="audioSource" src="" type="audio/mpeg">
                    您的浏览器不支持音频播放。
                </audio>
        <div class="content">
            <ul class="mp3-list">
                <?php
                $mp3Files = glob($musicDir . '*.mp3');

                // 打乱文件顺序
                shuffle($mp3Files);

                // 显示MP3文件（隐藏 .mp3 扩展名）
                foreach ($mp3Files as $file) {
                    $fileName = pathinfo($file, PATHINFO_FILENAME);  // 获取不带扩展名的文件名
                    echo "<li onclick=\"playMusic('$fileName.mp3')\" data-file=\"$fileName.mp3\" class=\"song-li\">$fileName</li>";
                }
                ?>
            </ul>
        </div>
    </main>

    <script>
        var audioPlayer = document.getElementById('audioPlayer');
        var audioSource = document.getElementById('audioSource');
        var currentTrackIndex = -1;
        var tracks = [];

        function playMusic(fileName) {
            audioSource.src = './API_readMusic.php?file=' + encodeURIComponent(fileName);
            audioPlayer.load();
            audioPlayer.play();
            currentTrackIndex = tracks.indexOf(fileName);

            // 更新当前播放的歌曲名
            document.querySelector('h3').innerText = `当前播放：${fileName}`;
        }

        function playPause() {
            if (audioPlayer.paused) {
                audioPlayer.play();
            } else {
                audioPlayer.pause();
            }
        }

        function previousTrack() {
            if (tracks.length > 0) {
                currentTrackIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
                playMusic(tracks[currentTrackIndex]);
            }
        }

        function nextTrack() {
            if (tracks.length > 0) {
                currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
                playMusic(tracks[currentTrackIndex]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var listItems = document.querySelectorAll('.mp3-list li');
            listItems.forEach(function(item) {
                tracks.push(item.getAttribute('data-file').trim());
            });
        });

        audioPlayer.addEventListener('ended', function() {
            alert('播放完成');
            // 播放下一首歌曲
            nextTrack();
        });
    </script>
</body>
</html>
