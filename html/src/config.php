<?php
# 更多图标，请自行到https://www.iconfinder.com/search/icons/related/7077519
$panTitle = "极简盘";
$icons = [
    'txt' => 'icons/txt_icon.png',
    'php' => 'icons/php_icon.png',
    'java' => 'icons/java_icon.png',
    'mp4' => 'icons/mp4_icon.png',
    'xml' => 'icons/xml_icon.png',
    'pdf' => 'icons/pdf_icon.png',
    'doc' => 'icons/word_icon.png',
    'docx' => 'icons/word_icon.png',
    'mp3' => 'icons/mp3_icon.png',
    'png' => 'icons/png_icon.png',
    'jpg' => 'icons/jpg_icon.png',
    'md' => 'icons/md_icon.png',
    'zip' => 'icons/zip_icon.png',
    'html' => 'icons/html_icon.png',
    'folder' => 'icons/folder_icon.png',
];


# 网盘根目录，建议绝对路径。并且不要放在web目录下，否则可能造成文件上传等漏洞
# 禁止web父级目录直接作为根目录
$panDir = "/var/www/pan";

// 获取音乐目录MP3下的所有MP3文件
$musicDir = $panDir . '/mp3/';
// 获取视频目录video下的所有视频文件
# 此处取消注释会报错
// $videoDir = $panDir . '/video/';


$dir = isset($_GET['dir']) ? urldecode($_GET['dir']) : '';

$fullPath = realpath($panDir . '/' . $dir);

if ($fullPath === false || strpos($fullPath, $panDir) !== 0) {
    $rootDir = $panDir;
} else {
    $rootDir = $fullPath;
}

# admin超管账号，默认admin password，看到这里，请手动生成你的用户名和密码，换为md5摘要，不要明文存储
// $predefinedMd5Hash = md5("$username".":"."$password");
$predefinedMd5Hash = '73eff6386ce2091b5ca702fc007e1da9';

# 允许上传文件的最大大小。
# 允许上传文件的最大大小。
# php.ini
// upload_max_filesize = 1024M
// post_max_size = 1024M
// memory_limit = 1024M
# nginx
//client_max_body_size 1024M;