@use('Illuminate\Support\Str')
<div class="col-12">
    <div class="stats-card">
        <div class="chart-title">
            <i class="fas fa-comments" style="color: var(--primary-color);"></i>
            Recent Comments
            <span class="comment-count ms-2">{{ count($recentComments) }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-user me-2"></i>User</th>
                        <th><i class="fas fa-music me-2"></i>Song</th>
                        <th><i class="fas fa-comment me-2"></i>Comment</th>
                        <th><i class="fas fa-calendar me-2"></i>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentComments as $comment)
                    <tr class="comment-row">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($comment->user->full_name, 0, 1)) }}
                                </div>
                                <span class="user-name">{{ $comment->user->full_name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="song-info">
                                <span class="song-title">{{ Str::limit($comment->song->title, 20) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="comment-content">
                                <p class="comment-text">{{ Str::limit($comment->content, 40) }}</p>
                            </div>
                        </td>
                        <td>
                            <span class="comment-date">
                                <i class="fas fa-clock me-1"></i>
                                {{ $comment->created_at->format('M d, Y') }}
                            </span>
                            <small class="d-block text-muted">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <p class="mb-0">No comments found</p>
                                <small class="text-muted">Comments will appear here when users interact with
                                    songs</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .comment-count {
        background: var(--primary-color);
        color: white;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .song-info .song-title {
        font-weight: 500;
        color: var(--text-primary);
    }

    .comment-content {
        max-width: 250px;
    }

    .comment-text {
        margin: 0;
        color: var(--text-secondary);
        line-height: 1.4;
        font-size: 14px;
    }

    .comment-date {
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 500;
    }

    .comment-row:hover {
        background-color: rgba(79, 70, 229, 0.03);
    }

    .table th i {
        color: var(--primary-color);
        font-size: 12px;
    }
</style>