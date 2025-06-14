<?php

namespace App\Controllers;

use App\Helpers\AuditHelper;
use App\Models\SongCategory;
use App\Requests\SongCategory\StoreCategoryRequest;
use App\Requests\SongCategory\UpdateCategoryRequest;
use App\Services\SongCategoryService;
use App\Traits\SearchPaginationTrait;

class SongCategoryController extends BaseController
{
    use SearchPaginationTrait;

    private SongCategoryService $songCategoryService;

    public function __construct()
    {
        $this->songCategoryService = new SongCategoryService;
    }

    public function index()
    {
        $songCategories = $this->songCategoryService->getSongCategories()->paginateWithQueryString(20);

        return blade_view('contents.song-categories.index', ['songCategories' => $songCategories]);
    }

    public function create()
    {
        $isCreating = true;
        $this->authorize('create', SongCategory::class);

        return blade_view('contents.song-categories.index', ['isCreating' => $isCreating]);
    }

    public function store()
    {
        $this->authorize('create', SongCategory::class);
        $category = SongCategory::create(StoreCategoryRequest::validateRequest());
        AuditHelper::logCreated($category);
        log_message('error', 'Song Category created: ' . $category->id);

        return redirect()->route('songs.categories.index')->with('success', 'Song Category created successfully.');
    }

    public function edit($id)
    {
        $isEditing = true;
        $songCategory = SongCategory::findOrFail($id);
        $this->authorize('update', $songCategory);

        return blade_view('contents.song-categories.index', ['songCategory' => $songCategory, 'isEditing' => $isEditing]);
    }

    public function update($id)
    {
        $songCategory = SongCategory::findOrFail($id);
        $this->authorize('update', $songCategory);
        $songCategory->update(UpdateCategoryRequest::validateRequest());
        AuditHelper::logUpdated($songCategory, $songCategory->getOriginal());

        return redirect()->back()->with('success', 'Song Category updated successfully.');
    }

    public function destroy($id)
    {
        $songCategory = SongCategory::findOrFail($id);
        $this->authorize('delete', $songCategory);
        $songCategory->delete();
        AuditHelper::logDeleted($songCategory);

        return redirect()->back()->with('success', 'Song Category deleted successfully.');
    }
}
