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
    /**
     * Display the dashboard with statistics and analytics
     */
    public function index()
    {
        $dashboardData = [
            'totalSongs' => Song::count(),
            'totalArtists' => Artist::count(),
            'totalUsers' => User::count(),
            'totalCategories' => SongCategory::count(),
            'popularSongs' => $this->getPopularSongs(),
            'songsByCategory' => $this->getSongsByCategory(),
            'monthlySongs' => $this->getMonthlySongStats(),
            'topArtists' => $this->getTopArtistsByCount(),
            'recentComments' => $this->getRecentComments()
        ];

        return blade_view('contents.dashboard.index', $dashboardData);
    }

    /**
     * Get popular songs ordered by views
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPopularSongs(int $limit = 10)
    {
        return Song::with(['artist', 'songCategory'])
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get songs grouped by category for pie chart
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getSongsByCategory()
    {
        return Song::select('song_category_id')
            ->with('songCategory')
            ->get()
            ->groupBy('songCategory.name')
            ->map(function ($songs) {
                return $songs->count();
            });
    }

    /**
     * Get monthly song creation statistics
     * 
     * @param int $months
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getMonthlySongStats(int $months = 6)
    {
        return Song::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths($months))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Get top artists by song count
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTopArtistsByCount(int $limit = 5)
    {
        return Artist::withCount('songs')
            ->orderBy('songs_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent comments with related user and song data
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecentComments(int $limit = 5)
    {
        return Comments::with(['user', 'song'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
