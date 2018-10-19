<?php

namespace cms\upload\validate;

use newday\upload\core\base\Validate;
use newday\upload\core\interfaces\FileInterface;
use newday\upload\core\exceptions\FileValidateException;

/**
 * Class ExtensionValidate
 * @package newday\upload\validate
 *
 * @option string min_size
 * @option string max_size
 */
class FileSizeValidate extends Validate
{

    /**
     *
     * {@inheritdoc}
     *
     * @see FileValidateInterface::validate()
     */
    public function validate(FileInterface $file)
    {
        // 最小值判断
        $minSize = $this->translateBytes($this->getOption('min_size'));
        if ($minSize && $file->getSize() < $minSize) {
            throw new FileValidateException('文件小于允许文件上传的最小值[' . $this->formatBytes($minSize) . ']');
        }

        // 最大值判断
        $maxSize = $this->translateBytes($this->getOption('max_size'));
        if ($maxSize && $file->getSize() > $maxSize) {
            throw new FileValidateException('文件超过允许文件上传的最大值[' . $this->formatBytes($maxSize) . ']');
        }

        return true;
    }

    /**
     * 转换文件大小
     *
     * @param string $size
     *
     * @return integer
     */
    public function translateBytes($size)
    {
        $units = [
            'k' => 1,
            'm' => 2,
            'g' => 3,
            't' => 4,
            'p' => 5
        ];
        $size = strtolower($size);
        $bytes = intval($size);
        foreach ($units as $key => $value) {
            if (strpos($size, $key)) {
                $bytes = $bytes * pow(1024, $value);
                break;
            }
        }
        return $bytes;
    }

    /**
     * 文件大小格式化
     *
     * @param number $size
     * @param string $delimiter
     * @return string
     */
    public function formatBytes($size, $delimiter = '')
    {
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
            'PB'
        ];
        for ($i = 0; $size >= 1024 && $i < 5; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . $delimiter . $units[$i];
    }

}