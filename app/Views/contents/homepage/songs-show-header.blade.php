<!-- Song Header -->
<section class="song-header" x-data="songShow({{ $song->id }}, '{{ $song->slug }}')" x-init="init()">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4 mt-5 mb-lg-0">
                <div class="song-image-wrapper"
                    x-data="imageLoader('{{ $song->image_path ?? '/placeholder/no-image.png' }}')">
                    <!-- Loading placeholder -->
                    <div x-show="!imageLoaded && !imageError" class="image-loading-placeholder">
                        <div class="placeholder-shimmer">
                            <i class="fas fa-image fa-3x text-white-50"></i>
                        </div>
                    </div>

                    <!-- Main image -->
                    <img x-show="imageLoaded && !imageError" :src="imageSrc" alt="{{ $song->title }}" class="song-image"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100">

                    <!-- Error fallback -->
                    <div x-show="imageError" class="image-error-placeholder">
                        <img src="/placeholder/no-image.png" alt="No image available" class="song-image">
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

                            <!-- Views Count with real-time updates -->
                            <span class="text-white-75 views-counter" x-show="viewCount >= 0"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100">
                                <i class="fas fa-eye me-1"></i>
                                <span x-text="formattedViewCount"></span>
                                <span x-text="viewCount === 1 ? 'view' : 'views'"></span>
                            </span>

                            <!-- Loading indicator for view count update -->
                            <span class="text-white-50" x-show="!viewCounted && viewCount === 0" x-transition>
                                <i class="fas fa-spinner fa-spin me-1"></i>
                                <small>Counting view...</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Count Update Success Message (Optional) -->
        <div class="row mt-2" x-show="viewCounted" x-transition:enter="transition ease-out duration-300 delay-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                    <small>
                        <i class="fas fa-check-circle me-1"></i>
                        Thanks for viewing! View count updated.
                    </small>
                    <button type="button" class="btn-close btn-close-white btn-sm"
                        @click="$el.parentElement.style.display = 'none'" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</section>