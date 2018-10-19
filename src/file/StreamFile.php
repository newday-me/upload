<?php

namespace newday\upload\file;

use newday\upload\core\exceptions\FileException;

class StreamFile extends LocalFile
{

    /**
     * 临时文件
     *
     * @var string
     */
    protected $tempFile;

    /**
     * 临时路径
     *
     * @var string
     */
    protected $tempPath;

    /**
     *
     * {@inheritdoc}
     *
     * @see LocalFile::load()
     */
    public function load($file)
    {
        if (empty($file)) {
            throw new FileException('文件内容为空');
        }

        $tempPath = $this->getTempPath();
        is_dir($tempPath) || @mkdir($tempPath, 0755, true);
        if (!is_writable($tempPath)) {
            throw new FileException('临时文件夹不可写入');
        }

        $this->tempFile = $tempPath . '/' . $this->getUniqueName();
        file_put_contents($this->tempFile, $file);

        return parent::load($this->tempFile);
    }

    /**
     * 获取唯一文件名
     *
     * @return string
     */
    public function getUniqueName()
    {
        return microtime(true) . '_' . uniqid();
    }

    /**
     * 获取临时文件夹
     *
     * @return string
     */
    public function getTempPath()
    {
        if ($this->tempPath) {
            return $this->tempPath;
        } else {
            return sys_get_temp_dir();
        }
    }

    /**
     * 设置临时路径
     *
     * @param string $tempPath
     */
    public function setTempPath($tempPath)
    {
        $this->tempPath = $tempPath;
    }

    /**
     * 删除临时文件
     */
    public function __destruct()
    {
        @unlink($this->tempFile);
    }
}