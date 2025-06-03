<div class="card shadow-sm mt-0 pt-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Artist Profile</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Artist Image -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="text-center">
                    <div class="img-placeholder bg-light rounded mb-3"
                        style="height: 250px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ $artist->image_path ?: '/placeholder/no-image.png' }}"
                            alt="{{ $artist->name }} image" class="img-fluid rounded"
                            style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                </div>
            </div>

            <!-- Artist Details -->
            <div class="col-md-8">
                <h2 class="artist-name">{{ $artist->name }}</h2>

                <div class="artist-meta text-muted mb-3">
                    <small>
                        <span class="me-3"><i
                                class="far fa-calendar-alt me-1"></i>{{ "Added: {$artist->created_at->format('F j, Y h:i a')}" }}</span>
                        <span><i
                                class="far fa-edit me-1"></i>{{ "Added: {$artist->updated_at->format('F j, Y h:i a')}" }}</span>
                    </small>
                </div>

                <div class="artist-about mb-4">
                    <h5>About the Artist</h5>
                    <p>
                        {{ $artist->about ?: 'No about information provided' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between">

            <a href="{{ back_url('songs.artists.index') }}" class="btn btn-outline-secondary"><i
                    class="fas fa-arrow-left me-1"></i> Back
                to
                Artists</a>
            <div>
                @include('components.utils.edit-button', [
                    'route' => 'songs.artists.edit',
                    'id' => $artist->id,
                ])
                @include('components.utils.delete-button', [
                    'route' => 'songs.artists.delete',
                    'id' => $artist->id,
                ])
            </div>
        </div>
    </div>
</div>
