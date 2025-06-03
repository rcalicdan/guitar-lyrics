<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Comments;
use App\Models\Song;
use CodeIgniter\HTTP\ResponseInterface;

class CommentsController extends BaseController
{
    public function index($songSlug)
    {
        $song = Song::where('slug', $songSlug)
            ->where('is_published', true)
            ->first();

        if (!$song) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Song not found'
            ])->setStatusCode(404);
        }

        $comments = Comments::with(['user', 'replies.user'])
            ->where('song_id', $song->id)
            ->rootComments()
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->response->setJSON([
            'success' => true,
            'data' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->full_name,
                        'image' => $comment->user->image_path ?? '/placeholder/avatar.png'
                    ],
                    'replies' => $comment->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'created_at' => $reply->created_at->diffForHumans(),
                            'user' => [
                                'id' => $reply->user->id,
                                'name' => $reply->user->full_name,
                                'image' => $reply->user->image_path ?? '/placeholder/avatar.png'
                            ]
                        ];
                    })
                ];
            })
        ]);
    }

    public function store($songSlug)
    {
        $song = Song::where('slug', $songSlug)
            ->where('is_published', true)
            ->first();

        if (!$song) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Song not found'
            ])->setStatusCode(404);
        }

        $rules = [
            'content' => 'required|min_length[3]|max_length[1000]',
            'parent_id' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $data = [
            'content' => $this->request->getPost('content'),
            'user_id' => auth()->user()->id,
            'song_id' => $song->id,
            'parent_id' => $this->request->getPost('parent_id')
        ];

        $comment = Comments::create($data);
        $comment->load('user');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Comment posted successfully',
            'data' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->full_name,
                    'image' => $comment->user->image_path ?? '/placeholder/avatar.png'
                ],
                'replies' => []
            ]
        ]);
    }

    public function update($commentId)
    {
        $comment = Comments::where('id', $commentId)
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$comment) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Comment not found or unauthorized'
            ])->setStatusCode(404);
        }

        $rules = [
            'content' => 'required|min_length[3]|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $comment->update([
            'content' => $this->request->getRawInput()['content']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Comment updated successfully'
        ]);
    }

    public function delete($commentId)
    {
        $comment = Comments::where('id', $commentId)
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$comment) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Comment not found or unauthorized'
            ])->setStatusCode(404);
        }

        $comment->delete();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}