<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomepageSongService
{
    public function getPaginatedSongs(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Song::with(['artist', 'songCategory'])
            ->where('is_published', true);

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $filters['sort'] ?? 'latest');

        return $query->paginateWithQueryString($perPage);
    }

    public function getFilterOptions(): array
    {
        return [
            'artists' => Artist::orderBy('name')->get(),
            'categories' => SongCategory::orderBy('name')->get(),
        ];
    }

    public function findBySlug(string $slug): ?Song
    {
        return Song::with(['artist', 'songCategory'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }

    public function getRelatedSongs(Song $song, int $limit = 6): Collection
    {
        return Song::with(['artist'])
            ->where('id', '!=', $song->id)
            ->where('is_published', true)
            ->when($song->artist_id, function ($query) use ($song) {
                $query->where('artist_id', $song->artist_id)
                    ->orWhere('title', 'LIKE', "%{$song->title}%");
            }, function ($query) use ($song) {
                $query->where('title', 'LIKE', "%{$song->title}%");
            })
            ->orderByRaw('
                CASE 
                    WHEN artist_id = ? THEN 1 
                    WHEN title LIKE ? THEN 2 
                    ELSE 3 
                END, created_at DESC
            ', [$song->artist_id ?? 0, "%{$song->title}%"])
            ->limit($limit)
            ->get();
    }

    private function applyFilters($query, array $filters): void
    {
        $query
            ->when(! empty($filters['search']), function ($q) use ($filters) {
                $search = $filters['search'];
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhereHas('artist', function ($artistQuery) use ($search) {
                            $artistQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(! empty($filters['artist']), function ($q) use ($filters) {
                $q->where('artist_id', $filters['artist']);
            })
            ->when(! empty($filters['category']), function ($q) use ($filters) {
                $q->where('song_category_id', $filters['category']);
            });
    }

    private function applySorting($query, string $sortBy): void
    {
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
    }
}
