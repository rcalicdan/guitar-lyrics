<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Song;
use App\Models\SongCategory;
use App\Requests\Song\StoreSongRequest;
use App\Requests\Song\UpdateSongRequest;
use App\Services\UserSongService;

class UserSongController extends BaseController
{
    private UserSongService $songService;

    public function __construct()
    {
        $this->songService = new UserSongService();
    }

    public function index()
    {
        $songs = $this->songService->getSongs()->paginateWithQueryString(20);

        return blade_view('contents.user-song.index', ['songs' => $songs]);
    }
}
