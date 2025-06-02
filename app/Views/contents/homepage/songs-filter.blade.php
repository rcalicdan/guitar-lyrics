<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-card">
            <form method="GET" 
                  action="{{ route_to('songs.index') }}" 
                  x-ref="filterForm"
                  @submit.prevent="submitForm()">
                <div class="row g-3 align-items-end">
                    <!-- Search -->
                    <div class="col-lg-4">
                        <label for="search" class="form-label fw-semibold">Search Songs</label>
                        <input type="text" 
                               class="form-control search-box" 
                               id="search" 
                               name="search" 
                               placeholder="Song title or artist..."
                               value="{{ $currentFilters['search'] }}"
                               x-model="filters.search"
                               @keyup.enter="submitForm()"
                               @input.debounce.500ms="autoSubmit()">
                    </div>
                    
                    <!-- Artist Filter -->
                    <div class="col-lg-3">
                        <label for="artist" class="form-label fw-semibold">Artist</label>
                        <select class="form-select filter-select" 
                                id="artist" 
                                name="artist"
                                x-model="filters.artist"
                                @change="submitForm()">
                            <option value="">All Artists</option>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->id }}" 
                                        {{ $currentFilters['artist'] == $artist->id ? 'selected' : '' }}>
                                    {{ $artist->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="col-lg-3">
                        <label for="category" class="form-label fw-semibold">Category</label>
                        <select class="form-select filter-select" 
                                id="category" 
                                name="category"
                                x-model="filters.category"
                                @change="submitForm()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ $currentFilters['category'] == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div class="col-lg-2">
                        <label for="sort" class="form-label fw-semibold">Sort By</label>
                        <select class="form-select filter-select" 
                                id="sort" 
                                name="sort"
                                x-model="filters.sort"
                                @change="submitForm()">
                            <option value="latest" {{ $currentFilters['sort'] == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ $currentFilters['sort'] == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="title_asc" {{ $currentFilters['sort'] == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                            <option value="title_desc" {{ $currentFilters['sort'] == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                            <option value="artist" {{ $currentFilters['sort'] == 'artist' ? 'selected' : '' }}>Artist</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <div x-show="hasActiveFilters()" x-transition>
                                <button type="button" 
                                        @click="clearAllFilters()" 
                                        class="clear-filters">
                                    <i class="fas fa-times me-1"></i> Clear all filters
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <!-- Loading indicator -->
                            <div x-show="loading" x-transition class="me-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="btn btn-custom"
                                    :disabled="loading">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>