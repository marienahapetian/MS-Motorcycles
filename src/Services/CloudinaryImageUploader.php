<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CloudinaryImageUploader
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            Configuration::instance($_ENV['CLOUDINARY_URL'])
        );
    }

    public function upload(UploadedFile $file): string
    {
        $result = $this->cloudinary
            ->uploadApi()
            ->upload($file->getRealPath());

        return $result['secure_url'];
    }
}
