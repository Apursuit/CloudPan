<link rel="stylesheet" href="../styles/index.css">

<style>
        h1,h2,h3{
            color: #000;
        }
        /* light-theme */
        ul.light-theme{
            color: #000;
        }
        /* Dark Theme */
        body.dark-theme {
            background-color: #2c3e50;
            color: #fff;
        }
    </style>
<nav class="navbar">
    <div class="nav-left">
        <a href="../index.php?dir=">首页</a>
        <a href="./music.php">音乐</a>
        <a href="./photos.php">图片</a>
        <a href="./video.php">视频</a>
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
            <a href="./logout.php">退出</a>
        <?php else: ?>
            <a href="./login.php">登录</a>
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
<ul>
    <li></li>
</ul>

<script src="../js/theme.js"></script>

<footer class="footer"><p>当前处于测试阶段，bug反馈：apursuit27@gmail.com</p></footer>
