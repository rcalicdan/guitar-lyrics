<?php

namespace App\Services;

use App\Helpers\AuditHelper;
use App\Models\Artist;
use App\Requests\Artist\StoreArtistRequest;
use App\Requests\Artist\UpdateArtistRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class ArtistService
{
    public function getArtist(): Builder
    {
        $artists = Artist::query()
            ->select(['id', 'name'])
            ->when(get('id'), function ($query, $id) {
                $query->where('id', $id);
            })
            ->when(get('name'), function ($query, $name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->oldest('id');

        return $artists;
    }

    public function store(StoreArtistRequest $data, ImageUploadService $imageUploadService, string $filePath = 'uploads/artists')
    {
        $imagePath = $this->handleFileUpload($data, $filePath, $imageUploadService);

        $artist = Artist::create([
            'name' => $data->name,
            'about' => $data->about,
            'image_path' => $imagePath,
        ]);

        AuditHelper::logCreated($artist);
    }

    public function update(Artist|Collection $artist, UpdateArtistRequest $data, ImageUploadService $imageUploadService, string $filePath = 'uploads/artists')
    {
        $imagePath = $artist->image_path;

        if ($data->hasFile('image')) {
            $imagePath = $this->handleFileUpload($data, $filePath, $imageUploadService, $artist);
        }

        $artist->update([
            'name' => $data->name,
            'about' => $data->about,
            'image_path' => $imagePath,
        ]);

        AuditHelper::logUpdated($artist, $artist->getOriginal());
    }

    private function handleFileUpload($data, string $filePath, ImageUploadService $imageUploadService, ?Artist $artist = null)
    {
        try {
            $imagePath = null;

            if ($data->hasFile('image')) {
                $oldImagePath = $artist?->image_path;
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
