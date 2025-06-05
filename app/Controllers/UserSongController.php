<?php

namespace App\Controllers;

use App\Services\UserSongService;

class UserSongController extends BaseController
{
    private UserSongService $songService;

    public function __construct()
    {
        $this->songService = new UserSongService;
    }

    public function index()
    {
        $songs = $this->songService->getSongs()->paginateWithQueryString(20);

        return blade_view('contents.user-song.index', ['songs' => $songs]);
    }
}
