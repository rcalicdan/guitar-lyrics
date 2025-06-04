<?php

namespace App\Services;

use App\Models\Song;
use App\Requests\Song\StoreSongRequest;
use App\Requests\Song\UpdateSongRequest;
use App\Traits\ModelFileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rcalicdan\Ci4Larabridge\Traits\RedirectIfNotFoundTrait;

class UserSongService
{
    use ModelFileUpload, RedirectIfNotFoundTrait;

    public function getSongs(): Builder
    {
        $songs = Song::query()
            ->with(['songCategory:id,name', 'artist:id,name'])
            ->select([
                'songs.id',
                'songs.title',
                'songs.slug',
                'songs.views_count',
                'songs.is_published',
                'songs.song_category_id',
                'songs.artist_id'
            ])
            ->where('songs.user_id', auth()->user()->id) 
            ->when(get('id'), function ($query, $songId) {
                $query->where('songs.id', $songId);
            })
            ->when(get('title'), function ($query, $title) {
                $query->where('songs.title', 'LIKE', "{$title}");
            })
            ->when(get('is_published'), function ($query, $isPublished) {
                $query->where('songs.is_published', $isPublished);
            })
            ->when(get('song_category_id'), function ($query, $songCategoryId) {
                $query->where('songs.song_category_id', $songCategoryId);
            })
            ->when(get('artist_name'), function ($query, $artistName) {
                $query->whereHas('artist', function ($artistQuery) use ($artistName) {
                    $artistQuery->where('name', 'LIKE', "%{$artistName}%");
                });
            });

        return $songs;
    }
}