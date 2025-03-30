<?php

function uploadIsImage($uploadFile)
{
    if ($uploadFile["error"] !== UPLOAD_ERR_OK) return false;

    $exifImgType = exif_imagetype($uploadFile["tmp_name"]);
    $supportedImageTypes = [
        IMAGETYPE_PNG => function ($file) {
            $img = imagecreatefrompng($file);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            return $img;
        },
        IMAGETYPE_JPEG => fn($file) => imagecreatefromjpeg($file)
    ];

    if ($exifImgType && in_array($exifImgType, array_keys($supportedImageTypes))) return $supportedImageTypes[$exifImgType]($uploadFile["tmp_name"]);
    return false;
}
