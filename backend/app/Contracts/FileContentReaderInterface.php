<?php
namespace App\Contracts;

interface FileContentReaderInterface
{
    public function getFileContent(string $filePath): string;
}