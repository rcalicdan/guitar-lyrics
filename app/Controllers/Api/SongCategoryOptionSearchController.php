<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\SongCategory;

class SongCategoryOptionSearchController extends BaseController
{
    public function search()
    {
        $term = $this->request->getGet('term');
        $query = SongCategory::select(['id', 'name']);

        if (!empty($term)) {
            $query->where('name', 'LIKE', "%{$term}%");
        }

        $categories = $query->limit(30)->orderBy('name')->get();

        return $this->response->setJSON($categories);
    }
}