<?php

namespace App\Services;

use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;

class ViewTrackingService
{
    public function incrementViewIfUnique(Song|Collection $song): bool
    {
        $sessionKey = "viewed_song_{$song->id}";

        if (! session($sessionKey)) {
            $song->incrementViews();
            session()->set($sessionKey, true);

            return true;
        }

        return false;
    }

    public function getViewData(Song|Collection $song): array
    {
        return [
            'views_count' => $song->views_count,
            'formatted_views' => $song->formatted_views,
        ];
    }
}
