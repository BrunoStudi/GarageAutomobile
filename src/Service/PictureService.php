<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture, ?string $folder = '')
    {
        // Generate a unique filename for the image
        $filename = md5(uniqid(rand(), true)) . '.' . $picture->getClientOriginalExtension();

        $path = $this->params->get('images_directory') . $folder;

        // Move the uploaded file to the destination directory
        $picture->move($path, $filename);

        return $filename;
    }

    public function delete(string $filename, ?string $folder = '')
    {
        // Construct the full path to the image file
        $path = $this->params->get('images_directory') . $folder . '/' . $filename;

        // Check if the file exists and delete it
        if (file_exists($path)) {
            unlink($path);
            return true;
        }

        return false;
    }
}
