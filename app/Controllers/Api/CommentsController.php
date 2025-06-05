<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Helpers\AuditHelper;
use App\Models\Comments;
use App\Models\Song;

class CommentsController extends BaseController
{
    public function index($songSlug)
    {
        $song = $this->findPublishedSong($songSlug);

        if (! $song) {
            return $this->respondNotFound('Song not found');
        }

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;
        $totalCount = Comments::where('song_id', $song->id)
            ->rootComments()
            ->count();
        $comments = Comments::with(['user', 'replies.user'])
            ->where('song_id', $song->id)
            ->rootComments()
            ->orderBy('created_at', 'desc')
            ->simplePaginate($perPage, ['*'], 'page', $page);

        return $this->respondSuccess([
            'data' => $this->formatCommentsData($comments->items()),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'has_more_pages' => $comments->hasMorePages(),
                'next_page_url' => $comments->nextPageUrl(),
                'prev_page_url' => $comments->previousPageUrl(),
                'path' => $comments->path(),
                'total' => $totalCount,
            ],
        ]);
    }

    public function loadMore($songSlug)
    {
        return $this->index($songSlug);
    }

    public function store($songSlug)
    {
        $song = $this->findPublishedSong($songSlug);

        if (! $song) {
            return $this->respondNotFound('Song not found');
        }

        if (! $this->validateCommentData()) {
            return $this->respondValidationError();
        }

        $comment = $this->createComment($song);

        AuditHelper::logCreated($comment);

        return $this->respondSuccess(
            $this->formatSingleCommentData($comment),
            'Comment posted successfully'
        );
    }

    public function update($songSlug, $commentId)
    {
        $song = $this->findPublishedSong($songSlug);

        if (! $song) {
            return $this->respondNotFound('Song not found');
        }

        $comment = Comments::where('id', $commentId)
            ->where('song_id', $song->id)
            ->first();

        if (! $comment) {
            return $this->respondNotFound('Comment not found');
        }

        if ($this->cannot('update', $comment)) {
            return $this->respondUnauthorized('You are not authorized to update this comment');
        }

        if (! $this->validateCommentData()) {
            return $this->respondValidationError();
        }

        $content = $this->request->getJSON(true)['content'] ?? $this->request->getPost('content');

        $comment->update([
            'content' => $content,
        ]);

        AuditHelper::logUpdated($comment, $comment->getOriginal());

        return $this->respondSuccess(null, 'Comment updated successfully');
    }

    public function delete($songSlug, $commentId)
    {
        $song = $this->findPublishedSong($songSlug);

        if (! $song) {
            return $this->respondNotFound('Song not found');
        }

        $comment = Comments::where('id', $commentId)
            ->where('song_id', $song->id)
            ->first();

        if (! $comment) {
            return $this->respondNotFound('Comment not found');
        }

        if ($this->cannot('delete', $comment)) {
            return $this->respondUnauthorized('You are not authorized to delete this comment');
        }

        $comment->delete();

        return $this->respondSuccess(null, 'Comment deleted successfully');
    }

    private function findPublishedSong($slug)
    {
        return Song::where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }

    private function validateCommentData(): bool
    {
        $rules = [
            'content' => [
                'rules' => 'required|min_length[3]|max_length[1000]',
                'errors' => [
                    'required' => 'Comment content is required.',
                    'min_length' => 'Comment must be at least 3 characters long.',
                    'max_length' => 'Comment cannot exceed 1000 characters.',
                ],
            ],
        ];

        return $this->validate($rules);
    }

    private function createComment($song)
    {
        $data = [
            'content' => $this->request->getJSON(true)['content'] ?? $this->request->getPost('content'),
            'user_id' => auth()->user()->id,
            'song_id' => $song->id,
            'parent_id' => $this->request->getJSON(true)['parent_id'] ?? $this->request->getPost('parent_id'),
        ];

        $comment = Comments::create($data);
        $comment->refresh();
        $comment->load('user');

        return $comment;
    }

    private function formatCommentsData($comments)
    {
        return collect($comments)->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => $this->formatUserData($comment->user),
                'can_edit' => auth()->check() ? $this->can('update', $comment) : false,
                'can_delete' => auth()->check() ? $this->can('delete', $comment) : false,
                'replies' => $comment->replies->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'content' => $reply->content,
                        'created_at' => $reply->created_at->diffForHumans(),
                        'user' => $this->formatUserData($reply->user),
                        'can_edit' => auth()->check() ? $this->can('update', $reply) : false,
                        'can_delete' => auth()->check() ? $this->can('delete', $reply) : false,
                    ];
                }),
            ];
        });
    }

    private function formatSingleCommentData($comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
            'user' => $this->formatUserData($comment->user),
            'can_edit' => auth()->check() ? $this->can('update', $comment) : false,
            'can_delete' => auth()->check() ? $this->can('delete', $comment) : false,
            'replies' => [],
        ];
    }

    private function formatUserData($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->full_name,
            'image' => $user->image_path ?? '/placeholder/no-profile.png',
        ];
    }

    private function respondSuccess($data = null, $message = null)
    {
        $response = ['success' => true];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        return $this->response->setJSON($response);
    }

    private function respondNotFound($message = 'Resource not found')
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => $message,
        ])->setStatusCode(404);
    }

    private function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => $message,
        ])->setStatusCode(403);
    }

    private function respondValidationError()
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $this->validator->getErrors(),
        ])->setStatusCode(400);
    }
}
