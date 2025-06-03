@use('Illuminate\Support\Str')
<div class="col-12">
    <div class="stats-card">
        <div class="chart-title">Recent Comments</div>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Song</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentComments as $comment)
                    <tr>
                        <td>{{ $comment->user->full_name }}</td>
                        <td>{{ Str::limit($comment->song->title, 25) }}</td>
                        <td>{{ Str::limit($comment->content, 50) }}</td>
                        <td>{{ $comment->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No comments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>