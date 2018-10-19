<?php

namespace newday\upload\storage;

use newday\upload\core\base\Storage;
use newday\upload\core\interfaces\FileInterface;

/**
 * Class LocalStorage
 * @package newday\upload\storage
 *
 * @option string base_url
 * @option string base_path
 */
class LocalStorage extends Storage
{

    /**
     *
     * {@inheritdoc}
     *
     * @see Storage::exists()
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Storage::url()
     */
    public function url($path)
    {
        return $this->getOption('base_url') . $path;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Storage::read($path)
     */
    public function read($path)
    {
        if ($this->exists($path)) {
            return file_get_contents($path);
        } else {
            return null;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Storage::save()
     */
    public function save(FileInterface $file, $path, $copy = false)
    {
        $path = $this->getOption('base_path') . $path;

        // 创建文件夹
        $dir = dirname($path);
        is_dir($dir) || @mkdir($dir, 0755, true);

        if ($copy) {
            return copy($file->getPath(), $path);
        } else {
            return rename($file->getPath(), $path);
        }
    }


    /**
     *
     * {@inheritdoc}
     *
     * @see Storage::delete($path)
     */
    public function delete($path)
    {
        $path = $this->getOption('base_path') . $path;
        if ($this->exists($path)) {
            return unlink($path);
        } else {
            return false;
        }
    }

}