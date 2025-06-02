<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\User;

class Home extends BaseController
{
    public function index()
    {
        $featuredSongs = Song::with('artist')
            ->where('is_published', true)
            ->limit(3)
            ->get()
            ->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist_name,
                    'image' => $song->image_path ?? '/placeholder/no-image.png'
                ];
            })
            ->toArray();

        $songsCount = $this->formatCount(Song::where('is_published', true)->count());
        $artistsCount = $this->formatCount(Artist::count());
        $usersCount = $this->formatCount(User::count());

        return blade_view('welcome', compact('featuredSongs', 'songsCount', 'artistsCount', 'usersCount'));
    }

    /**
     * Format count numbers for display (e.g., 1000 -> 1K)
     */
    private function formatCount(int $count): string
    {
        if ($count >= 1000000) {
            return number_format($count / 1000000, 1) . 'M+';
        } elseif ($count >= 1000) {
            return number_format($count / 1000, 1) . 'K+';
        }
        
        return (string) $count;
    }
}