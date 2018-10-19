<?php

namespace newday\upload\validate;

use newday\upload\core\base\Validate;
use newday\upload\core\interfaces\FileInterface;
use newday\upload\core\exceptions\FileValidateException;

/**
 * Class ExtensionValidate
 * @package newday\upload\validate
 *
 * @option array extensions
 */
class ExtensionValidate extends Validate
{

    /**
     *
     * {@inheritdoc}
     *
     * @see FileValidateInterface::validate()
     */
    public function validate(FileInterface $file)
    {
        // 后缀判断
        $extensions = $this->getOption('extensions');
        if (is_array($extensions) && !in_array($file->getExtension(), $extensions)) {
            throw new FileValidateException('不允许上传后缀为[' . $file->getExtension() . ']的文件');
        }

        return true;
    }

}