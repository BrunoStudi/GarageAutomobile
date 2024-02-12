<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImagesService
{
    public function upload(UploadedFile $file, string $directory): string
    {
        $fileName = md5(uniqid(rand(), true)) . '.' . $file->guessExtension();
        $file->move($directory, $fileName);
        return $fileName;
    }

    public function remove(string $fileName, string $directory): bool
    {
        $path = $directory . '/' . $fileName;
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }
}
