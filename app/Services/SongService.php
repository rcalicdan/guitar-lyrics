<?php

namespace App\Services;

use App\Helpers\AuditHelper;
use App\Models\Song;
use App\Requests\Song\StoreSongRequest;
use App\Requests\Song\UpdateSongRequest;
use App\Traits\ModelFileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SongService
{
    use ModelFileUpload;

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
                'songs.artist_id',
            ])
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

    public function store(StoreSongRequest $request)
    {
        $imagePath = $this->handleFileUpload($request, 'uploads/songs');

        $song = Song::create([
            'title' => purify_html($request->title),
            'content' => purify_html($request->content),
            'is_published' => true,
            'slug' => Str::slug($request->title).'-'.time(),
            'song_category_id' => $request->category_id ?: null,
            'artist_id' => $request->artist_id ?: null,
            'user_id' => auth()->user()->id,
            'image_path' => $imagePath,
        ]);

        AuditHelper::logCreated($song);
    }

    public function update(UpdateSongRequest $request, string $slug)
    {
        $song = Song::where('slug', $slug)->first();
        authorize('update', $song);
        $imagePath = $this->handleFileUpload($request, 'uploads/songs', $song);

        $song->update([
            'title' => purify_html($request->title),
            'content' => purify_html($request->content),
            'is_published' => true,
            'slug' => Str::slug($request->title).'-'.time(),
            'song_category_id' => $request->category_id ?: null,
            'artist_id' => $request->artist_id ?: null,
            'user_id' => auth()->user()->id,
            'image_path' => $imagePath,
        ]);

        AuditHelper::logUpdated($song, $song->getOriginal());
    }
}
