<?php

namespace Bido\Media\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageFileService
{
    protected static $sizes = [
        '300',
        '600',
    ];

    public static function upload($file)
    {
        $fileName = uniqid();
        $extension = $file->getClientOriginalExtension();
        $dir = 'public\\';
        Storage::putFileAs($dir, $file,$fileName . '.' . $extension);
        $path = $dir . $fileName . '.' . $extension;

        return self::resize(Storage::path($path), $fileName, $extension, $dir);
    }

    public static function resize($img, $fileName, $extension, $dir)
    {
        $img = Image::make($img);
        $images['origin'] = $fileName . '.' . $extension;

        foreach (self::$sizes as $size) {
            $images[$size] = $fileName . '_' . $size . '.' . $extension;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })->save(Storage::path($dir) . $fileName . '_' . $size . '.' . $extension);
        }

        return $images;
    }

    public static function delete($media)
    {
        foreach ($media->files as $file) {
            Storage::delete('public\\'. $file);
        }
    }
}