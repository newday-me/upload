<?php

namespace newday\upload\core\objects;

class FileInfo
{

    /**
     * 链接
     *
     * @var string
     */
    protected $url;

    /**
     * 路径
     *
     * @var string
     */
    protected $path;

    /**
     * 文件名
     *
     * @var string
     */
    protected $name;

    /**
     * 文件大小
     *
     * @var integer
     */
    protected $size;

    /**
     * 哈希值
     *
     * @var string
     */
    protected $hash;

    /**
     * 扩展类型
     *
     * @var string
     */
    protected $mime;

    /**
     * 后缀名
     *
     * @var string
     */
    protected $extension;

    /**
     * 获取链接
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 设置链接
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * 设置路径
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 获取路径
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * 获取文件名
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置文件名
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 获取文件大小
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * 设置文件大小
     *
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * 获取哈希值
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * 设置哈希值
     *
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * 获取后缀名
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * 设置后缀名
     *
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * 获取扩展类型
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * 设置扩展类型
     *
     * @param string $mime
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
    }
}