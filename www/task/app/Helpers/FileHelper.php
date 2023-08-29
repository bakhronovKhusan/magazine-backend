<?php

namespace App\Helpers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function uploadFile($file): string {
        $result = null;
        if ($file->isValid()) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put($filename, file_get_contents($file));
            $result = $filename;

        }
        return $result;
    }

    public static function deleteFile($fileUrl): bool {
        $result = false;
        if ($fileUrl && Storage::disk('local')->exists($fileUrl)) {
            Storage::disk('local')->delete($fileUrl);
            $result = true;
        }
        return $result;
    }
}
