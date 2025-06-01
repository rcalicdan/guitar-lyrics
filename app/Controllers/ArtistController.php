<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artist;
use App\Requests\Artist\StoreArtistRequest;
use App\Requests\Artist\UpdateArtistRequest;
use App\Services\ArtistService;
use App\Services\ImageUploadService;

class ArtistController extends BaseController
{
    private ImageUploadService $imageUploadService;
    private ArtistService $artistService;

    public function __construct()
    {
        $this->imageUploadService = new ImageUploadService();
        $this->artistService = new ArtistService();
    }

    public function index()
    {
        $artists = $this->artistService->getArtist()->paginateWithQueryString(20);

        return blade_view('contents.artist.index', [
            'artists' => $artists,
        ]);
    }

    public function create()
    {
        $isCreating = true;
        $this->authorize('create', Artist::class);

        return blade_view('contents.artist.index', [
            'isCreating' => $isCreating,
        ]);
    }

    public function store()
    {
        $request = new StoreArtistRequest();
        $this->authorize('create', Artist::class);
        $this->artistService->store($request, $this->imageUploadService);

        return redirect()->to(back_url('songs.artists.index'))->with('success', 'Artist created successfully');
    }

    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        $isShowing = true;

        return blade_view('contents.artist.index', [
            'artist' => $artist,
            'isShowing' => $isShowing,
        ]);
    }

    public function edit($id)
    {
        $artist = Artist::findOrFail($id);
        $this->authorize('update', $artist);
        $isEditing = true;

        return blade_view('contents.artist.index', [
            'artist' => $artist,
            'isEditing' => $isEditing,
        ]);
    }

    public function update($id)
    {
        $request = new UpdateArtistRequest();
        $artist = Artist::findOrFail($id);
        $this->authorize('update', $artist);
        $this->artistService->update($artist, $request, $this->imageUploadService);

        return redirect()->route('songs.artists.show', [$id])->with('success', 'Artist updated successfully');
    }

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $this->authorize('delete', $artist);
        $artist->delete();

        return redirect()->to(back_url())->with('success', 'Artist deleted successfully');
    }
}
