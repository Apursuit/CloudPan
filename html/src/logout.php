<?php
session_start();

// 清除会话变量
session_unset();
session_destroy();

// 重定向到首页
header('Location: ../index.php?dir=');
exit;
?>
