<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'Song List'])
        <div class="col-6 d-grid">
            @include('components.utils.search-modal-button', [
                'button_name' => 'Search Songs',
                'class' => 'w-100',
            ])
        </div>
        <div class="col-6 d-6">
            @include('components.utils.create-button', [
                'route' => 'songs.create',
                'button_name' => 'Publish New Song',
                'class' => 'w-100',
            ])
        </div>
    @endcomponent

    <!-- Card Body -->
    <div class="card-body">
        @if ($songs->isEmpty())
            <p class="text-center">No Songs found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th class="text-center">Views</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($songs as $song)
                            <tr>
                                <td>{{ $song->id }}</td>
                                <td>{{ $song->title }}</td>
                                <td>{{ $song->artist_name }}</td>
                                <td>{{ $song->category_name }}</td>
                                <td class="text-center">{{ $song->views_count }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @include('components.utils.view-button', [
                                            'route' => 'songs.show',
                                            'id' => $song->slug,
                                        ])
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {!! $songs->links() !!}
        </div>
    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Song', 'url' => 'song'])
    <div class="mb-3">
        <label for="searchSongName" class="form-label">Song Name</label>
        <input type="text" class="form-control" id="searchSongName" name="song_name" value="{{ get('song_name') }}"
            placeholder="Enter song name">
    </div>

    <!-- Artist Search Dropdown -->
    <div class="mb-3" x-data="artistSearchDropdown()">
        <label for="searchArtist" class="form-label">Artist</label>
        <div class="position-relative">
            <input type="text" class="form-control" id="searchArtist" x-model="searchTerm" @input="searchArtists"
                @focus="showDropdown = true" @click.away="showDropdown = false" placeholder="Type to search artists..."
                autocomplete="off">

            <div x-show="showDropdown && (artists.length > 0 || loading)" x-transition
                class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 z-3"
                style="max-height: 200px; overflow-y: auto;">

                <!-- Loading State -->
                <div x-show="loading" class="p-3 text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching artists...</span>
                </div>

                <!-- Artists List -->
                <template x-for="artist in artists" :key="artist.id">
                    <div @click="selectArtist(artist)" class="p-2 border-bottom cursor-pointer hover-bg-light"
                        :class="{ 'bg-light': selectedArtist && selectedArtist.id === artist.id }">
                        <strong x-text="artist.name"></strong>
                        <small class="text-muted d-block">ID: <span x-text="artist.id"></span></small>
                    </div>
                </template>

                <!-- No Results -->
                <div x-show="!loading && artists.length === 0 && searchTerm.length > 0" class="p-3 text-center text-muted">
                    No artists found
                </div>
            </div>
        </div>

        <!-- Selected Artist Display -->
        <div x-show="selectedArtist" class="mt-2">
            <small class="text-muted">Selected Artist:</small>
            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                <span>
                    <strong x-text="selectedArtist?.name"></strong>
                    <small class="text-muted">(ID: <span x-text="selectedArtist?.id"></span>)</small>
                </span>
                <button type="button" @click="clearArtistSelection()" class="btn btn-sm btn-outline-secondary">
                    ×
                </button>
            </div>
        </div>

        <!-- Hidden input for artist -->
        <input type="hidden" name="artist_name" :value="selectedArtist?.name || ''">
    </div>

    <!-- Category Search Dropdown -->
    <div class="mb-3" x-data="categorySearchDropdown()">
        <label for="searchCategory" class="form-label">Song Category</label>
        <div class="position-relative">
            <input type="text" class="form-control" id="searchCategory" x-model="searchTerm" @input="searchCategories"
                @focus="showDropdown = true" @click.away="showDropdown = false" placeholder="Type to search categories..."
                autocomplete="off">

            <div x-show="showDropdown && (categories.length > 0 || loading)" x-transition
                class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 z-3"
                style="max-height: 200px; overflow-y: auto;">

                <!-- Loading State -->
                <div x-show="loading" class="p-3 text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching categories...</span>
                </div>

                <!-- Categories List -->
                <template x-for="category in categories" :key="category.id">
                    <div @click="selectCategory(category)" class="p-2 border-bottom cursor-pointer hover-bg-light"
                        :class="{ 'bg-light': selectedCategory && selectedCategory.id === category.id }">
                        <strong x-text="category.name"></strong>
                        <small class="text-muted d-block">ID: <span x-text="category.id"></span></small>
                    </div>
                </template>

                <!-- No Results -->
                <div x-show="!loading && categories.length === 0 && searchTerm.length > 0"
                    class="p-3 text-center text-muted">
                    No categories found
                </div>
            </div>
        </div>

        <!-- Selected Category Display -->
        <div x-show="selectedCategory" class="mt-2">
            <small class="text-muted">Selected Category:</small>
            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                <span>
                    <strong x-text="selectedCategory?.name"></strong>
                    <small class="text-muted">(ID: <span x-text="selectedCategory?.id"></span>)</small>
                </span>
                <button type="button" @click="clearCategorySelection()" class="btn btn-sm btn-outline-secondary">
                    ×
                </button>
            </div>
        </div>

        <!-- Hidden input for category -->
        <input type="hidden" name="song_category_id" :value="selectedCategory?.id || ''">
    </div>

    <!-- Published Status -->
    <div class="mb-3">
        <label for="searchPublished" class="form-label">Published Status</label>
        <select class="form-select" id="searchPublished" name="is_published">
            <option value="">All Songs</option>
            <option value="1" {{ get('is_published') == '1' ? 'selected' : '' }}>Published</option>
            <option value="0" {{ get('is_published') == '0' ? 'selected' : '' }}>Unpublished</option>
        </select>
    </div>
@endcomponent

@push('custom-styles')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
        }

        .z-3 {
            z-index: 1030;
        }
    </style>
@endpush

@include('stacks.songs.script')
