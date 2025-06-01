<?php

namespace App\Traits;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ModelFileUpload
{
    public function handleFileUpload($data, string $filePath, Model|Collection|null $model = null)
    {
        try {
            $imageUploadService = new ImageUploadService();
            $imagePath = null;

            if ($data->hasFile('image')) {
                $oldImagePath = $model?->image_path;
                $image = $data->file('image');
                $imagePath = $imageUploadService->uploadImage($image, $filePath);


                if ($oldImagePath) {
                    $this->handleFileDelete($oldImagePath, $imageUploadService);
                }

                return $imagePath;
            }

            return $imagePath;
        } catch (\Exception $e) {
            $this->handleFileDelete($imagePath, $imageUploadService);
            throw $e;
        }
    }

    private function handleFileDelete($filePath, ImageUploadService $imageUploadService)
    {
        $imageUploadService->deleteIfExists($filePath);
    }
}
