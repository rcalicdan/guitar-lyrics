<!-- Song Header -->
<section class="song-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <div class="song-image-wrapper" x-data="{ imageLoaded: false, imageError: false }">
                    <!-- Loading placeholder -->
                    <div x-show="!imageLoaded && !imageError" class="image-loading-placeholder">
                        <div class="placeholder-shimmer">
                            <i class="fas fa-image fa-3x text-white-50"></i>
                        </div>
                    </div>

                    <!-- Main image -->
                    <img src="{{ $song->image_path ?? '/placeholder/no-image.png' }}" alt="{{ $song->title }}"
                        class="song-image" x-show="imageLoaded" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100" @load="imageLoaded = true"
                        imageLoaded=true; $el.src='/placeholder/no-image.png'">

                    <!-- Favorite/Like button overlay -->
                    <div class=" image-overlay" x-show="imageLoaded" x-transition>
                    <button @click="toggleFavorite()" class="btn-favorite" :class="{ 'active': isFavorite }">
                        <i :class="isFavorite ? 'fas fa-heart' : 'far fa-heart'"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route_to('home') }}" class="text-white-50">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route_to('songs.index') }}" class="text-white-50">
                            <i class="fas fa-music me-1"></i>Songs
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        {{ $song->title }}
                    </li>
                </ol>
            </nav>

            <!-- Song Title and Info -->
            <div x-show="true" x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                <h1 class="display-4 fw-bold mb-3">{{ $song->title }}</h1>
                <div class="song-meta-header mb-3">
                    <p class="lead mb-2">
                        <i class="fas fa-user me-2"></i>
                        <span class="artist-name">{{ $song->artist_name }}</span>
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="badge bg-light text-dark fs-6">
                            <i class="fas fa-tag me-1"></i>{{ $song->category_name }}
                        </span>
                        <span class="text-white-75">
                            <i class="fas fa-calendar me-1"></i>
                            Added {{ $song->created_at->diffForHumans() }}
                        </span>
                        <span class="text-white-75" x-show="viewCount > 0" x-transition>
                            <i class="fas fa-eye me-1"></i>
                            <span x-text="formatNumber(viewCount)"></span> views
                        </span>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="header-actions">
                    <button @click="toggleFavorite()" class="btn btn-light"
                        :class="{ 'btn-danger': isFavorite, 'btn-light': !isFavorite }">
                        <i :class="isFavorite ? 'fas fa-heart' : 'far fa-heart'" class="me-2"></i>
                        <span x-text="isFavorite ? 'Favorited' : 'Add to Favorites'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>