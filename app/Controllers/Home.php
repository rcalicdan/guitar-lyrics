<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $featuredSongs = [
            [
                'id' => 1,
                'title' => 'Hey Jude',
                'artist' => 'The Beatles',
                'image' => '/placeholder/hey-jude.png'
            ],
            [
                'id' => 2,
                'title' => 'Hello Goodbye',
                'artist' => 'The Beatles',
                'image' => '/placeholder/hello-goodbye.png'
            ],
            [
                'id' => 3,
                'title' => 'We are the Champions',
                'artist' => 'Queen',
                'image' => '/placeholder/we-are-the-champion.png'
            ]
        ];

        $songsCount = '10K+';
        $artistsCount = '5K+';
        $usersCount = '50K+';

        return blade_view('welcome', compact('featuredSongs', 'songsCount', 'artistsCount', 'usersCount'));
    }
}
