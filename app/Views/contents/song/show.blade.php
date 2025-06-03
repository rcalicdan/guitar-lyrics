<div class="card shadow-sm mt-0 pt-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-light">
        <h4 class="mb-0">Song Details</h4>
        <span class="badge {{ $song->is_published ? 'bg-success' : 'bg-warning' ?? '' }}">
            {{ $song->is_published ? 'Published' : 'Draft' }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Song Image -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="text-center">
                    <div class="img-placeholder bg-light rounded mb-3"
                        style="height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="{{ $song->image_path ?: '/placeholder/no-image.png' }}"
                            alt="{{ $song->title }} cover" class="img-fluid rounded"
                            style="object-fit: cover; width: 100%; height: 100%;">
                    </div>

                    <div class="song-meta text-center">
                        <span class="badge bg-primary me-2">{{ $song->category_name }}</span>
                        <span class="d-block mt-2 text-muted">
                            <i class="fas fa-user me-1"></i>{{ $song->artist_name }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Song Details -->
            <div class="col-md-8">
                <h2 class="song-title mb-3">{{ $song->title }}</h2>

                <div class="song-meta text-muted mb-3">
                    <small>
                        <span class="me-3"><i
                                class="far fa-calendar-alt me-1"></i>{{ "Added: {$song->created_at->format('F j, Y h:i a')}" }}</span>
                        <span><i
                                class="far fa-edit me-1"></i>{{ "Updated: {$song->updated_at->format('F j, Y h:i a')}" }}</span>
                    </small>
                </div>

                <div class="song-content mb-4">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-music me-2"></i>Lyrics</h5>
                        </div>
                        <div class="card-body lyrics-content"
                            style="white-space: pre-wrap; max-height: 400px; overflow-y: auto;">
                            {!! $song->content !!}
                        </div>
                    </div>
                </div>

                <div class="song-info mt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-light rounded p-3 me-3">
                                    <i class="fas fa-user-circle text-primary"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small">Artist</span>
                                    @if ($song->artist_id)
                                        <a href="{{ route_to('songs.artists.show', $song->artist_id) }}"
                                            class="text-decoration-none">
                                            <strong>{{ $song->artist_name }}</strong>
                                        </a>
                                    @else
                                        <strong>Unknown Artist</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-light rounded p-3 me-3">
                                    <i class="fas fa-folder text-primary"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small">Category</span>
                                    @if ($song->song_category_id)
                                        <a href="{{ route_to('songs.categories.show', $song->song_category_id) }}"
                                            class="text-decoration-none">
                                            <strong>{{ $song->category_name }}</strong>
                                        </a>
                                    @else
                                        <strong>Unknown Category</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between">
            <a href="{{ back_url('songs.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Songs
            </a>
            <div>
                @can('update', $song)
                    @include('components.utils.edit-button', [
                        'route' => 'songs.edit',
                        'id' => $song->slug,
                    ])
                @endcan
                @can('delete', $song)
                    @include('components.utils.delete-button', [
                        'route' => 'songs.delete',
                        'id' => $song->slug,
                        'itemName' => 'song',
                    ])
                @endcan
            </div>
        </div>
    </div>
</div>
