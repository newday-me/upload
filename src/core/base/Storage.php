<?php

namespace newday\upload\core\base;

use newday\upload\core\traits\OptionTrait;
use newday\upload\core\interfaces\StorageInterface;

abstract class Storage implements StorageInterface
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