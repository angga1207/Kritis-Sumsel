<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    /**
     * Resize/optimize an uploaded image and store it, returning its public URL.
     */
    public function storeArticleImage(UploadedFile $file, int $maxWidth = 1600): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->decodePath($file->getRealPath());

        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $filename = 'articles/'.date('Y/m').'/'.Str::random(20).'.jpg';

        Storage::disk('public')->put($filename, (string) $image->encodeUsingFileExtension('jpg', quality: 82));

        return Storage::url($filename);
    }
}
