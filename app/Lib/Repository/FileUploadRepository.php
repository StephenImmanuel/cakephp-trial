<?php

class FileUploadRepository
{
    public function createMany($data)
    {
        ClassRegistry::init('FileUpload')->saveAll($data);
    }
}