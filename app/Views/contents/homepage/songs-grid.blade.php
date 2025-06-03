<!-- Songs Grid -->
<section class="py-5">
    <div class="container">
        @if($songs->count() > 0)
        <div class="row g-4" x-show="!loading" x-transition>
            @foreach($songs as $song)
            <div class="col-lg-3 col-md-4 col-sm-6" x-data="{ 
                             imageLoaded: false,
                             imageError: false 
                         }">
                <div class="song-card" @mouseenter="$el.classList.add('hover')"
                    @mouseleave="$el.classList.remove('hover')">

                    <!-- Image with loading state -->
                    <div class="song-image-container"
                        x-data="imageLoader('{{ $song->image_path ?? '/placeholder/no-image.png' }}')">
                        <!-- Loading placeholder -->
                        <div x-show="!imageLoaded && !imageError" class="image-placeholder">
                            <div class="placeholder-content">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        </div>

                        <!-- Main image with preloading -->
                        <img :src="imageSrc" alt="{{ $song->title }}" class="song-image"
                            x-show="imageLoaded && !imageError">

                        <!-- Error fallback -->
                        <div x-show="imageError" class="image-placeholder">
                            <div class="placeholder-content">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                                <small class="text-muted">Image unavailable</small>
                            </div>
                        </div>
                    </div>

                    <div class="song-content">
                        <h5 class="song-title">{{ $song->title }}</h5>
                        <p class="song-artist">
                            <i class="fas fa-user me-1"></i>
                            {{ $song->artist_name }}
                        </p>
                        <span class="song-category">{{ $song->category_name }}</span>
                        <div class="d-grid">
                            <a href="{{ route_to('home.songs.show', $song->slug) }}" class="btn btn-custom"
                                @click="$event.target.innerHTML = '<i class=\'fas fa-spinner fa-spin me-2\'></i>Loading...'">
                                <i class="fas fa-music me-2"></i>View Chords
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Loading state for grid -->
        <div x-show="loading" x-transition class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading songs...</p>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper" x-show="!loading" x-transition>
            <div class="d-flex justify-content-center">
                {!! $songs->links() !!}
            </div>
        </div>
        @else
        <div class="no-results" x-show="!loading" x-transition>
            <i class="fas fa-music fa-3x mb-3 text-muted"></i>
            <h3>No songs found</h3>
            <p>Try adjusting your search criteria or browse all songs.</p>
            <button @click="clearAllFilters()" class="btn btn-custom">
                <i class="fas fa-refresh me-2"></i>Reset Filters
            </button>
        </div>
        @endif
    </div>
</section>