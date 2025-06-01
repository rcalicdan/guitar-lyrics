<div class="card-body">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Song Artist</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route_to('songs.artists.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Artist Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="Enter artist name" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">About Artist</label>
                    <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about"
                        placeholder="Enter artist description">{{ old('about') }}</textarea>

                    @error('about')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Artist Image</label>
                    <div class="card border-1 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            </div>

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mt-3 preview-container" style="display: none;">
                                <p class="text-muted mb-1">Image Preview:</p>
                                <div class="border rounded p-2">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded"
                                        style="max-width: 300px; height: auto; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Artist</button>
                <a href="{{ back_url('songs.artists.index') }}" class="btn btn-secondary">Cancel</a>
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
@endpush
