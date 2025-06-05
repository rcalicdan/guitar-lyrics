<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Artist;

class ArtistOptionSearchController extends BaseController
{
    public function search()
    {
        $term = $this->request->getGet('term');
        $query = Artist::select(['id', 'name']);

        if (! empty($term)) {
            $query->where('name', 'LIKE', "%{$term}%");
        }

        $artists = $query->limit(30)->get();

        return $this->response->setJSON($artists);
    }
}
