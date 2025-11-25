<?php

namespace Src\models;

use RuntimeException;

class Uploader
{

    public static function uploadImage(array $file, string $dir = "/../../resources/users/")
    {
        $baseDir = __DIR__ . $dir;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Failed to upload: {$file['name']}");
        }

        $type = mime_content_type($file['tmp_name']);
        if (!in_array($type, ['image/jpeg', 'image/png', 'image/jpg', 'image/avif'])) {
            throw new RuntimeException("Invalid file type: {$file['name']}");
        }

        $info = pathinfo($file['name']);
        $ext = strtolower($info['extension']);
        $newName = uniqid('img_', true) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $baseDir . $newName)) {
            throw new RuntimeException("Failed to move the file: {$file['name']}");
        }

        return $newName;
    }

    public static function deleteImage(string $file)
    {
        $dir = __DIR__ . "/../../resources/users/";

        $filePath = $dir . (string)$file;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}
