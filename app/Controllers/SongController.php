<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\AuditHelper;
use App\Models\Song;
use App\Models\SongCategory;
use App\Requests\Song\StoreSongRequest;
use App\Requests\Song\UpdateSongRequest;
use App\Services\SongService;

class SongController extends BaseController
{
    private SongService $songService;

    public function __construct()
    {
        $this->songService = new SongService();
    }

    public function index()
    {
        $songs = $this->songService->getSongs()->paginateWithQueryString(20);

        return blade_view('contents.song.index', ['songs' => $songs]);
    }

    public function show(string $slug)
    {
        $isShowing = true;
        $song = Song::with('artist:id,name', 'songCategory:id,name')
            ->where('slug', $slug)->first();

        return blade_view('contents.song.index', ['song' => $song, 'isShowing' => $isShowing]);
    }

    public function create()
    {
        $isCreating = true;
        $categories = SongCategory::get(['id', 'name']);

        return blade_view('contents.song.index', [
            'isCreating' => $isCreating,
            'categories' => $categories,
        ]);
    }

    public function store()
    {
        $request = new StoreSongRequest();
        $this->songService->store($request);

        return redirect()->route('songs.index')->with('success', 'Song created successfully');
    }

    public function edit(string $slug)
    {
        $song = Song::with('artist', 'songCategory')
            ->where('slug', $slug)->first();
        $this->authorize('update', $song);
        $isEditing = true;
        $categories = SongCategory::get(['id', 'name']);

        return blade_view('contents.song.index', [
            'isEditing' => $isEditing,
            'song' => $song,
            'categories' => $categories,
        ]);
    }

    public function update(string $slug)
    {
        $request = new UpdateSongRequest();
        $this->songService->update($request, $slug);

        return redirect()->route('songs.index')->with('success', 'Song updated successfully');
    }

    public function destroy(string $slug)
    {
        $song = Song::where('slug', $slug)->firstOrFail();
        $song->delete();
        AuditHelper::logDeleted($song);

        return redirect()->route('songs.index')->with('success', 'Song deleted successfully');
    }
}
