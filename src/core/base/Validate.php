<?php

namespace newday\upload\core\base;

use newday\upload\core\traits\OptionTrait;
use newday\upload\core\interfaces\FileValidateInterface;

abstract class Validate implements FileValidateInterface
{

    /**
     * 配置Trait
     */
    use OptionTrait;

    /**
     * 构造函数
     *
     * @param array $option
     */
    public function __construct($option = [])
    {
        $this->setOption($option);
    }

}