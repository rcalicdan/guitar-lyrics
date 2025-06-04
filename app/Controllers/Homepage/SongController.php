<?php

namespace App\Controllers\Homepage;

use App\Models\Song;
use App\Services\HomepageSongService;
use App\Services\ViewTrackingService;
use App\Controllers\BaseController;

class SongController extends BaseController
{
    private HomepageSongService $songService;
    private ViewTrackingService $viewTrackingService;

    public function __construct()
    {
        $this->songService = new HomepageSongService();
        $this->viewTrackingService = new ViewTrackingService();
    }

    public function index()
    {
        $filters = $this->getFiltersFromRequest();
        $songs = $this->songService->getPaginatedSongs($filters, 12);
        $filterOptions = $this->songService->getFilterOptions();

        return blade_view('contents.homepage.songs-index', [
            'songs' => $songs,
            'artists' => $filterOptions['artists'],
            'categories' => $filterOptions['categories'],
            'currentFilters' => $filters
        ]);
    }

    public function show($slug)
    {
        $song = $this->songService->findBySlug($slug);
        $this->redirectBack404IfNotFound($song);

        $this->viewTrackingService->incrementViewIfUnique($song);
        $relatedSongs = $this->songService->getRelatedSongs($song);

        return blade_view('contents.homepage.songs-show', compact('song', 'relatedSongs'));
    }

    public function incrementView($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $song = Song::find($id);

        if (!$song || !$song->is_published) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Song not found']);
        }

        $viewIncremented = $this->viewTrackingService->incrementViewIfUnique($song);

        if ($viewIncremented) {
            return $this->response->setJSON([
                'success' => true,
                ...$this->viewTrackingService->getViewData($song)
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'View already counted for this session'
        ]);
    }

    private function getFiltersFromRequest(): array
    {
        return [
            'search' => $this->request->getGet('search'),
            'artist' => $this->request->getGet('artist'),
            'category' => $this->request->getGet('category'),
            'sort' => $this->request->getGet('sort') ?? 'latest'
        ];
    }
}
