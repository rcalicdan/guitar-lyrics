<?php

namespace App\Services;

class ImageUploadService
{
    public function uploadProfile($image, $filePath = 'uploads/profile-images'): string
    {
        $this->deleteIfProfileExists();
        $newImageName = $image->getRandomName();
        $uploadPath = $this->createUploadPath($filePath);
        $image->move($uploadPath, $newImageName);

        $relativePath = "/{$filePath}/{$newImageName}";

        return $relativePath;
    }

    public function uploadImage($image, $filePath = 'uploads/images'): string
    {
        $newImageName = $image->getRandomName();
        $uploadPath = $this->createUploadPath($filePath);
        $image->move($uploadPath, $newImageName);

        $relativePath = "/{$filePath}/{$newImageName}";

        return $relativePath;
    }

    public function deleteIfExists(string $filePath)
    {
        if (! empty($filePath) && file_exists(FCPATH.$filePath)) {
            unlink(FCPATH.$filePath);
        }
    }

    private function deleteIfProfileExists(): void
    {
        $user = auth()->user();

        if (! empty($user->image_path) && file_exists(FCPATH.$user->image_path)) {
            unlink(FCPATH.$user->image_path);
        }
    }

    private function createUploadPath($filePath): string
    {
        $uploadPath = FCPATH.$filePath;

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        return $uploadPath;
    }
}
