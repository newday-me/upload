<?php

namespace newday\upload;

use newday\upload\core\objects\FileInfo;
use newday\upload\core\interfaces\FileInterface;
use newday\upload\core\interfaces\FileProcessInterface;
use newday\upload\core\interfaces\FileValidateInterface;
use newday\upload\core\interfaces\StorageInterface;
use newday\upload\core\interfaces\UploadInterface;
use newday\upload\core\exceptions\UploadException;

class Upload implements UploadInterface
{
    /**
     * 验证文件
     *
     * @var string|\Closure
     */
    protected $onCheck;

    /**
     * 上传成功
     *
     * @var string|\Closure
     */
    protected $onSuccess;

    /**
     * 文件存储
     *
     * @var StorageInterface
     */
    protected $storage;

    /**
     * 文件验证
     *
     * @var array
     */
    protected $validates = [];

    /**
     * 文件处理
     *
     * @var array
     */
    protected $processes = [];

    /**
     *
     * {@inheritdoc}
     *
     * @see UploadInterface::upload()
     */
    public function upload(FileInterface $file, $path, $overwrite = false)
    {
        // 存储
        $storage = $this->getStorage();
        if (is_null($storage)) {
            throw new UploadException('请先设置存储对象');
        }

        // 处理
        foreach ($this->processes as $processor) {
            $processor->process($file);
        }

        // 验证
        foreach ($this->validates as $validate) {
            $validate->validate($file);
        }

        // 文件信息
        $info = new FileInfo();
        $info->setName($file->getName());
        $info->setSize($file->getSize());
        $info->setHash(md5_file($file->getPath()));
        $info->setMime($file->getMime());
        $info->setExtension($file->getExtension());

        // 保存路径
        $vars = [
            '{Y}' => date('Y'),
            '{m}' => date('m'),
            '{d}' => date('d'),
            '{H}' => date('H'),
            '{i}' => date('i'),
            '{s}' => date('s'),
            '{hash}' => $info->getHash(),
            '{ext}' => $info->getExtension()
        ];
        $path = str_replace(array_keys($vars), array_values($vars), $path);
        $info->setPath($path);

        // 上传验证
        $this->execHandler($this->onCheck, $info);

        // 保存文件
        if (empty($info->getUrl())) {
            if ($overwrite || !$storage->exists($path)) {
                $storage->save($file, $path);
            }
            $info['url'] = $storage->url($path);
        }

        // 上传成功
        $this->execHandler($this->onSuccess, $info);

        return $info;
    }

    /**
     * 文件验证的处理
     *
     * @param string|\Closure $onCheck
     */
    public function setOnCheckHandler($onCheck)
    {
        $this->onCheck = $onCheck;
    }

    /**
     * 文件上传成功的处理
     *
     * @param string|\Closure $onSuccess
     */
    public function setOnSuccessHandler($onSuccess)
    {
        $this->onSuccess = $onSuccess;
    }

    /**
     * 执行处理器
     *
     * @param string|\Closure $handler
     * @param FileInfo $info
     * @return mixed
     */
    protected function execHandler($handler, $info)
    {
        try {
            if (is_null($handler)) {
                return null;
            } elseif ($handler instanceof \Closure) {
                return $handler($info, $this);
            }
            if (strpos($handler, '::')) {
                $handler = explode('::', $handler, 2);
                return call_user_func_array($handler, [
                    $info,
                    $this
                ]);
            } else {
                return call_user_func_array($handler, [
                    $info,
                    $this
                ]);
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see UploadInterface::addValidate()
     */
    public function addValidate(FileValidateInterface $validate)
    {
        $this->validates[] = $validate;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see UploadInterface::addProcesser()
     */
    public function addProcess(FileProcessInterface $process)
    {
        $this->processes[] = $process;
    }

    /**
     * 设置存储对象
     *
     * @param StorageInterface $storage
     * @return void
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * 获取存储对象
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * 重设上传
     *
     * @return void
     */
    protected function resetUpload()
    {
        $this->validates = [];
        $this->processes = [];
    }

}