<?php

namespace App\Services;

use App\Contracts\FileContentReaderInterface;

class FileContentReader implements FileContentReaderInterface
{
    public function getFileContent(string $filePath): string
    {
        return file_get_contents($filePath);
    }
}