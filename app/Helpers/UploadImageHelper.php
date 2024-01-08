<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadImageHelper
{
    public static function upload_image($file, $folder = '')
    {
        $baseFileName = public_path() . '/uploads/' . $_FILES[$file]['name'];

        $info = new \SplFileInfo($baseFileName);

        $ext = strtolower($info->getExtension());

        $nameFile = trim(str_replace('.' . $ext, '', strtolower($info->getFilename())));
        $fileName = date('Y-m-d__') . Str::slug($nameFile) . '.' . $ext;

        $path = public_path() . '/uploads/' . date('Y/m/d/');

        if ($folder) {
            $path = public_path() . '/uploads/' . $folder . '/' . date('Y/m/d/');
        }

        if (!File::exists($path)) {
            mkdir($path, 0777, true);
        }

        move_uploaded_file($_FILES[$file]['tmp_name'], $path . $fileName);

        return $fileName;
    }

    public static function pare_url_file($image, $folder = '')
    {
        if (!$image) {
            return '/images/no-image.jpg';
        }
        $explode = explode('__', $image);
        if (isset($explode[0])) {
            $time = str_replace('-', '/', $explode[0]);
            return '/uploads/' . $folder . '/' . $time . '/' . $image;
        }
    }
}
