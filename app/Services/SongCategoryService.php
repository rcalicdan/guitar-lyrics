<?php

namespace App\Services;

use App\Models\SongCategory;
use Illuminate\Database\Eloquent\Builder;

class SongCategoryService
{
    public function getSongCategories(): Builder
    {
        $songCategories = SongCategory::query()
            ->select('id', 'name')
            ->when(get('id'), function ($query, $id) {
                $query->where('id', $id);
            })
            ->when(get('name'), function ($query, $name) {
                $query->where('name', 'LIKE', "%{$name}%");
            })
            ->oldest('id');

        return $songCategories;
    }
}
