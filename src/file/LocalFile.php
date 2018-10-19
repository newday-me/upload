<?php

namespace newday\upload\file;

use newday\upload\core\base\File;
use newday\upload\core\exceptions\FileException;

class LocalFile extends File
{

    /**
     *
     * {@inheritdoc}
     *
     * @see FileInterface::load()
     */
    public function load($file)
    {
        $this->filePath = $file;

        if (!is_file($this->filePath)) {
            throw new FileException('文件[' . $file . ']不存在');
        }

        return true;
    }

}