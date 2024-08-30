<?php
# 导入配置
session_start();include('config.php');

function isBanned($ip) {
    $bans = isset($_SESSION['bans']) ? $_SESSION['bans'] : [];
    if (isset($bans[$ip])) {
        $banned_until = $bans[$ip];
        if (time() < $banned_until) {
            return true;
        } else {
            unset($bans[$ip]);
            $_SESSION['bans'] = $bans;
        }
    }
    return false;
}

function handleLogin($username, $password) {
    global $predefinedMd5Hash;

    $combined = $username . ':' . $password;
    $userMd5Hash = md5($combined);

    return ($userMd5Hash === $predefinedMd5Hash);
}

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    header('Location: ../index.php?dir=');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $ip = $_SERVER['REMOTE_ADDR'];

    if (isBanned($ip)) {
        $message = '禁止登录！请稍后再次尝试。';
    } else {
        if (handleLogin($username, $password)) {
            $_SESSION['user_logged_in'] = true;
            header('Location: ../index.php?dir='); 
            exit;
        } else {
            if (!isset($_SESSION['failed_attempts'][$ip])) {
                $_SESSION['failed_attempts'][$ip] = 0;
            }
            $_SESSION['failed_attempts'][$ip]++;
            
            if ($_SESSION['failed_attempts'][$ip] >= 5) {
                $_SESSION['bans'][$ip] = time() + 600; // Ban for 10 minutes
                unset($_SESSION['failed_attempts'][$ip]);
                $message = '错误次数过多，禁止登录！';
            } else {
                $message = '用户名或密码错误！';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$panTitle?></title>
    <link rel="stylesheet" href="../styles/index.css?v=1.0">
</head>
<body>
    <?php include("navbar.php");?>
    <div class="login-container">
        <h2>登录</h2>
        <form method="post" action="login.php">
            <label for="username">用户名:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">密码:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">登录</button>
        </form>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
