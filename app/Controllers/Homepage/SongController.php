<?php

namespace App\Controllers\Homepage;

use App\Models\Song;
use App\Models\Artist;
use App\Models\SongCategory;
use App\Controllers\BaseController;

class SongController extends BaseController
{
    public function index()
    {
        $perPage = 12; // Number of songs per page

        // Get search and filter parameters
        $search = $this->request->getGet('search');
        $artistFilter = $this->request->getGet('artist');
        $categoryFilter = $this->request->getGet('category');
        $sortBy = $this->request->getGet('sort') ?? 'latest';

        // Build the query
        $query = Song::with(['artist', 'songCategory'])
            ->where('is_published', true);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('artist', function ($artistQuery) use ($search) {
                        $artistQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply artist filter
        if ($artistFilter) {
            $query->where('artist_id', $artistFilter);
        }

        // Apply category filter
        if ($categoryFilter) {
            $query->where('song_category_id', $categoryFilter);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'artist':
                $query->join('artists', 'songs.artist_id', '=', 'artists.id')
                    ->orderBy('artists.name', 'asc')
                    ->select('songs.*');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $songs = $query->paginate($perPage);
        $artists = Artist::orderBy('name')->get();
        $categories = SongCategory::orderBy('name')->get();

        $currentFilters = [
            'search' => $search,
            'artist' => $artistFilter,
            'category' => $categoryFilter,
            'sort' => $sortBy
        ];

        return blade_view('contents.homepage.songs-index', compact(
            'songs',
            'artists',
            'categories',
            'currentFilters'
        ));
    }

    public function show($slug)
    {
        $song = Song::with(['artist', 'songCategory'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        $this->redirectBack404IfNotFound($song);

        $relatedSongs = Song::with(['artist'])
            ->where('id', '!=', $song->id)
            ->where('is_published', true)
            ->where(function ($query) use ($song) {
                if ($song->artist_id) {
                    $query->where('artist_id', $song->artist_id)
                        ->orWhere('title', 'LIKE', "%$song->title%");
                } else {
                    $query->where('title', 'LIKE', "%$song->title%");
                }
            })
            ->orderByRaw('
            CASE 
                WHEN artist_id = ? THEN 1 
                WHEN title LIKE ? THEN 2 
                ELSE 3 
            END, created_at DESC
        ', [$song->artist_id ?? 0, "%$song->title%"])
            ->limit(6)
            ->get();

        return blade_view('contents.homepage.songs-show', compact('song', 'relatedSongs'));
    }
}
