<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Song;
use App\Models\Artist;
use App\Models\User;
use App\Models\Comments;
use App\Models\SongCategory;
use Illuminate\Support\Carbon;

class DashboardController extends BaseController
{
    public function index()
    {
        // Get dashboard statistics
        $totalSongs = Song::count();
        $totalArtists = Artist::count();
        $totalUsers = User::count();
        $totalComments = Comments::count();
        
        // Get popular songs (top 10 by views)
        $popularSongs = Song::with(['artist', 'songCategory'])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
        
        // Get songs by category for pie chart
        $songsByCategory = Song::select('song_category_id')
            ->with('songCategory')
            ->get()
            ->groupBy('songCategory.name')
            ->map(function ($songs) {
                return $songs->count();
            });
        
        // Get monthly song creation stats (last 6 months)
        $monthlySongs = Song::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Get top artists by song count
        $topArtists = Artist::withCount('songs')
            ->orderBy('songs_count', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent comments
        $recentComments = Comments::with(['user', 'song'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return blade_view('contents.dashboard.index', [
            'totalSongs' => $totalSongs,
            'totalArtists' => $totalArtists,
            'totalUsers' => $totalUsers,
            'totalComments' => $totalComments,
            'popularSongs' => $popularSongs,
            'songsByCategory' => $songsByCategory,
            'monthlySongs' => $monthlySongs,
            'topArtists' => $topArtists,
            'recentComments' => $recentComments
        ]);
    }
}