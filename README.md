文件
-------

```php
use newday\upload\file\LocalFile;
use newday\upload\file\RemoteFile;
use newday\upload\file\StreamFile;
use newday\upload\file\UploadFile;

// 本地文件
$localPath = __FILE__;
$localFile = new LocalFile();
$localFile->load($localPath);

// 流文件
$content = 'This is content';
$streamFile = new StreamFile();
$streamFile->load($content);

// 远程文件
$url = 'http://www.xxx.com/logo.png';
$remoteFile = new RemoteFile();
$remoteFile->load($url);

// 上传文件
$file = $_FILES['upfile'];
$uploadFile = new UploadFile();
$uploadFile->load($file);

// 文件属性
echo 'path:' . $localFile->getPath() . '<br/>';
echo 'name:' . $localFile->getName() . '<br/>';
echo 'size:' . $localFile->getSize() . '<br/>';
echo 'mime:' . $localFile->getMime() . '<br/>';
echo 'extension:' . $localFile->getExtension() . '<br/>';
echo 'content:<pre>' . $localFile->getContent() . '</pre>';
```

存储
-------

```php
use newday\upload\storage\LocalStorage;

$localStorage = new LocalStorage();
$localStorage->setOption([
    'base_root' => 'D:/www/site/upload/',
    'base_url' => 'http://www.xxx.com/upload/'
]);

$savePath = '/raw/code.html';
$localStorage->save($localFile, $savePath);

echo 'exist:' . $localStorage->exists($savePath) ? 'true' : 'false' . '<br/>';
echo 'url:' . $localStorage->url($savePath) . '<br/>';
echo '<pre>' . $localStorage->read($savePath) . '<pre>';
```

上传
-------

```php
use newday\upload\Upload;

$upload = new Upload();
$upload->setStorage($localStorage);
$fileInfo = $upload->upload($localFile, '/{Y}{m}{d}/{hash}.{ext}');

echo 'url:' . $fileInfo->getUrl() . '<br/>';
echo 'path:' . $fileInfo->getPath() . '<br/>';
echo 'name:' . $fileInfo->getName() . '<br/>';
echo 'size:' . $fileInfo->getSize() . '<br/>';
echo 'hash:' . $fileInfo->getHash() . '<br/>';
echo 'extension:' . $fileInfo->getExt() . '<br/>';
```

其他
-------
有需要可上传时增加文件验证（大小限制、扩展限制）、文件处理（图片裁剪、图片压缩）等。