<?php

namespace App\Services;

interface IBaseService
{
    static public function renameImage($image, $folder);
    static public function resizeImage($folder, $image_name, $width = 800, $height = 600);
}
