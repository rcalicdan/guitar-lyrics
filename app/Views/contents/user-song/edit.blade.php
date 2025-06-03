<div class="card-body">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Song</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route_to('songs.update', $song->slug) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="Enter title" value="{{ old('title', $song->title) }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id">
                        <option value="">Select a Category</option>
                        <option value="">Unknown</option>
                        @forelse ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $song->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @empty
                            <option value="" disabled>No categories available</option>
                        @endforelse
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div x-data="artistSelector({{ json_encode($song->artist) }})" class="position-relative">
                    <div class="mb-1">Artist</div>
                    <!-- Dropdown button -->
                    <button @click="toggleDropdown()" type="button"
                        class="btn btn-outline-secondary d-flex justify-content-between align-items-center w-100">
                        <span x-text="selectedArtist ? selectedArtist.name : 'Select an artist'"></span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="isOpen" @click.away="isOpen = false" class="dropdown-menu position-absolute w-100 mt-1"
                        :class="{ 'show': isOpen }" style="box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);">

                        <!-- Search input -->
                        <div class="px-3 py-2 border-bottom">
                            <input x-model="searchTerm" @keyup="searchArtists()" type="text"
                                placeholder="Search artists..." class="form-control form-control-sm">
                        </div>

                        <!-- Loading indicator -->
                        <div x-show="isLoading" class="text-center p-2">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="ms-2 text-secondary">Loading...</span>
                        </div>

                        <!-- Error message -->
                        <div x-show="errorMessage" class="text-center p-2 text-danger" x-text="errorMessage"></div>

                        <!-- Empty results message -->
                        <div x-show="!isLoading && filteredArtists.length === 0 && searchTerm !== ''"
                            class="text-center p-2 text-muted">
                            No artists found
                        </div>

                        <!-- Options list -->
                        <div style="max-height: 200px; overflow-y: auto;">
                            <template x-for="artist in filteredArtists" :key="artist.id">
                                <button @click="selectArtist(artist)" type="button" class="dropdown-item text-dark"
                                    style="padding: 0.35rem 1rem; font-size: 0.9rem;" x-text="artist.name">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Hidden input field for form submission -->
                    <input type="hidden" name="artist_id" :value="selectedArtist ? selectedArtist.id : ''">
                </div>

                <div class="mb-3 mt-3">
                    <div>
                        <p>Content</p>
                    </div>
                    <input id="content_input" type="hidden" name="content" value="{!! old('content', $song->content) !!}">
                    <trix-editor id="content_editor" input="content_input"
                        class="form-control @error('content') is-invalid @enderror">
                    </trix-editor>
                    @error('content')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-bold">Cover Image</label>

                    @if ($song->image_path)
                        <div class="mb-3">
                            <p class="text-muted mb-1">Current Image:</p>
                            <div class="border rounded p-2">
                                <img src='{{ $song->image_path }}' alt="{{ $song->title }}" class="img-fluid rounded"
                                    style="max-width: 300px; height: auto; object-fit: contain;">
                            </div>
                        </div>
                    @endif

                    <div class="card border-1 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="mt-3 preview-container" style="display: none;">
                                <p class="text-muted mb-1">New Image Preview:</p>
                                <div class="border rounded p-2">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded"
                                        style="max-width: 300px; height: auto; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Song</button>
                <a href="{{ back_url('songs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('custom-styles')
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .preview-container {
            transition: all 0.2s ease;
        }

        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: gray !important;
            color: #212529 !important;
            border: none !important;
            padding: 0.35rem 1rem !important;
            transform: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .dropdown-item:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #ced4da;
            box-shadow: 0 0 0 0.1rem rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@push('custom-scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('imagePreview');
            const container = document.querySelector('.preview-container');

            reader.onload = function() {
                if (reader.readyState === 2) {
                    preview.src = reader.result;
                    container.style.display = 'block';
                    preview.classList.add('fade-in');
                }
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        function artistSelector(initialArtist = null) {
            return {
                isOpen: false,
                isLoading: false,
                errorMessage: '',
                searchTerm: '',
                artists: [],
                filteredArtists: [],
                selectedArtist: initialArtist,

                init() {
                    if (!this.selectedArtist) {
                        this.loadInitialArtists();
                    }
                },

                async loadInitialArtists() {
                    this.isLoading = true;
                    this.errorMessage = '';

                    try {
                        const response = await axios.get('/api/songs/artists/search?term=');
                        this.artists = response.data;
                        this.filteredArtists = response.data;
                    } catch (error) {
                        console.error('Error loading artists:', error);
                        this.errorMessage = 'Failed to load artists. Please try again.';
                    } finally {
                        this.isLoading = false;
                    }
                },

                async searchArtists() {
                    if (this.searchTerm.length === 0) {
                        this.filteredArtists = this.artists;
                        return;
                    }

                    if (this.searchTerm.length < 2) return;

                    this.isLoading = true;
                    this.errorMessage = '';

                    try {
                        const response = await axios.get(
                            `/api/songs/artists/search?term=${encodeURIComponent(this.searchTerm)}`
                        );
                        this.filteredArtists = response.data;
                    } catch (error) {
                        console.error('Error searching artists:', error);
                        this.errorMessage = 'Search failed. Please try again.';
                    } finally {
                        this.isLoading = false;
                    }
                },

                toggleDropdown() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen && this.filteredArtists.length === 0) {
                        this.loadInitialArtists();
                    }
                },

                selectArtist(artist) {
                    this.selectedArtist = artist;
                    this.isOpen = false;
                }
            };
        }
    </script>
@endpush
