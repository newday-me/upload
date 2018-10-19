<?php

namespace newday\upload\core\interfaces;

use newday\upload\core\objects\FileInfo;

interface UploadInterface
{

    /**
     * 上传文件
     *
     * @param FileInterface $file
     * @param string $path
     * @param boolean $overwrite
     *
     * @throws \Exception
     * @return FileInfo
     */
    public function upload(FileInterface $file, $path, $overwrite = false);

    /**
     * 添加文件验证
     *
     * @param FileValidateInterface $validate
     *
     * @return void
     */
    public function addValidate(FileValidateInterface $validate);

    /**
     * 添加文件处理
     *
     * @param FileProcessInterface $process
     *
     * @return void
     */
    public function addProcess(FileProcessInterface $process);

}