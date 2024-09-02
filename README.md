# 极简云盘

在国内网盘没有充值会员时，速度比较慢，体验不佳。写一个php网盘管理项目(nas)，当前处于测试阶段。

编写语言：PHP

| 贡献者 | 我   | chatGPT |
| ------ | ---- | ------- |
|        | 5%   | 95%     |

适用场景：局域网

测试：当前仅测试了linux

漏洞及安全问题：未知，很可能存在漏洞，建议局域网下自己玩玩

其他：局域网共享文件夹似乎比这个方案好一些？🤐

想法：一个二手随身wifi刷armbian，挂个机械盘(极简nas??)

## 使用

项目地址：[【极简云盘】](https://github.com/Apursuit/CloudPan)

把html里的文件复制到/var/www/html目录下

创建盘根目录/var/www/pan，如果把其他目录作为盘根目录，在配置文件里修改

权限相关：

由于并不熟悉linux权限知识，我给的权限是

```bash
chown -R www-data:www-data /var/www/pan
chmod -R 755 /var/www/pan
```
现在www-data用户可以访问文件，上传文件，创建文件夹了

在盘根目录下，创建img，mp3，video等文件夹，否则在线音乐，在线图片，在线视频功能无法正常使用

## 功能

现在有以下功能

- 在线下载
- 切换主题
- 在线播放音乐
- 在线预览图片
- 视频在线播放

需登录管理员适用以下功能

- 登录验证
- 文件上传
- 新建文件夹

删除文件及文件夹功能没有写，需要管理员在服务端自行删除

## 效果图

桌面端效果图

![首页](https://the0n3.top/medias/cloudpan/index.png)

![主题](https://the0n3.top/medias/cloudpan/dark.png)

![登录](https://the0n3.top/medias/cloudpan/login.png)

![在线音乐](https://the0n3.top/medias/cloudpan/music.png)

![预览图片](https://the0n3.top/medias/cloudpan/photos.png)

![在线视频](https://the0n3.top/medias/cloudpan/video.png)

移动端效果图

![首页](https://the0n3.top/medias/cloudpan/index.jpg)

![在线音乐](https://the0n3.top/medias/cloudpan/music.jpg)

![预览图片](https://the0n3.top/medias/cloudpan/img.jpg)

![在线视频](https://the0n3.top/medias/cloudpan/video.jpg)


## 配置文件config.php

```php
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

# 获取音乐目录MP3下的所有MP3文件
$musicDir = $panDir . '/mp3/';
# 获取视频目录video下的所有视频文件
# 此处取消注释会报错
# $videoDir = $panDir . '/video/';

# admin超管账号，默认admin password，看到这里，请手动生成你的用户名和密码，换为md5摘要，不要明文存储
$username = "admin";
$password = "password";
$predefinedMd5Hash = md5($username.":".$password);

# 配置php允许上传文件的最大大小
# php.ini相关配置已通过user.ini设置上限为1GB

# 配置nginx允许上传文件的最大大小
# 需要在nginx配置文件的server或location中添加下面配置，使能够上传1M大小以上的文件
# nginx配置文件常见位置：/etc/nginx/sites-available/default
# client_max_body_size 1024M;

# 路径处理
$dir = isset($_GET['dir']) ? urldecode($_GET['dir']) : '';
$fullPath = realpath($panDir . '/' . $dir);

if ($fullPath === false || strpos($fullPath, $panDir) !== 0) {
    $rootDir = $panDir;
} else {
    $rootDir = $fullPath;
}
```

## 样式

所有样式都堆在了styles/index.css里，依托石山。有...有兴趣可以试着修改。

## 更新日志

- 2024-09-02：去除在线视频需要登录的限制。发布v1.0.0版本，功能基础的网盘，满足在线影音
- 2024-09-01：修复子目录文件无法下载
- 2024-08-30：添加.user.ini文件，免除手动修改php.ini的麻烦
- 2024-08-30：上传功能，登录功能，视频播放功能，音乐播放功能，图片预览功能，管理员功能
